
@extends('layouts.layout_main')

@section('header_metas')
    @php
        $productoMeta = preg_replace('/\s+/', ', ', $producto->nombre_producto);
    @endphp
    <meta name="keywords" content="{{$productoMeta}}">
@endsection

@section('header_styles')
    <style rel="stylesheet">
        .verproductor > p{
            padding: 5px;
            border-radius: 15px;
            background-color: #26e8fb;
        }
        .estrellas-producto{
            height: 50px;
            font-size: 40px;
        }
        .colorear-estrella{
            color: #fdd835 !important;
        }
        .sincolor-estrella{
            color: #9d9c9c !important;
        }
        .clasefacebook{
            line-height: 34px;
        }
        .clasefacebook > a{
            display: inline-block;
            vertical-align: middle;
            color: #fff !important;
            font-size: 22px;
            width: 34px;
            height: 34px;
            background: #3b579d;
            border-radius: 100%;
            text-align: center;
        }
        .clasetwitter{
            line-height: 34px;
        }
        .clasetwitter > a{
            background: #1da1f2;
            display: inline-block;
            vertical-align: middle;
            color: #fff !important;
            font-size: 22px;
            width: 34px;
            height: 34px;
            border-radius: 100%;
            text-align: center;
        }
        .clasegoogle{
            line-height: 34px;
        }
        .clasegoogle > a{
            background: #cc3333;
            display: inline-block;
            vertical-align: middle;
            color: #fff !important;
            font-size: 22px;
            width: 34px;
            height: 34px;
            border-radius: 100%;
            text-align: center;
        }
        .claseyoutube{
            line-height: 34px;
        }
        .claseyoutube > a{
            background: #d32a2a;
            display: inline-block;
            vertical-align: middle;
            color: #fff !important;
            font-size: 22px;
            width: 34px;
            height: 34px;
            border-radius: 100%;
            text-align: center;
        }
        .claseinstagram{
            line-height: 34px;
        }
        .claseinstagram > a{
            background: #a0369c;
            display: inline-block;
            vertical-align: middle;
            color: #fff !important;
            font-size: 22px;
            width: 34px;
            height: 34px;
            border-radius: 100%;
            text-align: center;
        }
        .clasewhatsapp{
            line-height: 34px;
        }
        .clasewhatsapp > a{
            background: #50ca5e;
            display: inline-block;
            vertical-align: middle;
            color: #fff !important;
            font-size: 16px;
            width: 34px;
            height: 34px;
            border-radius: 100%;
            text-align: center;
        }
        .claseqr{
            line-height: 34px;
        }
        .claseqr > a{
            background: blue;
            display: inline-block;
            vertical-align: middle;
            color: #fff !important;
            font-size: 16px;
            width: 34px;
            height: 34px;
            border-radius: 100%;
            text-align: center;
        }
        .ullinkscomprar > li{
            display: inherit;border: 1px solid #ebebeb;
            padding: 5px;
            border-radius: 15px;
        }
        .cursormano{
            cursor: pointer;
        }
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
                            <li><a href="{{url('/feriavirtual/lista')}}">Ferias Virtuales</a></li>
                            <li><a href="{{url('feriavirtual/ver/'.$feria->fev_id)}}">Feria Virtual: {{$feria->nombre}}</a></li>
                            <li>{{$producto->nombre_producto}}</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb Area End-->

    <!-- Shop details Area start -->
    <section class="product-details-area mtb-60px ">
        <div class="container">
            <div class="row">
                <div class="col-xl-6 col-lg-6 col-md-12">
                    <div class="product-details-img product-details-tab">
                        <div class="zoompro-wrap zoompro-2">
                            @foreach($imagenes as $key=>$imagen)
                                <div class="zoompro-border zoompro-span">
                                    <img class="zoompro" src="{{url('storage/uploads/'.$imagen->imagen2)}}" data-zoom-image="{{url('storage/uploads/'.$imagen->imagen1)}}" alt="" />
                                </div>
                            @endforeach
                        </div>
                        <div id="gallery" class="product-dec-slider-2">
                            @foreach($imagenes as $key=>$imagen)
                                <div class="single-slide-item">
                                    <img class="img-responsive" data-image="{{url('storage/uploads/'.$imagen->imagen2)}}" data-zoom-image="{{url('storage/uploads/'.$imagen->imagen1)}}" src="{{url('storage/uploads/'.$imagen->imagen2)}}" alt="" />
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="col-xl-6 col-lg-6 col-md-12">
                    <div class="product-details-content">
                        <a class="verproductor" href="{{url('productor/tienda/'.$producto->pro_id)}}" target="_blank"><p class="reference">Ver al Productor:<span> {{$producto->productor->nombre_tienda}}</span></p></a>
                        <h2>{{$producto->nombre_producto}}</h2>
                        <div class="pro-details-rating-wrap">

                        </div>
                        <div class="pricing-meta">
                            <input type="hidden" name="precio_unidad_final" id="precio_unidad_final" value="{{$precioUnidadFinal}}">
                            <input type="hidden" id="fpr_id" value="{{$producto->fpr_id}}">
                            <ul>
                                <li class="cuttent-price">Bs. {{$producto->precio}}</li>
                            </ul>
                        </div>
                        <div class="pro-details-list">
                            <p>{{$producto->descripcion1}}</p>
                        </div>
                        <div class="pro-details-quality mt-0px">
                            <div class="cart-plus-minus">
                                <input class="cart-plus-minus-box" type="text" readonly name="qtybutton" id="cantidad_compra" value="1" />
                            </div>
                            <div class="pro-details-cart btn-hover">

                            </div>
                        </div>
                        @guest

                        @else
                            @php
                                $fechaActual = date('Y-m-d');
                            @endphp
                            @if($fechaActual <= $feria->fecha_final && $fechaActual >= $feria->fecha_inicio)
                                <div class="comprariconos">
                                    <h4>Comprar por:</h4><br>
                                    <div class="social-info">
                                        <ul class="ullinkscomprar">
                                            @isset($paginaFacebook)
                                                <li class="facebook clasefacebook">
                                                    Facebook:({{$paginaFacebook}}) <a title="Facebook" href="#" onclick="event.preventDefault();comprarPorFacebook('{{$paginaFacebook}}','{{$linkPaginaFacebook}}','{{$producto->nombre_producto}}')"><i class="ion-social-facebook"></i></a>
                                                </li>
                                            @endisset
                                            @isset($telefonoWhatsapp)
                                                <li class="clasewhatsapp" style="display: inherit;">
                                                    Whatsapp:({{$telefonoWhatsapp}}) <a title="Whatsapp" href="#" onclick="event.preventDefault();comprarPorWhatsapp('{{$producto->productor->celular_wp}}','{{$producto->nombre_producto}}');"><i class="ion-social-whatsapp"></i></a>
                                                </li>
                                            @endisset
                                            @isset($producto->codigo_qr_venta)
                                                <li class="claseqr" style="display: inherit;">
                                                    Código QR <a title="Código QR" href="#" onclick="event.preventDefault();modalVentaQr();"><i class="ion-qr-scanner"></i></a>
                                                </li>
                                            @endisset
                                            @isset($producto->productor)
                                                @isset($producto->productor->entidad_financiera)
                                                    @isset($producto->productor->cuenta)
                                                        <li class="claseqr" style="display: inherit;">
                                                            Deposito Bancario <a title="Código QR" href="#" onclick="event.preventDefault();modalVentaDeposito();"><i class="ion-card"></i></a>
                                                        </li>
                                                    @endisset
                                                @endisset
                                            @endisset
                                        </ul>
                                    </div>
                                </div>
                            @endif
                        @endguest
                        <div class="pro-details-social-info">
                        </div>
                        <div class="pro-details-social-info">
                            <span>Compartir por:</span>
                            <div class="social-info">
                                <ul>
                                    <li class="facebook clasefacebook">
                                        <a title="Facebook" href="#" onclick="event.preventDefault();compartirPorFacebook('{{url('feriavirtual/verproducto/'.$producto->fpr_id)}}');"><i class="ion-social-facebook"></i></a>
                                    </li>
                                    <li class="clasewhatsapp">
                                        <a title="Whatsapp" href="#" onclick="event.preventDefault();compartirPorWhatsapp('{{url('feriavirtual/verproducto/'.$producto->fpr_id)}}');"><i class="ion-social-whatsapp"></i></a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Shop details Area End -->

    <!-- product details description area start -->
    <div class="description-review-area mb-50px bg-light-gray-3 ptb-50px">
        <div class="container">
            <div class="description-review-wrapper">
                <div class="description-review-topbar nav">
                    <a data-toggle="tab" href="#des-details1">Descripción</a>
                    <a class="active" data-toggle="tab" href="#des-details2">Detalles del Producto</a>
                </div>
                <div class="tab-content description-review-bottom">
                    <div id="des-details1" class="tab-pane">
                        <div class="product-description-wrapper">
                            <p>{{$producto->descripcion1}}</p>
                        </div>
                    </div>
                    <div id="des-details2" class="tab-pane active">
                        <div class="product-anotherinfo-wrapper">
                            {!! $producto->descripcion2 !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- product details description area end -->



    <!-- The Modal venta por QR-->
    <div class="modal" id="modalVentaQr">
        <div class="modal-dialog">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title text-center">Comprar por QR:</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <form action="#" id="formQr" enctype="multipart/form-data">
                    <!-- Modal body -->
                    <div class="modal-body">
                        <div class="row col-md-12">
                            <div class="col-md-3"></div>
                            <div class="col-md-6">
                                <label id="textoDepositoQr" style="color: black" class="text-center">Por favor realice una transferencia de: </label>
                                @isset($producto->codigo_qr_venta)
                                    <img src="{{asset('storage/uploads/'.$producto->codigo_qr_venta)}}" alt="sin imagen">
                                @endisset
                            </div>
                            <div class="col-md-3"></div>
                        </div>
                        <div class="row col-md-12">
                            <div class="col-md-3"></div>
                            <div class="col-md-6">
                                <input type="hidden" name="fpr_id_qr" id="fpr_id_qr" value="{{$producto->fpr_id}}">
                                <input type="hidden" name="cantidad_qr" id="cantidad_qr" value="1">
                                <input type="hidden" name="precio_venta_qr" id="precio_venta_qr" value="{{$precioUnidadFinal}}">
                                <input type="hidden" name="tipo_pago_qr" id="tipo_pago_qr" value="1">
                                <label>Subir Foto del Comprobante (JPG max 2MB):</label>
                                <input type="file" required name="comprobante_qr" id="comprobante_qr" class="form-control-sm" accept="image/jpeg">
                            </div>
                            <div class="col-md-3"></div>
                        </div>
                    </div>

                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <div class="row col-md-12">
                            <div class="col-md-4"></div>
                            <div class="col-md-4">
                                <button type="submit" class="btn btn-primary">Confirmar</button>
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                            </div>
                            <div class="col-md-4"></div>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <!-- The Modal venta por Deposito-->
    <div class="modal" id="modalVentaDeposito">
        <div class="modal-dialog">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title text-center">Comprar por Deposito Bancario:</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <form action="#" id="formDeposito" enctype="multipart/form-data">
                    <!-- Modal body -->
                    <div class="modal-body">
                        <div class="row col-md-12">
                            <div class="col-md-2"></div>
                            <div class="col-md-8">
                                <label id="textoDeposito" style="color: black" class="text-center">Por favor realice un depósito de: </label>
                                @if(isset($producto->productor))
                                    @if(isset($producto->productor->entidad_financiera) && isset($producto->productor->cuenta) && isset($producto->productor->titular_cuenta))
                                        <p class="text-justify" style="font-size: 16pt;color: black;">
                                            <b>Titular de la Cuenta:</b><br>
                                            {{$producto->productor->titular_cuenta}}
                                        </p>
                                        <p class="text-justify" style="font-size: 16pt;color: black;">
                                            <b>Entidad Financiera:</b><br>
                                            {{$producto->productor->entidad_financiera}}
                                        </p>
                                        <p class="text-justify" style="font-size: 16pt;color: black;">
                                            <b>Cuenta:</b><br>
                                            {{$producto->productor->cuenta}}
                                        </p>
                                    @endif
                                @endif
                            </div>
                            <div class="col-md-2"></div>
                        </div>
                        <div class="row col-md-12">
                            <div class="col-md-3"></div>
                            <div class="col-md-6">
                                <input type="hidden" name="fpr_id_dp" id="fpr_id_dp" value="{{$producto->fpr_id}}">
                                <input type="hidden" name="cantidad_dp" id="cantidad_dp" value="1">
                                <input type="hidden" name="precio_venta_dp" id="precio_venta_dp" value="{{$precioUnidadFinal}}">
                                <input type="hidden" name="tipo_pago_dp" id="tipo_pago_dp" value="2">
                                <label>Subir Foto del Comprobante (JPG max 2MB):</label>
                                <input type="file" required name="comprobante_dp" id="comprobante_dp" class="form-control-sm" accept="image/jpeg">
                            </div>
                            <div class="col-md-3"></div>
                        </div>
                    </div>

                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <div class="row col-md-12">
                            <div class="col-md-4"></div>
                            <div class="col-md-4">
                                <button type="submit" class="btn btn-primary">Confirmar</button>
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                            </div>
                            <div class="col-md-4"></div>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>

@endsection
@section('footer_scripts')

    <script>
        $(document).ready(function(){

            //seteamos la ruta para realizar denuncia
            var rutaDenuncia = '{{url('denuncia/midenuncia')}}';
            rutaDenuncia = rutaDenuncia+'?pro_id='+'{{$producto->pro_id}}'+'&fpr_id='+'{{$producto->fpr_id}}';
            $("#linkrealizardenuncia").attr("href", rutaDenuncia);

            $("#div-comentarios").animate({ scrollTop: 0}, 1000);



            //envio de la venta por qr
            $("#formQr").submit(function (event){
                event.preventDefault();
                var cantidad = $("#cantidad_compra").val();
                $("#cantidad_qr").val(cantidad);
                console.log('venta por qr');
                var form = $('#formQr')[0];
                var datos = new FormData(form);
                loaderR.showPleaseWait();
                $.ajax({
                    url : '{{url("venta/_storeqr")}}',
                    data : datos,
                    type : 'POST',
                    processData: false,
                    contentType: false,
                    success : function(resp) {
                        console.log(resp);
                        if(resp.res == true){
                            toastr.success(resp.mensaje,'');
                        }else{
                            toastr.error(resp.mensaje,'');
                        }
                    },
                    error : function(xhr, status) {
                        toastr.error('Ocurrio un error al guardar su compra, intente otra vez por favor.','');
                    },
                    complete : function(xhr, status) {
                        $("#modalVentaQr").modal("toggle");
                        loaderR.hidePleaseWait();
                    }
                });
            });

            //envio de la venta por deposito
            $("#formDeposito").submit(function (event){
                event.preventDefault();
                var cantidad = $("#cantidad_compra").val();
                $("#cantidad_dp").val(cantidad);
                console.log('venta por deposito');
                var form = $('#formDeposito')[0];
                var datos = new FormData(form);
                loaderR.showPleaseWait();
                $.ajax({
                    url : '{{url("venta/_storedeposito")}}',
                    data : datos,
                    type : 'POST',
                    processData: false,
                    contentType: false,
                    success : function(resp) {
                        console.log(resp);
                        if(resp.res == true){
                            toastr.success(resp.mensaje,'');
                        }else{
                            toastr.error(resp.mensaje,'');
                        }
                    },
                    error : function(xhr, status) {
                        toastr.error('Ocurrio un error al guardar su compra, intente otra vez por favor.','');
                    },
                    complete : function(xhr, status) {
                        $("#modalVentaDeposito").modal("toggle");
                        loaderR.hidePleaseWait();
                    }
                });
            });

        });

        function enviarMensajeWhatsapp(telefono,mensaje) {
            var isMobile = /iPhone|iPad|iPod|Android/i.test(navigator.userAgent);
            var mensaje = encodeURI(mensaje);
            if (isMobile) {
                console.log('es mobil');
                window.open(
                    'https://api.whatsapp.com/send?phone=591'+telefono+'&text='+mensaje,
                    '_blank'
                );
            } else {
                console.log('es escritorio');
                window.open(
                    'https://web.whatsapp.com/send?phone=591'+telefono+'&text='+mensaje,
                    '_blank'
                );
            }
        }

        //funcion comprar por facebook
        function comprarPorFacebook(paginaFacebook,link,nombre_producto){
            var isMobile = /iPhone|iPad|iPod|Android/i.test(navigator.userAgent);
            var cantidad = $("#cantidad_compra").val();
            var mensaje = '!Hola¡. Quisiera comprar su producto '+nombre_producto+', la cantidad de: '+cantidad;
            mensaje = encodeURI(mensaje);
            if (isMobile) {
                console.log('es mobil');
                guardarCompraPorRedes();
                window.open(
                    'http://m.me/'+paginaFacebook+'?ref='+mensaje,
                    '_blank'
                );
            } else {
                console.log('es escritorio');
                guardarCompraPorRedes();
                window.open(
                    ''+link+'',
                    '_blank'
                );
            }
        }

        //funcion comprar por whatsapp
        function comprarPorWhatsapp(telefono,nombre_producto){
            var isMobile = /iPhone|iPad|iPod|Android/i.test(navigator.userAgent);
            var cantidad = $("#cantidad_compra").val();
            var mensaje = '!Hola¡. Quisiera comprar su producto '+nombre_producto+', la cantidad de: '+cantidad;
            mensaje = encodeURI(mensaje);
            if (isMobile) {
                console.log('es mobil');
                guardarCompraPorRedes();
                window.open(
                    'https://api.whatsapp.com/send?phone=591'+telefono+'&text='+mensaje,
                    '_blank'
                );
            } else {
                console.log('es escritorio');
                guardarCompraPorRedes();
                window.open(
                    'https://web.whatsapp.com/send?phone=591'+telefono+'&text='+mensaje,
                    '_blank'
                );
            }
        }

        //funcion para compartir por facebook
        function compartirPorFacebook(link) {
            var isMobile = /iPhone|iPad|iPod|Android/i.test(navigator.userAgent);
            var link = encodeURI(link);
            if (isMobile) {
                console.log('es mobil');
                window.open(
                    'https://m.facebook.com/sharer/sharer.php?u='+link,
                    '_blank'
                );
            } else {
                console.log('es escritorio');
                window.open(
                    'https://www.facebook.com/sharer/sharer.php?u='+link,
                    '_blank'
                );
            }
        }
        //funcion para compartir por whatsapp
        function compartirPorWhatsapp(link){
            var isMobile = /iPhone|iPad|iPod|Android/i.test(navigator.userAgent);
            var link = encodeURI(link);
            if (isMobile) {
                console.log('es mobil');
                window.open(
                    'https://api.whatsapp.com/send?text='+link,
                    '_blank'
                );
            } else {
                console.log('es escritorio');
                window.open(
                    'https://web.whatsapp.com/send?text='+link,
                    '_blank'
                );
            }
        }

        //funcion para la compra del producto
        function guardarCompraPorRedes(){
            var fpr_id = $("#fpr_id").val();
            var cantidad = $("#cantidad_compra").val();
            var precio_venta = $("#precio_unidad_final").val();
            var tipo_pago = 3;
            loaderR.showPleaseWait();
            $.ajax({
                url : '{{url("venta/_store")}}',
                data : {
                    fpr_id:fpr_id,
                    cantidad:cantidad,
                    precio_venta:precio_venta,
                    tipo_pago:tipo_pago
                },
                type : 'POST',
                success : function(resp) {
                    console.log(resp);
                    if(resp.res == true){
                        toastr.success(resp.mensaje,'');
                    }else{
                        toastr.success(resp.mensaje,'');
                    }
                },
                error : function(xhr, status) {
                    toastr.error('Ocurrio un error al guardar su compra, intente otra vez por favor.','');
                },
                complete : function(xhr, status) {
                    loaderR.hidePleaseWait();
                }
            });

        }

        function modalVentaQr(){
            console.log('venta qr');
            var cantidad = $("#cantidad_compra").val();
            var precio_venta = $("#precio_unidad_final").val();
            cantidad = tratarComoNumeroV2(cantidad);
            precio_venta = tratarComoNumeroV2(precio_venta);
            var cantidadDeposito = cantidad * precio_venta;
            cantidadDeposito = roundNumber(cantidadDeposito,2);
            $("#textoDepositoQr").text('Por favor realice una transferencia rápida de: '+cantidadDeposito +' Bs.');
            $("#modalVentaQr").modal("toggle");
        }

        function modalVentaDeposito(){
            console.log('venta deposito');
            var cantidad = $("#cantidad_compra").val();
            var precio_venta = $("#precio_unidad_final").val();
            cantidad = tratarComoNumeroV2(cantidad);
            precio_venta = tratarComoNumeroV2(precio_venta);
            var cantidadDeposito = cantidad * precio_venta;
            cantidadDeposito = roundNumber(cantidadDeposito,2);
            $("#textoDeposito").text('Por favor realice una deposito de: '+cantidadDeposito +' Bs. a la siguiente cuenta:');
            $("#modalVentaDeposito").modal("toggle");
        }


    </script>
@stop
