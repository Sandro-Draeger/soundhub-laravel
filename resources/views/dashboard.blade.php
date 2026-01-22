@extends('fe_master')

@section('content')
<div class="container">

    <h1>Dashboard</h1>
    <p>Olá, {{ auth()->user()->name }}</p>

    {{-- ÁREA DO ADMIN --}}
    @if(auth()->user()->role === 'admin')
        <hr>
        <h2>Gestão</h2>

        <a href="{{ route('bands.create') }}" class="btn btn-primary">+ Adicionar Banda</a>

        <a href="{{ route('albums.create') }}" class="btn btn-secondary">+ Adicionar Álbum</a>
    @endif

    <hr>

    {{-- LISTA DE BANDAS --}}
    <h2>Bandas</h2>

    @if($bands->count())
        <ul>
            @foreach($bands as $band)
                <li>
                    {{ $band->name }}
                    <a href="{{ route('bands.show', $band) }}">Ver</a>
                </li>
            @endforeach
        </ul>
    @else
        <p>Não existem bandas registadas.</p>
    @endif

    <hr>

    {{-- LISTA DE ÁLBUNS --}}
    <h2>Álbuns</h2>

    @if($albums->count())
        <ul>
            @foreach($albums as $album)
                <li>
                    {{ $album->name }}
                    ({{ $album->band->name }})
                    <a href="{{ route('albums.show', $album) }}">Ver</a>
                </li>
            @endforeach
        </ul>
    @else
        <p>Não existem álbuns registados.</p>
    @endif

</div>
@endsection
