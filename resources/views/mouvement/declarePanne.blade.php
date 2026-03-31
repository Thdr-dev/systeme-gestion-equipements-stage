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
                    <div class="card-header bg-danger-subtle text-center">
                        <h5 class="mb-0 py-2">Declarer une Panne</h5>
                    </div>
                
                    <div class="card-body">
                        <form action="{{ route('mouvements.store') }}" method="POST" >
                            @csrf
                            <input type="hidden" name="materiel_id" value="{{ $materiel->id }}">
                            <input type="hidden" name="type" value="Panne">


                            <div class="mb-3">
                                <label class="form-label">Commentaire</label>
                                <textarea name="commentaire" class="form-control" rows="2" placeholder="Note facultative..."></textarea>
                                @error('commentaire')
                                    <div class="form-text text-danger ps-2">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-flex justify-content-between gap-3">
                                <a href="{{ url()->previous("/") }}" class="btn btn-secondary">Annuler</a>
                                <button type="submit" onclick="return confirm('Valider la declaration')" class="btn bg-danger-subtle flex-grow-1">Valider</button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
