@extends('fe_master')

@section('content')
<div class="container">
    <h1>Nova Banda</h1>

    <form method="POST" action="{{ route('bands.store') }}" enctype="multipart/form-data">
        @csrf

        <input type="text" name="name" placeholder="Nome da banda">

        <input type="file" name="photo">

        <button type="submit">Guardar</button>
    </form>
</div>
@endsection
