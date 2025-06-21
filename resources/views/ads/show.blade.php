@extends('layouts.app')

@section('title', $ad->title)

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card mb-4">
            @if($ad->image)
                <img src="{{ asset('storage/ads/' . $ad->image) }}" class="card-img-top" alt="{{ $ad->title }}">
            @endif
            <div class="card-body">
                <h1 class="card-title">{{ $ad->title }}</h1>
                <p class="text-muted">Catégorie : {{ $ad->category->name }}</p>
                <p class="h4 text-primary">{{ number_format($ad->price, 2) }} €</p>
                <hr>
                <p class="card-text">{{ nl2br(e($ad->description)) }}</p>
            </div>
            <div class="card-footer">
                <small class="text-muted">Publié le {{ $ad->created_at->format('d/m/Y') }} par {{ $ad->user->name }}</small>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Contacter le vendeur</h5>
                @auth
                    <form action="{{ route('messages.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="ad_id" value="{{ $ad->id }}">
                        <div class="mb-3">
                            <textarea class="form-control" name="content" rows="3" placeholder="Votre message..."></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Envoyer</button>
                    </form>
                @else
                    <div class="alert alert-info">
                        <a href="{{ route('login') }}">Connectez-vous</a> pour contacter le vendeur.
                    </div>
                @endauth
            </div>
        </div>
        @auth
            @if(auth()->user()->id === $ad->user_id || auth()->user()->isAdmin())
                <div class="card mt-3">
                    <div class="card-body">
                        <h5 class="card-title">Gestion</h5>
                        <a href="{{ route('ads.edit', $ad) }}" class="btn btn-outline-primary w-100 mb-2">Modifier</a>
                        <form action="{{ route('ads.destroy', $ad) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger w-100" onclick="return confirm('Supprimer cette annonce ?')">Supprimer</button>
                        </form>
                    </div>
                </div>
            @endif
        @endauth
    </div>
</div>
@endsection