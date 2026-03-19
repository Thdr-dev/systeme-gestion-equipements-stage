@extends("layouts.app")

@section("title", "List des utilisateurs")

@section("content")

    <div class="mt-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="display-6 fw-normal text-secondary">List des Utilisateurs</h1>
            <a class="btn btn-outline-primary" href="{{ route('users.register') }}">Ajouter un Operateur</a>
        </div>

            <form id="search-form" method="GET" action="{{ route('users.index') }}" class="mb-3">
                <div class="d-flex">
                    <div class="input-group mb-3">
                        <input autofocus id="search-input" value="{{ request()->search }}" id="search-input" type="text" name="search" class="form-control" placeholder="Chercher par le nom/prenom/email..." >
                        <a class="btn btn-danger m-0 border-0" href="{{ route("users.index") }}">Reset</a>
                    </div>
                    <script>
                        let timer;
                        document.getElementById("search-input").oninput = () => {
                            clearTimeout(timer);


                            timer = setTimeout( () => {
                                document.getElementById("search-form").submit()
                            }, 1000)
                        }
                    </script>
                </div>
            </form>

        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th class="bg-primary text-secondary">Nom</th>
                    <th class="bg-primary text-secondary">Prenom</th>
                    <th class="bg-primary text-secondary">Email</th>
                    <th class="bg-primary text-secondary">Role</th>
                    <th class="bg-primary text-secondary">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                    <tr>
                        <td class="align-middle">{{ $user->nom }}</td>
                        <td class="align-middle">{{ $user->prenom }}</td>
                        <td class="align-middle">{{ $user->email }}</td>
                        <td class="align-middle">
                            <span class="badge py-2 rounded-pill text-bg-{{ $user->isAdmin ? 'success' : 'warning' }}">
                                {{ $user->isAdmin ? "Admin" : "Operateur" }}
                            </span>
                        </td>
                        <td class="d-flex gap-3 align-middle">
                            <a href="{{ route("users.edit", $user) }}" class="btn btn-primary">Update @if($user->id === auth()->user()->id) (Moi) @endif</a>
                            @if(!$user->isAdmin )
                                <form action="{{ route("users.delete", $user) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method("DELETE")
                                    <button class="btn btn-danger" name="isAdmin" onclick="return confirm('Confirmer la suppression !')">
                                        Delete
                                    </button>
                                </form>
                            @endif
                        </td>
                    </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-3 align-middle text-center">Aucun utilisateur</td>
                        </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{ $users->links() }}

@endsection