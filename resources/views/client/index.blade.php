@extends('theme.base')

@section('content')

    <div class="container py-5 text-center">
        <h1>Listado de Clientes</h1>
        <a href="{{ route('client.create') }}" class="btn btn-primary">Crear Cliente</a>

        @if (Session::has('mensaje'))
            <div class="alert alert-info my-5">
                {{ Session::get('mensaje') }}
            </div>
        @endif

        <table class="table">
            <thead>
                <th>Nombre</th>
                <th>Saldo</th>
                <th>Acciones</th>
            </thead>
            <tbody>
                @forelse ($clients as $client)
                    <tr>
                        <td>{{ $client->name }}</td>
                        <td>{{ $client->due }}</td>
                        <td>
                            <a href="{{ route('client.edit', $client) }}" class="btn btn-warning">Editar</a>
                            
                            {{-- d-inline para que se muestre en línea --}}
                            <form action="{{ route('client.destroy', $client) }}" method="post" class="d-inline">
                                @method('DELETE')
                                @csrf
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Estás seguro de Eliminar este Cliente?')">Eliminar</button>                                
                            </form>
                        </td>
                    </tr>                    
                @empty
                <tr>
                    <td colspan="3">No hay registros</td>
                </tr> 
                @endforelse
            </tbody>
        </table>

        {{-- Valida si hay registros en $clients --}}
        @if ($clients->count())
            {{ $clients->links() }}            
        @endif
                   
    </div>

@endsection