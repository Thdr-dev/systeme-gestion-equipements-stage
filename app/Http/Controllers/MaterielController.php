<?php

namespace App\Http\Controllers;

use App\Models\Materiel;
use App\Models\Unite;
use App\Models\SousFamille;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class MaterielController implements HasMiddleware{

    public static function middleware(){
        return [
            'auth',
            
            new Middleware('admin', except: ['index', 'show']),
        ];
    }

    public function index(Request $request) {
        $user = Auth::user();
        $query = Materiel::with(['unite', 'sousFamille.famille']);

        $query->where('unite_id', $user->unite_id);
        if (!$user->isAdmin) {

            $query->where(function($q) use ($user) {
                $q->where('status', 'Disponible')
                ->orWhere(function($sub) use ($user) {
                    $sub->where('status', 'Sorti')
                        ->whereHas('mouvements', function($m) use ($user) {
                            $m->where('user_id', $user->id)
                                ->where('type', 'Sortie');
                        });
                });
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $query->where('nom', 'like', "%{$request->search}%");
        }

        // if($user->isAdmin && $request->filled('unite_id')){
        //     $query->where('unite_id', $request->unite_id);            
        // }

        if ($request->filled('sous_famille_id')) $query->where('sous_famille_id', $request->sous_famille_id);

        $materiels = $query->latest()->paginate(10)->appends($request->all());
        
        // $unites = $user->isAdmin ? Unite::orderBy("nom")->get() : collect([$user->unite]);
        
        $sousFamilles = SousFamille::with('famille')->orderBy("nomSousFam")->get();
        
        return view('materiels.index', compact('materiels', 'sousFamilles'));
    }

    
    public function create(){
        $unites = Unite::orderBy('nom')->get();
        $sousFamilles = SousFamille::with('famille')->get();

        return view('materiels.create', compact('unites', 'sousFamilles'));
    }

    public function store(Request $request){
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:Disponible,Sorti,En panne,Maintenance',
            'date_maintenance' => 'nullable|date|after:today',
            'sous_famille_id' => 'required|exists:sous_familles,id',
            'image' => 'nullable|image|max:2048',
        ]);

        try{
            if ($request->hasFile('image')) {
                $validated['image'] = $request->file('image')->store('materiels', 'public');
            }
            $validated['unite_id'] = Auth::user()->unite_id;

            Materiel::create($validated);

            return redirect()->route('materiels.index')->with('message-success', 'Matériel ajouté.');
        } catch(Exception $e){
            return back()
            ->withInput()
            ->withErrors(['error' => 'Une erreur est survenue lors de la création du Materiel. Veuillez réessayer.']);
        }
    }

    public function show(Materiel $materiel){
        if( !Auth::user()->isAdmin ){
            if ($materiel->unite_id !== Auth::user()->unite_id) {
                return redirect()->route('materiels.index')
                    ->withErrors(['message-error'=> "Accès refusé : Ce matériel appartient à une autre unité opérationnelle."]);
            }
        }
        
        $materiel->load(['unite', 'sousFamille.famille']);
        
        return view('materiels.show', compact('materiel'));
    }

    public function edit(Materiel $materiel){
        if($materiel->unite_id != Auth::user()->unite_id){
            return redirect()->route('materiels.index')
                    ->withErrors(['message-error'=> "Accès refusé : Ce matériel appartient à une autre unité opérationnelle."]);
        }

        $unites = Unite::all();
        $sousFamilles = SousFamille::all();
        
        return view('materiels.edit', compact('materiel', 'unites', 'sousFamilles'));
    }

    public function update(Request $request, Materiel $materiel){
        if($materiel->unite_id != Auth::user()->unite_id){
            return redirect()->route('materiels.index')
                ->withErrors(['message-error'=> "Accès refusé : Ce matériel appartient à une autre unité opérationnelle."]);
        }
        
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'description' => 'nullable|string',
            'date_maintenance' => 'nullable|date|after:today',
            'sous_famille_id' => 'required|exists:sous_familles,id',
            'image' => 'nullable|image|max:2048',
        ]);

        try{
            if ($request->hasFile('image')) {
                if ($materiel->image) Storage::disk('public')->delete($materiel->image);
                $validated['image'] = $request->file('image')->store('materiels', 'public');
            }

            $materiel->update($validated);

            return redirect()->route('materiels.show', $materiel)->with('message-success', 'Mise à jour réussie.');
        } catch (Exception $e) {
            return back()
                ->withInput()
                ->withErrors(['error' => 'Une erreur est survenue lors de la mise à jour.']);
        }
    }

    public function destroy(Materiel $materiel){
        if($materiel->unite_id != Auth::user()->unite_id){
            return redirect()->route('materiels.index')
                    ->withErrors(['message-error'=> "Accès refusé : Ce matériel appartient à une autre unité opérationnelle."]);
        }
        
        try{
            $materiel->delete(); 
            return redirect()->route('materiels.index')->with('message-success', 'Matériel archivé.');
        } catch (Exception $e) {
            return back()->withErrors(['error' => 'Erreur lors de la suppression.']);
        }
    }

}