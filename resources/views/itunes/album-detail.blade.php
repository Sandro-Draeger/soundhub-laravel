@extends('fe_master')

<link rel="stylesheet" href="{{ asset('css/itunes.css') }}">

@section('content')
<div class="itunes-album-page">

    <a href="{{ route('itunes.search') }}" class="back-link">
        ← Back to Search
    </a>

    @if(session('error'))
        <div class="alert error">{{ session('error') }}</div>
    @endif

    @if(session('success'))
        <div class="alert success">{{ session('success') }}</div>
    @endif

    {{-- ALBUM CARD --}}
    <div class="itunes-album-card">

        <div class="itunes-album-grid">

            {{-- COVER --}}
            <div class="itunes-album-cover">
                @if(isset($album['artworkUrl100']))
                    <img src="{{ str_replace('100x100', '300x300', $album['artworkUrl100']) }}"
                         alt="{{ $album['collectionName'] ?? $album['artistName'] }}">
                @else
                    <div class="cover-placeholder">Without Image</div>
                @endif
            </div>

            {{-- INFO --}}
            <div class="itunes-album-info">
                <h1 class="album-title">
                    {{ $album['collectionName'] ?? $album['artistName'] ?? 'Without Name' }}
                </h1>

                @if(isset($album['artistName']))
                    <p class="album-artist">
                        <strong>Artist:</strong> {{ $album['artistName'] }}
                    </p>
                @endif

                @if(isset($album['releaseDate']))
                    <p class="album-meta">
                        <strong>Release:</strong>
                        {{ \Carbon\Carbon::parse($album['releaseDate'])->format('d/m/Y') }}
                    </p>
                @endif

                @if(isset($album['primaryGenreName']))
                    <p class="album-meta">
                        <strong>Genre:</strong> {{ $album['primaryGenreName'] }}
                    </p>
                @endif

                {{-- IMPORT ALBUM (ADMIN ONLY) --}}
                @if(auth()->check() && auth()->user()->role === 'admin')
                    <form method="POST"
                          action="{{ route('itunes.import-album') }}"
                          class="import-form">
                        @csrf
                        <input type="hidden" name="artist_name" value="{{ $album['artistName'] ?? '' }}">
                        <input type="hidden" name="album_name" value="{{ $album['collectionName'] ?? '' }}">
                        <input type="hidden" name="release_date" value="{{ $album['releaseDate'] ?? '' }}">
                        <input type="hidden" name="itunes_id" value="{{ $collectionId }}">

                        <button type="submit" class="btn-import">
                            ✓ Import Album
                        </button>
                    </form>
                @endif
            </div>
        </div>
    </div>

    {{-- SONGS --}}
    @if(count($songs) > 0)
        <h2 class="section-title">Songs of the Album</h2>

        <div class="songs-table-wrapper">
            <table class="songs-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Song</th>
                        <th>Duration</th>
                        <th>Preview</th>
                        @if(auth()->check() && auth()->user()->role === 'user')
                        <th>Playlist</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @foreach($songs as $index => $song)
                        <tr>
                            <td>{{ $index + 1 }}</td>

                            <td>{{ $song['trackName'] ?? 'Without name' }}</td>

                            <td>
                                {{ isset($song['trackTimeMillis'])
                                    ? gmdate('i:s', $song['trackTimeMillis'] / 1000)
                                    : '--'
                                }}
                            </td>

                            <td>
                                @if(isset($song['previewUrl']))
                                    <div class="audio-preview">
                                        <audio controls>
                                            <source src="{{ $song['previewUrl'] }}">
                                        </audio>
                                    </div>
                                @else
                                    <span class="muted">Not available</span>
                                @endif
                            </td>

                            {{-- ADD TO PLAYLIST (USER ONLY) --}}

                                @if(auth()->check() && auth()->user()->role === 'user')
                                <td>
                                    <form method="POST"
                                          action="{{ route('playlist.add-song') }}"
                                          class="playlist-form">
                                        @csrf

                                        <input type="hidden"
                                               name="track_name"
                                               value="{{ $song['trackName'] ?? '' }}">

                                        <input type="hidden"
                                               name="preview_url"
                                               value="{{ $song['previewUrl'] ?? '' }}">

                                        <select name="playlist_id" required>
                                            <option value="">Add to playlist...</option>
                                            @forelse($playlists as $playlist)
                                                <option value="{{ $playlist->id }}">
                                                    {{ $playlist->name }}
                                                </option>
                                            @empty
                                                <option disabled>
                                                    You have no playlists
                                                </option>
                                            @endforelse
                                        </select>

                                        <button type="submit"
                                                class="btn-add-playlist">
                                            +
                                        </button>
                                    </form>
                                @else
                                    <span class="muted">—</span>
                                    </td>
                                @endif


                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif

</div>
@endsection
