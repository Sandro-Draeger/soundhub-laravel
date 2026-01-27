@extends('fe_master')

@section('content')
<div class="container" style="padding: 30px;">

    <div style="margin-bottom: 30px;">
        <a href="{{ route('bands.index') }}" style="color: #667eea; text-decoration: none;">← Voltar às Bandas</a>
    </div>

    <div style="background: white; padding: 30px; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); margin-bottom: 30px;">
        <div style="display: flex; gap: 30px;">
            @if($band->photo)
                <img src="{{ asset('storage/' . $band->photo) }}" alt="{{ $band->name }}" style="height: 200px; width: 200px; object-fit: cover; border-radius: 12px;">
            @else
                <div style="height: 200px; width: 200px; background: #f0f0f0; border-radius: 12px; display: flex; align-items: center; justify-content: center; color: #999;">
                    Sem foto
                </div>
            @endif

            <div>
                <h1 style="margin: 0 0 20px 0;">{{ $band->name }}</h1>
                <p style="color: #666; font-size: 16px; margin-bottom: 10px;">
                    <strong>Total de Álbuns:</strong> {{ $band->albums->count() }}
                </p>

                @if(auth()->check() && auth()->user()->role === 'admin')
                    <div style="margin-top: 20px;">
                        <a href="{{ route('bands.edit', $band) }}" style="
                            background: #ff9800;
                            color: white;
                            padding: 10px 20px;
                            border-radius: 8px;
                            text-decoration: none;
                            font-weight: 600;
                            margin-right: 10px;
                        ">Editar</a>
                        <form method="POST" action="{{ route('bands.destroy', $band) }}" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('Tem certeza que deseja apagar esta banda?')" style="
                                background: #f44336;
                                color: white;
                                padding: 10px 20px;
                                border: none;
                                border-radius: 8px;
                                font-weight: 600;
                                cursor: pointer;
                            ">Apagar</button>
                        </form>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <h2 style="margin-bottom: 20px;">Álbuns</h2>

    @if($band->albums->count())
        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="background: #f5f5f5; border-bottom: 2px solid #ddd;">
                    <th style="padding: 15px; text-align: left; font-weight: 600;">Imagem</th>
                    <th style="padding: 15px; text-align: left; font-weight: 600;">Nome do Álbum</th>
                    <th style="padding: 15px; text-align: left; font-weight: 600;">Data de Lançamento</th>
                    @if(auth()->check() && auth()->user()->role === 'admin')
                        <th style="padding: 15px; text-align: center; font-weight: 600;">Ações</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @foreach($band->albums as $album)
                    <tr style="border-bottom: 1px solid #eee;">
                        <td style="padding: 15px;">
                            @if($album->image)
                                <img src="{{ asset('storage/' . $album->image) }}" alt="{{ $album->title }}" style="height: 60px; width: 60px; object-fit: cover; border-radius: 6px;">
                            @else
                                <div style="height: 60px; width: 60px; background: #f0f0f0; border-radius: 6px; display: flex; align-items: center; justify-content: center; color: #999; font-size: 12px;">
                                    Sem imagem
                                </div>
                            @endif
                        </td>
                        <td style="padding: 15px; font-weight: 500;">
                            {{ $album->title }}
                        </td>
                        <td style="padding: 15px;">
                            @if($album->release_date)
                                {{ \Carbon\Carbon::parse($album->release_date)->format('d/m/Y') }}
                            @else
                                <span style="color: #999;">-</span>
                            @endif
                        </td>
                        @if(auth()->check() && auth()->user()->role === 'admin')
                            <td style="padding: 15px; text-align: center;">
                                <a href="{{ route('albums.edit', $album) }}" style="
                                    background: #ff9800;
                                    color: white;
                                    padding: 8px 15px;
                                    border-radius: 6px;
                                    text-decoration: none;
                                    font-size: 12px;
                                    font-weight: 600;
                                    margin-right: 5px;
                                ">Editar</a>
                                <form method="POST" action="{{ route('albums.destroy', $album) }}" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" onclick="return confirm('Tem certeza?')" style="
                                        background: #f44336;
                                        color: white;
                                        padding: 8px 15px;
                                        border: none;
                                        border-radius: 6px;
                                        font-size: 12px;
                                        font-weight: 600;
                                        cursor: pointer;
                                    ">Apagar</button>
                                </form>
                            </td>
                        @endif
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <div style="background: #fff3cd; border: 1px solid #ffeaa7; color: #856404; padding: 20px; border-radius: 8px;">
            Esta banda ainda não tem álbuns registados.
        </div>
    @endif

</div>
@endsection

