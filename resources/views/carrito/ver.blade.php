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
                            <li>Carrito</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb Area End-->

    <div class="container">

        <!-- cart area start -->
        <div class="cart-main-area mtb-50px">

            @if($carritos->count() == 0)
                <div class="row">
                    <div class="col-md-12">
                        <div class="cart-heading"><h2>Productos en mi carrito</h2></div>
                        <div class="empty-text-contant text-center">
                            <i class="lnr lnr-cart"></i>
                            <h1>No hay productos en su carrito.</h1>
                            <a class="empty-cart-btn" href="{{url('/')}}">
                                <i class="ion-ios-arrow-left"> </i> Continue comprando
                            </a>
                        </div>
                    </div>
                </div>
            @else
                <div class="container">
                    <h3 class="cart-page-title">Productos en mi carrito</h3>
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                            {{--<form action="#">--}}
                            <div class="table-content table-responsive cart-table-content">
                                <table>
                                    <thead>
                                    <tr>
                                        <th>Imagen</th>
                                        <th>Nombre de Producto</th>
                                        <th>Precio Estimado</th>
                                        <th>Cantidad</th>
                                        <th>Subtotal</th>
                                        <th>Acciones</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($carritos as $key=>$carrito)
                                        <tr id="fila-{{$carrito->car_id}}">
                                            <td class="product-thumbnail">
                                                @foreach($carrito->producto->imagenesProducto as $key=>$imagen)
                                                    @if($imagen->estado == 'AC' && $imagen->tipo == 12)
                                                        <a  href="{{url('producto/ver/'.$carrito->producto->prd_id)}}"><img class="img-responsive" src="{{asset('storage/uploads/'.$imagen->imagen)}}" alt="Sin Imagen" /></a>
                                                        @break
                                                    @endif
                                                @endforeach
                                            </td>
                                            <td class="product-name"><a href="{{url('producto/ver/'.$carrito->producto->prd_id)}}">{{$carrito->producto->nombre_producto}}</a></td>
                                            <td class="product-price-cart"><span class="amount">Bs. {{$carrito->producto->precio}}</span></td>
                                            <td class="product-quantity"><span class="amount">{{$carrito->cantidad}}</span></td>
                                            <td class="product-subtotal">
                                                @php
                                                    $subtotal = $carrito->producto->precio * $carrito->cantidad;
                                                    $subtotal = round($subtotal,2);
                                                @endphp
                                                Bs. {{$subtotal}}
                                            </td>
                                            <td class="product-remove">
                                                {{--<a href="#"><i class="fa fa-pencil-alt"></i></a>--}}
                                                <a style="margin: 4px;" href="{{url('producto/ver/'.$carrito->producto->prd_id.'#divcomprariconos')}}"><i class="fa fa-cash-register"></i> Comprar</a>
                                                <button style="margin: 4px;" onclick="quitarProducto('{{$carrito->car_id}}');" type="button" class="btn btn-sm" title="Quitar de mi carrito"><i class="fa fa-times"></i> Quitar</button>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="cart-shiping-update-wrapper">
                                        <div class="cart-shiping-update">
                                            {{--<a href="{{url('/')}}">Continuar Comprando</a>--}}
                                        </div>
                                        <div class="cart-clear">
                                            {{--<button>Update Shopping Cart</button>--}}
                                            <a href="{{url('/')}}">Continuar Comprando</a>
                                            <button onclick="quitarTodosProductos();" type="button" class="btn btn-sm btn-primary">Limpiar mi carrito</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{--</form>--}}

                        </div>
                    </div>
                </div>
            @endif


        </div>
        <!-- cart area end -->

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
                    console.log(resp);
                    if(resp.res == true){
                        $("#fila-"+car_id).hide();
                        //actualizamos la cantidad
                        var cantidadc = ''+resp.cantidad+'';
                        document.documentElement.style.setProperty('--cantidadcarrito', "\'"+cantidadc+"\'");
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

        function quitarTodosProductos(car_id)
        {
            loaderR.showPleaseWait();
            $.ajax({
                url : '{{url("carrito/quitarTodoCarrito")}}',
                data : {
                },
                type : 'POST',
                success : function(resp) {
                    //console.log(resp);
                    if(resp.res == true){
                        toastr.success(resp.mensaje,'');
                        location.reload(true);
                    }else{
                        toastr.error(resp.mensaje,'');
                    }
                },
                error : function(xhr, status) {
                    toastr.error('No se pudo quitar los productos de su carrito.','');
                },
                complete : function(xhr, status) {
                    loaderR.hidePleaseWait();

                }
            });
        }

    </script>
@stop
