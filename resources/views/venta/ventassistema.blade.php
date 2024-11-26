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
                            <li>Seguimiento > Ventas</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb Area End-->
    <h3 align="center">Ventas</h3>
    <div class="col-md-12">
        <form class="col-md-12" action="{{url('venta/ventassistema')}}" method="get">
            <div class="row">
                <div class="col-md-1"></div>
                <div class="col-md-1">
                    <label for="search">Buscar por:</label>
                </div>
                <div class="col-md-2">
                    {{
                        Form::select('searchtype',[1=>'Nombre Cliente',2=>'Nombre Producto'],$searchtype,  ['class' => 'form-control form-control-sm','id' => 'searchtype'])
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
                        Form::select('sort',[1=>'Fecha Venta'],$sort,  ['class' => 'form-control form-control-sm','id' => 'sort'])
                    }}
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-search"></i> Buscar</button>
                </div>

            </div>
        </form>
        <div class="col-md-12">
            <div class="content" id="contenidoLista">
                <table class="table table-hover table-responsive-xl table-sm" id="tablaContenido">
                    <thead>
                    <tr>
                        <th>N°</th>
                        <th>Fecha</th>
                        <th>Productor</th>
                        <th>Producto</th>
                        <th>Cliente</th>
                        <th>Celular <br> Dirección</th>
                        <th>Tipo Venta</th>
                        <th>Comprobante</th>
                        <th>Cantidad</th>
                        <th>Precio</th>
                        <th>Costo Delivery</th>
                        <th>Total</th>
                        <th>Estado Venta</th>
                        <th width="10%">Estado Delivery</th>
                        <th width="10%">Acciones</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($ventas as $key => $venta)
                        @php
                            $tienda = '';
                            $nombreProducto = '';
                            $imagenRuta = 'aaa.jpg';
                            if (isset($venta->producto)){
                                $nombreProducto = $venta->producto->nombre_producto;
                                $tienda = $venta->producto->productor->nombre_tienda;
                                foreach ($venta->producto->imagenesProducto as $imagen){
                                    if ($imagen->estado == 'AC' && $imagen->tipo == 12){
                                        $imagenRuta = $imagen->imagen;
                                        break;
                                    }
                                }
                            }
                            if (isset($venta->feriaProducto)){
                                $nombreProducto = $venta->feriaProducto->nombre_producto;
                                $tienda = $venta->feriaProducto->productor->nombre_tienda;
                                foreach ($venta->feriaProducto->imagenesFeriaProductos as $imagen){
                                    if ($imagen->estado == 'AC' && $imagen->tipo == 12){
                                        $imagenRuta = $imagen->imagen;
                                        break;
                                    }
                                }
                            }
                        @endphp
                        <tr>
                            <td>{{$ventas->firstItem() + $key}}</td>
                            <td>{{date('d/m/Y H:i:s',strtotime($venta->fecha))}}</td>
                            <td>{{$tienda}}</td>
                            <td>
                                {{$nombreProducto}}
                                <br>
                                {{
                                    Html::image(asset('storage/uploads/'.$imagenRuta), 'Sin Imagen', array('id'=>'imagen', 'class' =>'img-thumbnail','width'=>'90'))
                                }}
                            </td>
                            <td>{{$venta->usuario->name}}</td>
                            <td>
                                {{$venta->usuario->celular}}<br>
                                {{$venta->usuario->direccion}}
                            </td>
                            <td>
                                {{$tipo_pagos[$venta->tipo_pago]}}
                            </td>
                            <td align="center">
                                @if(!empty($venta->comprobante))
                                    <a title="Haga clic sobre la imagen para verla completa" href="{{asset('storage/uploads/'.$venta->comprobante)}}" target="_blank">
                                        {{
                                            Html::image(asset('storage/uploads/'.$venta->comprobante), 'Sin Imagen', array('id'=>'imagen', 'class' =>'img-thumbnail','width'=>'140','height'=>'100'))
                                        }}
                                    </a>
                                @else
                                    <p>El tipo de venta no requiere comprobante.</p>
                                @endif
                            </td>
                            <td align="center">{{$venta->cantidad}}</td>
                            <td>{{$venta->precio_venta}}</td>
                            <td>{{$venta->precio_base_delivery}}</td>
                            <td>{{$venta->subtotal}}</td>
                            <td>{{$estado_ventas[$venta->estado_venta]}}</td>
                            <td>
                                @if($venta->estado_venta == 1)
                                    {{
                                        Form::select('estado_delivery',$estado_deliverys,$venta->estado_delivery,  ['class' => 'form-control form-control-sm','onchange'=>"cambiarEstadoDelivery('$venta->ven_id',this);"])
                                    }}
                                @else
                                    {{$estado_deliverys[$venta->estado_delivery]}}
                                @endif
                            </td>
                            <td>
                                <a href="{{url('mensajes/chat/'.$venta->usr_id)}}" class="btn btn-info btn-sm" title="Mensajear con el cliente">Mensajear<i class="fa fa-mail-bulk"></i></a>
                                @if($venta->estado_venta == 1)
                                    <button type="button" class="btn btn-danger btn-sm" onclick="cancelarVenta('{{$venta->ven_id}}');" title="Marcar la venta como cancelada">Cancelar Venta <i class="fa fa-trash"></i></button>
                                    {{--<a href="{{url('venta/editDelivery/'.$venta->ven_id)}}" class="btn btn-warning btn-sm" title="Modificar el delivery de la venta">Cambiar Delivery <i class="fa fa-truck"></i></a>--}}
                                    <button type="button" class="btn btn-success btn-sm" onclick="ventaCompletada('{{$venta->ven_id}}');" title="Marcar venta como completada">Venta Completada <i class="fa fa-check-circle"></i></button>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <div class="d-flex justify-content-center">
                    {{ $ventas->appends(['searchtype'=>$searchtype,'search'=>$search,'sort'=>$sort])->links() }}
                </div>
            </div>
        </div>
    </div>

@endsection

@section('footer_scripts')
    <script type="text/javascript">

        $(document).ready(function(){

        });

        function cambiarEstadoDelivery(ven_id,valor){
            console.log(ven_id);
            console.log($(valor).val());
            var estado_delivery = $(valor).val();
            loaderR.showPleaseWait();
            $.ajax({
                url : '{{url("venta/_modificarEstadoDelivery")}}',
                data : {
                    ven_id:ven_id,
                    estado_delivery:estado_delivery
                },
                type : 'POST',
                success : function(resp) {
                    console.log(resp);
                    if(resp.res == true){
                        toastr.success(resp.mensaje,'');
                    }else{
                        toastr.error(resp.mensaje,'');
                    }
                },
                error : function(xhr, status) {
                    toastr.error('Ocurrio un error al modificar el estado del delivery','');
                },
                complete : function(xhr, status) {
                    loaderR.hidePleaseWait();
                }
            });
        }

        function cancelarVenta(ven_id){
            console.log(ven_id);
            $.confirm({
                theme: 'modern',
                title: false,
                content: '¿Desea cancelar esta venta?',
                buttons: {
                    SI: {
                        text: 'SI',
                        btnClass: 'btn-blue',
                        keys: ['enter'],
                        action: function(){
                            loaderR.showPleaseWait();
                            $.ajax({
                                url : '{{url("venta/_cancelarVenta")}}',
                                data : {
                                    ven_id:ven_id
                                },
                                type : 'POST',
                                success : function(resp) {
                                    console.log(resp);
                                    if(resp.res == true){
                                        toastr.success(resp.mensaje,'');
                                        location.reload(true);
                                    }else{
                                        toastr.error(resp.mensaje,'');
                                    }
                                },
                                error : function(xhr, status) {
                                    toastr.error('Ocurrio un error al cancelar la venta','');
                                },
                                complete : function(xhr, status) {
                                    loaderR.hidePleaseWait();
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

        function ventaCompletada(ven_id){
            console.log(ven_id);
            $.confirm({
                theme: 'modern',
                title: false,
                content: '¿Desea marcar esta venta como completada?',
                buttons: {
                    SI: {
                        text: 'SI',
                        btnClass: 'btn-blue',
                        keys: ['enter'],
                        action: function(){
                            loaderR.showPleaseWait();
                            $.ajax({
                                url : '{{url("venta/_ventaCompletada")}}',
                                data : {
                                    ven_id:ven_id
                                },
                                type : 'POST',
                                success : function(resp) {
                                    console.log(resp);
                                    if(resp.res == true){
                                        toastr.success(resp.mensaje,'');
                                        location.reload(true);
                                    }else{
                                        toastr.error(resp.mensaje,'');
                                    }
                                },
                                error : function(xhr, status) {
                                    toastr.error('Ocurrio un error al completar la venta','');
                                },
                                complete : function(xhr, status) {
                                    loaderR.hidePleaseWait();
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
