@extends('fe_master')

@section('content')
<div class="container" style="padding: 30px; max-width: 900px;">

    <div style="margin-bottom: 30px;">
        <a href="{{ route('playlists.index') }}" style="color: #667eea; text-decoration: none;">← Voltar às Playlists</a>
    </div>

    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
        <div>
            <h1 style="margin: 0 0 5px 0;">{{ $playlist->name }}</h1>
            @if($playlist->description)
                <p style="color: #666; margin: 0;">{{ $playlist->description }}</p>
            @endif
        </div>
        <a href="{{ route('playlists.edit', $playlist) }}" style="
            background: #ff9800;
            color: white;
            padding: 10px 20px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
        ">Editar</a>
    </div>

    @if(session('success'))
        <div style="background: #4caf50; color: white; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div style="background: #f44336; color: white; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
            {{ session('error') }}
        </div>
    @endif

    @if($musics->count())
        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="background: #f5f5f5; border-bottom: 2px solid #ddd;">
                    <th style="padding: 15px; text-align: left; font-weight: 600;">Nº</th>
                    <th style="padding: 15px; text-align: left; font-weight: 600;">Nome da Música</th>
                    <th style="padding: 15px; text-align: left; font-weight: 600;">Artista</th>
                    <th style="padding: 15px; text-align: left; font-weight: 600;">Álbum</th>
                    <th style="padding: 15px; text-align: center; font-weight: 600;">Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach($musics as $index => $music)
                    <tr style="border-bottom: 1px solid #eee;">
                        <td style="padding: 15px;">{{ $index + 1 }}</td>
                        <td style="padding: 15px;">{{ $music->track_name }}</td>
                        <td style="padding: 15px;">{{ $music->artist_name }}</td>
                        <td style="padding: 15px;">{{ $music->album->title ?? '-' }}</td>
                        <td style="padding: 15px; text-align: center;">
                            <form method="POST" action="{{ route('playlists.remove-music', $playlist) }}" style="display: inline;">
                                @csrf
                                <input type="hidden" name="music_id" value="{{ $music->id }}">
                                <button type="submit" onclick="return confirm('Tem certeza?')" style="
                                    background: #f44336;
                                    color: white;
                                    padding: 6px 12px;
                                    border: none;
                                    border-radius: 6px;
                                    font-size: 12px;
                                    font-weight: 600;
                                    cursor: pointer;
                                ">Remover</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <div style="background: #fff3cd; border: 1px solid #ffeaa7; color: #856404; padding: 20px; border-radius: 8px; text-align: center;">
            Esta playlist está vazia. Adicione músicas para começar!
        </div>
    @endif

</div>
@endsection
