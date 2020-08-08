<a href=# class="btn-ver btn btn-info btn-sm" id="btn-ver">Ver</a>
<a href="{{ route('users.edit', $id) }}" class=" btn-editar btn btn-warning btn-sm">Editar</a>

<a href=# data-id="6" id="btn-eliminar" class=" btn-eliminar btn btn-sm btn-danger">eliminar</a>


{{--
{!! Form::open(['route' => ['users.destroy', $id],
'method' => 'DELETE']) !!}

    <button class=" btn-eliminar btn btn-sm btn-danger">
        Eliminar
    </button>
 {!! Form::close() !!}
 "{{ route('users.destroy', $id) }}"
--}}
