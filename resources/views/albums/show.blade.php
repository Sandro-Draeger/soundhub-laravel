@extends('fe_master')

@section('content')

<input type="text" id="search" placeholder="Pesquisar música">
<button onclick="searchItunes()">Pesquisar no iTunes</button>

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
