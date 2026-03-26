<?php

namespace App\Http\Controllers;

use App\Models\Unite;
use Exception;
use Illuminate\Http\Request;

class UniteController extends Controller{
    public function index(Request $request){
        $query = Unite::query();

        if($request->filled('search')){
            $search = $request->search;

            $query->where(function($q) use ($search){
                $q->where('nom', 'like', "%$search%")
                ->orWhere('ville', 'like', "%$search%");
            });

        }
        

        $unites = $query->withCount('materiels')->paginate(10)->appends(['search' => $request->search]);
        return view('unites.index', compact('unites'));
    }

    public function create(){
        return view('unites.create');
    }

    public function store(Request $request){
        $validated = $request->validate([
            'nom' => 'required|string|max:255|unique:unites,nom',
            'ville' => 'required|string|max:255',
            'description' => 'nullable|string'
        ]);

        try{
            Unite::create($validated);

            return redirect()->route('unites.index')->with('message-success', 'Unité créée avec succès.');
        } catch(Exception $e){
            return back()
            ->withInput()
            ->withErrors(['error' => 'Une erreur est survenue lors de la création d\'Unite. Veuillez réessayer.']);
        }
    }

    public function edit(Unite $unite){
        return view('unites.edit', compact('unite'));
    }

    public function update(Request $request, Unite $unite){
        $validated = $request->validate([
            'nom' => 'required|string|max:255|unique:unites,nom,' . $unite->id,
            'ville' => 'required|string|max:255',
            'description' => 'nullable|string'
        ]);

        try{
            $unite->update($validated);

            return redirect()->route('unites.index')->with('message-success', 'Unité mise à jour.');
        } catch (Exception $e) {
            return back()
                ->withInput()
                ->withErrors(['error' => 'Une erreur est survenue lors de la mise à jour.']);
        }
    }

    public function destroy(Unite $unite){
        try{
            if ($unite->materiels()->count() > 0) {
                return back()->withErrors(['message-error'=> 'Action impossible : Cette unité contient encore du matériel.']);
            }

            $unite->delete();
            return redirect()->route('unites.index')->with('message-success', 'Unité supprimée.');
        } catch (Exception $e) {
            return back()->withErrors(['error' => 'Erreur lors de la suppression.']);
        }
    }
}