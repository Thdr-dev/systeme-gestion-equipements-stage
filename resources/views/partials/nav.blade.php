<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm mb-4 p-2">
    <div class="container-fluid">
        <a class="navbar-brand fw-bold pt-2 nav-link {{ request()->is('/') ? 'disabled text-secondary' : '' }}" href="{{ url('/') }}">
            <img class="logo" draggable="false" width="30" src="{{ asset('logo-protection-civile-low.png') }}" /> 
            <span class="d-inline-block ms-2">Accueil</span>
        </a>
        
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            @auth
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('materiels.*') ? 'disabled text-secondary' : '' }}" href="{{ route('materiels.index') }}">
                            Liste Matériels
                        </a>
                    </li>

                    @if(Auth::user()->isAdmin)
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle {{ request()->routeIs('familles.*', 'sous-familles.*', 'unites.*', 'users.*') ? 'active text-secondary' : '' }}" href="#" id="configDrop" data-bs-toggle="dropdown">
                                Administration
                            </a>
                            <ul class="dropdown-menu shadow py-0 overflow-hidden">
                                <li class="nav-item">
                                    <a class="dropdown-item py-2 {{ request()->routeIs('users.index') ? 'bg-primary-subtle disabled text-secondary fw-bold' : 'text-black' }}" 
                                    href="{{ route('users.index') }}">
                                        Utilisateurs
                                    </a>
                                </li>
                                <li><hr class="dropdown-divider m-0"></li>
                                <li><a class="dropdown-item py-2 {{ request()->routeIs('familles.index') ? 'bg-primary-subtle disabled text-secondary fw-bold' : 'text-black' }}" href="{{ route('familles.index') }}">Familles</a></li>
                                <li><a class="dropdown-item py-2 {{ request()->routeIs('sous-familles.index') ? 'bg-primary-subtle disabled text-secondary fw-bold' : 'text-black' }}" href="{{ route('sous-familles.index') }}">Sous-Familles</a></li>
                                <li><hr class="dropdown-divider m-0"></li>
                                <li><a class="dropdown-item py-2 {{ request()->routeIs('unites.index') ? 'bg-primary-subtle disabled text-secondary fw-bold' : 'text-black' }}" href="{{ route('unites.index') }}">Unités (Centres)</a></li>

                            </ul>
                        </li>


                        <li class="nav-item">
                            <a class="nav-link" href="">Statistiques</a>
                        </li>
                        
                    @endif
                </ul>

                <ul class="navbar-nav ms-auto pe-0 pe-lg-5">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="userDrop" data-bs-toggle="dropdown">
                            <i class="fas fa-user-circle me-1"></i> {{ Auth::user()->prenom }}
                        </a>
                        <ul class="dropdown-menu shadow py-0 overflow-hidden" style="left: -30px">
                            <li>
                                <form action="{{ route('users.logout') }}" method="POST">
                                    @csrf
                                    <button class="dropdown-item text-danger py-2" type="submit">
                                        <i class="fas fa-sign-out-alt"></i> Déconnexion
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>
                    {{-- @if(Auth::user()->isAdmin)
                        <li class="nav-item">
                            <a class="btn btn-outline-light ms-lg-2" href="{{ route('users.register') }}">
                                <i class="fas fa-user-plus"></i> Ajouter un Operateur
                            </a>
                        </li>
                    @endif --}}
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