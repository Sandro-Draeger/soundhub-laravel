<!DOCTYPE html>
<html lang="pt">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<title>soundhub</title>

<link rel="stylesheet" href="{{ asset('fe_master.css') }}">
</head>
<body>

    <div class="sidebar">
     <div class="brand">
         <img src="{{ asset('sound-hub-full.svg') }}" alt="SoundHub logo">
     </div>

    <nav class="menu">
      <a href="#" class="active"><span class="icon">🏠</span> Home</a>
      <a href="#"><span class="icon">🎧</span> Browse</a>
      <a href="#"><span class="icon">🎶</span> Playlists</a>
      <a href="#"><span class="icon">📻</span> Radio</a>
      <a href="#"><span class="icon">⚙️</span> Settings</a>
    </nav>

    <div class="now-playing">
      <p>Now Playing</p>
    </div>
  </div>

  <!-- MAIN -->
  <div class="main">

    <header class="topbar">
      <div class="search-box">
        <span class="search-icon">🔍</span>
        <input type="text" placeholder="Pesquisar músicas, artistas..." />
      </div>

      <div class="user-menu">
        <button class="user-button">
          <img src="https://i.pravatar.cc/40" alt="User">
          <span class="username">João</span>
          <span class="arrow">▾</span>
        </button>

        <div class="dropdown">
          <a href="#">Perfil</a>
          <a href="#">Logout</a>
        </div>
      </div>
    </header>

    <div class="content">




    </div>

  </div>

</body>

</html>
