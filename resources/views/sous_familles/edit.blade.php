@extends('layouts.app')

@section("title", "Modifier La Sous-Famille")

@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow">

                    <div class="card-header text-dark bg-warning text-center">
                        <h5 class="mb-0 py-2">Modifier la Sous-Famille</h5>
                    </div>

                    <div class="card-body">
                        <form action="{{ route('sous-familles.update', $sousFamille->id) }}" method="POST">
                            @csrf
                            @method('PUT') <div class="mb-3">
                                <label class="form-label">Nom de la Sous-Famille</label>
                                <input type="text" name="nomSousFam"
                                    class="form-control @error('nomSousFam') is-invalid @enderror"
                                    value="{{ old('nomSousFam', $sousFamille->nomSousFam) }}" required>
                                @error('nomSousFam')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Famille Parente</label>
                                <select name="famille_id" class="form-select" required>
                                    @foreach($familles as $f)
                                        <option value="{{ $f->id }}"
                                            {{ $f->id == $sousFamille->famille_id ? 'selected' : '' }}>
                                            {{ $f->nomFam }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Description</label>
                                <textarea name="description" class="form-control" rows="3">{{ old('description', $sousFamille->description) }}</textarea>
                            </div>
                            <div class="d-flex justify-content-between gap-3">
                                <a href="{{ route('sous-familles.index') }}" class="btn btn-secondary">Annuler</a>
                                <button type="submit" class="btn btn-warning flex-grow-1">Mettre à jour</button>
                            </div>
                        </form>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>

@endsection