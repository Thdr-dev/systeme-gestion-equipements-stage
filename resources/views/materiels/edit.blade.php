@extends('layouts.app')

@section('title', 'Modifier : ' . $materiel->nom)

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow border-0">
            <div class="card-header bg-warning text-dark py-3">
                <h5 class="mb-0 fw-bold">Modifier le matériel</h5>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('materiels.update', $materiel->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="text-center mb-4">
                        @if($materiel->image)
                            <img src="{{ asset('storage/'.$materiel->image) }}" class="rounded shadow mb-2" width="120">
                            <p class="small text-muted">Image actuelle</p>
                        @endif
                    </div>

                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label class="form-label fw-bold">Nom du matériel</label>
                            <input type="text" name="nom" class="form-control" value="{{ old('nom', $materiel->nom) }}" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Statut actuel</label>
                            <select name="status" class="form-select">
                                @foreach(['Disponible', 'Sorti', 'En panne', 'Maintenance'] as $st)
                                    <option value="{{ $st }}" {{ $materiel->status == $st ? 'selected' : '' }}>{{ $st }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Remplacer l'image</label>
                            <input type="file" name="image" class="form-control">
                        </div>
                    </div>

                    <div class="d-grid gap-2 mt-4">
                        <button type="submit" class="btn btn-warning btn-lg fw-bold">Mettre à jour</button>
                        <a href="{{ route('materiels.index') }}" class="btn btn-link text-muted">Retour</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection