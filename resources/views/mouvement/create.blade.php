@extends("layouts.app")

@section("content")

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">

                <div class="alert alert-info d-flex align-items-center shadow-sm mb-4">
                    <i class="fas fa-info-circle me-3 fa-2x"></i>
                    <div>
                        <strong>Matériel :</strong> {{ $materiel->nom }} <br/>
                        <strong>Unité actuelle :</strong> {{ $materiel->unite->nom }} <br/>
                        <strong>Statut actuel :</strong> {{ $materiel->status }}
                    </div>
                </div>

                <div class="card shadow">
                    <div class="card-header bg-success text-white text-center">
                        <h5 class="mb-0 py-2">Enregistrer un Mouvement</h5>
                    </div>
                
                    <div class="card-body">
                        <form action="{{ route('mouvements.store') }}" method="POST" >
                            @csrf
                            <input type="hidden" name="materiel_id" value="{{ $materiel->id }}">

                            
                            @if(Auth::user()->isAdmin)
                                
                                <div class="mb-3">
                                    <label class="form-label">Type de mouvement</label>
                                    <select name="type" class="form-select">
                                        <option value="Transfert">Transfert d'Unité</option>
                                        <option value="Maintenance">Envoi en Maintenance</option>
                                        <option value="Retour">Retour de Maintenance</option>
                                        <option value="Sortie">Sortie de stock</option>
                                    </select>
                                    @error('type')
                                        <div class="form-text text-danger ps-2">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Vers l'Unité</label>
                                    <select name="to_unite_id" class="form-select">
                                        @foreach($unites as $unite)
                                            <option value="{{ $unite->id }}" @selected($materiel->unite_id == $unite->id)>
                                                {{ $unite->nom }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('to_unite_id')
                                        <div class="form-text text-danger ps-2">{{ $message }}</div>
                                    @enderror
                                </div>
                            @else

                                <div class="mb-3">
                                    <label class="form-label">Action</label>
                                    <select name="type" class="form-select">
                                        <option value="Sortie">📤 Sortie (Mise en service)</option>
                                        <option value="Retour">📥 Entrée (Retour au stock)</option>
                                        <option value="Panne">🚨 Signaler une Panne</option>
                                    </select>
                                    @error('type')
                                        <div class="form-text text-danger ps-2">{{ $message }}</div>
                                    @enderror
                                </div>
                                <input type="hidden" name="to_unite_id" value="{{ $materiel->unite_id }}">

                            @endif

                            <div class="mb-3">
                                <label class="form-label">Commentaire</label>
                                <textarea name="commentaire" class="form-control" rows="2" placeholder="Note facultative..."></textarea>
                                @error('commentaire')
                                    <div class="form-text text-danger ps-2">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-flex justify-content-between gap-3">
                                <a href="{{ route('materiels.index') }}" class="btn btn-secondary">Annuler</a>
                                <button type="submit" class="btn btn-success flex-grow-1">Enregistrer le Mouvement</button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection