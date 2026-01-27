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
      <label>Banda/Artista</label>
      <select name="band_id" required>
        <option value="">Selecione uma banda</option>
        @foreach($bands as $band)
          <option value="{{ $band->id }}" {{ old('band_id', $album->band_id ?? '') == $band->id ? 'selected' : '' }}>
            {{ $band->name }}
          </option>
        @endforeach
      </select>
    </div>

    <div class="field">
      <label>Título</label>
      <input
        name="title"
        value="{{ old('title', $album->title ?? '') }}"
        required
      >
    </div>

    <div class="field">
      <label>Data de Lançamento</label>
      <input
        type="date"
        name="release_date"
        value="{{ old('release_date', $album->release_date ?? '') }}"
      >
    </div>

    <div class="field">
      <label>Imagem/Capa</label>
      <input type="file" name="image" accept="image/*">
    </div>

    @if(isset($album) && $album->image)
      <div class="field">
        <label>Imagem Atual:</label><br>
        <img src="{{ asset('storage/'.$album->image) }}" width="120" style="border-radius: 8px; margin-top: 10px;">
      </div>
    @endif

    <button class="login-button">
      {{ isset($album) ? 'Atualizar' : 'Criar' }}
    </button>

  </form>
</div>

@endsection
