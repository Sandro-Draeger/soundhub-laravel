@extends('fe_master')

<link rel="stylesheet" href="{{ asset('css/playlists.css') }}">

@section('content')
<div class="playlist-container">

    <header class="playlist-header">
        <h1>My Playlists</h1>

        <a href="{{ route('playlists.create') }}" class="btn-primary">
            + New Playlist
        </a>
    </header>

    @if(session('success'))
        <div class="alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if($playlists->count())
        <div class="playlist-grid">
            @foreach($playlists as $playlist)
                <div class="playlist-card">

                    <div class="playlist-image">
                        <img
                            src="{{ $playlist->cover ?? asset('images/playlist-placeholder.png') }}"
                            alt="{{ $playlist->name }}"
                        >
                    </div>

                    <div class="playlist-info">
                        <h3>{{ $playlist->name }}</h3>

                        <p class="playlist-description">
                            {{ $playlist->description }}
                        </p>

                        <span class="playlist-count">
                            {{ $playlist->musics()->count() }} songs
                        </span>
                    </div>

                    <div class="playlist-actions">
                        <a href="{{ route('playlists.show', $playlist) }}" class="btn btn-open">
                            Open
                        </a>

                        <a href="{{ route('playlists.edit', $playlist) }}" class="btn btn-edit">
                            Edit
                        </a>

                        <form method="POST" action="{{ route('playlists.destroy', $playlist) }}">
                            @csrf
                            @method('DELETE')
                            <button
                                type="submit"
                                class="btn btn-delete"
                                onclick="return confirm('Are you sure?')"
                            >
                                Delete
                            </button>
                        </form>
                    </div>

                </div>
            @endforeach
        </div>
    @else
        <div class="empty-state">
            <p>You haven't created any playlist yet.</p>
            <a href="{{ route('playlists.create') }}">Create your first playlist</a>
        </div>
    @endif

</div>
@endsection
