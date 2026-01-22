@extends('fe_master')

@section('content')
<div class="container">
    <h1>Editar Banda</h1>

    <form method="POST" action="{{ route('bands.update', $band) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <input type="text" name="name" value="{{ $band->name }}">

        <input type="file" name="photo">

        <button type="submit">Atualizar</button>
    </form>
</div>
@endsection
