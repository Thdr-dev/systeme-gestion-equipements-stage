@extends('layouts.app')

@section("title", "Liste des Sous-Famille")

@section('content')

    <div class="mt-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="display-6 fw-normal text-secondary">List des Sous-Familles</h1>
            <a class="btn btn-outline-success" href="{{ route('sous-familles.create') }}">Ajouter une Sous-Famille</a>
        </div>

        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <form id="search-form" action="{{ route('sous-familles.index') }}" method="GET">
                    <div class="d-flex">
                        <div class="input-group">
                            <span class="input-group-text bg-secondary-subtle border-end-0">
                                <i class="fa-solid fa-magnifying-glass text-muted"></i>
                            </span>
                            <input id="search-input" value="{{ request()->search }}" id="search-input" type="text" name="search" class="form-control" placeholder="Chercher par le nom de Sous-Famille" >
                            <a class="btn btn-danger m-0 border-0" style="width:150px;" href="{{ route("sous-familles.index") }}">Reset</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="card shadow-sm">
            <div class="table-responsive">
                <table class="table table-hover table-striped align-middle mb-0">
                    <thead>
                        <tr>
                            <th class="bg-primary text-secondary">Nom</th>
                            <th class="bg-primary text-secondary">Famille Parente</th>
                            <th class="bg-primary text-secondary">Description</th>
                            <th class="bg-primary text-secondary">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($sousFamilles as $sf)
                        <tr>
                            <td>{{ $sf->nomSousFam }}</td>
                            <td>
                                <span class="badge bg-info text-dark">{{ $sf->famille->nomFam }}</span>
                            </td>
                            <td>{{ $sf->description ?? '-' }}</td>
                            <td>
                                <a href="{{ route('sous-familles.edit', $sf) }}" title="Modifier" class="btn btn-outline-warning btn-sm"><i class="fas fa-edit"></i></a>
                                <form action="{{ route('sous-familles.destroy', $sf) }}" method="POST" class="d-inline" onsubmit="return confirm('Supprimer ?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-outline-danger btn-sm" title="Supprimer">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="py-3 align-middle text-center">Aucun Sous-Famille trouvé.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{ $sousFamilles->links() }}

@endsection

@section("scripts")

    <script src="{{ asset("js/search-input.js") }}"></script>

@endsection