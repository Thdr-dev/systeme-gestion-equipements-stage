@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="card col-md-6 mx-auto shadow-sm">
            <div class="card-header text-dark bg-warning text-center">
                <h5 class="mb-0 py-2">Modifier la Famille</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('familles.update', $famille->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label class="form-label">Nom de la Famille</label>
                        <input type="text" name="nomFam" 
                            class="form-control" 
                            value="{{ old('nomFam', $famille->nomFam) }}" >
                        @error('nomFam')
                            <div class="form-text text-danger ps-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Description (Optionnel)</label>
                        <textarea name="description" class="form-control" rows="3">{{ old('description', $famille->description) }}</textarea>
                        @error('description')
                            <div class="form-text text-danger ps-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-between gap-3">
                        <a href="{{ route('familles.index') }}" class="btn btn-secondary">Annuler</a>
                        <button type="submit" class="btn btn-warning flex-grow-1">Mettre à jour</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection