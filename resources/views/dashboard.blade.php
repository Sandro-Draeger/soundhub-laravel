@extends('fe_master')

<link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">

@section('content')
<div class="dashboard-container">

    {{-- HEADER --}}
    <div class="dashboard-header">
        @if(auth()->user()->role === 'admin')
            <div class="admin-actions">
                <p>Manage your music collection and explore new albums.</p>

                <a href="{{ route('itunes.search') }}" class="btn btn-secondary">
                    <i class="bi bi-music-note-list"></i> Add Album
                </a>
            </div>
        @endif
    </div>

    {{-- FLASH MESSAGES --}}
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-error">
            {{ session('error') }}
        </div>
    @endif

    {{-- ALBUM GRID --}}
    @if($albums->count())
        <div class="album-grid">
            @foreach($albums as $album)
                <div class="album-card">

                    <div class="album-cover-wrapper">
                        @if($album->image)
                            <img src="{{ Storage::url($album->image) }}" class="album-cover">
                        @elseif($album->itunes_id)
                            <img src="https://is1-ssl.mzstatic.com/image/thumb/Music{{ substr($album->itunes_id, 0, 2) }}/{{ $album->itunes_id }}/300x300.jpg" class="album-cover">
                        @else
                            <div class="album-placeholder"></div>
                        @endif
                    </div>

                    <div class="album-info">

    <div class="album-title-row">
        <span class="album-title">{{ $album->title }}</span>

        @if(auth()->user()->role === 'admin')
            <div class="album-actions">
                <a href="{{ route('dashboard.album.manage-songs', $album->id) }}" class="btn btn-manage">
                    <i class="bi bi-gear"></i>
                </a>

                <form method="POST" action="{{ route('dashboard.album.destroy', $album->id) }}">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-delete">
                        <i class="bi bi-trash"></i>
                    </button>
                </form>
            </div>
        @endif
    </div>

    <span class="album-artist">{{ $album->band->name ?? 'Unknown Artist' }}</span>

</div>

                </div>
            @endforeach
        </div>
    @else
        <div class="empty-state">
            <h3>No albums found</h3>
            <p>Start by adding your first album.</p>
        </div>
    @endif

</div>
@endsection
