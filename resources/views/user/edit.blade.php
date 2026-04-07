@extends("layouts.app")

@section("title", "Modifier L'utilisateur")

@section("content")

    <div class="row justify-content-center align-items-center">
        <div class="col-lg-8">
            <div class="card shadow">
                <div class="py-2 border-0 card-header text-dark bg-warning text-center">
                    <h4>Modifier</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('users.update', $user) }}" method="POST">
                        @csrf
                        @method("PUT")
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Nom</label>
                                <input type="text" placeholder="Nom..." name="nom" class="form-control" value="{{ old('nom', $user->nom) }}" >
                                @error('nom')
                                    <div class="form-text text-danger ps-2">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Prénom</label>
                                <input type="text" placeholder="Prenom..." name="prenom" class="form-control" value="{{ old('prenom', $user->prenom) }}" >
                                @error('prenom')
                                    <div class="form-text text-danger ps-2">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input id="email" type="text" placeholder="Email..." name="email" class="form-control" value="{{ old('email', $user->email) }}" >
                            @error('email')
                                <div class="form-text text-danger ps-2">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Mot de passe</label>
                            <input id="password" type="password" placeholder="Nouveau Mot de passe..." name="password" class="form-control">
                            @error('password')
                                <div class="form-text text-danger ps-2">{{ $message }}</div>
                            @enderror
                            <div id="password-guidelines" class="mt-2 p-2 border rounded bg-light" style="font-size: 0.85rem;">
                                <p class="mb-1">Le mot de passe doit contenir :</p>
                                <ul class="list-unstyled mb-0 ps-2">
                                    <li id="rule-length" class="text-danger">✖ Au moins 8 caractères</li>
                                    <li id="rule-mixed" class="text-danger">✖ Majuscules et minuscules</li>
                                    <li id="rule-number" class="text-danger">✖ Au moins un chiffre</li>
                                    <li id="rule-symbol" class="text-danger">✖ Au moins un symbole (@$!%*?&...)</li>
                                </ul>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Confirmer le mot de passe</label>
                            <input id="password_confirmation" type="password" placeholder="Confirmation de Mot de passe..." name="password_confirmation" class="form-control" >
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Unite</label>
                            <select class="form-select" name="unite_id">
                                @foreach($unites as $unite)
                                    <option value="{{ $unite->id }}" @selected($user->unite_id == $unite->id) >{{ $unite->nom }}</option>
                                @endforeach
                            </select>
                            @error('unite_id')
                                <div class="form-text text-danger ps-2">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Status</label>
                            <select class="form-select" name="status">
                                <option value="admin" @selected($user->isAdmin === 1)>Admin</option>
                                @if( auth()->user()->id !== $user->id)
                                    <option value="operateur" @selected($user->isAdmin === 0)>Opérateur</option>
                                @endif
                            </select>
                            @error('status')
                                <div class="form-text text-danger ps-2">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex gap-3">
                            <a href="{{ route("users.index") }}" type="submit" class="btn btn-secondary">Annuler</a>
                            <button type="submit" class="btn btn-warning flex-grow-1">Mettre à jour le compte</button>
                        </div>
                        

                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection


@section('scripts')
    <script src="{{ asset('js/auth-validation.js') }}"></script>
@endsection