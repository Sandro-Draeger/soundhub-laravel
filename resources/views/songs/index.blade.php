@extends('fe_master')

@section('content')

<form method="GET">
    <input type="text" name="term" placeholder="Search album">
    <button type="submit">Search</button>
</form>

<hr>

@if(!empty($albums))
    @foreach($albums as $album)
        <div style="margin-bottom: 15px;">
            <img src="{{ $album['artworkUrl100'] }}" alt="">
            <p><strong>{{ $album['collectionName'] }}</strong></p>
            <p>{{ $album['artistName'] }}</p>

            <a href="/albums/{{ $album['collectionId'] }}">
                See Details
            </a>
        </div>
    @endforeach
@endif



@endsection
