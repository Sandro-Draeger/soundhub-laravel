@extends('fe_master')
<link rel="stylesheet" href="{{ asset('css/playlists.css') }}">

@section('content')
<div class="playlist-create-container">

    <h1 class="page-title">Edit Playlist</h1>

    <form
        method="POST"
        action="{{ route('playlists.update', $playlist) }}"
        enctype="multipart/form-data"
        class="playlist-form"
    >
        @csrf
        @method('PUT')

                {{-- Cover --}}
        <div class="form-group">
            <label class="form-label">Playlist Cover</label>

            <div class="cover-upload">
                <input
                    type="file"
                    name="photo"
                    accept="image/*"
                >
                <span>Select image</span>
            </div>

            <small class="form-help">
                JPG, PNG or GIF — max 2MB
            </small>

            @error('photo')
                <span class="form-error">{{ $message }}</span>
            @enderror
        </div>

        {{-- NAME --}}
        <div class="form-group">
            <label class="form-label">Playlist Name</label>

            <input
                type="text"
                name="name"
                value="{{ old('name', $playlist->name) }}"
                placeholder="My favorite songs"
                required
            >

            @error('name')
                <span class="form-error">{{ $message }}</span>
            @enderror
        </div>

        {{-- DESCRIPTION --}}
        <div class="form-group">
            <label class="form-label">Description</label>

            <textarea
                name="description"
                placeholder="Describe your playlist..."
            >{{ old('description', $playlist->description) }}</textarea>

            @error('description')
                <span class="form-error">{{ $message }}</span>
            @enderror
        </div>

        {{-- ACTIONS --}}
        <div class="form-actions">
            <button type="submit" class="btn-primary">
                Update
            </button>

            <a
                href="{{ route('playlists.show', $playlist) }}"
                class="btn-secondary"
            >
                Cancel
            </a>
        </div>

    </form>

</div>
@endsection
