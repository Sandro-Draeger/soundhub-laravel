@extends('fe_master')

@section('content')
<div class="container" style="padding: 10px; max-width: 1000px;">

    <div style="margin-bottom: 30px;">
        <a href="{{ route('dashboard.album', $album->id) }}" style="color: #667eea; text-decoration: none;">← Voltar ao Álbum</a>
    </div>

    <div style="background: rgb(61, 61, 61); padding: 30px; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); margin-bottom: 30px;">
        <div style="display: grid; grid-template-columns: 200px 1fr; gap: 30px; align-items: start;">

            @if($album->image)
                <img src="{{ asset('storage/' . $album->image) }}" alt="{{ $album->title }}" style="width: 100%; border-radius: 8px;">
            @elseif($album->itunes_id)
                <img src="https://is1-ssl.mzstatic.com/image/thumb/Music{{ substr($album->itunes_id, 0, 2) }}/{$album->itunes_id}/300x300.jpg" alt="{{ $album->title }}" style="width: 100%; border-radius: 8px;">
            @else
                <div style="width: 100%; aspect-ratio: 1; background: #f0f0f0; border-radius: 8px; display: flex; align-items: center; justify-content: center; color: #999;">
                    Sem imagem
                </div>
            @endif

            <div>
                <h1 style="margin: 0 0 10px 0;">Gerenciar Músicas: <br><br>
                    {{ $album->title }}</h1>

                @if($album->band)
                    <p style="color: #ffffff; font-size: 16px; margin: 0 0 10px 0;">
                        <strong>Artista:</strong> {{ $album->band->name }}
                    </p>
                @endif

                <p style="color: #ffffff; font-size: 16px; margin: 0 0 20px 0;">
                    <strong>Músicas atuais:</strong> {{ $album->songs->count() }}
                </p>


            </div>
        </div>
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

    <h2 style="margin-bottom: 20px;">Músicas Atuais</h2>

    @if($album->songs->count() > 0)
        <div style="background: rgb(145, 145, 145); border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); overflow: hidden; margin-bottom: 30px;">
            <table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="background: #5f5f5f; border-bottom: 2px solid #181818;">
                        <th style="padding: 15px; text-align: left; font-weight: 600;">Nº</th>
                        <th style="padding: 15px; text-align: left; font-weight: 600;">Música</th>
                        <th style="padding: 15px; text-align: center; font-weight: 600;">Duração</th>
                        <th style="padding: 15px; text-align: center; font-weight: 600;">Preview</th>
                        <th style="padding: 15px; text-align: center; font-weight: 600;">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($album->songs as $index => $song)
                        <tr style="border-bottom: 1px solid #131313;">
                            <td style="padding: 15px;">{{ $index + 1 }}</td>
                            <td style="padding: 15px;">{{ $song->track_name }}</td>
                            <td style="padding: 15px; text-align: center;">
                                @if($song->track_time)
                                    {{ gmdate('i:s', $song->track_time / 1000) }}
                                @else
                                    --
                                @endif
                            </td>
                            <td style="padding: 15px; text-align: center;">
                                @if($song->preview_url)
                                    <audio controls style="height: 30px; max-width: 200px;">
                                        <source src="{{ $song->preview_url }}" type="audio/mpeg">
                                        Seu navegador não suporta o elemento audio.
                                    </audio>
                                @else
                                    <span style="color: #999;">Não disponível</span>
                                @endif
                            </td>
                            <td style="padding: 15px; text-align: center;">
                                <form method="POST" action="{{ route('dashboard.album.song.destroy', ['albumId' => $album->id, 'songId' => $song->id]) }}" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" style="
                                        background: #f44336;
                                        color: white;
                                        border: none;
                                        padding: 5px 10px;
                                        border-radius: 4px;
                                        cursor: pointer;
                                        font-size: 12px;
                                    " onclick="return confirm('Tem certeza que deseja remover esta música?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div style="background: rgb(145, 145, 145); padding: 30px; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); text-align: center; margin-bottom: 30px;">
            <p style="color: #333; margin: 0;">Este álbum ainda não tem músicas.</p>
        </div>
    @endif

</div>
@endsection
