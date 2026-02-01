@extends('fe_master')

<link rel="stylesheet" href="{{ asset('css/itunes.css') }}">

@section('content')
<div class="spotify-page py-4">
    <div class="container">

        {{-- BACK --}}
        <a href="{{ route('itunes.search') }}" class="back-link mb-3 d-inline-block">
            ← Back to Search
        </a>

        {{-- TITLE --}}
        <h4 class="mb-1 text-white">
            Results for "{{ $term }}"
        </h4>

        {{-- META --}}
        <p class="text-muted mb-4">
            {{ ucfirst($type) }} • {{ count($results) }} result(s)
        </p>

        @if(count($results) > 0)

            {{-- RESULTS GRID --}}
            <div class="itunes-results-grid">

                @foreach($results as $item)
                    <div class="itunes-result-card">

                        {{-- COVER --}}
                        @if(isset($item['artworkUrl100']))
                            <div class="itunes-result-cover">
                                <img
                                    src="{{ str_replace('100x100', '300x300', $item['artworkUrl100']) }}"
                                    alt="{{ $item['collectionName'] ?? $item['artistName'] }}"
                                    class="itunes-result-image"
                                >
                            </div>
                        @else
                            <div class="itunes-result-cover"></div>
                        @endif

                        {{-- INFO --}}
                        <div class="itunes-result-info">

                            <div class="itunes-result-title">
                                {{ $item['collectionName'] ?? $item['artistName'] ?? 'Sem nome' }}
                            </div>

                            <div class="itunes-result-artist">
                                {{ $item['artistName'] ?? '' }}
                            </div>

                            {{-- ACTION --}}
                            <a
                                href="{{ route('itunes.album', $item['collectionId'] ?? $item['artistId']) }}"
                                class="spotify-action-btn"
                                title="View songs"
                            >
                                <i class="bi bi-music-note"></i>
                                <span>View songs</span>
                            </a>

                        </div>

                    </div>
                @endforeach

            </div>

        @else
            <p class="text-muted">
                No results found.
            </p>
        @endif

    </div>
</div>
@endsection
