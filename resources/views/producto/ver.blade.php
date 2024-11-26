
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
                            <span class="read-review"><p class="reviews">Puntaje:</p></span>
                            <div class="rating-product">
                                @switch($producto->puntuacion)
                                    @case(1)
                                        <i class="ion-android-star"></i><i class="ion-android-star sincolor-estrella"></i><i class="ion-android-star sincolor-estrella"></i>
                                        <i class="ion-android-star sincolor-estrella"></i><i class="ion-android-star sincolor-estrella"></i>
                                        @break
                                    @case(2)
                                        <i class="ion-android-star"></i><i class="ion-android-star"></i><i class="ion-android-star sincolor-estrella"></i>
                                        <i class="ion-android-star sincolor-estrella"></i><i class="ion-android-star sincolor-estrella"></i>
                                        @break
                                    @case(3)
                                        <i class="ion-android-star"></i><i class="ion-android-star"></i><i class="ion-android-star"></i>
                                        <i class="ion-android-star sincolor-estrella"></i><i class="ion-android-star sincolor-estrella"></i>
                                        @break
                                    @case(4)
                                        <i class="ion-android-star"></i><i class="ion-android-star"></i><i class="ion-android-star"></i>
                                        <i class="ion-android-star"></i><i class="ion-android-star sincolor-estrella"></i>
                                        @break
                                    @case(5)
                                        <i class="ion-android-star"></i><i class="ion-android-star"></i><i class="ion-android-star"></i>
                                        <i class="ion-android-star"></i><i class="ion-android-star"></i>
                                        @break
                                    @default
                                        <i class="ion-android-star"></i><i class="ion-android-star"></i><i class="ion-android-star"></i>
                                        <i class="ion-android-star"></i><i class="ion-android-star"></i>
                                @endswitch
                            </div>
                        </div>
                        <div class="pricing-meta">
                            <input type="hidden" name="precio_unidad_final" id="precio_unidad_final" value="{{$precioUnidadFinal}}">
                            <ul>
                                @if($oferta)
                                    <li class="old-price">Bs. {{$producto->precio}}</li>
                                    <li class="cuttent-price">Bs. {{$producto->precio_oferta}}</li>
                                    <li class="discount-flag">- {{$producto->descuento}}%</li>
                                @elseif($nuevo)
                                    <li class="cuttent-price">Bs. {{$producto->precio}}</li>
                                    <li class="discount-flag">Nuevo</li>
                                @else
                                    <li class="cuttent-price">Bs. {{$producto->precio}}</li>
                                @endif
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
                                <a href="#" onclick="event.preventDefault();agregarProductoCarrito('{{$producto->prd_id}}');">Agregar a mi Carrito</a>
                            </div>
                        </div>
                        @guest

                        @else
                            <div class="comprariconos" id="divcomprariconos">
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
                        @endguest
                        <div class="pro-details-social-info">
                        </div>
                        <div class="pro-details-social-info">
                            <span>Compartir por:</span>
                            <div class="social-info">
                                <ul>
                                    <li class="facebook clasefacebook">
                                        <a title="Facebook" href="#" onclick="event.preventDefault();compartirPorFacebook('{{url('producto/ver/'.$producto->prd_id)}}');"><i class="ion-social-facebook"></i></a>
                                    </li>
                                    <li class="clasewhatsapp">
                                        <a title="Whatsapp" href="#" onclick="event.preventDefault();compartirPorWhatsapp('{{url('producto/ver/'.$producto->prd_id)}}');"><i class="ion-social-whatsapp"></i></a>
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
                    <a data-toggle="tab" href="#des-details3">Valoraciones</a>
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
                    <div id="des-details3" class="tab-pane">
                        <div class="row">
                            <div class="col-lg-7">
                                <div class="review-wrapper" id="valoracionesContenido">

                                    @foreach($valoraciones as $key => $valo)
                                        <div class="single-review">
                                            <div class="review-content">
                                                <div class="review-top-wrap">
                                                    <div class="review-left">
                                                        <div class="review-name">
                                                            <h4>{{$valo->usuario->name}}</h4>
                                                        </div>
                                                        <div class="rating-product">
                                                            @switch($valo->puntuacion)
                                                                @case(1)
                                                                <i class="ion-android-star"></i>
                                                                <i class="ion-android-star sincolor-estrella"></i>
                                                                <i class="ion-android-star sincolor-estrella"></i>
                                                                <i class="ion-android-star sincolor-estrella"></i>
                                                                <i class="ion-android-star sincolor-estrella"></i>
                                                                @break
                                                                @case(2)
                                                                <i class="ion-android-star"></i>
                                                                <i class="ion-android-star"></i>
                                                                <i class="ion-android-star sincolor-estrella"></i>
                                                                <i class="ion-android-star sincolor-estrella"></i>
                                                                <i class="ion-android-star sincolor-estrella"></i>
                                                                @break
                                                                @case(3)
                                                                <i class="ion-android-star"></i>
                                                                <i class="ion-android-star"></i>
                                                                <i class="ion-android-star"></i>
                                                                <i class="ion-android-star sincolor-estrella"></i>
                                                                <i class="ion-android-star sincolor-estrella"></i>
                                                                @break
                                                                @case(4)
                                                                <i class="ion-android-star"></i>
                                                                <i class="ion-android-star"></i>
                                                                <i class="ion-android-star"></i>
                                                                <i class="ion-android-star"></i>
                                                                <i class="ion-android-star sincolor-estrella"></i>
                                                                @break
                                                                @case(5)
                                                                <i class="ion-android-star"></i>
                                                                <i class="ion-android-star"></i>
                                                                <i class="ion-android-star"></i>
                                                                <i class="ion-android-star"></i>
                                                                <i class="ion-android-star"></i>
                                                                @break
                                                                @default
                                                                <i class="ion-android-star"></i>
                                                                <i class="ion-android-star"></i>
                                                                <i class="ion-android-star"></i>
                                                                <i class="ion-android-star sincolor-estrella"></i>
                                                                <i class="ion-android-star sincolor-estrella"></i>
                                                            @endswitch
                                                        </div>
                                                    </div>
                                                    <div class="review-left">
                                                    </div>
                                                </div>
                                                <div class="review-bottom">
                                                    <p>{{$valo->valoracion}}</p>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach

                                </div>
                            </div>
                            <div class="col-lg-5">
                                <div class="ratting-form-wrapper pl-50">

                                    <h3>Puntuar al Producto</h3>
                                    <div class="ratting-form">
                                        <form action="#" id="formularioValoracion">
                                            <div class="star-box">
                                                <span>Tú Puntuación:</span>
                                                <div class="rating-product">
                                                    <input type="hidden" id="puntaje" value="3">
                                                    <input type="hidden" id="prd_id" value="{{$producto->prd_id}}">
                                                    <i id="est-1" style="font-size: 30px;" onclick="cambiarColorEstrella(1);" class="ion-android-star cursormano"></i>
                                                    <i id="est-2" style="font-size: 30px;" onclick="cambiarColorEstrella(2);" class="ion-android-star cursormano"></i>
                                                    <i id="est-3" style="font-size: 30px;" onclick="cambiarColorEstrella(3);" class="ion-android-star cursormano"></i>
                                                    <i id="est-4" style="font-size: 30px;" onclick="cambiarColorEstrella(4);" class="ion-android-star cursormano sincolor-estrella"></i>
                                                    <i id="est-5" style="font-size: 30px;" onclick="cambiarColorEstrella(5);" class="ion-android-star cursormano sincolor-estrella"></i>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="rating-form-style mb-10">
                                                        @guest
                                                            <input type="email" placeholder="Correo Electrónico"/>
                                                        @else
                                                            <input value="{{Auth::user()->email}}" type="email" readonly/>
                                                        @endguest
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="rating-form-style form-submit">
                                                        @guest
                                                            <textarea name="comentario" maxlength="500" placeholder="Escribe un comentario..."></textarea>
                                                            <input type="button" class="btn disabled" title="Ingresa al página para poder comentar y puntuar los productos" value="Enviar" />
                                                        @else
                                                            <textarea name="comentario" id="comentario" maxlength="500" placeholder="Escribe un comentario..."></textarea>
                                                            <input type="button" id="btnEnviar" value="Enviar" />
                                                        @endguest
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- product details description area end -->

    <!-- Arrivals Area Start -->
    <div class="arrival-area single-product-nav mb-20px">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="section-title">
                        <h2 class="section-heading">Productos relacionados</h2>
                    </div>
                </div>
            </div>
            <!-- Arrivel slider start -->
            <div class="arrival-slider-wrapper slider-nav-style-1">
                @foreach($productosRelacionados as $key=>$pro)
                    @php
                        $oferta = false;
                        $nuevo = false;
                        $fechaActual = date('Y-m-d');
                        $fechaDesde = date("Y-m-d",strtotime($fechaActual."- $diasNuevos days"));
                        if(isset($pro->precio_oferta) && isset($pro->fecha_inicio_oferta) && isset($pro->fecha_fin_oferta)){
                            if($pro->fecha_inicio_oferta <= $fechaActual && $pro->fecha_fin_oferta >= $fechaActual ){
                                $oferta = true;
                            }
                        }elseif($pro->fecha_registro >= $fechaDesde){
                            $nuevo = true;
                        }
                    @endphp
                    @if($oferta)
                        <div class="slider-single-item">
                            <!-- Single Item -->
                            <article class="list-product text-center">
                                <div class="product-inner">
                                    <div class="img-block">
                                        <a href="{{url('producto/ver/'.$pro->prd_id)}}" target="_blank" class="thumbnail">
                                            @php
                                                $contador = 1;
                                            @endphp
                                            @foreach($pro->imagenesProducto as $key => $imagen)
                                                @if($imagen->estado == 'AC' && $imagen->tipo == 12)
                                                    @if($contador == 1)
                                                        <img class="first-img" src="{{asset('storage/uploads/'.$imagen->imagen)}}" alt="" />
                                                        @php
                                                            $contador++;
                                                        @endphp
                                                    @elseif($contador == 2)
                                                        <img class="second-img" src="{{asset('storage/uploads/'.$imagen->imagen)}}" alt="" />
                                                        @php
                                                            $contador++;
                                                        @endphp
                                                    @else
                                                    @endif
                                                @endif
                                            @endforeach
                                        </a>
                                        <div class="add-to-link">

                                        </div>
                                    </div>
                                    <ul class="product-flag">
                                        <li class="new">-{{$pro->descuento}}%</li>
                                    </ul>
                                    <div class="product-decs">
                                        <a class="inner-link" target="_blank" href="{{url('productor/tienda/'.$pro->pro_id)}}"><span>{{$pro->productor->nombre_tienda}}</span></a>
                                        <h2><a target="_blank" href="{{url('producto/ver/'.$pro->prd_id)}}" class="product-link">{{$pro->nombre_producto}}</a></h2>
                                        <div class="pricing-meta">
                                            <ul>
                                                <li class="old-price">Bs.{{$pro->precio}}</li>
                                                <li class="current-price">Bs.{{$pro->precio_oferta}}</li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="cart-btn">
                                        <a href="#" onclick="event.preventDefault();agregarProductoCarrito('{{$pro->prd_id}}');" class="add-to-curt" title="Agregar a mi Carrito">Agregar a mi Carrito</a>
                                    </div>
                                </div>
                            </article>
                            <!-- Single Item -->
                        </div>
                    @elseif($nuevo)
                        <div class="slider-single-item">
                            <!-- Single Item -->
                            <article class="list-product text-center">
                                <div class="product-inner">
                                    <div class="img-block">
                                        <a href="{{url('producto/ver/'.$pro->prd_id)}}" target="_blank" class="thumbnail">
                                            @php
                                                $contador = 1;
                                            @endphp
                                            @foreach($pro->imagenesProducto as $key => $imagen)
                                                @if($imagen->estado == 'AC' && $imagen->tipo == 12)
                                                    @if($contador == 1)
                                                        <img class="first-img" src="{{asset('storage/uploads/'.$imagen->imagen)}}" alt="" />
                                                        @php
                                                            $contador++;
                                                        @endphp
                                                    @elseif($contador == 2)
                                                        <img class="second-img" src="{{asset('storage/uploads/'.$imagen->imagen)}}" alt="" />
                                                        @php
                                                            $contador++;
                                                        @endphp
                                                    @else
                                                    @endif
                                                @endif
                                            @endforeach
                                        </a>
                                        <div class="add-to-link">

                                        </div>
                                    </div>
                                    <ul class="product-flag">
                                        <li class="new">Nuevo</li>
                                    </ul>
                                    <div class="product-decs">
                                        <a class="inner-link" target="_blank" href="{{url('productor/tienda/'.$pro->pro_id)}}"><span>{{$pro->productor->nombre_tienda}}</span></a>
                                        <h2><a target="_blank" href="{{url('producto/ver/'.$pro->prd_id)}}" class="product-link">{{$pro->nombre_producto}}</a></h2>
                                        <div class="pricing-meta">
                                            <ul>
                                                <li class="current-price">Bs.{{$pro->precio}}</li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="cart-btn">
                                        <a href="#" onclick="event.preventDefault();agregarProductoCarrito('{{$pro->prd_id}}');" class="add-to-curt" title="Agregar a mi Carrito">Agregar a mi Carrito</a>
                                    </div>
                                </div>
                            </article>
                            <!-- Single Item -->
                        </div>
                    @else
                        <div class="slider-single-item">
                            <!-- Single Item -->
                            <article class="list-product text-center">
                                <div class="product-inner">
                                    <div class="img-block">
                                        <a href="{{url('producto/ver/'.$pro->prd_id)}}" target="_blank" class="thumbnail">
                                            @php
                                                $contador = 1;
                                            @endphp
                                            @foreach($pro->imagenesProducto as $key => $imagen)
                                                @if($imagen->estado == 'AC' && $imagen->tipo == 12)
                                                    @if($contador == 1)
                                                        <img class="first-img" src="{{asset('storage/uploads/'.$imagen->imagen)}}" alt="" />
                                                        @php
                                                            $contador++;
                                                        @endphp
                                                    @elseif($contador == 2)
                                                        <img class="second-img" src="{{asset('storage/uploads/'.$imagen->imagen)}}" alt="" />
                                                        @php
                                                            $contador++;
                                                        @endphp
                                                    @else
                                                    @endif
                                                @endif
                                            @endforeach
                                        </a>
                                        <div class="add-to-link">

                                        </div>
                                    </div>
                                    <ul class="product-flag">

                                    </ul>
                                    <div class="product-decs">
                                        <a class="inner-link" target="_blank" href="{{url('productor/tienda/'.$pro->pro_id)}}"><span>{{$pro->productor->nombre_tienda}}</span></a>
                                        <h2><a target="_blank" href="{{url('producto/ver/'.$pro->prd_id)}}" class="product-link">{{$pro->nombre_producto}}</a></h2>
                                        <div class="pricing-meta">
                                            <ul>
                                                <li class="current-price">Bs.{{$pro->precio}}</li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="cart-btn">
                                        <a href="#" onclick="event.preventDefault();agregarProductoCarrito('{{$pro->prd_id}}');" class="add-to-curt" title="Agregar a mi Carrito">Agregar a mi Carrito</a>
                                    </div>
                                </div>
                            </article>
                            <!-- Single Item -->
                        </div>
                    @endif
                @endforeach
            </div>
            <!-- Arrivel slider end -->
        </div>
    </div>
    <!-- Arrivals Area End -->


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
                                <input type="hidden" name="prd_id_qr" id="prd_id_qr" value="{{$producto->prd_id}}">
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
                                    @if(isset($producto->productor->titular_cuenta))
                                        <p class="text-justify" style="font-size: 16pt;color: black;">
                                            <b>Titular de la Cuenta:</b><br>
                                            {{$producto->productor->titular_cuenta}}
                                        </p>
                                    @endif
                                    @if(isset($producto->productor->entidad_financiera))
                                        <p class="text-justify" style="font-size: 16pt;color: black;">
                                            <b>Entidad Financiera:</b><br>
                                            {{$producto->productor->entidad_financiera}}
                                        </p>
                                    @endif
                                    @if(isset($producto->productor->cuenta))
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
                                <input type="hidden" name="prd_id_dp" id="prd_id_dp" value="{{$producto->prd_id}}">
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
            rutaDenuncia = rutaDenuncia+'?pro_id='+'{{$producto->pro_id}}'+'&prd_id='+'{{$producto->prd_id}}';
            $("#linkrealizardenuncia").attr("href", rutaDenuncia);

            $("#div-comentarios").animate({ scrollTop: 0}, 1000);

            //envio de valoracion
            $("#btnEnviar").click(function (){
                var puntaje = $("#puntaje").val();
                var comentario = $("#comentario").val();
                var cantidadComentario = comentario.length;
                console.log(cantidadComentario);
                var prd_id = $("#prd_id").val();
                if(cantidadComentario <= 500){
                    console.log('dice '+puntaje+' '+comentario);
                    loaderR.showPleaseWait();
                    $.ajax({
                        url : '{{url("producto/ver/_guardarValoracion")}}',
                        data : {
                            prd_id:prd_id,
                            puntaje : puntaje,
                            comentario : comentario
                        },
                        type : 'POST',
                        success : function(resp) {
                            //console.log(resp);
                            if(resp.res == true){
                                toastr.success('Valoración guardada','');
                                $("#valoracionesContenido").html(resp.html);
                                $("#div-comentarios").animate({ scrollTop: 0}, 500);

                            }else{
                                toastr.error('Ocurrio un error al guardar su valoración, por favor intente otra vez.','');
                            }
                        },
                        error : function(xhr, status) {
                            toastr.error('Ocurrio un error al guardar su valoración, intente otra vez por favor.','');
                        },
                        complete : function(xhr, status) {
                            $("#comentario").val('');
                            cambiarColorEstrella(3);
                            loaderR.hidePleaseWait();

                        }
                    });
                }else{
                    toastr.warning('Su comentario no puede exceder los 500 caracteres, por favor redusca su comentario. gracias.','');
                }
            });


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

        //function para las estrellas
        function cambiarColorEstrella(indice){
            switch (indice){
                case 1:
                    //$("#est-1").addClass('sincolor-estrella');
                    $("#est-2").addClass('sincolor-estrella');
                    $("#est-3").addClass('sincolor-estrella');
                    $("#est-4").addClass('sincolor-estrella');
                    $("#est-5").addClass('sincolor-estrella');
                    $("#puntaje").val(1);
                    break;
                case 2:
                    $("#est-2").removeClass('sincolor-estrella');
                    $("#est-3").addClass('sincolor-estrella');
                    $("#est-4").addClass('sincolor-estrella');
                    $("#est-5").addClass('sincolor-estrella');
                    $("#puntaje").val(2);
                    break;
                case 3:
                    $("#est-2").removeClass('sincolor-estrella');
                    $("#est-3").removeClass('sincolor-estrella');
                    $("#est-4").addClass('sincolor-estrella');
                    $("#est-5").addClass('sincolor-estrella');
                    $("#puntaje").val(3);
                    break;
                case 4:
                    $("#est-2").removeClass('sincolor-estrella');
                    $("#est-3").removeClass('sincolor-estrella');
                    $("#est-4").removeClass('sincolor-estrella');
                    $("#est-5").addClass('sincolor-estrella');
                    $("#puntaje").val(4);
                    break;
                case 5:
                    $("#est-2").removeClass('sincolor-estrella');
                    $("#est-3").removeClass('sincolor-estrella');
                    $("#est-4").removeClass('sincolor-estrella');
                    $("#est-5").removeClass('sincolor-estrella');
                    $("#puntaje").val(5);
                    break;
                default:
                    $("#est-2").removeClass('sincolor-estrella');
                    $("#est-3").removeClass('sincolor-estrella');
                    $("#est-4").addClass('sincolor-estrella');
                    $("#est-5").addClass('sincolor-estrella');
                    $("#puntaje").val(3);
                    break;
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
            var prd_id = $("#prd_id").val();
            var cantidad = $("#cantidad_compra").val();
            var precio_venta = $("#precio_unidad_final").val();
            var tipo_pago = 3;
            loaderR.showPleaseWait();
            $.ajax({
                url : '{{url("venta/_store")}}',
                data : {
                    prd_id:prd_id,
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
