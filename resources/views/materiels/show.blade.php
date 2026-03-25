@extends('layouts.app')

@section('title', 'Détails - ' . $materiel->nom)

@section('content')
<div class="container-fluide py-4">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="mb-3">
                <a href="{{ route('materiels.index') }}" class="btn btn-outline-secondary shadow-sm">
                    <i class="fas fa-arrow-left me-1"></i> Retour à la liste
                </a>
            </div>

            <div class="card shadow border-0 overflow-hidden">
                <div class="row g-0">

                    <div class="col-lg-5 bg-light d-flex align-items-center justify-content-center p-4 border-end">
                        @if($materiel->image)
                            <img draggable="false" src="{{ asset('storage/' . $materiel->image) }}" alt="{{ $materiel->nom }}" class="img-fluid rounded shadow-sm" style="max-height: 400px;">
                        @else
                            <div class="text-center text-muted">
                                <i class="fas fa-camera fa-5x mb-3 opacity-25"></i>
                                <p>Aucune image disponible</p>
                            </div>
                        @endif
                    </div>

                    <div class="col-lg-7">
                        <div class="card-body p-4">

                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <div>
                                    <h2 class="fw-bold mb-1">{{ $materiel->nom }}</h2>
                                    <p class="text-muted"><i class="fas fa-tag me-1"></i> ID Matériel : #{{ $materiel->id }}</p>
                                </div>
                                <span class="badge px-3 py-2 fs-6 {{ 
                                    $materiel->status == 'Disponible' ? 'bg-success' : 
                                    ($materiel->status == 'En panne' ? 'bg-danger' : 
                                    ($materiel->status == 'Maintenance' ? 'bg-warning text-dark' : 'bg-secondary')) 
                                }}">
                                    <i class="fas fa-circle me-1 small"></i> {{ $materiel->status }}
                                </span>
                            </div>

                            <hr>

                            <div class="row mb-4">

                                <div class="col-lg-6 mb-3">
                                    <label class="text-uppercase small fw-bold text-muted d-block">Localisation (Unité)</label>
                                    <span class="ms-2 mt-2 fs-6 badge bg-info text-secondary"><i class="fas fa-map-marker-alt text-primary me-2"></i>{{ $materiel->unite->nom }}</span>
                                </div>
                                
                                <div class="col-lg-6 mb-3">
                                    <label class="text-uppercase small fw-bold text-muted d-block">Famille parente</label>
                                    <span class="ms-2 mt-2 fs-6 badge bg-info text-secondary"><i class="fa-solid fa-table-cells-large text-primary me-2"></i>{{ $materiel->sousFamille->famille->nomFam }}</span>
                                </div>

                                <div class="col-lg-6 mb-3">
                                    <label class="text-uppercase small fw-bold text-muted d-block">Catégorie</label>
                                    <span class="ms-2 mt-2 fs-6 badge bg-info text-secondary"><i class="fa-solid fa-layer-group text-primary me-2"></i>{{ $materiel->sousFamille->nomSousFam }}</span>
                                </div>

                                <div class="col-lg-6 mb-3">
                                    <label class="text-uppercase small fw-bold text-muted d-block">Date de Maintenance</label>
                                    <span class="ms-2 mt-2 fs-6 badge bg-info text-secondary {{ $materiel->date_maintenance < now() ? 'text-danger fw-bold' : '' }}">
                                        <i class="fas fa-tools text-primary me-2"></i>{{ $materiel->date_maintenance ? \Carbon\Carbon::parse($materiel->date_maintenance)->format('d/m/Y') : 'Non définie' }}
                                    </span>
                                </div>

                            </div>

                            <div class="mb-4">
                                <label class="text-uppercase small fw-bold text-muted d-block mb-2">Description</label>
                                <div class="p-3 bg-light rounded italic">
                                    {{ $materiel->description ?: 'Aucune description détaillée pour ce matériel.' }}
                                </div>
                            </div>

                            @if(Auth::user()->isAdmin)
                                
                                <div class="d-flex align-items-center gap-2 pt-3 border-top">
                                    <div class="container-fluide">
                                        <div class="row g-3">
                                            <div class="col-md-6 col-12">
                                                <a href="{{ route('materiels.edit', $materiel->id) }}" class="w-100 btn btn-outline-warning px-4 fw-bold">
                                                    <i class="fas fa-edit me-1"></i> Modifier le materiel
                                                </a>
                                            </div>
                                            
                                            <div class="col-md-6 col-12">
                                                <form class="w-100" action="{{ route('materiels.destroy', $materiel->id) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce matériel ?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="w-100 btn btn-outline-danger px-4">
                                                        <i class="fas fa-trash-alt me-1"></i> Supprimer
                                                    </button>
                                                </form>
                                            </div>
                                            
                                            <div class="col-12">
                                                <a href="{{ route('mouvements.create', $materiel) }}" class="btn btn-outline-info w-100"
                                                    title="Enregistrer un mouvement">
                                                    <i class="fas fa-exchange-alt"></i> Enregistrer un mouvement
                                                </a>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                
                                <div class="mt-3 alert alert-info py-2">
                                    <small><i class="fas fa-info-circle"></i> &nbsp; La suppression de cet materiel est pas un suppression complete.</small>
                                </div>
                                @else
                                    <a href="{{ route('mouvements.create', $materiel) }}" class="btn btn-outline-info w-100" title="Enregistrer un mouvement">
                                        <i class="fas fa-exchange-alt"></i> Enregistrer un mouvement
                                    </a>
                            @endif
                        </div>
                    </div>

                </div>
            </div>
        </div>      
    </div>

    @if(Auth::user()->isAdmin)
            <div class="card shadow-sm mt-4">
                <div class="card-header text-bg-dark">
                    <h5 class="mb-0"><i class="fas fa-history me-2"></i>Historique des Mouvements</h5>
                </div>
                <div class="card-body p-0">
                    <div class="responsive-table">
                        <table class="table table-hover table-striped align-middle mb-0">
                            <thead>
                                <tr>
                                    <th class="bg-primary text-secondary">Date</th>
                                    <th class="bg-primary text-secondary">Type</th>
                                    <th class="bg-primary text-secondary">Source ➔ Destination</th>
                                    <th class="bg-primary text-secondary">Par</th>
                                    <th class="bg-primary text-secondary">Commentaire</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($materiel->mouvements->sortByDesc('created_at') as $mvt)
                                    <tr>
                                        <td class="small">{{ $mvt->created_at->format('d/m/Y H:i') }}</td>
                                        <td>
                                            <span class="badge @if($mvt->type == 'Panne') bg-danger @elseif($mvt->type == 'Transfert') bg-info @else bg-secondary @endif">
                                                {{ $mvt->type }}
                                            </span>
                                        </td>
                                        <td class="small">
                                            {{ $mvt->fromUnite->nom ?? 'N/A' }}
                                            <i class="fas fa-long-arrow-alt-right mx-2 text-muted"></i>
                                            {{ $mvt->toUnite->nom ?? 'N/A' }}
                                        </td>
                                        <td>{{ $mvt->user->nom }}</td>
                                        <td class="text-muted italic small">{{ $mvt->commentaire ?: '-' }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-3 text-muted">Aucun mouvement enregistré pour ce matériel.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        
    @endif

</div>
@endsection