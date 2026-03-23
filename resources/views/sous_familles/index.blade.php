@extends('layouts.app')

@section("title", "Liste des Sous-Famille")

@section('content')

    <div class="mt-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="display-6 fw-normal text-secondary">List des Sous-Familles</h1>
            <a class="btn btn-outline-success" href="{{ route('sous-familles.create') }}">Ajouter une Sous-Famille</a>
        </div>

        <table class="table table-bordered shadow-sm">
            <thead class="table-dark">
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
                    <td><span class="badge bg-info text-dark">{{ $sf->famille->nomFam }}</span></td>
                    <td>{{ $sf->description ?? '-' }}</td>
                    <td>
                        <a href="{{ route('sous-familles.edit', $sf) }}" class="btn btn-warning btn-sm">Modifier</a>
                        <form action="{{ route('sous-familles.destroy', $sf) }}" method="POST" class="d-inline" onsubmit="return confirm('Supprimer ?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm">Supprimer</button>
                        </form>
                    </td>
                </tr>
                @empty
                    <tr>
                        <td colspan="4" class="py-3 align-middle text-center">Aucun Sous-Famille</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{ $sousFamilles->links() }}

@endsection