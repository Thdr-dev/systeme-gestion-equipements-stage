@if(Auth::user()->isAdmin)
    <li class="nav-item dropdown me-3">
        <a class="text-white nav-link" href="#" id="notifDrop" data-bs-toggle="dropdown">
            <span id="bell" class="position-relative">
                <i class="fas fa-bell fa"></i>
                @if(auth()->user()->unreadNotifications->count() > 0)
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size: 0.6rem;">
                        {{ auth()->user()->unreadNotifications->count() }}
                    </span>
                @endif
            </span>
        </a>
        <ul class="dropdown-menu dropdown-menu-end shadow border-0 py-0 position-fixed" style="width: 400px; max-width: 90%; max-height: 450px; overflow-y: auto; top: 60px; right: 20px">
            <li class="bg-light p-2 border-bottom small fw-bold text-uppercase sticky-top">Notifications</li>
            
            @forelse(auth()->user()->unreadNotifications as $notification)
                @php
                    $msg = strtoupper($notification->data['message']); 
                    $style = 'border-left: 4px solid #dee2e6;';

                    if (Str::contains($msg, 'PANNE')) {
                        $style = 'background-color: #fff5f5; border-left: 4px solid #dc3545;';
                    }
                    elseif (Str::contains($msg, 'RETARD RETOUR')) {
                        $style = 'background-color: #f6fff6; border-left: 4px solid #dc3545;';
                    }  
                    elseif (Str::contains($msg, 'ENTREE') || Str::contains($msg, 'RETOUR')) {
                        $style = 'background-color: #f6fff6; border-left: 4px solid #198754;';
                    }
                    elseif (Str::contains($msg, 'SORTIE')) {
                        $style = 'background-color: #fffdf0; border-left: 4px solid #ffc107;';
                    } 
                    elseif (Str::contains($msg, 'MAINTENANCE')) {
                        $style = 'background-color: #f0f7ff; border-left: 4px solid #0d6efd;';
                    } 
                    elseif (Str::contains($msg, 'TRANSFÉRÉ') || Str::contains($msg, 'TRANSFERT')) {
                        $style = 'background-color: #f8f5ff; border-left: 4px solid #6610f2;';
                    }
                @endphp

                <li>
                    <a class="dropdown-item py-2 border-bottom small text-wrap d-flex flex-column" 
                    href="{{ route('notifications.markAsRead', $notification) }}"
                    style="{{ $style }}">
                        
                        <span class="text-dark">
                            {!! $notification->data['message'] !!}
                        </span>
                        
                        <div class="text-muted small mt-1" style="font-size: 0.7rem;">
                            <i class="far fa-clock me-1"></i>{{ $notification->created_at->diffForHumans() }}
                        </div>
                    </a>
                </li>
            @empty
                <li class="p-3 text-center text-muted small">Aucune notification pour le moment</li>
            @endforelse

            @if(auth()->user()->unreadNotifications->count() > 0)
                <li class="sticky-bottom">
                    <a class="dropdown-item text-center small py-2 bg-light text-primary fw-bold border-top" href="{{ route('notifications.readAll') }}">
                        Tout marquer comme lu
                    </a>
                </li>
            @endif

        </ul>
    </li>
@endif