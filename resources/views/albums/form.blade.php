@extends('fe_master')

@section('content')

<div class="album-form">

  <h1>{{ isset($album) ? 'Editar Álbum' : 'Novo Álbum' }}</h1>

  <form
    method="POST"
    action="{{ isset($album) ? route('albums.update', $album) : route('albums.store') }}"
    enctype="multipart/form-data"
  >
    @csrf
    @if(isset($album))
      @method('PUT')
    @endif

    <div class="field">
      <label>Título</label>
      <input
        name="title"
        value="{{ old('title', $album->title ?? '') }}"
        required
      >
    </div>

    <div class="field">
      <label>Artista</label>
      <input
        name="artist"
        value="{{ old('artist', $album->artist ?? '') }}"
        required
      >
    </div>

    <div class="field">
      <label>Ano</label>
      <input
        name="year"
        value="{{ old('year', $album->year ?? '') }}"
        placeholder="2024"
      >
    </div>

    <div class="field">
      <label>Capa</label>
      <input type="file" name="cover">
    </div>

    @if(isset($album) && $album->cover)
      <img src="{{ asset('storage/'.$album->cover) }}" width="120">
    @endif

    <button class="login-button">
      {{ isset($album) ? 'Atualizar' : 'Criar' }}
    </button>

  </form>
</div>

@endsection
