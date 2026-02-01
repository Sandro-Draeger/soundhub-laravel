@extends('fe_master')

<link rel="stylesheet" href="{{ asset('css/playlists.css') }}">


@section('content')
<div class="album-page">

    {{-- BACK --}}
    <a href="{{ route('playlists.index') }}" class="back-link">
        ← Back to Playlists
    </a>

    {{-- HEADER --}}
    <div class="album-header">

        {{-- EDIT BUTTON (TOP RIGHT) --}}
        <a
            href="{{ route('playlists.edit', $playlist) }}"
            class="playlist-edit-btn"
            title="Edit playlist"
        >
            ✎
        </a>

        <div class="album-header-grid">

            {{-- COVER --}}
            <div class="album-cover">
                @if($playlist->photo)
                    <img
                        src="{{ asset('storage/' . $playlist->photo) }}"
                        alt="{{ $playlist->name }}"
                    >
                @else
                    <div class="album-cover-placeholder">
                        Playlist
                    </div>
                @endif
            </div>

            {{-- INFO --}}
            <div class="album-header-info">
                <span class="album-type">
                    Playlist
                </span>

                <h1 class="album-title">
                    {{ $playlist->name }}
                </h1>

                @if($playlist->description)
                    <p class="album-artist">
                        {{ $playlist->description }}
                    </p>
                @endif

                <p class="album-meta">
                    {{ $playlist->musics->count() }} songs
                </p>
            </div>

        </div>
    </div>

    {{-- SECTION TITLE --}}
    <h2 class="section-title">Songs</h2>

    {{-- SUCCESS MESSAGE --}}
    @if(session('success'))
        <div class="alert-success">
            {{ session('success') }}
        </div>
    @endif

    {{-- TRACKLIST --}}
    @if($playlist->musics->count())
        <div class="songs-table-wrapper">
            <table class="songs-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Title</th>
                        <th>Artist</th>
                        <th>Preview</th>
                        <th></th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($playlist->musics as $index => $music)
                        <tr>

                            <td>{{ $index + 1 }}</td>

                            <td>{{ $music->track_name }}</td>

                            <td>{{ $music->artist_name }}</td>

                            <td>
                                @if($music->preview_url)
                                    <audio controls>
                                        <source
                                            src="{{ $music->preview_url }}"
                                            type="audio/mpeg"
                                        >
                                    </audio>
                                @endif
                            </td>

                            {{-- ACTIONS --}}
                            <td class="track-actions">
                                <form
                                    method="POST"
                                    action="{{ route('playlists.remove-music') }}"
                                >
                                    @csrf

                                    <input
                                        type="hidden"
                                        name="music_id"
                                        value="{{ $music->id }}"
                                    >
                                    <input
                                        type="hidden"
                                        name="playlist_id"
                                        value="{{ $playlist->id }}"
                                    >

                                    <button
                                        type="submit"
                                        class="icon-trash"
                                        title="Remove from playlist"
                                        onclick="return confirm('Remove this song?')"
                                    >
                                        🗑
                                    </button>
                                </form>
                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="empty-state">
            This playlist has no songs.
        </div>
    @endif

</div>
@endsection
