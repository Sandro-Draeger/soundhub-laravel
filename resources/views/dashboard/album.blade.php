@extends('fe_master')

<link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">

@section('content')
<div class="album-page">

    <a href="{{ route('dashboard') }}" class="back-link">
        ← Back to Dashboard
    </a>

    {{-- HEADER --}}
    <div class="album-header">

        <div class="album-header-grid">

            {{-- COVER --}}
            <div class="album-cover">
                @if($album->image)
                    <img src="{{ asset('storage/' . $album->image) }}" alt="{{ $album->title }}">
                @elseif($album->itunes_id)
                    <img src="https://is1-ssl.mzstatic.com/image/thumb/Music{{ substr($album->itunes_id, 0, 2) }}/{{ $album->itunes_id }}/300x300.jpg">
                @else
                    <div class="cover-placeholder">Without Cover</div>
                @endif
            </div>

            {{-- INFO --}}
            <div class="album-header-info">
                <h1 class="album-title">{{ $album->title }}</h1>

                @if($album->band)
                    <p class="album-artist">
                        <strong>Artist:</strong> {{ $album->band->name }}
                    </p>
                @endif

                @if($album->release_date)
                    <p class="album-meta">
                        <strong>Release:</strong>
                        {{ \Carbon\Carbon::parse($album->release_date)->format('d/m/Y') }}
                    </p>
                @endif

                <p class="album-meta">
                    <strong>Songs:</strong> {{ $album->songs->count() }}
                </p>
            </div>

        </div>
    </div>

    {{-- SONGS --}}
    @if($album->songs->count())
        <h2 class="section-title">Songs of the Album</h2>

        <div class="songs-table-wrapper">
            <table class="songs-table">
                <thead>
                    <tr>
                        <th>Song</th>
                        <th>Duration</th>
                        <th>Preview</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($album->songs as $song)
                        <tr>
                            <td>{{ $song->track_name }}</td>
                            <td>
                                {{ $song->track_time ? gmdate('i:s', $song->track_time / 1000) : '--' }}
                            </td>
                            <td>
                                @if($song->preview_url)
                                    <div class="audio-preview">
                                        <audio controls>
                                            <source src="{{ $song->preview_url }}">
                                        </audio>
                                    </div>
                                @else
                                    <span class="muted">
                                        <i class="bi bi-ban"></i>
                                    </span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="empty-state">
            This album does not have any songs registered.
        </div>
    @endif

</div>
@endsection

