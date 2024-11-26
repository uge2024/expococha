@extends('layouts.layout_main')

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
                            <li>Mis Compras</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb Area End-->

    <div class="col-md-12">

        <!-- cart area start -->
        <div class="cart-main-area mtb-50px">

            @if($ventas->count() == 0)
                <div class="row">
                    <div class="col-md-12">
                        <div class="cart-heading"><h2>Mis Compras</h2></div>
                        <div class="empty-text-contant text-center">
                            <i class="lnr lnr-cart"></i>
                            <h1>No tiene compras.</h1>
                            <a class="empty-cart-btn" href="{{url('/')}}">
                                <i class="ion-ios-arrow-left"> </i> Continue comprando
                            </a>
                        </div>
                    </div>
                </div>
            @else
                <div class="col-md-12">
                    <h3 class="cart-page-title">Mis Compras</h3>
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="table-content table-responsive cart-table-content">
                                <table>
                                    <thead>
                                    <tr>
                                        <th>Producto</th>
                                        <th>Precio</th>
                                        <th>Cantidad</th>
                                        <th>Costo Envio</th>
                                        <th>Subtotal</th>
                                        <th>Tipo Pago</th>
                                        <th>Estado</th>
                                        <th>Acciones</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($ventas as $key=>$venta)
                                        @if(isset($venta->prd_id))
                                            <tr>
                                                <td class="product-thumbnail">
                                                    <p><b>{{$venta->producto->nombre_producto}}</b></p>
                                                    @foreach($venta->producto->imagenesProducto as $key=>$imagen)
                                                        @if($imagen->estado == 'AC' && $imagen->tipo == 12)
                                                            <a  href="{{url('producto/ver/'.$venta->producto->prd_id)}}"><img class="img-responsive" src="{{asset('storage/uploads/'.$imagen->imagen)}}" alt="Sin Imagen" /></a>
                                                            @break
                                                        @endif
                                                    @endforeach
                                                </td>
                                                <td class="product-price-cart"><span class="amount">Bs. {{$venta->precio_venta}}</span></td>
                                                <td class="product-quantity"><span class="amount">{{$venta->cantidad}}</span></td>
                                                <td class="product-quantity"><span class="amount">Bs. {{$venta->precio_base_delivery}}</span></td>
                                                <td class="product-subtotal">Bs. {{$venta->subtotal}}</td>
                                                <td class="product-subtotal">{{$tipo_pagos[$venta->tipo_pago]}}</td>
                                                <td class="product-subtotal">{{$estado_ventas[$venta->estado_venta]}}</td>
                                                <td class="product-remove">
                                                    <a href="{{url('mensajes/chat/'.$venta->producto->productor->usr_id)}}" class="btn btn-warning btn-sm" title="Mensajear con el productor">Mensajear<i class="fa fa-mail-bulk"></i></a>
                                                    @if($venta->estado_venta == 1)
                                                        <button onclick="marcarEntregado('{{$venta->ven_id}}');" type="button" class="btn btn-success btn-sm" title="Marcar compra como entregada">Entregado <i class="fa fa-check-circle"></i></button>
                                                        <button onclick="verEstadoDelivery('{{$venta->ven_id}}');" type="button" class="btn btn-primary btn-sm" title="Ver el estado del delivery">Estado Envio <i class="fa fa-truck"></i></button>
                                                    @endif
                                                </td>
                                            </tr>
                                        @elseif(isset($venta->fpr_id))
                                            <tr>
                                                <td class="product-thumbnail">
                                                    <p><b>{{$venta->feriaProducto->nombre_producto}}</b></p>
                                                    @foreach($venta->feriaProducto->imagenesFeriaProductos as $key=>$imagen)
                                                        @if($imagen->estado == 'AC' && $imagen->tipo == 12)
                                                            <a  href="{{url('feriavirtual/verproducto/'.$venta->feriaProducto->fpr_id)}}"><img class="img-responsive" src="{{asset('storage/uploads/'.$imagen->imagen)}}" alt="Sin Imagen" /></a>
                                                            @break
                                                        @endif
                                                    @endforeach
                                                </td>
                                                <td class="product-price-cart"><span class="amount">Bs. {{$venta->precio_venta}}</span></td>
                                                <td class="product-quantity"><span class="amount">{{$venta->cantidad}}</span></td>
                                                <td class="product-quantity"><span class="amount">Bs. {{$venta->precio_base_delivery}}</span></td>
                                                <td class="product-subtotal">Bs. {{$venta->subtotal}}</td>
                                                <td class="product-subtotal">{{$tipo_pagos[$venta->tipo_pago]}}</td>
                                                <td class="product-subtotal">{{$estado_ventas[$venta->estado_venta]}}</td>
                                                <td class="product-remove">
                                                    <a href="{{url('mensajes/chat/'.$venta->feriaProducto->productor->usr_id)}}" class="btn btn-warning btn-sm" title="Mensajear con el productor">Mensajear<i class="fa fa-mail-bulk"></i></a>
                                                    @if($venta->estado_venta == 1)
                                                        <button onclick="marcarEntregado('{{$venta->ven_id}}');" type="button" class="btn btn-success btn-sm" title="Marcar compra como entregada">Entregado <i class="fa fa-check-circle"></i></button>
                                                        <button onclick="verEstadoDelivery('{{$venta->ven_id}}');" type="button" class="btn btn-primary btn-sm" title="Ver el estado del delivery">Estado Envio <i class="fa fa-truck"></i></button>
                                                    @endif
                                                </td>
                                            </tr>
                                        @else

                                        @endif
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="d-flex justify-content-center">
                                {{ $ventas->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            @endif


        </div>
        <!-- cart area end -->

        <!-- The Modal estado delivery -->
        <div class="modal fade" id="modalEstadoDelivery">
            <div class="modal-dialog modal-sm" style="max-width: 600px;">
                <div class="modal-content">

                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">Estado Delivery</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <!-- Modal body -->
                    <div class="modal-body">
                        <div class="col-md-12" id="contenidoVista">

                        </div>
                    </div>

                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                    </div>

                </div>
            </div>
        </div>

    </div>

@endsection
@section('footer_scripts')
    <script>
        $(document).ready(function(){

        });
        function quitarProducto(car_id)
        {
            loaderR.showPleaseWait();
            $.ajax({
                url : '{{url("carrito/quitarCarrito")}}',
                data : {
                    car_id:car_id
                },
                type : 'POST',
                success : function(resp) {
                    //console.log(resp);
                    if(resp.res == true){
                        $("#fila-"+car_id).hide();
                        toastr.success(resp.mensaje,'');
                    }else{
                        toastr.error(resp.mensaje,'');
                    }
                },
                error : function(xhr, status) {
                    toastr.error('No se pudo quitar el producto de su carrito.','');
                },
                complete : function(xhr, status) {
                    loaderR.hidePleaseWait();

                }
            });
        }

        function marcarEntregado(ven_id){
            $.confirm({
                theme: 'modern',
                title: false,
                content: '¿Desea marcar esta compra como entregado?',
                buttons: {
                    SI: {
                        text: 'SI',
                        btnClass: 'btn-blue',
                        keys: ['enter'],
                        action: function(){
                            loaderR.showPleaseWait();
                            $.ajax({
                                url : '{{url("venta/_marcarEntregado")}}',
                                data : {
                                    ven_id:ven_id
                                },
                                type : 'POST',
                                success : function(resp) {
                                    console.log(resp);
                                    if(resp.res == true){
                                        location.reload(true);
                                    }else{
                                        toastr.error(resp.mensaje,'');
                                    }
                                },
                                error : function(xhr, status) {
                                    toastr.error('No se pudo marcar el producto como entregado.','');
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

        function verEstadoDelivery(ven_id){
            console.log('ver estado delivery');
            $.ajax({
                url : '{{url("venta/_verEstadoDelivery")}}',
                data : {
                    ven_id:ven_id
                },
                type : 'POST',
                success : function(resp) {
                    //console.log(resp);
                    $("#contenidoVista").html(resp);
                    $("#modalEstadoDelivery").modal('show');
                },
                error : function(xhr, status) {
                    toastr.error('No se pudo cargar el estado del pedido','');
                },
                complete : function(xhr, status) {
                    //loaderR.hidePleaseWait();

                }
            });

        }

    </script>
@stop
