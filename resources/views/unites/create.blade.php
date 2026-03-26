@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow">
                    <div class="card-header bg-success text-white text-center">
                        <h5 class="mb-0 py-2">Ajouter une nouveau Unite</h5>
                    </div>

                    <div class="card-body">
                        <form action="{{ route('unites.store') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Nom du Centre (ex: Caserne Nord)</label>
                                    <input type="text" name="nom" class="form-control" value="{{ old('nom') }}">
                                    @error('nom')
                                        <div class="form-text text-danger ps-2">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Type d'unité</label>
                                    <select name="type" class="form-control">
                                        <option value="Direction">Direction</option>
                                        <option value="Service">Service</option>
                                        <option value="Bureau">Bureau</option>
                                        <option value="Caserne">Caserne / Centre</option>
                                    </select>
                                    @error('type')
                                        <div class="form-text text-danger ps-2">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Ville</label>
                                    <input type="text" name="ville" class="form-control" value="{{ old('ville') }}">
                                    @error('ville')
                                        <div class="form-text text-danger ps-2">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Unité Parente (Rattachement)</label>
                                    <select name="parent_id" class="form-control">
                                        <option value="">-- Aucune --</option>
                                        @foreach($unites as $unite)
                                            <option value="{{ $unite->id }}">{{ $unite->nom }}</option>
                                        @endforeach
                                    </select>
                                    @error('parent_id')
                                        <div class="form-text text-danger ps-2">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Description</label>
                                <textarea name="description" class="form-control" rows="3">{{ old('description') }}</textarea>
                                @error('description')
                                    <div class="form-text text-danger ps-2">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-flex justify-content-between gap-3">
                                <a href="{{ route('unites.index') }}" class="btn btn-secondary">Annuler</a>
                                <button type="submit" class="btn btn-success w-100">Enregistrer l'Unité</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>

@endsection