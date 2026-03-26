<?php

namespace App\Http\Controllers;

use App\Models\Materiel;
use App\Models\Mouvement;
use App\Models\Unite;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class MouvementController extends Controller{

    public function create(Materiel $materiel){
        $unites = Unite::all();

        return view("mouvement.create", compact('materiel', 'unites'));
    }

    public function store(Request $request){

        $request->validate([
            'materiel_id' => 'required|exists:materiels,id',
            'type' => 'required|in:Transfert,Maintenance,Retour,Sortie,Panne',
            'to_unite_id' => 'required_if:type,Transfert|nullable|exists:unites,id', 
            'commentaire' => 'nullable|string|max:255',
        ]);

        try{
            $materiel = Materiel::findOrFail($request->materiel_id);
            $user = Auth::user();

            DB::transaction(function () use ($request, $materiel, $user) {
                
                $destinationId = ($user->isAdmin) ? $request->to_unite_id : $materiel->unite_id;


                Mouvement::create([
                    'type' => $request->type,
                    'commentaire' => $request->commentaire,
                    'materiel_id' => $materiel->id,
                    'user_id' => $user->id,
                    'from_unite_id' => $materiel->unite_id,
                    'to_unite_id' => $destinationId,
                ]);

                $newStatus = $materiel->status;
                
                switch($request->type) {
                    case 'Sortie':      $newStatus = 'Sorti'; break;
                    case 'Panne':       $newStatus = 'En panne'; break;
                    case 'Maintenance': $newStatus = 'Maintenance'; break;
                    case 'Retour':      $newStatus = 'Disponible'; break;
                    case 'Transfert':   $newStatus = 'Disponible'; break;
                }

                $materiel->update([
                    'unite_id' => $destinationId,
                    'status'   => $newStatus
                ]);
            });

            return redirect()->route('materiels.show', $materiel)->with('message-success', 'Mouvement enregistré et statut mis à jour.');
        } catch(Exception $e){
            return back()
            ->withInput()
            ->withErrors(['error' => 'Une erreur est survenue lors de la enregistrement d\'un mouvement. Veuillez réessayer.']);
        }
    }
}