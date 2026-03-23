@extends('layouts.app')

@section("title", "Liste des Unites")

@section('content')

    <div class="mt-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="display-6 fw-normal text-secondary">List des Unités</h1>
            <a href="{{ route('unites.create') }}" class="btn btn-outline-primary">Ajouter une Unite</a>
        </div>

        <div class="table-responsive">
            <table class="table table-hover border">
                <thead class="table-dark">
                    <tr>
                        <th class="bg-primary text-secondary">Nom du Centre</th>
                        <th class="bg-primary text-secondary">Ville</th>
                        <th class="bg-primary text-secondary">Matériels Stockés</th>
                        <th class="bg-primary text-secondary">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($unites as $unite)
                    <tr>
                        <td>{{ $unite->nom }}</td>
                        <td>{{ $unite->ville }}</td>
                        <td><span class="badge bg-secondary">{{ $unite->materiels_count }} articles</span></td>
                        <td>
                            <a href="{{ route('unites.edit', $unite) }}" class="btn btn-sm btn-warning">Modifier</a>
                            <form action="{{ route('unites.destroy', $unite) }}" method="POST" class="d-inline" onsubmit="return confirm('Supprimer ce centre ?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-danger">Supprimer</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="py-3 align-middle text-center">Aucun Unite</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{ $unites->links() }}

@endsection