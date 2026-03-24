@extends('layouts.app')

@section("title", "List des familles")

@section('content')

    <div class="mt-5">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="display-6 fw-normal text-secondary">List des Familles</h1>
            <a class="btn btn-outline-success" href="{{ route('familles.create') }}">Ajouter une Famille</a>
        </div>

        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <form id="search-form" action="{{ route('familles.index') }}" method="GET">
                    <div class="d-flex">
                        <div class="input-group">
                            <span class="input-group-text bg-secondary-subtle border-end-0">
                                <i class="fa-solid fa-magnifying-glass text-muted"></i>
                            </span>
                            <input id="search-input" value="{{ request()->search }}" id="search-input" type="text" name="search" class="form-control" placeholder="Chercher par le nom de Famille" >
                            <a class="btn btn-danger m-0 border-0" style="width:150px;" href="{{ route("familles.index") }}">Reset</a>
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
                            <th class="bg-primary text-secondary">Sous-catégories</th>
                            <th class="bg-primary text-secondary">Description</th>
                            <th class="bg-primary text-secondary">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($familles as $famille)
                        <tr>
                            <td>{{ $famille->nomFam }}</td>
                            <td>
                                <span class="badge bg-info text-dark">
                                    {{ $famille->sous_familles_count }} sous-familles
                                </span>
                            </td>
                            <td>{{ $famille->description ?? '-' }}</td>
                            <td>
                                <a href="{{ route('familles.edit', $famille) }}" title="Modifier" class="btn btn-sm btn-outline-warning"><i class="fas fa-edit"></i></a>
                                <form action="{{ route('familles.destroy', $famille) }}" method="POST" class="d-inline" onsubmit="return confirm('Supprimer ?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger" title="Supprimer">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="py-3 align-middle text-center">Aucun Famille trouvé.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    {{ $familles->links() }}

@endsection

@section("scripts")

    <script src="{{ asset("js/search-input.js") }}"></script>

@endsection