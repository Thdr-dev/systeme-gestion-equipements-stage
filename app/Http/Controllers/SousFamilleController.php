<?php

namespace App\Http\Controllers;

use App\Models\SousFamille;
use App\Models\Famille;
use Exception;
use Illuminate\Http\Request;

class SousFamilleController extends Controller{

    public function index(Request $request){
        $query = SousFamille::query();

        if($request->filled('search')){
            $search = $request->search;

            $query->where("nomSousFam", "like", "%$search%");
        }

        $sousFamilles = $query->with('famille')->paginate(10)->appends(['search' => $request->search]);
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
        
        try{
            SousFamille::create($validated);

            return redirect()->route('sous-familles.index')->with('message-success', 'Sous-famille ajoutée !');
            } catch(Exception $e){
            return back()
            ->withInput()
            ->withErrors(['error' => 'Une erreur est survenue lors de la création du SousFamille. Veuillez réessayer.']);
        }
    }


    public function edit(SousFamille $sousFamille){
        $familles = Famille::all();
        return view('sous_familles.edit', compact('sousFamille', 'familles'));
    }


    public function update(Request $request, SousFamille $sousFamille){
        try{
            $validated = $request->validate([
                'nomSousFam' => 'required|string|max:255',
                'famille_id' => 'required|exists:familles,id',
                'description' => 'nullable|string'
            ]);

            $sousFamille->update($validated);

            return redirect()->route('sous-familles.index')->with('message-success', 'Mise à jour réussie.');
        } catch (Exception $e) {
            return back()
                ->withInput()
                ->withErrors(['error' => 'Une erreur est survenue lors de la mise à jour.']);
        }
    }

 
    public function destroy(SousFamille $sousFamille){
        try{
            if ($sousFamille->materiels()->count() > 0) {
                return back()->withErrors(['message-error'=> 'Action impossible : du matériel appartient encore à cette sous-famille.']);
            }

            $sousFamille->delete();
            return redirect()->route('sous-familles.index')->with('message-success', 'Suppression effectuée.');
        } catch(Exception $e){
            return back()->withErrors(['error' => 'Erreur lors de la suppression.']);
        }
    }
}