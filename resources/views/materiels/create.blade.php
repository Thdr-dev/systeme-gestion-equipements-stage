@extends('layouts.app')

@section('title', 'Ajouter un Matériel')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow">
            <div class="card-header bg-success text-white text-center">
                <h5 class="mb-0 py-2">Ajouter une Matériel</h5>
            </div>
            
            <div class="card-body p-4">
                <form action="{{ route('materiels.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label class="form-label fw-bold">Nom du matériel</label>
                            <input type="text" name="nom" class="form-control @error('nom') is-invalid @enderror" value="{{ old('nom') }}">
                            @error('nom')
                                <div class="form-text text-danger ps-2">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Unité / Centre</label>
                            <select name="unite_id" class="form-select @error('unite_id') is-invalid @enderror">
                                <option value="">Choisir...</option>
                                @foreach($unites as $unite)
                                    <option value="{{ $unite->id }}">{{ $unite->nom }} ({{ $unite->ville }})</option>
                                @endforeach
                            </select>
                            @error('unite_id')
                                <div class="form-text text-danger ps-2">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Sous-Famille</label>
                            <select name="sous_famille_id" class="form-select @error('sous_famille_id') is-invalid @enderror">
                                <option value="">Choisir...</option>
                                @foreach($sousFamilles as $sf)
                                    <option value="{{ $sf->id }}">{{ $sf->famille->nomFam }} / {{ $sf->nomSousFam }}</option>
                                @endforeach
                            </select>
                            @error('sous_famille_id')
                                <div class="form-text text-danger ps-2">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Statut Initial</label>
                            <select name="status" class="form-select">
                                <option selected value="Disponible">Disponible</option>
                                <option value="Maintenance">En maintenance</option>
                                <option value="En panne">En panne</option>
                            </select>
                            @error('status')
                                <div class="form-text text-danger ps-2">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Image</label>
                            <input type="file" name="image" class="form-control @error('image') is-invalid @enderror">
                            @error('image')
                                <div class="form-text text-danger ps-2">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-12 mb-3">
                            <label class="form-label fw-bold">Description</label>
                            <textarea name="description" rows="3" class="form-control">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="form-text text-danger ps-2">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="d-flex justify-content-between gap-3">
                        <a href="{{ route('materiels.index') }}" class="btn btn-secondary">Annuler</a>
                        <button type="submit" class="btn btn-success flex-grow-1">Enregistrer le matériel</button>
                    </div>
                    
                </form>
            </div>
        </div>
    </div>
</div>
@endsection