<div class="col-md-4 mb-4">
    <div class="card h-100">
        @if($ad->image)
            <img src="{{ asset('storage/' . $ad->image) }}" class="card-img-top" alt="{{ $ad->title }}" style="height: 200px; object-fit: cover;">
        @else
            <div class="bg-secondary text-white d-flex align-items-center justify-content-center" style="height: 200px;">
                Pas d'image
            </div>
        @endif
        <div class="card-body">
            <h5 class="card-title">{{ Str::limit($ad->title, 30) }}</h5>
            <p class="text-muted">{{ $ad->category->name }}</p>
            <p class="card-text">{{ Str::limit($ad->description, 100) }}</p>
            <p class="fw-bold text-primary">{{ number_format($ad->price, 2) }} €</p>
        </div>
        <div class="card-footer bg-white">
            <a href="{{ route('ads.show', $ad) }}" class="btn btn-sm btn-primary">Voir</a>
            @auth
                @if(auth()->user()->id === $ad->user_id || auth()->user()->isAdmin())
                    <a href="{{ route('ads.edit', $ad) }}" class="btn btn-sm btn-outline-secondary">Modifier</a>
                @endif
            @endauth
        </div>
    </div>
</div>