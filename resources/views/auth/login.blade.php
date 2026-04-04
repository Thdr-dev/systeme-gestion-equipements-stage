@extends('layouts.app')

@section('title', 'Se Connecter')

@section('content')


<div class="row justify-content-center align-items-center" style="height: 74.6vh">
    <div class="col-lg-8">
        <div class="card border-0 shadow-lg rounded-4">
            <div class="card-body py-4 px-5">
                <div class="text-center mb-4">
                    <img src="logo-protection-civile.png" alt="Logo" class="mb-2 logo" style="width: 80px; filter: drop-shadow(0px 0px 15px #2e7d3290)">
                    <h3 class="fw-bold" style="color: #2e7d32;">Login</h3>
                </div>

                <form action="{{ route('users.login') }}" method="POST">
                    @csrf
                    
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted text-uppercase">Adresse Email</label>
                        <input type="text" name="email" class="form-control bg-light border-0" 
                               value="{{ old('email') }}" style="border-radius: 10px;">
                        @error("email")
                            <p class="text-danger small ps-2 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted text-uppercase">Mot de passe</label>
                        <input type="password" name="password" class="form-control bg-light border-0" 
                               style="border-radius: 10px;">
                        @error("password")
                            <p class="text-danger small ps-2 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-3 form-check">
                        <input type="checkbox" name="remember" value="1" class="form-check-input" id="remember" {{ old('remember') ? 'checked' : '' }}>
                        <label class="form-check-label text-muted" for="remember">Se souvenir de moi</label>
                    </div>

                    <button id="submit-button" type="submit" class="btn btn-success w-100 py-2 fw-bold text-uppercase rounded-3">
                        Connexion
                    </button>

                </form>
            </div>
        </div>
    </div>
</div>

@endsection


@section('scripts')
    <script src="{{ asset('js/login-validation.js') }}"></script>
@endsection