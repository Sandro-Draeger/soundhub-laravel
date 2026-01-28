@extends('fe_master')

@section('content')
<div class="container" style="padding: 30px; max-width: 900px;">

    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
        <h1 style="margin: 0;">My Playlists</h1>
        <a href="{{ route('playlists.create') }}" style="
            background: #667eea;
            color: white;
            padding: 10px 20px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
        ">+ New Playlist</a>
    </div>

    @if(session('success'))
        <div style="background: #4caf50; color: white; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
            {{ session('success') }}
        </div>
    @endif

    @if($playlists->count())
        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 20px;">
            @foreach($playlists as $playlist)
                <div style="background: white; padding: 20px; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); transition: transform 0.2s;">
                    <h3 style="color: #666; font-size: 14px; margin: 0 0 10px 0;">{{ $playlist->name }}</h3>

                    <image>

                    <p style="color: #666; font-size: 14px; margin: 0 0 10px 0;">
                        {{ $playlist->description }}
                    </p>

                    <p style="color: #999; font-size: 12px; margin: 0 0 15px 0;">
                        <strong>{{ $playlist->musics()->count() }}</strong> song(s)
                    </p>

                    <div style="display: flex; gap: 10px;">
                        <a href="{{ route('playlists.show', $playlist) }}" style="
                            background: #2196f3;
                            color: white;
                            padding: 8px 15px;
                            border-radius: 6px;
                            text-decoration: none;
                            font-size: 12px;
                            font-weight: 600;
                            flex: 1;
                            text-align: center;
                        ">Open</a>

                        <a href="{{ route('playlists.edit', $playlist) }}" style="
                            background: #ff9800;
                            color: white;
                            padding: 8px 15px;
                            border-radius: 6px;
                            text-decoration: none;
                            font-size: 12px;
                            font-weight: 600;
                            flex: 1;
                            text-align: center;
                        ">Edit</a>

                        <form method="POST" action="{{ route('playlists.destroy', $playlist) }}" style="flex: 1;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('have you sure?')" style="
                                background: #f44336;
                                color: white;
                                padding: 8px 15px;
                                border: none;
                                border-radius: 6px;
                                font-size: 12px;
                                font-weight: 600;
                                cursor: pointer;
                                width: 100%;
                            ">Delete</button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div style="background: #fff3cd; border: 1px solid #ffeaa7; color: #856404; padding: 20px; border-radius: 8px; text-align: center;">
            <p>You haven't created any playlist yet.</p>
            <a href="{{ route('playlists.create') }}" style="color: #856404; text-decoration: underline; font-weight: 600;">Create your first playlist now!</a>
        </div>
    @endif

</div>
@endsection
