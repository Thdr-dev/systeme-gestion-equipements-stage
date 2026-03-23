@extends('layouts.app')

@section("title", "List des familles")

@section('content')

    <div class="mt-5">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="display-6 fw-normal text-secondary">List des Familles</h1>
            <a class="btn btn-outline-success" href="{{ route('familles.create') }}">Ajouter une Famille</a>
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
                                <a href="{{ route('familles.edit', $famille) }}" class="btn btn-sm btn-warning">Modifier</a>
                                <form action="{{ route('familles.destroy', $famille) }}" method="POST" class="d-inline" onsubmit="return confirm('Supprimer ?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger">Supprimer</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="py-3 align-middle text-center">Aucun famille</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    {{ $familles->links() }}

@endsection