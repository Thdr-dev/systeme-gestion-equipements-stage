@extends('layouts.app')

@section('title', 'Détails - ' . $materiel->nom)

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="mb-3">
                <a href="{{ route('materiels.index') }}" class="btn btn-outline-secondary shadow-sm">
                    <i class="fas fa-arrow-left me-1"></i> Retour à la liste
                </a>
            </div>

            <div class="card shadow border-0 overflow-hidden">
                <div class="row g-0">
                    <div class="col-md-5 bg-light d-flex align-items-center justify-content-center p-3 border-end">
                        @if($materiel->image)
                            <img src="{{ asset('storage/' . $materiel->image) }}" alt="{{ $materiel->nom }}" class="img-fluid rounded shadow-sm" style="max-height: 450px; object-fit: contain;">
                        @else
                            <div class="text-center text-muted">
                                <i class="fas fa-camera fa-5x mb-3 opacity-25"></i>
                                <p>Aucune image disponible</p>
                            </div>
                        @endif
                    </div>

                    <div class="col-md-7">
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <div>
                                    <h2 class="fw-bold mb-1">{{ $materiel->nom }}</h2>
                                    <p class="text-muted"><i class="fas fa-tag me-1"></i> ID Matériel : #{{ str_pad($materiel->id, 5, '0', STR_PAD_LEFT) }}</p>
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
                                <div class="col-sm-6 mb-3">
                                    <label class="text-uppercase small fw-bold text-muted d-block">Localisation (Unité)</label>
                                    <span class="fs-5"><i class="fas fa-map-marker-alt text-primary me-2"></i>{{ $materiel->unite->nom }}</span>
                                </div>
                                <div class="col-sm-6 mb-3">
                                    <label class="text-uppercase small fw-bold text-muted d-block">Catégorie</label>
                                    <span class="fs-5"><i class="fas fa-folder text-warning me-2"></i>{{ $materiel->sousFamille->nom }}</span>
                                </div>
                                <div class="col-sm-6 mb-3">
                                    <label class="text-uppercase small fw-bold text-muted d-block">Famille parente</label>
                                    <span class="fs-5 text-secondary">{{ $materiel->sousFamille->famille->nom }}</span>
                                </div>
                                <div class="col-sm-6 mb-3">
                                    <label class="text-uppercase small fw-bold text-muted d-block">Date de Maintenance</label>
                                    <span class="fs-5 {{ $materiel->date_maintenance < now() ? 'text-danger fw-bold' : '' }}">
                                        <i class="fas fa-tools me-2"></i>{{ $materiel->date_maintenance ? \Carbon\Carbon::parse($materiel->date_maintenance)->format('d/m/Y') : 'Non définie' }}
                                    </span>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="text-uppercase small fw-bold text-muted d-block mb-2">Description / Notes</label>
                                <div class="p-3 bg-light rounded italic">
                                    {{ $materiel->description ?: 'Aucune description détaillée pour ce matériel.' }}
                                </div>
                            </div>

                            <div class="d-flex gap-2 pt-3 border-top">
                                <a href="{{ route('materiels.edit', $materiel->id) }}" class="btn btn-warning px-4 fw-bold">
                                    <i class="fas fa-edit me-1"></i> Modifier la fiche
                                </a>
                                
                                @if(Auth::user()->isAdmin)
                                <form action="{{ route('materiels.destroy', $materiel->id) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir archiver ce matériel ?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger px-4">
                                        <i class="fas fa-trash-alt me-1"></i> Archiver
                                    </button>
                                </form>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection