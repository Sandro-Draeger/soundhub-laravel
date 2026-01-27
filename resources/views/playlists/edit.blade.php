@extends('fe_master')

@section('content')
<div class="container" style="padding: 30px; max-width: 600px;">

    <h1 style="margin-bottom: 30px;">Editar Playlist</h1>

    <form method="POST" action="{{ route('playlists.update', $playlist) }}" style="background: white; padding: 30px; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
        @csrf
        @method('PUT')

        <div style="margin-bottom: 20px;">
            <label style="display: block; margin-bottom: 8px; font-weight: 600; color: #333;">Nome da Playlist</label>
            <input
                type="text"
                name="name"
                value="{{ old('name', $playlist->name) }}"
                placeholder="Ex: Minhas Favoritas"
                style="width: 100%; padding: 12px; border: 2px solid #e0e0e0; border-radius: 8px; font-size: 14px;"
                required
            >
            @error('name')
                <span style="color: #f44336; font-size: 12px;">{{ $message }}</span>
            @enderror
        </div>

        <div style="margin-bottom: 20px;">
            <label style="display: block; margin-bottom: 8px; font-weight: 600; color: #333;">Descrição</label>
            <textarea
                name="description"
                placeholder="Descrição da sua playlist..."
                style="width: 100%; padding: 12px; border: 2px solid #e0e0e0; border-radius: 8px; font-size: 14px; min-height: 100px;"
            >{{ old('description', $playlist->description) }}</textarea>
            @error('description')
                <span style="color: #f44336; font-size: 12px;">{{ $message }}</span>
            @enderror
        </div>

        <div style="display: flex; gap: 10px;">
            <button type="submit" style="
                background: #667eea;
                color: white;
                padding: 12px 25px;
                border: none;
                border-radius: 8px;
                font-weight: 600;
                cursor: pointer;
                flex: 1;
            ">Atualizar</button>
            <a href="{{ route('playlists.show', $playlist) }}" style="
                background: #e0e0e0;
                color: #333;
                padding: 12px 25px;
                border-radius: 8px;
                text-decoration: none;
                font-weight: 600;
                flex: 1;
                text-align: center;
            ">Cancelar</a>
        </div>
    </form>

</div>
@endsection
