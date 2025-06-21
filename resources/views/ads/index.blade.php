@extends('layouts.app')

@section('title', 'Annonces')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-md-8">
            <h1 class="h2">Annonces récentes</h1>
        </div>
        <div class="col-md-4">
            <form action="{{ route('ads.index') }}" method="GET" class="d-flex">
                <input type="text" name="search" class="form-control me-2" 
                       placeholder="Rechercher..." value="{{ request('search') }}">
                <button type="submit" class="btn btn-primary">OK</button>
            </form>
        </div>
    </div>

    <!-- Filtres -->
    <div class="card mb-4 shadow-sm">
        <div class="card-body">
            <form action="{{ route('ads.index') }}" method="GET">
                <div class="row g-3">
                    <div class="col-md-4">
                        <label for="category" class="form-label">Catégorie</label>
                        <select name="category" id="category" class="form-select">
                            <option value="">Toutes</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="min_price" class="form-label">Prix min</label>
                        <input type="number" name="min_price" id="min_price" 
                               class="form-control" value="{{ request('min_price') }}" min="0">
                    </div>
                    <div class="col-md-4">
                        <label for="max_price" class="form-label">Prix max</label>
                        <input type="number" name="max_price" id="max_price" 
                               class="form-control" value="{{ request('max_price') }}" min="0">
                    </div>
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary">Filtrer</button>
                        @if(request()->hasAny(['search', 'category', 'min_price', 'max_price']))
                            <a href="{{ route('ads.index') }}" class="btn btn-outline-secondary ms-2">Réinitialiser</a>
                        @endif
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Liste des annonces -->
    <div class="row">
        @forelse($ads as $ad)
            @include('layouts.partials.ad-card', ['ad' => $ad])
        @empty
            <div class="col-12">
                <div class="alert alert-info">Aucune annonce trouvée</div>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="d-flex justify-content-center mt-4">
        {{ $ads->appends($filters)->links() }}
    </div>
</div>
@endsection