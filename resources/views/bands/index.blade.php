@extends('fe_master')

@section('content')
<div class="container" style="padding: 30px;">

    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
        <h1 style="margin: 0;">Bandas</h1>
        @if(auth()->check() && auth()->user()->role === 'admin')
            <a href="{{ route('bands.create') }}" style="
                background: #667eea;
                color: white;
                padding: 10px 20px;
                border-radius: 8px;
                text-decoration: none;
                font-weight: 600;
            ">+ Nova Banda</a>
        @endif
    </div>

    @if(session('success'))
        <div style="background: #4caf50; color: white; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
            {{ session('success') }}
        </div>
    @endif

    @if($bands->count())
        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="background: #f5f5f5; border-bottom: 2px solid #ddd;">
                    <th style="padding: 15px; text-align: left; font-weight: 600;">Foto</th>
                    <th style="padding: 15px; text-align: left; font-weight: 600;">Nome da Banda</th>
                    <th style="padding: 15px; text-align: center; font-weight: 600;">Número de Álbuns</th>
                    <th style="padding: 15px; text-align: center; font-weight: 600;">Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach($bands as $band)
                    <tr style="border-bottom: 1px solid #eee; transition: background 0.2s;">
                        <td style="padding: 15px;">
                            @if($band->photo)
                                <img src="{{ asset('storage/' . $band->photo) }}" alt="{{ $band->name }}" style="height: 80px; width: 80px; object-fit: cover; border-radius: 8px;">
                            @else
                                <div style="height: 80px; width: 80px; background: #f0f0f0; border-radius: 8px; display: flex; align-items: center; justify-content: center; color: #999;">
                                    Sem foto
                                </div>
                            @endif
                        </td>
                        <td style="padding: 15px; font-weight: 500;">
                            {{ $band->name }}
                        </td>
                        <td style="padding: 15px; text-align: center;">
                            <strong>{{ $band->albums->count() }}</strong>
                        </td>
                        <td style="padding: 15px; text-align: center;">
                            <a href="{{ route('bands.show', $band) }}" style="
                                background: #2196f3;
                                color: white;
                                padding: 8px 15px;
                                border-radius: 6px;
                                text-decoration: none;
                                font-size: 12px;
                                font-weight: 600;
                                margin-right: 5px;
                            ">Ver Álbuns</a>

                            @if(auth()->check() && auth()->user()->role === 'admin')
                                <a href="{{ route('bands.edit', $band) }}" style="
                                    background: #ff9800;
                                    color: white;
                                    padding: 8px 15px;
                                    border-radius: 6px;
                                    text-decoration: none;
                                    font-size: 12px;
                                    font-weight: 600;
                                    margin-right: 5px;
                                ">Editar</a>

                                <form method="POST" action="{{ route('bands.destroy', $band) }}" style="display: inline;">
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
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <div style="background: #fff3cd; border: 1px solid #ffeaa7; color: #856404; padding: 20px; border-radius: 8px; text-align: center;">
            Não existem bandas registadas.
        </div>
    @endif

</div>
@endsection

