<?php

namespace App\Http\Controllers;

use App\Models\Famille;
use Illuminate\Http\Request;

class FamilleController extends Controller{
    public function index(){
        $familles = Famille::withCount('sousFamilles')->paginate(10);
        return view('familles.index', compact('familles'));
    }

    public function create(){
        return view('familles.create');
    }

    public function store(Request $request){
        $validated = $request->validate([
            'nomFam' => 'required|string|unique:familles,nomFam|max:255',
            'description' => 'nullable|string'
        ]);
        

        Famille::create($validated);

        return redirect()->route('familles.index')->with('message-success', 'Nouvelle famille ajoutée.');
    }

    public function edit(Famille $famille){
        return view('familles.edit', compact('famille'));
    }

    public function update(Request $request, Famille $famille){
        $validated = $request->validate([
            'nomFam' => 'required|string|max:255|unique:familles,nomFam,' . $famille->id,
            'description' => 'nullable|string'
        ]);

        $famille->update($validated);

        return redirect()->route('familles.index')->with('message-success', 'Famille mise à jour.');
    }

    public function destroy(Famille $famille){
        if ($famille->sousFamilles()->count() > 0) {
            return back()->withErrors(['message-error'=> 'Impossible : cette famille contient des sous-familles actives.']);
        }

        $famille->delete();
        return redirect()->route('familles.index')->with('message-success', 'Famille supprimée.');
    }
}