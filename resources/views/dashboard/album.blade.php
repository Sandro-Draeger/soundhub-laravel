@extends('fe_master')

@section('content')
<div class="container" style="padding: 10px; max-width: 1000px;">

    <div style="margin-bottom: 30px;">
        <a href="{{ route('dashboard') }}" style="color: #667eea; text-decoration: none;">← Voltar ao Dashboard</a>
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
                <h1 style="margin: 0 0 10px 0;">{{ $album->title }}</h1>

                @if($album->band)
                    <p style="color: #ffffff; font-size: 16px; margin: 0 0 10px 0;">
                        <strong>Artista:</strong> {{ $album->band->name }}
                    </p>
                @endif

                @if($album->release_date)
                    <p style="color: #ffffff; font-size: 16px; margin: 0 0 10px 0;">
                        <strong>Data de Lançamento:</strong> {{ \Carbon\Carbon::parse($album->release_date)->format('d/m/Y') }}
                    </p>
                @endif

                <p style="color: #ffffff; font-size: 16px; margin: 0 0 20px 0;">
                    <strong>Músicas:</strong> {{ $album->songs->count() }}
                </p>
            </div>
        </div>
    </div>

    @if($album->songs->count() > 0)
        <h2 style="margin-bottom: 20px;">Músicas do Álbum</h2>

        <div style="background: rgb(145, 145, 145); border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); overflow: hidden;">
            <table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="background: #5f5f5f; border-bottom: 2px solid #181818;">
                        <th style="padding: 15px; text-align: left; font-weight: 600;">Nº</th>
                        <th style="padding: 15px; text-align: left; font-weight: 600;">Música</th>
                        <th style="padding: 15px; text-align: center; font-weight: 600;">Duração</th>
                        <th style="padding: 15px; text-align: center; font-weight: 600;">Preview</th>
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

                                @endif
                            </td>
                            <td style="padding: 15px; text-align: center; border-radius: 8px;">
                                @if($song->preview_url)
                                    <audio controls style="height: 30px; max-width: 200px; border-radius: 8px;">
                                        <source src="{{ $song->preview_url }}" type="audio/mpeg">
                                        Seu navegador não suporta o elemento audio.
                                    </audio>
                                @else
                                    <span style="color: #ffffff;"><i class="bi bi-ban"></i></span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div style="background: white; padding: 30px; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); text-align: center;">
            <p style="color: #666; margin: 0;">Este álbum ainda não tem músicas cadastradas.</p>
        </div>
    @endif

</div>
@endsection
