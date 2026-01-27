@extends('fe_master')

@section('content')
<div class="spotify-page py-4">
    <div class="container">

        <a href="{{ route('itunes.search') }}" class="back-link mb-3 d-inline-block">
            ← Voltar à Busca
        </a>

        <h4 class="mb-1 text-white">
            Resultados para "{{ $term }}"
        </h4>

        <p class="text-muted mb-4">
            {{ ucfirst($type) }} • {{ count($results) }} resultado(s)
        </p>

        @if(count($results) > 0)
        <div class="album-grid">
            @foreach($results as $item)
                <div class="album-col">
                    <div class="album-card">

                        @if(isset($item['artworkUrl100']))
                        <div class="album-cover-wrapper">
                            <img
                                src="{{ str_replace('100x100', '300x300', $item['artworkUrl100']) }}"
                                alt="{{ $item['collectionName'] ?? $item['artistName'] }}"
                                class="album-cover"
                            >
                        </div>
                        @else
                            <div class="album-placeholder"></div>
                        @endif

                        <div class="album-info">
                            <div class="album-title">
                                {{ $item['collectionName'] ?? $item['artistName'] ?? 'Sem nome' }}
                            </div>

                            <div class="album-artist">
                                {{ $item['artistName'] ?? '' }}
                            </div>

                            <a href="{{ route('itunes.album', $item['collectionId'] ?? $item['artistId']) }}"
                                class="import-button">
                                  <i class="bi bi-music-note-list"></i> songs
                            </a>
                        </div>

                    </div>
                </div>
            @endforeach
        </div>
        @else
            <p class="text-muted">Nenhum resultado encontrado.</p>
        @endif

    </div>
</div>
@endsection
