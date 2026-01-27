@extends('fe_master')

@section('content')
<div class="container" style="padding: 30px; max-width: 1000px;">

    <div style="margin-bottom: 30px;">
        <a href="{{ route('itunes.search') }}" style="color: #667eea; text-decoration: none;">← Voltar à Busca</a>
    </div>

    <h1 style="margin-bottom: 10px;">Resultados para: "{{ $term }}"</h1>
    <p style="color: #666; margin-bottom: 30px;">Tipo: <strong>{{ ucfirst($type) }}</strong> - <strong>{{ count($results) }}</strong> resultado(s)</p>

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

    @if(count($results) > 0)
        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 20px;">
            @foreach($results as $item)
                <div style="background: white; border-radius: 12px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.1); transition: transform 0.2s;">

                    @if(isset($item['artworkUrl100']))
                        <img src="{{ str_replace('100x100', '300x300', $item['artworkUrl100']) }}" alt="{{ $item['collectionName'] ?? $item['artistName'] }}" style="width: 100%; height: 200px; object-fit: cover;">
                    @else
                        <div style="width: 100%; height: 200px; background: #f0f0f0; display: flex; align-items: center; justify-content: center; color: #999;">
                            Sem imagem
                        </div>
                    @endif

                    <div style="padding: 20px;">
                        <h3 style="margin: 0 0 10px 0; font-size: 16px;">
                            {{ $item['collectionName'] ?? $item['artistName'] ?? 'Sem nome' }}
                        </h3>

                        @if(isset($item['artistName']))
                            <p style="margin: 0 0 10px 0; color: #666; font-size: 14px;">
                                <strong>Artista:</strong> {{ $item['artistName'] }}
                            </p>
                        @endif

                        @if(isset($item['releaseDate']))
                            <p style="margin: 0 0 15px 0; color: #666; font-size: 14px;">
                                <strong>Data:</strong> {{ \Carbon\Carbon::parse($item['releaseDate'])->format('d/m/Y') }}
                            </p>
                        @endif

                        <div style="display: flex; gap: 10px;">
                            <a href="{{ route('itunes.album', $item['collectionId'] ?? $item['artistId']) }}" style="
                                background: #2196f3;
                                color: white;
                                padding: 8px 12px;
                                border-radius: 6px;
                                text-decoration: none;
                                font-size: 12px;
                                font-weight: 600;
                                flex: 1;
                                text-align: center;
                            ">Ver Detalhes</a>

                            @if(auth()->check() && auth()->user()->role === 'admin')
                                <form method="POST" action="{{ route('itunes.import-artist') }}" style="flex: 1;">
                                    @csrf
                                    <input type="hidden" name="artist_name" value="{{ $item['artistName'] }}">
                                    <input type="hidden" name="artist_photo" value="{{ $item['artworkUrl100'] ?? '' }}">
                                    <button type="submit" style="
                                        background: #4caf50;
                                        color: white;
                                        padding: 8px 12px;
                                        border: none;
                                        border-radius: 6px;
                                        font-size: 12px;
                                        font-weight: 600;
                                        cursor: pointer;
                                        width: 100%;
                                    ">Importar</button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div style="background: #fff3cd; border: 1px solid #ffeaa7; color: #856404; padding: 20px; border-radius: 8px; text-align: center;">
            Nenhum resultado encontrado para sua busca.
        </div>
    @endif

</div>
@endsection
