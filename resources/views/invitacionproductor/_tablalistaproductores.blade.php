<center><h5> Lista de productores</h5></center>
<table class="table table-hover table-responsive-xl table-sm">
    <thead>
    <tr>
        <th>N°</th>
        <th>Nombre de tienda</th>
        <th>Nombre del propietario</th>
        <th>
            <a onclick="getTodosSeleccionados();" class=" btn-sm" style="color: #003eff">Todos</a>
        </th>
    </tr>
    </thead>
    <tbody>
    @php
        $indice = 1;
    @endphp
    @foreach ($listaProductores as $item)
        <tr>
            <td>
                {{$indice++}}
            </td>
            <td>
                {{$item->nombre_tienda}}
            </td>
            <td>
                {{$item->nombre_propietario}}
            </td>
            <td>
                <center><input type="checkbox" class="btn btn-danger btn-sm" value="{{$item}}" name="page" class="up"></center>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
