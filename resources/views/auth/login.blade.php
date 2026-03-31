@extends('layouts.app')


@section('content')


    <div class="row justify-content-center align-items-center" style="height: 72.7vh">
        <div class="col-lg-8">
            <div class="card shadow">
                <div class="card-header pt-3 bg-primary text-white text-center">
                    <h4>Connexion</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('users.login') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label>Email</label>
                            <input type="text" name="email" class="form-control" value="{{ @old("email") }}">
                            @error("email")
                                <p class="text-danger form-text ps-2 m-0">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label>Mot de passe</label>
                            <input type="password" name="password" class="form-control">
                            @error("password")
                                <p class="text-danger form-text ps-2 m-0">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-3 form-check">
                            <input type="checkbox" name="remember" class="form-check-input" id="remember">
                            <label class="form-check-label" for="remember">Se souvenir de moi</label>
                        </div>

                        <button id="submit-button" type="submit" class="btn btn-primary w-100">Se connecter</button>

                    </form>
                </div>
            </div>
        </div>
    </div>


@endsection


@section('scripts')
    <script src="{{ asset('js/login-validation.js') }}"></script>
@endsection