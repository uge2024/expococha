
<table class="table table-hover table-responsive-xl table-sm" id="tablaContenido">
    <thead>
    <tr>
        <th>
            N°
        </th>
        <th>
            Nombre producto
        </th>
        <th>
            Descripcion corta
        </th>
        <th>
            Stock
        </th>
        <th>
            Precio
        </th>
        <th width="17%">
            Acciones
        </th>
    </tr>
    </thead>
    <tbody>
    @php
        $indice = 1;
    @endphp
    @foreach ($lista as $item)
        <tr>
            <td>
                {{$indice++}}
            </td>
            <td>
                {{$item->nombre_producto}}
            </td>
            <td>
                {{$item->descripcion1}}
            </td>
            <td>
                {{$item->existencia}}
            </td>
            <td>
                {{$item->precio}}
            </td>

            <th>
                @if ($item->estado == 'AC')
                    <a href="{{ url('feriaproducto/edit/'.$item->fpr_id) }}" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i> Editar</a>
                @endif
                @if ($item->estado != 'AC')
                @endif
                @if ($item->estado == 'AC')
                    <button type="button" class="btn btn-danger btn-sm" onclick="modificarEstado('{{$item->fpr_id}}','{{$item->monto}}','inhabilitar');"><i class="fa fa-trash"></i> Inhabilitar</button>
                @endif
                @if ($item->estado != 'AC')
                    <button type="button" class="btn btn-success btn-sm" onclick="modificarEstado('{{$item->fpr_id}}','{{$item->monto}}','habilitar');"><i class="fa fa-trash"></i> Habilitar</button>
                @endif
            </th>
        </tr>
    @endforeach
    </tbody>
</table>
