<div class="modal fade" id="modalMouvement{{ $materiel->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('mouvements.store') }}" method="POST" class="modal-content">
            @csrf
            <input type="hidden" name="materiel_id" value="{{ $materiel->id }}">

            <div class="modal-header bg-light">
                <h5 class="modal-title">
                    <i class="fas fa-exchange-alt text-primary me-2"></i>
                    Mouvement : {{ $materiel->nom }}
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                @if(Auth::user()->isAdmin)
                    <div class="mb-3">
                        <label class="form-label fw-bold">Type de mouvement</label>
                        <select name="type" class="form-select" required>
                            <option value="Transfert">Transfert d'Unité</option>
                            <option value="Maintenance">Envoi en Maintenance</option>
                            <option value="Retour">Retour de Maintenance</option>
                            <option value="Sortie">Sortie de stock</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Vers l'Unité</label>
                        <select name="to_unite_id" class="form-select">
                            @foreach($unites as $unite)
                                <option value="{{ $unite->id }}" @selected($materiel->unite_id == $unite->id)>
                                    {{ $unite->nom }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                @else
                    <div class="alert alert-info py-2 small">
                        <i class="fas fa-user-shield me-1"></i> Mode Opérateur : Entrée/Sortie uniquement.
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Action</label>
                        <select name="type" class="form-select" required>
                            <option value="Sortie">📤 Sortie (Mise en service)</option>
                            <option value="Retour">📥 Entrée (Retour au stock)</option>
                            <option value="Panne">🚨 Signaler une Panne</option>
                        </select>
                    </div>
                    <input type="hidden" name="to_unite_id" value="{{ $materiel->unite_id }}">
                @endif

                <div class="mb-3">
                    <label class="form-label fw-bold">Commentaire</label>
                    <textarea name="commentaire" class="form-control" rows="2" placeholder="Note facultative..."></textarea>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                <button type="submit" class="btn btn-primary">Enregistrer</button>
            </div>
        </form>
    </div>
</div>