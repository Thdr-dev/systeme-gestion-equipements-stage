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
                        <a class="text-white nav-link {{ request()->routeIs('materiels.*', 'mouvements.*') ? (request()->routeIs('materiels.index') ? 'disabled text-secondary' : 'text-secondary' ) : '' }}" href="{{ route('materiels.index') }}">
                            Liste Matériels
                        </a>
                    </li>

                    @if(Auth::user()->isAdmin)
                        <li class="nav-item dropdown">
                            <a class="text-white nav-link dropdown-toggle {{ request()->routeIs('familles.*', 'sous-familles.*', 'unites.*', 'users.*') ? 'active text-secondary' : '' }}" href="#" id="configDrop" data-bs-toggle="dropdown">
                                Administration
                            </a>
                            <ul class="dropdown-menu shadow py-0 overflow-hidden">
                                <li class="nav-item">
                                    <a class="dropdown-item py-2 {{ request()->routeIs('users.*') ? ( request()->routeIs('users.index') ? 'disabled bg-primary-subtle text-secondary fw-bold' : 'bg-primary-subtle text-secondary fw-bold' ) : 'text-black' }}" 
                                    href="{{ route('users.index') }}">
                                        Utilisateurs
                                    </a>
                                </li>
                                <li><hr class="dropdown-divider m-0"></li>
                                <li><a class="dropdown-item py-2 {{ request()->routeIs('familles.*') ? ( request()->routeIs('familles.index') ? 'disabled bg-primary-subtle text-secondary fw-bold' : 'bg-primary-subtle text-secondary fw-bold' ) : 'text-black' }}" href="{{ route('familles.index') }}">Familles</a></li>
                                <li><a class="dropdown-item py-2 {{ request()->routeIs('sous-familles.*') ? ( request()->routeIs('sous-familles.index') ? 'disabled bg-primary-subtle text-secondary fw-bold' : 'bg-primary-subtle text-secondary fw-bold' ) : 'text-black' }}" href="{{ route('sous-familles.index') }}">Sous-Familles</a></li>
                                <li><hr class="dropdown-divider m-0"></li>
                                <li><a class="dropdown-item py-2 {{ request()->routeIs('unites.*') ? ( request()->routeIs('unites.index') ? 'disabled bg-primary-subtle text-secondary fw-bold' : 'bg-primary-subtle text-secondary fw-bold' ) : 'text-black' }}" href="{{ route('unites.index') }}">Unités (Centres)</a></li>

                            </ul>
                        </li>


                        <li class="nav-item">
                            <a class="text-white nav-link {{ request()->routeIs('dashboard.index') ? 'disabled text-secondary' : '' }}" href="{{ route("dashboard.index") }}">Dashboard</a>
                        </li>
                        
                    @endif
                </ul>

                <ul id="notificationList" class="navbar-nav">
                    @include('partials.notifications_list')
                </ul>
                
                <ul class="navbar-nav pe-0 pe-lg-5">
                    <li class="nav-item dropdown">
                        <a class="text-white nav-link dropdown-toggle" href="#" id="userDrop" data-bs-toggle="dropdown">
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


@if(Auth::user()->isAdmin)

    @section("notification-script")
        <script>
            let lastCount = {{ auth()->user()->unreadNotifications->count() }};

            function fetchNotifications() {
                fetch('/api/notifications/data')
                    .then(response => response.json())
                    .then(data => {
                        if (data.count !== lastCount) {

                            
                            const bellContainer = document.getElementById('bell');
                            const listContainer = document.getElementById('notificationList');

                            if (bellContainer) {
                                let badge = bellContainer.querySelector('.badge');
                                if (data.count > 0) {
                                    if (badge) {
                                        badge.innerText = data.count;
                                    } else {
                                        bellContainer.insertAdjacentHTML('beforeend', `<span class="badge position-absolute top-0 start-100 translate-middle rounded-pill bg-danger" style="font-size: 0.6rem;">${data.count}</span>`);
                                    }
                                } else if (badge) {
                                    badge.remove();
                                }
                            }

                            if (listContainer) {
                                listContainer.innerHTML = data.html;
                            }

                            lastCount = data.count;

                            const bellIcon = document.getElementById('bell').firstElementChild;
                            bellIcon.classList.add('fa-shake', 'text-warning');
                            setTimeout(() => {
                                bellIcon.classList.remove('fa-shake', 'text-warning');
                            }, 2000);

                        }
                    })
                    .catch(err => console.error("Erreur de rafraîchissement:", err));
            }
            setInterval(fetchNotifications, 15000);
            
        </script>
    @endsection

@endif