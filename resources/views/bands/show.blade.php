@extends('fe_master')

@section('content')
<div class="container">

    <h1>{{ $band->name }}</h1>

    @if($band->photo)
        <img src="{{ asset('storage/' . $band->photo) }}" width="200">
    @endif

    <h3>Álbuns</h3>

    @if($band->albums->count())
        <ul>
            @foreach($band->albums as $album)
                <li>{{ $album->title }}</li>
            @endforeach
        </ul>
    @else
        <p>Esta banda ainda não tem álbuns.</p>
    @endif

</div>
@endsection
