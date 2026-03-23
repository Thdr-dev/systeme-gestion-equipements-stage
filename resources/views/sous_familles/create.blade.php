@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="card col-md-8 mx-auto">
            <div class="card-header bg-success text-white text-center">
                <h5 class="mb-0 py-2">Ajouter une Sous-Famille</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('sous-familles.store') }}" method="POST">
                    @csrf
                    
                    <div class="mb-3">
                        <label class="form-label">Nom de la Sous-Famille</label>
                        <input type="text" name="nomSousFam" class="form-control" placeholder="Ex: Radios Portatives">
                        @error('nomSousFam')
                            <div class="form-text text-danger ps-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Sélectionner la Famille Parente</label>
                        <select name="famille_id" class="form-select">
                            <option value="" hidden>-- Choisir une Famille --</option>
                            @foreach($familles as $f)
                                <option @selected( old('famille_id') == $f->id ) value="{{ $f->id }}">{{ $f->nomFam }}</option>
                            @endforeach
                        </select>
                        @error('famille_id')
                            <div class="form-text text-danger ps-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Description (Optionnel)</label>
                        <textarea name="description" class="form-control" rows="3"></textarea>
                        @error('description')
                            <div class="form-text text-danger ps-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-between gap-3">
                        <a href="{{ route('sous-familles.index') }}" class="btn btn-secondary">Annuler</a>
                        <button type="submit" class="btn btn-success flex-grow-1">Enregistrer le sous famille</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection