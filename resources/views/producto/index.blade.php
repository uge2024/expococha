@extends('layouts.layout_main',['noMostrarHeaderBuscar'=>'1'])

@section('header_styles')
    <style type="text/css">

    </style>
@endsection
@section('content')
    <!-- Breadcrumb Area Start -->
    <div class="breadcrumb-area">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="breadcrumb-content">
                        <ul class="nav">
                            <li><a href="{{url('/')}}">Inicio</a></li>
                            @guest
                            @else
                                @if(Auth::user()->rol == 3)
                                    <li><a href="{{url('/administracion/productores')}}">Administración / Productores</a></li>
                                    <li>Revisar Productos</li>
                                @elseif(Auth::user()->rol == 2)
                                    <li>Mi Tienda / Mis Productos</li>
                                @else
                                @endif
                            @endguest

                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb Area End-->
    <h3 align="center">Lista de Productos de {{$titulo}}</h3>
    <div class="col-md-12">
        <div class="col-md-12">
            <a href="{{ url('producto/create/'.$pro_id.'/'.$usr_id) }}" class="btn btn-primary btn-sm" id="btnNuevo"><i class="fa fa-plus"></i> Agregar</a>
             <form class="col-md-12" action="{{url('producto/'.$usr_id.'/lista')}}" method="get">
                <div class="row">
                    <div class="col-md-1"></div>
                    <div class="col-md-1">
                        <label for="search">Buscar por:</label>
                    </div>
                    <div class="col-md-2">
                        {{
                            Form::select('searchtype',[1=>'Nombre Producto',2=>'Descripcion corta'],$searchtype,  ['class' => 'form-control form-control-sm','id' => 'searchtype'])
                        }}
                    </div>
                    <div class="col-md-3">
                        <input type="text" class="form-control form-control-sm" placeholder="Ingrese su busqueda" id="search" name="search" value="{{$search}}">
                    </div>
                    <div class="col-md-1">
                        <label>Ordenar por:</label>
                    </div>
                    <div class="col-md-2">
                        {{
                            Form::select('sort',[1=>'Nombre Producto',2=>'Descripcion corta',3=>'Stock',4=>'Precio'],$sort,  ['class' => 'form-control form-control-sm','id' => 'sort'])
                        }}
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-search"></i> Buscar</button>
                    </div>
                </div>
            </form>
            {{-- <a href="{{ url('delivery/5') }}" class="btn btn-primary btn-sm" id="btnNuevo"><i class="fa fa-plus"></i> Agregarsdsd</a>--}}
        <div class="content" id="contenidoLista">
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
                    <th>
                        Imagen
                    </th>
                    <th>
                        Estado
                    </th>
                     <th width="17%">
                        Acciones
                    </th>
                </tr>
                </thead>
                <tbody>
                @php
                    $indice = 1;
                    $contador = 0;
                @endphp
                @foreach ($lista as $key =>  $item)
                    <tr>
                        <td>
                            {{$lista->firstItem() + $key}}
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
                        <td>
                            @if ($item->estado == 'AC')
                                <p style="color:#00A600 "> <b>Habilitado</b></p>
                            @endif
                            @if ($item->estado != 'AC')
                                <p style="color:#FF0000 "> <b>Inhabilitado</b></p>
                            @endif
                        </td>
                        <td>
                            @if ($item->estado == 'AC')
                                <a href="{{ url('producto/edit/'.$item->prd_id.'/'.$item->pro_id.'/'.$usr_id) }}" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i> Editar</a>
                            @endif
                            @if ($item->estado != 'AC')
                            @endif
                            @if ($item->estado == 'AC')
                                <button type="button" class="btn btn-danger btn-sm" onclick="modificarEstado('{{$item->prd_id}}','{{$item->nombre_producto}}','inhabilitar');"><i class="fa fa-trash"></i> Inhabilitar</button>
                            @endif
                            @if ($item->estado != 'AC')
                                <button type="button" class="btn btn-success btn-sm" onclick="modificarEstado('{{$item->prd_id}}','{{$item->nombre_producto}}','habilitar');"><i class="fa fa-gavel"></i> Habilitar</button>
                            @endif
                            @if ($item->estado == 'AC')
                            <a href="{{ url('producto/registro_oferta_crear/'.$item->prd_id.'/'.$usr_id) }}" class="btn btn-warning btn-sm"><i class="fa fa-money-bill-alt"></i> Registrar oferta</a>
                            @endif
                            @if ($item->estado != 'AC')
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <div class="d-flex justify-content-center">
                {{ $lista->appends(['searchtype'=>$searchtype,'search'=>$search,'sort'=>$sort])->links() }}
            </div>
        </div>
      </div>
    </div>

@endsection

@section('footer_scripts')
    <script type="text/javascript">
        $(document).ready(function(){
        });

        function modificarEstado(prd_id,nombre,texto)
        {
            var mensajeConsulta = '¿Desea '+texto+' el Producto: '+nombre+'?';
            $.confirm({
                theme: 'modern',
                title: false,
                content: mensajeConsulta,
                buttons: {
                    SI: {
                        text: 'SI',
                        btnClass: 'btn-blue',
                        keys: ['enter'],
                        action: function(){
                            $.ajax({
                                url : '{{url("producto/_modificarEstado")}}',
                                data : {
                                    prd_id:prd_id,
                                    texto:texto
                                },
                                type : 'POST',
                                success : function(resp) {
                                    console.log(resp);
                                    if(resp.res == true){
                                        toastr.success('Operación completada','');
                                        location.reload(true);
                                    }else{
                                        toastr.error('Ocurrio un error al Habilitar el producto','');
                                    }
                                },
                                error : function(xhr, status) {
                                    toastr.error('Ocurrio un error al eliminar el prodcto','');
                                },
                                complete : function(xhr, status) {
                                }
                            });
                        }
                    },
                    NO: {
                        text: 'NO',
                        btnClass: 'btn-red',
                        action: function(){
                            //location.reload(true);
                        }
                    }
                }
            });
        }

    </script>
@endsection
