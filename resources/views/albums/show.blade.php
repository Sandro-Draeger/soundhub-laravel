@extends('fe_master')

@section('content')

<input type="text" id="search" placeholder="Pesquisar música">
<button onclick="searchItunes()">Pesquisar no iTunes</button>




@if(auth()->check())
    @if(auth()->user()->role === 'admin')
        <form method="POST" action="{{ route('albums.destroy', $album->id) }}" onsubmit="return confirm('Tem certeza que deseja deletar este álbum?');">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">Deletar Álbum</button>
        </form>
    @endif
@endif

<h2>Músicas do Álbum</h2>
@if($album->songs->count())
    <ul>
    @foreach($album->songs as $song)
        <li>
            {{ $song->track_name }} - {{ $song->artist_name }}
            @if(auth()->check() && auth()->user()->role !== 'admin')
                <form method="POST" action="{{ route('playlist.add-song') }}" style="display:inline">
                    @csrf
                    <input type="hidden" name="track_name" value="{{ $song->track_name }}">
                    <input type="hidden" name="preview_url" value="{{ $song->preview_url }}">
                    <input type="hidden" name="album_id" value="{{ $album->id }}">
                    <input type="hidden" name="artist_name" value="{{ $song->artist_name }}">
                    <label for="playlist_id_{{ $song->id }}">Playlist:</label>
                    <select name="playlist_id" id="playlist_id_{{ $song->id }}">
                        @foreach(auth()->user()->playlists as $playlist)
                            <option value="{{ $playlist->id }}">{{ $playlist->name }}</option>
                        @endforeach
                    </select>
                    <button type="submit">Adicionar à Playlist</button>
                </form>
            @endif
        </li>
    @endforeach
    </ul>
@else
    <p>Nenhuma música cadastrada neste álbum.</p>
@endif

<div id="results"></div>

<script>
function searchItunes() {
    const term = document.getElementById('search').value;

    fetch(`/itunes/search?term=${term}`)
        .then(res => res.json())
        .then(data => {
            let html = '';
            data.forEach(song => {
                html += `
                    <p>
                      ${song.trackName} - ${song.artistName}
                      <button onclick='addMusic(${JSON.stringify(song)})'>
                        Adicionar
                      </button>
                    </p>`;
            });
            document.getElementById('results').innerHTML = html;
        });
}
</script>

@endsection
