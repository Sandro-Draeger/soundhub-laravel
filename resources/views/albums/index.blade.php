@extends('fe_master')

@section('content')
<div class="container">

    <h1>Álbuns</h1>

    @if(auth()->check() && auth()->user()->role === 'admin')
        <a href="{{ route('albums.create') }}" class="btn btn-primary">+ Adicionar Álbum</a>
        <a href="{{ route('itunes.search') }}" class="btn btn-secondary">Buscar no iTunes</a>
    @endif

    @if($albums->count())
        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 20px; margin-top: 20px;">
            @foreach($albums as $album)
                <div style="background: rgb(59, 59, 59); border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); overflow: hidden;">
                    @if($album->image)
                        <img src="{{ asset('storage/' . $album->image) }}" alt="{{ $album->title }}" style="width: 100%; height: 200px; object-fit: cover;">
                    @else
                        <div style="width: 100%; height: 200px; background: #707070; display: flex; align-items: center; justify-content: center; color: #999;">
                            Sem imagem
                        </div>
                    @endif
                    <div style="padding: 15px;">
                        <h3 style="margin: 0 0 5px 0;">{{ $album->title }}</h3>
                        @if($album->band)
                            <p style="color: #666; margin: 0 0 10px 0;">{{ $album->band->name }}</p>
                        @endif
                        @if($album->songs->count())
                            <h4>Músicas:</h4>
                            <ul style="list-style: none; padding: 0; margin: 0;">
                                @foreach($album->songs as $song)
                                    <li style="margin-bottom: 5px; display: flex; justify-content: space-between; align-items: center;">
                                        <span>{{ $song->track_name }}</span>
                                        @if($song->preview_url)
                                            <audio controls style="height: 30px;">
                                                <source src="{{ $song->preview_url }}" type="audio/mpeg">
                                            </audio>
                                        @endif
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                        <a href="{{ route('albums.show', $album) }}" style="display: inline-block; margin-top: 10px; color: #667eea; text-decoration: none;">Ver detalhes</a>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <p>Não existem álbuns registados.</p>
    @endif

</div>
@endsection
