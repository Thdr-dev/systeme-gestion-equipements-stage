@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow">
                    <div class="card-header bg-success text-white text-center">
                        <h5 class="mb-0 py-2">Ajouter une Nouvelle Famille</h5>
                    </div>

                    <div class="card-body">
                        <form action="{{ route('familles.store') }}" method="POST">
                            @csrf

                            <div class="mb-3">
                                <label for="nomFam" class="form-label">Nom de la Famille <span class="text-danger">*</span></label>
                                <input type="text" 
                                    name="nomFam" 
                                    id="nomFam" 
                                    class="form-control" 
                                    placeholder="Ex: Matériel Médical, Transmission, Incendie..." 
                                    value="{{ old('nomFam') }}" 
                                    >
                                @error('nomFam')
                                    <div class="form-text text-danger ps-2">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="description" class="form-label">Description (Optionnelle)</label>
                                <textarea name="description" 
                                        id="description" 
                                        class="form-control @error('description') is-invalid @enderror" 
                                        rows="4" 
                                        placeholder="Détails sur cette catégorie de matériel...">{{ old('description') }}</textarea>
                                @error('description')
                                    <div class="form-text text-danger ps-2">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-flex justify-content-between gap-3">
                                <a href="{{ route('familles.index') }}" class="btn btn-secondary">Annuler</a>
                                <button type="submit" class="btn btn-success flex-grow-1">Enregistrer la Famille</button>
                            </div>
                            
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection