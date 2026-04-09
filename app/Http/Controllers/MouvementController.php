<?php

namespace App\Http\Controllers;

use App\Models\Materiel;
use App\Models\Mouvement;
use App\Models\Unite;
use App\Models\User;
use App\Notifications\MaterielNotification;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class MouvementController extends Controller{


    protected function checkUserPermission(Materiel $materiel){
        $user = Auth::user();
        if (!$user->isAdmin) {
            if (in_array($materiel->status, ['En panne', 'Maintenance'])) {
                return redirect()->route('materiels.index')
                    ->withErrors(['message-error'=> "Ce matériel est en {$materiel->status}. Seul un administrateur peut modifier son état."]);
            }

            if ($materiel->status === 'Sorti') {
                $dernierMouvement = $materiel->mouvements()
                    ->where('type', 'Sortie')
                    ->latest()
                    ->first();

                if ($dernierMouvement && $dernierMouvement->user_id !== $user->id) {
                    return redirect()->back()
                        ->withErrors(['message-error'=> "Ce matériel est déjà utilisé par un autre opérateur."]);
                }
            }
        }
        if ($materiel->unite_id !== Auth::user()->unite_id) {
                return redirect()->route('materiels.index')
                    ->withErrors(['message-error'=> "Accès refusé : Ce matériel appartient à une autre unité opérationnelle."]);
        }
        return true;
    }

    public function create(Materiel $materiel) {
        $allowedOrRedirect = $this->checkUserPermission( $materiel );

        if($allowedOrRedirect === true){
            $unites = Unite::all();
            return view("mouvement.create", compact('materiel', 'unites'));
        }
        return $allowedOrRedirect;
    }

    public function declarePanne(Materiel $materiel){
        $allowedOrRedirect = $this->checkUserPermission( $materiel );
        
        if(Auth::user()->isAdmin){
            if ($materiel->status === 'En panne') {
                    return redirect()->route('materiels.index')
                        ->withErrors(['message-error'=> "Ce matériel est deja {$materiel->status}."]);
            }
        }

        if($allowedOrRedirect === true){
            $unites = Unite::all();
            return view("mouvement.declarePanne", compact('materiel', 'unites'));
        }
        return $allowedOrRedirect;
    }

    public function store(Request $request){

        $request->validate([
            'materiel_id' => 'required|exists:materiels,id',
            'type' => 'required|in:Transfert,Maintenance,Retour,Sortie,Panne',
            'to_unite_id' => 'required_if:type,Transfert|nullable|exists:unites,id',
            'delai_maintenance' => 'required_if:type,Maintenance|nullable|date|after:today',
            'commentaire' => 'nullable|string|max:255',
        ]);

        try{
            $materiel = Materiel::findOrFail($request->materiel_id);
            $user = Auth::user();

            if($user->isAdmin && $request->type !== "Retour"){
                if ($materiel->status === 'Maintenance') {
                        return redirect()->route('materiels.index')
                            ->withErrors(['message-error'=> "Ce matériel est deja en {$materiel->status}."]);
                }
            }


           DB::transaction(function () use ($request, $materiel, $user) {
    
                $destinationId = ($request->type === 'Transfert') 
                                ? $request->to_unite_id 
                                : $materiel->unite_id;
                                
                $commentaireFinal = $request->commentaire;

                if ($request->type === 'Maintenance' && $request->delai_maintenance) {
                    $dateFmt = date('d/m/Y', strtotime($request->delai_maintenance));
                    $commentaireFinal .= " [Retour prévu le : $dateFmt]";
                }

                Mouvement::create([
                    'type' => $request->type,
                    'commentaire' => $commentaireFinal,
                    'materiel_id' => $materiel->id,
                    'user_id' => $user->id,
                    'from_unite_id' => $materiel->unite_id,
                    'to_unite_id' => $destinationId,
                ]);

                $newStatus = $materiel->status;
                $actionText = "";
                $delaiMaint = null;

                switch($request->type) {
                    case 'Sortie':      
                        $newStatus = 'Sorti'; 
                        $actionText = "a effectué une <strong style='color: #d97706;'>SORTIE</strong> pour"; 
                        break;

                    case 'Panne':       
                        $newStatus = 'En panne'; 
                        $actionText = "a signalé une <strong style='color: #dc3545;'>PANNE</strong> sur"; 
                        break;

                    case 'Maintenance': 
                        $newStatus = 'Maintenance'; 
                        $delaiMaint = $request->delai_maintenance; 
                        $actionText = "a envoyé en <strong style='color: #0d6efd;'>MAINTENANCE</strong> (Prévu jusqu'au : " . date('d/m/Y', strtotime($delaiMaint)) . ")"; 
                        break;

                    case 'Retour':      
                        $newStatus = 'Disponible'; 
                        $delaiMaint = null;
                        $actionText = "a enregistré le <strong style='color: #198754;'>RETOUR</strong> de"; 
                        break;

                    case 'Transfert':
                        $actionText = "a <strong style='color: #6610f2;'>TRANSFÉRÉ</strong>"; 
                        break;
                }

                $materiel->update([
                    'unite_id' => $destinationId,
                    'status'   => $newStatus,
                    'delai_maintenance' => $delaiMaint ? $delaiMaint : $materiel->delai_maintenance,
                ]);
                
                $admins = User::where('isAdmin', true)
                        ->where(function($q) use ($destinationId) {
                            $q->where('unite_id', $destinationId);
                        })->get();
                        
                $newUniteNom = Unite::findOrFail($destinationId)->nom;

                $data = [
                    'message' => "{$user->prenom} {$actionText} [{$materiel->nom}] (Unité: {$newUniteNom})",
                    'link' => route('materiels.show', $materiel),
                    'type' => 'mouvement'
                ];

                foreach ($admins as $admin) {
                    if ($admin->id !== $user->id) {
                        $admin->notify(new MaterielNotification($data));
                    }
                }
            });

            return redirect()->route('materiels.show', $materiel)->with('message-success', 'Mouvement enregistré et statut mis à jour.');
        } catch(Exception $e){
            return back()
            ->withInput()
            ->withErrors(['error' => 'Une erreur est survenue lors de la enregistrement d\'un mouvement. Veuillez réessayer.']);
        }
    }
    
}