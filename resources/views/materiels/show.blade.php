@extends('layouts.app')

@section('title', 'Détails de Materiel')

@section('content')

    <div class="mt-5">
        
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="mb-3">
                    <a href="{{ route('materiels.index', Auth::user()->isAdmin ? ['unite_id' => Auth::user()->unite_id] : []) }}" class="btn btn-outline-secondary shadow-sm">
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
                                    
                                    <div class="badge px-3 py-2 fs-6 {{ 
                                            $materiel->status == 'Disponible' ? 'bg-success' : 
                                            ($materiel->status == 'En panne' ? 'bg-danger' : 
                                            ($materiel->status == 'Maintenance' ? 'bg-warning text-dark' : 'bg-secondary')) 
                                        }}">
                                        <span>
                                            <i class="fas fa-circle me-1 small"></i> {{ $materiel->status }}
                                        </span>
                                        <p class="m-0 form-text text-light">{{ $materiel->status === "Sorti" ? ( ($materiel->mouvements()->latest()->first()?->user_id == auth()->user()->id ) ? "( Par moi )" : "( Par autre operateur )" ): '' }}</p> 
                                    </div>
                                    
                                    
                                </div>

                                <hr>

                                <div class="row mb-4">

                                    <div class="mb-3">
                                        <label class="text-uppercase small fw-bold text-muted d-block">Localisation (Unité)</label>
                                        <span class="ms-2 mt-2 fs-6 badge bg-info text-secondary"><i class="fas fa-map-marker-alt text-primary me-2"></i>{{ $materiel->unite->nom }}</span>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label class="text-uppercase small fw-bold text-muted d-block">Famille parente</label>
                                        <span class="ms-2 mt-2 fs-6 badge bg-info text-secondary"><i class="fa-solid fa-table-cells-large text-primary me-2"></i>{{ $materiel->sousFamille->famille->nomFam }}</span>
                                    </div>

                                    <div class="mb-3">
                                        <label class="text-uppercase small fw-bold text-muted d-block">Catégorie</label>
                                        <span class="ms-2 mt-2 fs-6 badge bg-info text-secondary"><i class="fa-solid fa-layer-group text-primary me-2"></i>{{ $materiel->sousFamille->nomSousFam }}</span>
                                    </div>

                                    <div class="mb-3">
                                        <label class="text-uppercase small fw-bold text-muted d-block">Maintenance Préventive</label>
                                        
                                        @php
                                            $date = $materiel->date_maintenance;
                                            $statusColor = 'light text-dark';
                                            if($date) {
                                                if($date->isPast() && !$date->isToday()) $statusColor = 'danger text-white';
                                                elseif($date->isToday()) $statusColor = 'warning text-dark';
                                                elseif($date->diffInDays(now()) <= 7) $statusColor = 'info text-secondary';
                                                else $statusColor = 'success text-white';
                                            }
                                        @endphp

                                        <span class="badge bg-{{ $statusColor }} mt-2 p-2 fs-6 ms-2">
                                            <i class="fas fa-tools me-2"></i>
                                            {{ $date ? $date->format('d/m/Y') : 'Non définie' }}
                                        </span>
                                    </div>

                                    @if($materiel->status === 'Maintenance' && $materiel->delai_maintenance)
                                        <div class="col-lg-6 mb-3">
                                            <label class="text-uppercase small fw-bold text-muted d-block">Retour de réparation prévu</label>
                                            <span class="ms-2 mt-2 fs-6 badge {{ $materiel->delai_maintenance->isPast() ? 'bg-danger text-white' : 'bg-primary text-white' }} shadow-sm">
                                                <i class="fas fa-calendar-check me-2"></i>{{ $materiel->delai_maintenance->format('d/m/Y') }}
                                                @if($materiel->delai_maintenance->isPast())
                                                    <small class="ms-1">(EN RETARD)</small>
                                                @endif
                                            </span>
                                        </div>
                                    @endif

                                </div>

                                <div class="mb-4">
                                    <label class="text-uppercase small fw-bold text-muted d-block mb-2">Description</label>
                                    <div class="p-3 bg-light rounded italic">
                                        {{ $materiel->description ?: 'Aucune description détaillée pour ce matériel.' }}
                                    </div>
                                </div>

                                @if($materiel->unite_id == Auth::user()->unite_id)
                                    @if(Auth::user()->isAdmin)


                                        @if($materiel->status === 'Maintenance' && $materiel->delai_maintenance)
                                            @php
                                                $enRetard = $materiel->delai_maintenance->isPast();
                                                $temps = $materiel->delai_maintenance->diffForHumans(null, true);
                                            @endphp

                                            <div class="alert {{ $enRetard ? 'alert-danger' : 'alert-primary' }} d-flex align-items-center shadow-sm">
                                                <i class="fas {{ $enRetard ? 'fa-exclamation-triangle' : 'fa-info-circle' }} me-3 fa-2x"></i>
                                                <div>
                                                    <strong>Attention :</strong> Cet équipement est en maintenance. 
                                                    @if($enRetard)
                                                        Le retour était prévu pour le {{ $materiel->delai_maintenance->format('d/m/Y') }} (Retard de {{ $temps }}).
                                                    @else
                                                        Retour attendu dans {{ $temps }}.
                                                    @endif
                                                </div>
                                            </div>
                                        @endif

                                        
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
                                                    
                                                    @if(!in_array($materiel->status, ["En panne", "Maintenance"]))
                                                        <div class="col-12">
                                                            <a href="{{ route('mouvements.declarePanne', $materiel) }}" class="btn btn-outline-danger w-100"
                                                                title="Declarer une Panne">
                                                                <i class="fa-solid fa-triangle-exclamation"></i> Declare une Panne
                                                            </a>
                                                        </div>
                                                    @endif

                                                </div>
                                            </div>

                                        </div>
                                        
                                        <div class="mt-3 alert alert-info py-2">
                                            <small><i class="fas fa-info-circle"></i> &nbsp; La suppression de cet materiel est pas un suppression complete.</small>
                                        </div>
                                        @else

                                            @if( !in_array($materiel->status, ["En panne", "Maintenance"]) )
                                                <a href="{{ route('mouvements.create', $materiel) }}" class="btn btn-outline-info w-100 mb-2" title="Enregistrer un mouvement">
                                                    <i class="fas fa-exchange-alt"></i> Enregistrer un mouvement
                                                </a>

                                                <a href="{{ route('mouvements.declarePanne', $materiel) }}" class="btn btn-outline-danger w-100"
                                                    title="Declarer une Panne">
                                                    <i class="fa-solid fa-triangle-exclamation"></i> Declare une Panne
                                                </a>
                                            @endif

                                    @endif
                                @endif
                            </div>
                        </div>

                    </div>
                </div>
            </div>      
        </div>

        @if($materiel->unite_id == Auth::user()->unite_id)
            @if(Auth::user()->isAdmin)
                <div class="card shadow-sm mt-4">
                    <div class="card-header text-bg-dark">
                        <h5 class="mb-0"><i class="fas fa-history me-2"></i>Historique des Mouvements</h5>
                    </div>
                    <div class="card">
                        <div class="table-responsive">
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
                                                <span class="badge @if($mvt->type == 'Panne') bg-danger @elseif($mvt->type == 'Transfert') bg-info @elseif($mvt->type == 'Retour') bg-success @else bg-secondary @endif">
                                                    {{ $mvt->type }}
                                                </span>
                                            </td>
                                            <td class="small">
                                                {{ $mvt->fromUnite->nom ?? 'N/A' }}
                                                <i class="fas fa-long-arrow-alt-right mx-2 text-muted"></i>
                                                {{ $mvt->toUnite->nom ?? 'N/A' }}
                                            </td>
                                            <td>{{ $mvt->user->prenom . " " . $mvt->user->nom }}</td>
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
        @endif
        
    </div>

@endsection