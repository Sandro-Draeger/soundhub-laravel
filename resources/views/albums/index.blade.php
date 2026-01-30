@extends('fe_master')

<link rel="stylesheet" href="{{ asset('css/albums.css') }}">

@section('content')
<div class="albums-page">

    <div class="albums-header">
        <h1 class="page-title">Albums</h1>

        @if(auth()->check() && auth()->user()->role === 'admin')
            <a href="{{ route('itunes.search') }}" class="btn-primary">
                + Add Album
            </a>
        @endif
    </div>

    @if($albums->count())
        <div class="albums-grid">

            @foreach($albums as $album)
                <div class="album-card">

                    {{-- COVER --}}
                    <div class="album-card-cover">
                        @if($album->image)
                            <img src="{{ asset('storage/' . $album->image) }}" alt="{{ $album->title }}">
                        @else
                            <div class="cover-placeholder">Without cover</div>
                        @endif

                        {{-- PLAY OVERLAY (ÚNICO LINK) --}}
                        <a href="{{ route('albums.show', ['album' => $album->id]) }}" class="play-overlay">
                            <i class="bi bi-play-fill"></i>
                        </a>
                    </div>

                    {{-- INFO --}}
                    <div class="album-card-info">
                        <h3 class="album-card-title">{{ $album->title }}</h3>

                        @if($album->band)
                            <p class="album-card-artist">{{ $album->band->name }}</p>
                        @endif
                    </div>

                </div>
            @endforeach

        </div>
    @else
        <div class="empty-state">
            No albums registered.
        </div>
    @endif

</div>
@endsection
