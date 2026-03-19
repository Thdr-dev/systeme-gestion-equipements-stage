<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm mb-4 p-2">
    <div class="container-fluid">
        <a class="navbar-brand fw-bold pt-2 " href="{{ url('/') }}">
            <img draggable="false" width="30" src="{{ asset("logo-protection-civile.png") }}" /> <span class="d-inline-block ms-2">Accueil</span>
        </a>
        
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            @auth
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="materiels.index">Liste Matériels</a>
                    </li>

                    @if(Auth::user()->isAdmin)
                        <li class="nav-item">
                            <a class="nav-link" href="">Suivi Entretien</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="">Statistiques</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ Route::is('users.index') ? 'text-secondary' : 'text-white' }}" 
                            href="{{ Route::is('users.index') ? '#' : route('users.index') }}"
                            style="{{ Route::is('users.index') ? 'pointer-events: none;' : '' }}">
                                Utilisateurs
                            </a>
                        </li>
                    @endif
                </ul>

                <ul class="navbar-nav ms-auto pe-0 pe-lg-5">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="userDrop" data-bs-toggle="dropdown">
                            <i class="fas fa-user-circle me-1"></i> {{ Auth::user()->prenom }}
                        </a>
                        <ul class="dropdown-menu shadow" style="left: -30px">
                            <li>
                                <form action="{{ route('users.logout') }}" method="POST">
                                    @csrf
                                    <button class="dropdown-item text-secondary pe-0" type="submit">
                                        <i class="fas fa-sign-out-alt"></i> Déconnexion
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>
                    @if(Auth::user()->isAdmin)
                        <li class="nav-item">
                            <a class="btn btn-outline-light ms-lg-2" href="{{ route('users.register') }}">Ajouter un Operateur</a>
                        </li>
                    @endif
                </ul>
            @endauth

            @guest
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('users.login') }}">Se connecter</a>
                    </li>
                </ul>
            @endguest
        </div>
    </div>
</nav>