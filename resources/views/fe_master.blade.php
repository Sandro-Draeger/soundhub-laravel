<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>SoundHub</title>

    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css"
    >

    <link rel="stylesheet" href="{{ asset('fe_master.css') }}">

    @stack('css')
</head>
<body>

<div class="sidebar">

    {{-- BRAND --}}
    <div class="brand">
        <img src="{{ asset('sound-hub-full.svg') }}" alt="SoundHub logo">
    </div>

    {{-- MENU --}}
    <nav class="menu">

        @auth
            <a href="{{ route('albums.index') }}"
               class="{{ request()->routeIs('albums.*') ? 'active' : '' }}">
                <i class="bi bi-house"></i>
                <span>Home</span>
            </a>
        @endauth

        <a href="{{ route('albums.index') }}"
           class="{{ request()->routeIs('albums.*') ? 'active' : '' }}">
            <i class="bi bi-disc"></i>
            <span>Albums</span>
        </a>

        @auth
            <a href="{{ route('playlists.index') }}"
               class="{{ request()->routeIs('playlists.*') ? 'active' : '' }}">
                <i class="bi bi-list-ul"></i>
                <span>My Playlists</span>
            </a>

            <a href="{{ route('itunes.search') }}"
               class="{{ request()->routeIs('itunes.*') ? 'active' : '' }}">
                <i class="bi bi-search"></i>
                <span>Buscar iTunes</span>
            </a>

            @if(auth()->user()->role === 'admin')
                <hr class="menu-divider">

                <span class="menu-label">
                    Admin Panel
                </span>

                <a href="{{ route('dashboard') }}"
                   class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <i class="bi bi-speedometer2"></i>
                    <span>Dashboard</span>
                </a>
            @endif

            <hr class="menu-divider">

            <form method="POST" action="{{ route('logout') }}" class="logout-form">
                @csrf
                <button type="submit" class="logout-btn">
                    <i class="bi bi-box-arrow-right"></i>
                    <span>Logout</span>
                </button>
            </form>

        @else
            <hr class="menu-divider">

            <a href="{{ route('login') }}"
               class="{{ request()->routeIs('login') ? 'active' : '' }}">
                <i class="bi bi-box-arrow-in-right"></i>
                <span>Login</span>
            </a>

            <a href="{{ route('register') }}"
               class="{{ request()->routeIs('register') ? 'active' : '' }}">
                <i class="bi bi-person-plus"></i>
                <span>Register</span>
            </a>
        @endauth

    </nav>

    {{-- USER / NOW PLAYING --}}
    <div class="now-playing">
        @auth
            <p class="user-label">User</p>
            <p class="user-name">{{ auth()->user()->name }}</p>

            <span class="user-role {{ auth()->user()->role }}">
                {{ strtoupper(auth()->user()->role) }}
            </span>
        @else
            <p>SoundHub</p>
        @endauth
    </div>

</div>

{{-- MAIN CONTENT --}}
<div class="main">
    <main class="content">
        @yield('content')
    </main>
</div>

</body>
</html>
