<?php

namespace App\Http\Controllers;

use App\Models\Unite;
use Illuminate\Http\Request;

class UniteController extends Controller{
    public function index(){
        $unites = Unite::withCount('materiels')->paginate(10);
        return view('unites.index', compact('unites'));
    }

    public function create()
    {
        return view('unites.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255|unique:unites,nom',
            'ville' => 'required|string|max:255',
            'description' => 'nullable|string'
        ]);

        Unite::create($validated);

        return redirect()->route('unites.index')->with('success', 'Unité créée avec succès.');
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

        $unite->update($validated);

        return redirect()->route('unites.index')->with('success', 'Unité mise à jour.');
    }

    public function destroy(Unite $unite){
        if ($unite->materiels()->count() > 0) {
            return back()->with('error', 'Action impossible : Cette unité contient encore du matériel.');
        }

        $unite->delete();
        return redirect()->route('unites.index')->with('success', 'Unité supprimée.');
    }
}