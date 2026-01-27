@extends('fe_master')

@section('content')
<div class="container" style="padding: 10px; max-width: 1000px;">

    <div style="margin-bottom: 30px;">
        <a href="{{ route('itunes.search') }}" style="color: #667eea; text-decoration: none;">← Voltar à Busca</a>
    </div>

    @if(session('error'))
        <div style="background: #f44336; color: white; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
            {{ session('error') }}
        </div>
    @endif

    @if(session('success'))
        <div style="background: #4caf50; color: white; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
            {{ session('success') }}
        </div>
    @endif

    <div style="background: white; padding: 30px; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); margin-bottom: 30px;">
        <div style="display: grid; grid-template-columns: 200px 1fr; gap: 30px; align-items: start;">

            @if(isset($album['artworkUrl100']))
                <img src="{{ str_replace('100x100', '300x300', $album['artworkUrl100']) }}" alt="{{ $album['collectionName'] ?? $album['artistName'] }}" style="width: 100%; border-radius: 8px;">
            @else
                <div style="width: 100%; aspect-ratio: 1; background: #f0f0f0; border-radius: 8px; display: flex; align-items: center; justify-content: center; color: #999;">
                    Sem imagem
                </div>
            @endif

            <div>
                <h1 style="margin: 0 0 10px 0;">{{ $album['collectionName'] ?? $album['artistName'] ?? 'Sem nome' }}</h1>

                @if(isset($album['artistName']))
                    <p style="color: #666; font-size: 16px; margin: 0 0 10px 0;">
                        <strong>Artista:</strong> {{ $album['artistName'] }}
                    </p>
                @endif

                @if(isset($album['releaseDate']))
                    <p style="color: #666; font-size: 16px; margin: 0 0 10px 0;">
                        <strong>Data de Lançamento:</strong> {{ \Carbon\Carbon::parse($album['releaseDate'])->format('d/m/Y') }}
                    </p>
                @endif

                @if(isset($album['primaryGenreName']))
                    <p style="color: #666; font-size: 16px; margin: 0 0 20px 0;">
                        <strong>Gênero:</strong> {{ $album['primaryGenreName'] }}
                    </p>
                @endif

                @if(auth()->check() && auth()->user()->role === 'admin')
                    <div style="display: grid; gap: 10px;">
                        <form method="POST" action="{{ route('itunes.import-album') }}" style="display: inline;">
                            @csrf
                            <input type="hidden" name="artist_name" value="{{ $album['artistName'] ?? '' }}">
                            <input type="hidden" name="album_name" value="{{ $album['collectionName'] ?? '' }}">
                            <input type="hidden" name="release_date" value="{{ $album['releaseDate'] ?? '' }}">
                            <input type="hidden" name="itunes_id" value="{{ $collectionId }}">
                            <button type="submit" style="
                                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                                color: white;
                                padding: 12px 25px;
                                border: none;
                                border-radius: 8px;
                                font-weight: 600;
                                cursor: pointer;
                                width: 100%;
                            ">✓ Importar Álbum</button>
                        </form>
                    </div>
                @endif
            </div>
        </div>
    </div>

    @if(count($songs) > 0)
        <h2 style="margin-bottom: 20px;">Músicas do Álbum</h2>

        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="background: #5f5f5f; border-bottom: 2px solid #181818;">
                    <th style="padding: 15px; text-align: left; font-weight: 600;">Nº</th>
                    <th style="padding: 15px; text-align: left; font-weight: 600;">Música</th>
                    <th style="padding: 15px; text-align: center; font-weight: 600;">Duração</th>
                </tr>
            </thead>
            <tbody>
                @foreach($songs as $index => $song)
                    <tr style="border-bottom: 1px solid #131313;">
                        <td style="padding: 15px;">{{ $index + 1 }}</td>
                        <td style="padding: 15px;">{{ $song['trackName'] ?? 'Sem nome' }}</td>
                        <td style="padding: 15px; text-align: center;">
                            @if(isset($song['trackTimeMillis']))
                                {{ gmdate('i:s', $song['trackTimeMillis'] / 1000) }}
                            @else

                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

</div>
@endsection
