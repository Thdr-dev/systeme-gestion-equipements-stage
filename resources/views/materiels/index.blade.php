@extends('layouts.app')

@section('title', 'Inventaire Matériel')

@section('content')

    <div class="mt-5">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="display-6 fw-normal text-secondary">List du Matériel</h1>
            @if(Auth::user()->isAdmin)
                <a class="btn btn-outline-success" href="{{ route('materiels.create') }}">Ajouter un Matériel</a>
            @endif
        </div>
        
        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <form id="search-form" method="GET" action="{{ route('materiels.index') }}" class="row g-3">
                    
                    <div class="col-lg-4 col-md-6">
                        <div class="input-group">
                            <span class="input-group-text bg-secondary-subtle border-end-0">
                                <i class="fa-solid fa-magnifying-glass text-muted"></i>
                            </span>
                            <input type="text" name="search" class="search-input form-control" placeholder="Rechercher par le nom de materiel" value="{{ request('search') }}">
                        </div>
                    </div>

                    <div class="col-lg-2 col-md-6">
                        <select name="unite_id" class="search-input form-select">
                            <option value="">Toutes les Unités</option>
                            @foreach($unites as $unite)
                                <option value="{{ $unite->id }}" @selected(request('unite_id') == $unite->id) >{{ $unite->nom }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-lg-2 col-md-6">
                        <select name="status" class="search-input form-select">
                            @if(Auth::user()->isAdmin)
                                <option value="">Tous les statuts</option>
                                @foreach(['Disponible', 'Sorti', 'En panne', 'Maintenance'] as $status)
                                    <option value="{{ $status }}" @selected(request('status') == $status)>{{ $status }}</option>
                                @endforeach
                            @else
                                <option value="">Tous mes accès</option>
                                <option value="Disponible" @selected(request('status') == 'Disponible')>Disponible</option>
                                <option value="Sorti" @selected(request('status') == 'Sorti')>Sorties</option>
                            @endif
                        </select>
                    </div>
                    
                    <div class="col-lg-2 col-md-6">
                        <select name="sous_famille_id" class="search-input form-select">
                            <option value="">Tous les Categories</option>
                            @foreach($sousFamilles as $sousFam)
                                <option value="{{ $sousFam->id }}" @selected(request('sous_famille_id') == $sousFam->id) >{{ $sousFam->nomSousFam }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-lg-2 d-grid">
                        <a class="btn btn-secondary m-0 border-0 w-100" href="{{ route("materiels.index") }}">Reset</a>
                    </div>

                </form>
            </div>
        </div>

        <div class="card shadow-sm">
            <div class="table-responsive">
                <table class="table table-hover table-striped align-middle mb-0">
                    <thead>
                        <tr>
                            <th class="bg-primary text-secondary">Image</th>
                            <th class="bg-primary text-secondary">Nom</th>
                            <th class="bg-primary text-secondary">Unité</th>
                            <th class="bg-primary text-secondary">Statut</th>
                            <th class="bg-primary text-secondary">Catégorie</th>
                            <th class="bg-primary text-secondary">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($materiels as $item)
                        <tr>
                            <td>
                                @if($item->image)
                                    <img draggable="false" src="{{ asset('storage/'.$item->image) }}" class="rounded shadow-sm" width="50" height="50" style="object-fit: cover; aspect-ratio: 1/1;">
                                @else
                                    <div class="bg-light rounded d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                        <i class="fas fa-image text-muted"></i>
                                    </div>
                                @endif
                            </td>
                            <td>
                                <div class="fw-bold">{{ $item->nom }}</div>
                                <small class="text-muted">{{ Str::limit($item->description, 30) }}</small>
                            </td>
                            <td><span class="badge bg-info text-dark">{{ $item->unite->nom }}</span></td>
                            <td>
                                <span class="badge {{ $item->status == 'Disponible' ? 'bg-success' : ($item->status == 'En panne' ? 'bg-danger' : 'bg-warning text-dark') }}">
                                    {{ $item->status }}
                                </span>   {{ $item->status === "Sorti" ? ( ($item->mouvements()->latest()->first()?->user_id == auth()->user()->id ) ? "( Par moi )" : "( Par autre operateur )" ): '' }} 
                            </td>
                            <td>{{ $item->sousFamille->nomSousFam }}</td>
                            <td>
                                <a href="{{ route('materiels.show', $item->id) }}" class="mb-1 mb-lg-0 btn btn-sm btn-outline-primary" title="Voir"><i class="fas fa-eye"></i></a>
                                
                                @if(Auth::user()->isAdmin)
                                <a href="{{ route('materiels.edit', $item->id) }}" class="mb-1 mb-lg-0 btn btn-sm btn-outline-warning" title="Modifier"><i class="fas fa-edit"></i></a>
                                @endif

                                @if( !in_array($item->status, ["En panne", "Maintenance"]) )
                                    <a href="{{ route('mouvements.declarePanne', $item->id) }}" class="btn btn-sm btn-outline-danger" title="Declarer une panne"><i class="fa-solid fa-triangle-exclamation"></i></a>
                                @endif
                                
                                <a href="{{ route('mouvements.create', $item->id) }}" class="btn btn-sm btn-outline-info" title="Enregistrer un mouvement"><i class="fas fa-exchange-alt"></i></a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted">Aucun matériel trouvé.</td>
                        </tr>
                        @endforelse
                    </tbody>
                    @if($materiels->hasPages())
                        <tfoot>
                            <tr>
                                <td colspan="6" class="px-3 pt-3 pb-0">
                                    {{ $materiels->links() }}
                                </td>
                            </tr>
                        </tfoot>
                    @endif
                </table>
            </div>
        </div>
        
    </div>

@endsection

@section("scripts")
    <script src="{{ asset("js/search-materiels.js") }}"></script>
@endsection