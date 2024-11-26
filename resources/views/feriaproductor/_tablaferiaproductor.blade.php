<table class="table table-hover table-responsive-xl table-sm" id="tablaContenido">
    <thead>
    <tr>
        <th>
            N°
        </th>
        <th>
            Usuario
        </th>
        <th width="20%">
            Tienda
        </th>
        <th>
            Fecha Inscripcion
        </th>
        <th>
            N. Comprobante
        </th>
        <th width="25%">
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
                {{$item->productor->nombre_propietario}}
            </td>
            <td>
                {{$item->productor->nombre_tienda}}
            </td>
            <td>
                {{date('d/m/Y',strtotime($item->fecha_inscripcion))}}
            </td>
            <td>
                {{$item->comprobante}}
            </td>
            <td>
                @if ($item->estado == 'AC')
                    <a href="{{ url('feriaproducto/'.$item->productor->pro_id) }}" class="btn btn-warning btn-sm"><i class="fa fa-eye"></i> Ver Productor</a>
                @endif
                @if ($item->estado != 'AC')
                @endif
                @if ($item->estado == 'AC')
                    <a href="{{ url('feriaproductor/edit/'.$item->fpd_id) }}" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i> Editar</a>
                @endif
                @if ($item->estado != 'AC')
                @endif
                @if ($item->estado == 'AC')
                    <button type="button" class="btn btn-danger btn-sm" onclick="modificarEstado('{{$item->fpd_id}}','{{$item->monto}}','inhabilitar');"><i class="fa fa-trash"></i> Inhabilitar</button>
                @endif
                @if ($item->estado != 'AC')
                    <button type="button" class="btn btn-success btn-sm" onclick="modificarEstado('{{$item->fpd_id}}','{{$item->monto}}','habilitar');"><i class="fa fa-trash"></i> Habilitar</button>
                @endif
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
