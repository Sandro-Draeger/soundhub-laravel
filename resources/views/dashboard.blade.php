@extends('fe_master')

@section('content')
<div class="container" style="padding: 10px; max-width: 1200px;">

    <div style="background: rgb(61, 61, 61); padding: 30px; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); margin-bottom: 30px;">
        <h1 style="margin: 0 0 10px 0; color: white;">Meus Álbuns</h1>
        <p style="color: #cccccc; font-size: 16px; margin: 0 0 20px 0;">Olá, {{ auth()->user()->name }}</p>

        {{-- ÁREA DO ADMIN --}}
        @if(auth()->user()->role === 'admin')
            <div style="display: grid; gap: 10px;">
                <div style="display: flex; gap: 10px; flex-wrap: wrap;">
                    <a href="{{ route('bands.create') }}" style="
                        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                        color: white;
                        padding: 12px 25px;
                        border: none;
                        border-radius: 8px;
                        font-weight: 600;
                        cursor: pointer;
                        text-decoration: none;
                        display: inline-block;
                    ">+ Adicionar Banda</a>

                    <a href="{{ route('albums.create') }}" style="
                        background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
                        color: white;
                        padding: 12px 25px;
                        border: none;
                        border-radius: 8px;
                        font-weight: 600;
                        cursor: pointer;
                        text-decoration: none;
                        display: inline-block;
                    ">+ Adicionar Álbum</a>

                    <a href="{{ route('itunes.search') }}" style="
                        background: linear-gradient(135deg, #fd7e14 0%, #e83e8c 100%);
                        color: white;
                        padding: 12px 25px;
                        border: none;
                        border-radius: 8px;
                        font-weight: 600;
                        cursor: pointer;
                        text-decoration: none;
                        display: inline-block;
                    ">🔍 Buscar na iTunes</a>
                </div>
            </div>
        @endif
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

    {{-- LISTA DE ÁLBUNS --}}
    @if($albums->count())
        <div class="album-grid">
            @foreach($albums as $album)
                <div class="album-col">
                    <div class="album-card">
                        @if($album->image)
                            <div class="album-cover-wrapper">
                                <img src="{{ asset('storage/' . $album->image) }}" alt="{{ $album->title }}" class="album-cover">
                            </div>
                        @elseif($album->itunes_id)
                            <div class="album-cover-wrapper">
                                <img src="https://is1-ssl.mzstatic.com/image/thumb/Music{{ substr($album->itunes_id, 0, 2) }}/{$album->itunes_id}/300x300.jpg" alt="{{ $album->title }}" class="album-cover">
                            </div>
                        @else
                            <div class="album-placeholder"></div>
                        @endif

                        <div class="album-info">
                            <div class="album-title">
                                {{ $album->title }}
                            </div>

                            <div class="album-artist">
                                {{ $album->band->name ?? 'Artista Desconhecido' }}
                            </div>

                            <div style="display: flex; gap: 5px; flex-direction: column;">
                                <a href="{{ route('dashboard.album', $album->id) }}" class="import-button">
                                    <i class="bi bi-music-note-list"></i> Ver Músicas
                                </a>

                                @if(auth()->user()->role === 'admin')
                                    <div style="display: flex; gap: 5px;">
                                        <a href="{{ route('dashboard.album.manage-songs', $album->id) }}" style="
                                            background: #17a2b8;
                                            color: white;
                                            padding: 5px 10px;
                                            border-radius: 4px;
                                            text-decoration: none;
                                            font-size: 12px;
                                            display: flex;
                                            align-items: center;
                                            gap: 3px;
                                        ">
                                            <i class="bi bi-gear"></i> Gerenciar
                                        </a>

                                        <form method="POST" action="{{ route('dashboard.album.destroy', $album->id) }}" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" style="
                                                background: #dc3545;
                                                color: white;
                                                border: none;
                                                padding: 5px 10px;
                                                border-radius: 4px;
                                                cursor: pointer;
                                                font-size: 12px;
                                                display: flex;
                                                align-items: center;
                                                gap: 3px;
                                            " onclick="return confirm('Tem certeza que deseja remover este álbum e todas as suas músicas?')">
                                                <i class="bi bi-trash"></i> Remover
                                            </button>
                                        </form>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div style="background: rgb(145, 145, 145); padding: 50px; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); text-align: center;">
            <h3 style="color: #333; margin: 0 0 20px 0;">Nenhum álbum encontrado</h3>
            <p style="color: #666; margin: 0 0 30px 0;">Comece adicionando seu primeiro álbum à coleção.</p>
            @if(auth()->user()->role === 'admin')
                <div style="display: flex; gap: 10px; justify-content: center; flex-wrap: wrap;">
                    <a href="{{ route('albums.create') }}" style="
                        background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
                        color: white;
                        padding: 12px 25px;
                        border: none;
                        border-radius: 8px;
                        font-weight: 600;
                        cursor: pointer;
                        text-decoration: none;
                        display: inline-block;
                    ">+ Adicionar Álbum</a>

                    <a href="{{ route('itunes.search') }}" style="
                        background: linear-gradient(135deg, #fd7e14 0%, #e83e8c 100%);
                        color: white;
                        padding: 12px 25px;
                        border: none;
                        border-radius: 8px;
                        font-weight: 600;
                        cursor: pointer;
                        text-decoration: none;
                        display: inline-block;
                    ">🔍 Buscar na iTunes</a>
                </div>
            @endif
        </div>
    @endif

</div>
@endsection
