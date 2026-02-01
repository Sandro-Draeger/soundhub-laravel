@extends('fe_master')

<link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
<link rel="stylesheet" href="{{ asset('css/albums.css') }}">

@section('content')
<div class="album-page">

    {{-- BACK --}}
    <a href="{{ route('albums.index') }}" class="back-link">
        ← Back to Albums
    </a>

    {{-- HEADER --}}
    <div class="album-header">
        <div class="album-header-grid">

            {{-- COVER --}}
            <div class="album-cover">
                @if($album->image)
                    <img src="{{ asset('storage/' . $album->image) }}" alt="{{ $album->title }}">
                @else
                    <div class="album-cover-placeholder">Album</div>
                @endif
            </div>

            {{-- INFO --}}
            <div class="album-header-info">
                <span class="album-type">Album</span>

                <h1 class="album-title">{{ $album->title }}</h1>
                <p class="album-artist">by {{ $album->artist }}</p>

                <p class="album-meta">
                    {{ $album->songs->count() }} songs
                </p>

                @if(auth()->check() && auth()->user()->role === 'admin')
                    <form
                        method="POST"
                        action="{{ route('albums.destroy', $album) }}"
                        onsubmit="return confirm('Delete this album?')"
                        class="album-admin-actions">
                        @csrf
                        @method('DELETE')

                        <button class="btn-danger">
                            Delete Album
                        </button>
                    </form>
                @endif
            </div>

        </div>
    </div>

    {{-- SONGS --}}
    <h2 class="section-title">Songs</h2>


@if(session('success'))
    <div class="alert-success">
        {{ session('success') }}
    </div>
@endif

    @if($album->songs->count())
        <div class="songs-table-wrapper">
            <table class="songs-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Title</th>
                        <th>Artist</th>
                        <th>Preview</th>
                        @if(auth()->check() && auth()->user()->role == 'user')
                            <th>Add to Playlist</th>
                        @endif
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($album->songs as $index => $song)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $song->track_name }}</td>
                            <td>{{ $song->artist_name }}</td>
                            <td>
                                @if($song->preview_url)
                                    <audio controls>
                                        <source src="{{ $song->preview_url }}" type="audio/mpeg">
                                    </audio>
                                @endif
                            <td>
                                @if(auth()->check() && auth()->user()->role == 'user')
                                    <form
                                        method="POST"
                                        action="{{ route('playlist.add-song') }}"
                                        class="playlist-inline-form">
                                        @csrf

                                        <input type="hidden" name="track_name" value="{{ $song->track_name }}">
                                        <input type="hidden" name="preview_url" value="{{ $song->preview_url }}">
                                        <input type="hidden" name="album_id" value="{{ $album->id }}">
                                        <input type="hidden" name="artist_name" value="{{ $song->artist_name }}">

                                        <select name="playlist_id" required>
                                            @foreach(auth()->user()->playlists as $playlist)
                                                <option value="{{ $playlist->id }}">
                                                    {{ $playlist->name }}
                                                </option>
                                            @endforeach
                                        </select>

                                        <button type="submit" class="add-btn" title="Add to playlist">
    +
</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                     @if ($success = session('success'))
                                            <div class="form-success">
                                                {{ $success }}
                                            </div>
                                        @endif
                </tbody>
            </table>
        </div>
    @else
        <div class="empty-state">
            This album has no songs.
        </div>
    @endif

</div>

<script>
function searchItunes() {
    const term = document.getElementById('search').value;

    fetch(`/itunes/search?term=${term}`)
        .then(res => res.json())
        .then(data => {
            let html = '';

            data.forEach(song => {
                html += `
                    <div class="itunes-result-row">
                        <span>${song.trackName} — ${song.artistName}</span>
                        <button class="btn btn-primary btn-sm">
                            Add
                        </button>
                    </div>
                `;
            });

            document.getElementById('results').innerHTML = html;
        });
}
</script>
@endsection
