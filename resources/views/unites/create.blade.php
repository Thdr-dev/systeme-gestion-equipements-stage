@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="card col-md-8 mx-auto shadow">
            <div class="card-header bg-primary text-white">Ajouter un nouveau centre</div>
            <div class="card-body">
                <form action="{{ route('unites.store') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Nom du Centre (ex: Caserne Nord)</label>
                            <input type="text" name="nom" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Ville</label>
                            <input type="text" name="ville" class="form-control" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Description / Adresse</label>
                        <textarea name="description" class="form-control" rows="3"></textarea>
                    </div>
                    <button type="submit" class="btn btn-success w-100">Enregistrer l'Unité</button>
                </form>
            </div>
        </div>
    </div>

@endsection