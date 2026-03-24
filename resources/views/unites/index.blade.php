@extends('layouts.app')

@section("title", "Liste des Unites")

@section('content')

    <div class="mt-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="display-6 fw-normal text-secondary">List des Unités</h1>
            <a class="btn btn-outline-success" href="{{ route('unites.create') }}">Ajouter une Unite</a>
        </div>
        
        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <form id="search-form" action="{{ route('unites.index') }}" method="GET">
                    <div class="d-flex">
                        <div class="input-group">
                            <span class="input-group-text bg-secondary-subtle border-end-0">
                                <i class="fa-solid fa-magnifying-glass text-muted"></i>
                            </span>
                            <input value="{{ request()->search }}" id="search-input" type="text" name="search" class="form-control" placeholder="Chercher par le nom ou ville de l'unite" >
                            <a class="btn btn-danger m-0 border-0" style="width:150px;" href="{{ route("unites.index") }}">Reset</a>
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
                            <th class="bg-primary text-secondary">Nom du Centre</th>
                            <th class="bg-primary text-secondary">Ville</th>
                            <th class="bg-primary text-secondary">Matériels</th>
                            <th class="bg-primary text-secondary">Description</th>
                            <th class="bg-primary text-secondary">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($unites as $unite)
                        <tr>
                            <td>{{ $unite->nom }}</td>
                            <td>{{ $unite->ville }}</td>
                            <td><span class="badge bg-secondary">{{ $unite->materiels_count }} articles</span></td>
                            <td>{{ $unite->description ?? "-" }}</td>
                            <td>
                                <a href="{{ route('unites.edit', $unite) }}" title="Modifier" class="btn btn-sm btn-outline-warning"><i class="fas fa-edit"></i></a>
                                <form action="{{ route('unites.destroy', $unite) }}" method="POST" class="d-inline" onsubmit="return confirm('Supprimer ce centre ?')">
                                    @csrf @method('DELETE')
                                    <button title="Supprimer" class="btn btn-sm btn-outline-danger">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-3 align-middle text-center">Aucun Unite trouvé.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    {{ $unites->links() }}

@endsection

@section("scripts")

    <script src="{{ asset("js/search-input.js") }}"></script>

@endsection