@extends('layouts.app')

@section('title', 'Modifier : ' . $materiel->nom)

@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow">

                    <div class="card-header text-dark bg-warning text-center">
                        <h5 class="mb-0 py-2">Modifier le matériel</h5>
                    </div>

                    <div class="card-body p-0">
                        <form action="{{ route('materiels.update', $materiel->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
        
                            <div class="text-center bg-light py-4">
                                @if($materiel->image)
                                    <img draggable="false" src="{{ asset('storage/'.$materiel->image) }}" class="rounded shadow materiel_image" width="250">
                                    <p class="small text-muted m-0">Image actuelle</p>
                                @endif
                            </div>
                            <div class="p-4">
                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label fw-bold">Nom du matériel</label>
                                        <input type="text" name="nom" class="form-control" value="{{ old('nom', $materiel->nom) }}" required>
                                        @error('nom')
                                            <div class="form-text text-danger ps-2">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-bold">Category</label>
                                        <select name="sous_famille_id" class="form-select">
                                            @foreach($sousFamilles as $sf)
                                                <option value="{{ $sf->id }}" @selected($materiel->sous_famille_id == $sf->id) >{{ $sf->nomSousFam }}</option>
                                            @endforeach
                                        </select>
                                        @error('status')
                                            <div class="form-text text-danger ps-2">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-bold">Statut actuel</label>
                                        <select name="status" class="form-select">
                                            @foreach(['Disponible', 'Sorti', 'En panne', 'Maintenance'] as $st)
                                                <option value="{{ $st }}" @selected($materiel->status == $st) >{{ $st }}</option>
                                            @endforeach
                                        </select>
                                        @error('status')
                                            <div class="form-text text-danger ps-2">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-bold">Unite</label>
                                        <select name="unite_id" class="search-input form-select">
                                            <option value="">Toutes les Unités</option>
                                            @foreach($unites as $unite)
                                                <option value="{{ $unite->id }}" @selected( $materiel->unite_id == $unite->id) >{{ $unite->nom }}</option>
                                            @endforeach
                                        </select>
                                        @error('unite_id')
                                            <div class="form-text text-danger ps-2">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-bold">Date maintenance</label>
                                        <input id="date_maintenance" type="date" class="form-control" name="date_maintenance" value="{{ old('date_maintenance', $materiel->date_maintenance) }}">
                                        @error('date_maintenance')
                                            <div class="form-text text-danger ps-2">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label fw-bold">Remplacer l'image</label>
                                        <input type="file" name="image" class="form-control">
                                        @error('image')
                                            <div class="form-text text-danger ps-2">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label fw-bold">Description</label>
                                        <textarea name="" rows="3" class="form-control">{{ old('description', $materiel->description) }}</textarea>
                                        @error('description')
                                            <div class="form-text text-danger ps-2">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="d-flex justify-content-between gap-3">
                                    <a href="{{ route('materiels.index') }}" class="btn btn-secondary">Annuler</a>
                                    <button type="submit" class="btn btn-warning flex-grow-1">Mettre à jour</button>
                                </div>
                            </div>


                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>

@endsection


@section("scripts")
    
    <script>
        
        const today = new Date().toISOString().split("T")[0];
        
        const dateInput = document.getElementById("date_maintenance")
        
        dateInput.setAttribute("min", today);

    </script>

@endsection