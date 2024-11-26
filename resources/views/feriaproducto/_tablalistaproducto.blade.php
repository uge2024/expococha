<table class="table table-hover table-responsive-xl table-sm" >
    <thead>
    <tr>
        <th>N°</th>
        <th width="30%">Nombre de producto</th>
        <th width="50%">Nombre del descripcion</th>
        <th width="8%">Precio</th>
        <th width="9%">Stock</th>
        <th width="9%">Imagen</th>
        <th width="3%">
            <a onclick="getTodosSeleccionados();" class=" btn-sm" style="color: #003eff">Todos</a>
        </th>
    </tr>
    </thead>
    <tbody>
    @php
        $indice = 1;
    @endphp
    @foreach ($listaProductos as $item)
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
                {{$item->precio}}

            </td>
            <td>
                {{$item->existencia}}
            </td>
            <td>
                @php
                    $bandera = true;
                @endphp
                @foreach ($item->imagenesProducto as $imagen)
                    @if($imagen->estado == 'AC' && $imagen->tipo == 12)
                        @if($bandera)
                            {{
                                Html::image(asset('storage/uploads/'.$imagen->imagen), 'Sin Imagen', array('id'=>'imagen', 'class' =>'img-thumbnail','width'=>'90'))
                            }}
                            @php
                                $bandera = false;
                            @endphp
                        @endif
                    @endif
                @endforeach
            </td>
            <td align="center">
                <input type="checkbox" class="btn btn-danger btn-sm" value="{{$item->prd_id}}" name="page" class="up">
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
