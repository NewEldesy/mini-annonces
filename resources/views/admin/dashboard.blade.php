@extends('layouts.app')

@section('title', 'Administration')

@section('content')
<div class="container">
    <h1 class="my-4">Tableau de bord administrateur</h1>

    <ul class="nav nav-tabs" id="adminTabs">
        <li class="nav-item">
            <a class="nav-link active" data-bs-toggle="tab" href="#ads">Annonces</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="tab" href="#users">Utilisateurs</a>
        </li>
    </ul>

    <div class="tab-content py-4">
        <!-- Onglet Annonces -->
        <div class="tab-pane fade show active" id="ads">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Titre</th>
                            <th>Prix</th>
                            <th>Statut</th>
                            <th>Auteur</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($ads as $ad)
                            <tr>
                                <td>{{ $ad->id }}</td>
                                <td>{{ Str::limit($ad->title, 30) }}</td>
                                <td>{{ $ad->price }} €</td>
                                <td>
                                    <span class="badge bg-{{ $ad->status === 'approved' ? 'success' : ($ad->status === 'rejected' ? 'danger' : 'warning') }}">
                                        {{ $ad->status }}
                                    </span>
                                </td>
                                <td>{{ $ad->user->name }}</td>
                                <td>
                                    <div class="d-flex gap-2">
                                        @if($ad->status !== 'approved')
                                            <form action="{{ route('admin.ads.approve', $ad) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-success">✓</button>
                                            </form>
                                        @endif
                                        @if($ad->status !== 'rejected')
                                            <form action="{{ route('admin.ads.reject', $ad) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-danger">✗</button>
                                            </form>
                                        @endif
                                        <form action="{{ route('admin.ads.destroy', $ad) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Supprimer définitivement ?')">Supprimer</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $ads->links() }}
            </div>
        </div>

        <!-- Onglet Utilisateurs -->
        <div class="tab-pane fade" id="users">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nom</th>
                        <th>Email</th>
                        <th>Rôle</th>
                        <th>Statut</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->role }}</td>
                            <td>
                                @if($user->isBanned())
                                    <span class="badge bg-danger">Banni</span>
                                @else
                                    <span class="badge bg-success">Actif</span>
                                @endif
                            </td>
                            <td>
                                <div class="d-flex gap-2">
                                    @if($user->isBanned())
                                        <form action="{{ route('admin.users.unban', $user) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-success">Débannir</button>
                                        </form>
                                    @else
                                        <form action="{{ route('admin.users.ban', $user) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-warning">Bannir</button>
                                        </form>
                                    @endif
                                    <form action="{{ route('admin.users.destroy', $user) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Supprimer définitivement ?')">Supprimer</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $users->links() }}
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Active le bon onglet si présent dans l'URL
    const urlParams = new URLSearchParams(window.location.search);
    const tab = urlParams.get('tab');
    if(tab) {
        const tabElement = document.querySelector(`#adminTabs button[data-bs-target="#${tab}"]`);
        if(tabElement) {
            new bootstrap.Tab(tabElement).show();
        }
    }
</script>
@endpush