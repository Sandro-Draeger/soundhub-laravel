@extends('fe_master')

<link rel="stylesheet" href="{{ asset('css/playlists.css') }}">

@section('content')
<div class="playlist-create-container">

    <h1 class="page-title">Create Playlist</h1>

    <form
        method="POST"
        action="{{ route('playlists.store') }}"
        enctype="multipart/form-data"
        class="playlist-form"
    >
        @csrf

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

        {{-- Name --}}
        <div class="form-group">
            <label class="form-label">Playlist Name</label>
            <input
                type="text"
                name="name"
                value="{{ old('name') }}"
                placeholder="My favorite songs"
                required
            >
            @error('name')
                <span class="form-error">{{ $message }}</span>
            @enderror
        </div>

        {{-- Description --}}
        <div class="form-group">
            <label class="form-label">Description</label>
            <textarea
                name="description"
                placeholder="Describe your playlist..."
            >{{ old('description') }}</textarea>
            @error('description')
                <span class="form-error">{{ $message }}</span>
            @enderror
        </div>

        {{-- Actions --}}
        <div class="form-actions">
            <button type="submit" class="btn-primary">
                Create
            </button>

            <a
                href="{{ route('playlists.index') }}"
                class="btn-secondary"
            >
                Cancel
            </a>
        </div>

    </form>

</div>
@endsection
