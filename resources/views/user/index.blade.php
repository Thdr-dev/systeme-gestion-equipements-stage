@extends("layouts.app")

@section("title", "List des utilisateurs")

@section("content")

    <div class="mt-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="display-6 fw-normal text-secondary">List des Utilisateurs</h1>
            <a class="btn btn-outline-success" href="{{ route('users.register') }}">Ajouter un Operateur</a>
        </div>

        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <form id="search-form" action="{{ route('users.index') }}" method="GET">
                    <div class="d-flex">
                        <div class="input-group">
                            <span class="input-group-text bg-secondary-subtle border-end-0">
                                <i class="fa-solid fa-magnifying-glass text-muted"></i>
                            </span>
                            <input id="search-input" value="{{ request()->search }}" id="search-input" type="text" name="search" class="form-control" placeholder="Chercher par le nom, prenom ou email de l'utilisateur" >
                            <a class="btn btn-danger m-0 border-0" style="width:150px;" href="{{ route("users.index") }}">Reset</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="card shadow-sm">
            <div class="table-responsive">
                <table class="table table-hover table-striped align-middle mb-0">
                    <thead>
                        <tr>
                            <th class="bg-primary text-secondary">Nom</th>
                            <th class="bg-primary text-secondary">Prenom</th>
                            <th class="bg-primary text-secondary">Email</th>
                            <th class="bg-primary text-secondary">Unite</th>
                            <th class="bg-primary text-secondary">Role</th>
                            <th class="bg-primary text-secondary">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $user)
                            <tr>
                                <td>{{ $user->nom }}</td>
                                <td>{{ $user->prenom }}</td>
                                <td>{{ $user->email }}</td>
                                <td><span class="badge bg-info text-dark">{{ $user->unite ? $user->unite->nom : 'N/A'}}</span></td>
                                <td>
                                    <span class="badge py-2 rounded-pill text-bg-{{ $user->isAdmin ? 'success' : 'warning' }}">
                                        {{ $user->isAdmin ? "Admin" : "Operateur" }}
                                    </span>
                                </td>
                                <td class="d-flex gap-3 align-middle">
                                    <a href="{{ route("users.edit", $user) }}" title="Modifier" class="btn btn-sm btn-outline-warning"><i class="fas fa-edit"></i> @if($user->id === auth()->user()->id) (Moi) @endif</a>
                                    @if(!$user->isAdmin )
                                        <form action="{{ route("users.delete", $user) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method("DELETE")
                                            <button class="btn btn-sm btn-outline-danger" title="Supprimer" onclick="return confirm('Confirmer la suppression !')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="py-3 align-middle text-center">Aucun utilisateur trouvé.</td>
                                </tr>
                        @endforelse
                    </tbody>
                    @if($users->hasPages())
                        <tfoot>
                            <tr>
                                <td colspan="6" class="px-3 pt-3 pb-0">
                                    {{ $users->links() }}
                                </td>
                            </tr>
                        </tfoot>
                    @endif
                </table>
            </div>
        </div>
    </div>
    
@endsection

@section("scripts")

    <script src="{{ asset("js/search-input.js") }}"></script>

@endsection