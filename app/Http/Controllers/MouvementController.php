<?php

namespace App\Http\Controllers;

use App\Models\Materiel;
use App\Models\Mouvement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class MouvementController extends Controller{


    public function store(Request $request){
        $request->validate([
            'materiel_id' => 'required|exists:materiels,id',
            'type' => 'required|in:Transfert,Maintenance,Retour,Sortie,Panne',
            'to_unite_id' => 'nullable|exists:unites,id',
            'commentaire' => 'nullable|string|max:255',
        ]);

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

        return back()->with('message-success', 'Mouvement enregistré et statut mis à jour.');
    }
}