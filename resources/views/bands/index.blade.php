@extends('fe_master')

@section('content')
<div class="container">

    <h1>Bandas</h1>

    {{-- @if(auth()->user()->role === 'admin') --}}
        <a href="{{ route('bands.create') }}">+ Nova Banda</a>
   {{-- // @endif --}}

    <ul>
        @foreach($bands as $band)
            <li>
                {{ $band->name }}
                <a href="{{ route('bands.show', $band) }}">Ver</a>
                <a href="{{ route('bands.edit', $band) }}">Editar</a>

                @if(auth()->user()->role === 'admin')
                    <form method="POST" action="{{ route('bands.destroy', $band) }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit">Apagar</button>
                    </form>
                @endif
            </li>
        @endforeach
    </ul>

</div>
@endsection
