<?php

namespace App\Http\Controllers;

use App\Models\SousFamille;
use App\Models\Famille; // Importation nécessaire pour le formulaire
use Illuminate\Http\Request;

class SousFamilleController extends Controller{

    public function index(){
        $sousFamilles = SousFamille::with('famille')->paginate(10);
        return view('sous_familles.index', compact('sousFamilles'));
    }


    
    public function create(){
        $familles = Famille::all();
        return view('sous_familles.create', compact('familles'));
    }


    public function store(Request $request){
        $validated = $request->validate([
            'nomSousFam' => 'required|string|max:255',
            'famille_id' => 'required|exists:familles,id',
            'description' => 'nullable|string'
        ]);

        SousFamille::create($validated);

        return redirect()->route('sous-familles.index')->with('success', 'Sous-famille ajoutée !');
    }


    public function edit(SousFamille $sousFamille){
        $familles = Famille::all();
        return view('sous_familles.edit', compact('sousFamille', 'familles'));
    }


    public function update(Request $request, SousFamille $sousFamille){
        $validated = $request->validate([
            'nomSousFam' => 'required|string|max:255',
            'famille_id' => 'required|exists:familles,id',
            'description' => 'nullable|string'
        ]);

        $sousFamille->update($validated);

        return redirect()->route('sous-familles.index')->with('success', 'Mise à jour réussie.');
    }

 
    public function destroy(SousFamille $sousFamille){
        if ($sousFamille->materiels()->count() > 0) {
            return back()->with('error', 'Action impossible : du matériel appartient encore à cette sous-famille.');
        }

        $sousFamille->delete();
        return redirect()->route('sous-familles.index')->with('success', 'Suppression effectuée.');
    }
}