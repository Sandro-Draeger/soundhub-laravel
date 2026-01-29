@extends('fe_master')

<link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">

@section('content')
<div class="album-page">

    <a href="{{ route('dashboard', $album->id) }}" class="back-link">
        ← Back to Dashboard
    </a>

    {{-- HEADER DO ÁLBUM --}}
    <div class="album-header">

        <div class="album-header-grid">

            {{-- COVER --}}
            <div class="album-cover">
                @if($album->image)
                    <img src="{{ asset('storage/' . $album->image) }}" alt="{{ $album->title }}">
                @elseif($album->itunes_id)
                    <img src="https://is1-ssl.mzstatic.com/image/thumb/Music{{ substr($album->itunes_id, 0, 2) }}/{{ $album->itunes_id }}/300x300.jpg">
                @else
                    <div class="album-cover-placeholder">Without Cover</div>
                @endif
            </div>

            {{-- INFO --}}
            <div class="album-header-info">
                <span class="album-type">Album</span>

                <h1 class="album-title">{{ $album->title }}</h1>

                @if($album->band)
                    <p class="album-artist">{{ $album->band->name }}</p>
                @endif

                <p class="album-meta">
                    {{ $album->songs->count() }} songs
                </p>
            </div>

        </div>
    </div>

    {{-- FEEDBACK --}}
    @if(session('success'))
        <div class="alert success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert error">{{ session('error') }}</div>
    @endif

    {{-- LISTA --}}
    <h2 class="section-title">Songs</h2>

    @if($album->songs->count())
        <div class="songs-table-wrapper">
            <table class="songs-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Title</th>
                        <th>Duration</th>
                        <th>Preview</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($album->songs as $index => $song)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $song->track_name }}</td>
                            <td>
                                {{ $song->track_time ? gmdate('i:s', $song->track_time / 1000) : '--' }}
                            </td>
                            <td>
                                @if($song->preview_url)
                                    <audio controls>
                                        <source src="{{ $song->preview_url }}">
                                    </audio>
                                @else
                                    <span class="muted">Not available</span>
                                @endif
                            </td>
                            <td>
                                <form method="POST" action="{{ route('dashboard.album.song.destroy', ['albumId' => $album->id, 'songId' => $song->id]) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn-danger">Remove</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="empty-state">
            This album does not have any songs.
        </div>
    @endif

</div>
@endsection
