@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow">
                    <div class="card-header bg-warning d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 text-dark">Modifier l'Unité : {{ $unite->nom }}</h5>
                        <a href="{{ route('unites.index') }}" class="btn btn-sm btn-outline-dark">Retour</a>
                    </div>

                    <div class="card-body">
                        <form action="{{ route('unites.update', $unite->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="nom" class="form-label">Nom de l'Unité / Centre</label>
                                    <input type="text" 
                                        name="nom" 
                                        id="nom" 
                                        class="form-control @error('nom') is-invalid @enderror" 
                                        value="{{ old('nom', $unite->nom) }}" 
                                        required>
                                    @error('nom')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="ville" class="form-label">Ville</label>
                                    <input type="text" 
                                        name="ville" 
                                        id="ville" 
                                        class="form-control @error('ville') is-invalid @enderror" 
                                        value="{{ old('ville', $unite->ville) }}" 
                                        required>
                                    @error('ville')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="description" class="form-label">Description ou Adresse précise</label>
                                <textarea name="description" 
                                        id="description" 
                                        class="form-control @error('description') is-invalid @enderror" 
                                        rows="3">{{ old('description', $unite->description) }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-warning fw-bold">
                                    Mettre à jour l'unité
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                
                <div class="mt-3 alert alert-info py-2">
                    <small><i class="fas fa-info-circle"></i> Modifier le nom de l'unité mettra à jour la localisation de tous les matériels qui y sont rattachés.</small>
                </div>
            </div>
        </div>
    </div>

@endsection