@extends('fe_master')

@section('content')
<div class="container" style="padding: 30px; max-width: 900px;">

    <h1 style="margin-bottom: 30px;">Search Artists</h1>

    @if(session('error'))
        <div style="background: #f44336; color: white; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
            {{ session('error') }}
        </div>
    @endif

    @if(session('success'))
        <div style="background: #4caf50; color: white; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
            {{ session('success') }}
        </div>
    @endif

    <div style="background: white; padding: 30px; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); margin-bottom: 30px;">
        <form method="GET" action="{{ route('itunes.results') }}">
            <div style="display: grid; gap: 20px;">
                <div>
                    <label style="display: block; margin-bottom: 8px; font-weight: 600; color: #333;">What do you want to search?</label>
                    <input
                        type="text"
                        name="term"
                        placeholder="Ex: The Beatles, Pink Floyd, etc..."
                        style="width: 100%; padding: 12px; border: 2px solid #e0e0e0; border-radius: 8px; font-size: 14px;"
                        required
                    >
                </div>

                <div>
                    <label style="display: block; margin-bottom: 8px; font-weight: 600; color: #333;">Search Type</label>
                    <select name="type" style="width: 100%; padding: 12px; border: 2px solid #e0e0e0; border-radius: 8px; font-size: 14px;">
                        <option value="album">Album</option>
                    </select>
                </div>

                <button type="submit" style="
                    background: #667eea;
                    color: white;
                    padding: 12px 25px;
                    border: none;
                    border-radius: 8px;
                    font-weight: 600;
                    cursor: pointer;
                    font-size: 14px;
                ">Search</button>
            </div>
        </form>
    </div>


</div>
@endsection
