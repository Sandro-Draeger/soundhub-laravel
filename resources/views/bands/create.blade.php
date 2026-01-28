@extends('fe_master')

@section('content')
<div class="container" style="padding: 30px; max-width: 600px;">

    <h1 style="margin-bottom: 30px;">Create New Band</h1>

    <form method="POST" action="{{ route('bands.store') }}" enctype="multipart/form-data" style="background: white; padding: 30px; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
        @csrf

        <div style="margin-bottom: 20px;">
            <label style="display: block; margin-bottom: 8px; font-weight: 600; color: #333;">Band Name</label>
            <input
                type="text"
                name="name"
                placeholder="Ex: The Beatles"
                style="width: 100%; padding: 12px; border: 2px solid #e0e0e0; border-radius: 8px; font-size: 14px;"
                required
            >
            @error('name')
                <span style="color: #f44336; font-size: 12px;">{{ $message }}</span>
            @enderror
        </div>

        <div style="margin-bottom: 20px;">
            <label style="display: block; margin-bottom: 8px; font-weight: 600; color: #333;">Band Cover</label>
            <input
                type="file"
                name="photo"
                style="width: 100%; padding: 10px; border: 2px solid #e0e0e0; border-radius: 8px;"
            >
            <small style="color: #666;">Allowed formats: JPG, PNG, GIF (max. 2MB)</small>
            @error('photo')
                <span style="color: #f44336; font-size: 12px; display: block;">{{ $message }}</span>
            @enderror
        </div>

        <div style="display: flex; gap: 10px;">
            <button type="submit" style="
                background: #667eea;
                color: white;
                padding: 12px 25px;
                border: none;
                border-radius: 8px;
                font-weight: 600;
                cursor: pointer;
            ">Create Band</button>
            <a href="{{ route('bands.index') }}" style="
                background: #e0e0e0;
                color: #333;
                padding: 12px 25px;
                border-radius: 8px;
                text-decoration: none;
                font-weight: 600;
            ">Cancel</a>
        </div>
    </form>
</div>
@endsection

