<!DOCTYPE html>
<html lang="pt">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<title>soundhub</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
<link rel="stylesheet" href="{{ asset('fe_master.css') }}">
<style>
  .menu a {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 12px 20px;
    transition: background 0.2s;
    border-radius: 6px;
  }

  .menu a:hover {
    background: rgba(255,255,255,0.1);
  }

  .menu a.active {
    background: #667eea;
    color: white;
  }
</style>
@stack('css')
</head>
<body>

    <div class="sidebar">
     <div class="brand">
         <img src="{{ asset('sound-hub-full.svg') }}" alt="SoundHub logo">
     </div>

    <nav class="menu">
      <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">
        <i class="bi bi-house"></i> Home
      </a>

      <a href="{{ route('bands.index') }}" class="{{ request()->routeIs('bands.*') ? 'active' : '' }}">
        <i class="bi bi-music-note-beamed"></i> Artists
      </a>

      <a href="{{ route('albums.index') }}" class="{{ request()->routeIs('albums.*') ? 'active' : '' }}">
        <i class="bi bi-disc"></i> Albums
      </a>

      @auth
        <a href="{{ route('playlists.index') }}" class="{{ request()->routeIs('playlists.*') ? 'active' : '' }}">
          <i class="bi bi-list-ul"></i> MY Playlists
        </a>

        <a href="{{ route('itunes.search') }}" class="{{ request()->routeIs('itunes.*') ? 'active' : '' }}">
          <i class="bi bi-search"></i> Buscar iTunes
        </a>

        @if(auth()->user()->role === 'admin')
          <hr style="margin: 20px 0; border: none; border-top: 1px solid rgba(255,255,255,0.2);">

          <div style="padding: 10px 20px; font-weight: 600; color: rgba(255,255,255,0.7); font-size: 12px;">
            ADMINISTRADOR
          </div>

          <a href="{{ route('bands.create') }}" class="{{ request()->routeIs('bands.create') ? 'active' : '' }}">
            <i class="bi bi-plus-circle"></i> Add Artist
          </a>

          <a href="{{ route('albums.create') }}" class="{{ request()->routeIs('albums.create') ? 'active' : '' }}">
            <i class="bi bi-plus-circle"></i> Add Album
          </a>

          <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <i class="bi bi-speedometer2"></i> Dashboard
          </a>
        @endif

        <hr style="margin: 20px 0; border: none; border-top: 1px solid rgba(255,255,255,0.2);">

        <form method="POST" action="{{ route('logout') }}" style="margin: 0;">
          @csrf
          <button type="submit" style="
            width: 100%;
            background: none;
            border: none;
            color: white;
            padding: 12px 20px;
            text-align: left;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 10px;
            border-radius: 6px;
            transition: background 0.2s;
            font-size: 14px;
          " onmouseover="this.style.background='rgba(255,255,255,0.1)'" onmouseout="this.style.background='none'">
            <i class="bi bi-box-arrow-right"></i> Logout
          </button>
        </form>
      @else
        <hr style="margin: 20px 0; border: none; border-top: 1px solid rgba(255,255,255,0.2);">

        <a href="{{ route('login') }}" class="{{ request()->routeIs('login') ? 'active' : '' }}">
          <i class="bi bi-box-arrow-in-right"></i> Login
        </a>

        <a href="{{ route('register') }}" class="{{ request()->routeIs('register') ? 'active' : '' }}">
          <i class="bi bi-person-plus"></i> Register
        </a>
      @endauth
    </nav>

    <div class="now-playing">
      @auth
        <p style="font-size: 12px; color: rgba(255,255,255,0.7);">User</p>
        <p style="margin: 0; font-weight: 600;">{{ auth()->user()->name }}</p>
        @if(auth()->user()->role === 'admin')
          <span style="display: inline-block; background: #667eea; color: white; padding: 3px 8px; border-radius: 4px; font-size: 10px; font-weight: 600; margin-top: 5px;">ADMIN</span>
        @else
          <span style="display: inline-block; background: #666; color: white; padding: 3px 8px; border-radius: 4px; font-size: 10px; font-weight: 600; margin-top: 5px;">USER</span>
        @endif
      @else
        <p>SoundHub</p>
      @endauth
    </div>
  </div>

  <!-- MAIN -->
  <div class="main">

<!-- Conteúdo -->
<main class="content">
    @yield('content')
</main>


  </div>

</body>

</html>
