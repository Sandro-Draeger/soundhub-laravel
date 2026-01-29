@extends('fe_master')

<link rel="stylesheet" href="{{ asset('css/itunes.css') }}">

@section('content')
<div class="search-page">

    <h1 class="page-title">What do you want to search?</h1>

    @if(session('error'))
        <div class="alert error">{{ session('error') }}</div>
    @endif

    @if(session('success'))
        <div class="alert success">{{ session('success') }}</div>
    @endif

    <div class="search-card">
        <form method="GET" action="{{ route('itunes.results') }}" class="search-form">

            <div class="form-group">
                <label>Name</label>
                <input
                    type="text"
                    name="term"
                    placeholder="Ex: The Beatles, Pink Floyd..."
                    required
                >
            </div>

            <div class="form-group">
                <label>Type</label>
                <select name="type">
                    <option value="album">Album</option>
                    <option value="artist">Artist</option>
                    <option value="song">Song</option>
                </select>
            </div>

            <button type="submit" class="btn-primary">
                Search
            </button>

        </form>
    </div>

</div>
@endsection

