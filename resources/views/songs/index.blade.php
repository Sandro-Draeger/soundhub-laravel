@extends('fe_master')

@section('content')

<form method="GET">
    <input type="text" name="term" placeholder="Buscar álbum">
    <button type="submit">Pesquisar</button>
</form>

<hr>

@if(!empty($albums))
    @foreach($albums as $album)
        <div style="margin-bottom: 15px;">
            <img src="{{ $album['artworkUrl100'] }}" alt="">
            <p><strong>{{ $album['collectionName'] }}</strong></p>
            <p>{{ $album['artistName'] }}</p>

            <a href="/albums/{{ $album['collectionId'] }}">
                Ver músicas
            </a>
        </div>
    @endforeach
@endif



@endsection
