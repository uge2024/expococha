@extends('layouts.layout_main')

@section('header_styles')
    <link rel="stylesheet" href="{{asset('css/ol.css')}}" type="text/css">
    <style type="text/css">
        .estrellas-productor{
            height: 50px;
            font-size: 40px;
        }
        .colorear-estrella{
            color: #fdd835 !important;
        }
        .sincolor-estrella{
            color: #9d9c9c !important;
        }
        .div-comentarios{
            max-height: 500px;
            overflow-y: scroll;
        }
        .map {
            height: 400px;
            width: 100%;
        }
        .div-titulo-redes {
            font-size: 18px;
            color: #272727;
            margin: 0 20px 0 0;
            text-transform: capitalize;
            display: inline-block;
            font-weight: 600;
            vertical-align: bottom;
            align-self: center;
        }
        .clasefacebook{
            line-height: 34px;
        }
        .clasefacebook > a{
            display: inline-block;
            vertical-align: middle;
            color: #fff;
            font-size: 16px;
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
            color: #fff;
            font-size: 16px;
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
            color: #fff;
            font-size: 16px;
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
            color: #fff;
            font-size: 16px;
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
            color: #fff;
            font-size: 16px;
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
            color: #fff;
            font-size: 16px;
            width: 34px;
            height: 34px;
            border-radius: 100%;
            text-align: center;
        }
        .clasemensaje{
            line-height: 34px;
        }
        .clasemensaje > a{
            background: #266cfb;
            display: inline-block;
            vertical-align: middle;
            color: #fff;
            font-size: 16px;
            width: 34px;
            height: 34px;
            border-radius: 100%;
            text-align: center;
        }
        /*.slider-area .bg-img::after{
            background: none;
        }*/
        .cursormano{
            cursor: pointer;
        }
    </style>
@endsection

@section('header_metas')
    @php
        $productorMeta = preg_replace('/\s+/', ', ', $productor->nombre_tienda);
    @endphp
    <meta name="keywords" content="{{$productorMeta}}">
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
                            <li>Productor: {{$productor->nombre_propietario}}</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb Area End-->

    <div class="container">
        <!-- Slider Start -->
        <div class="slider-area slider-dots-style-3">
            <div class="hero-slider-wrapper">
                @foreach($productor->imagenProductores as $key => $baner)
                    @if($baner->tipo == 1 && $baner->estado == 'AC')
                        <!-- Single Slider  -->
                        <div class="single-slide slider-height-3 bg-img d-flex" data-bg-image="{{asset('storage/uploads/'.$baner->imagen)}}">
                            <div class="container align-self-center">
                                <div class="slider-content-1 slider-animated-1 text-left">
                                    <h1 class="animated color-black">
                                        {{$productor->nombre_tienda}}
                                    </h1>
                                    <p class="animated color-gray">{{$productor->actividad}}</p>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
        <!-- Slider End -->

        <!-- About Area Start -->
        <section class="about-area mtb-50px">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="about-left-image mb-md-30px mb-lm-30px ">
                            @foreach($productor->imagenProductores as $key => $baner)
                                @if($baner->tipo == 8 && $baner->estado == 'AC')
                                    <img src="{{asset('storage/uploads/'.$baner->imagen)}}" alt="Imagen no Encontrada" class="img-responsive" />
                                @endif
                            @endforeach
                            <div class="star-box">
                                <span>Puntuación:</span>
                                <div class="rating-product estrellas-productor">
                                    @switch($productor->puntuacion)
                                        @case(1)
                                            <i class="ion-android-star colorear-estrella"></i>
                                            <i class="ion-android-star"></i>
                                            <i class="ion-android-star"></i>
                                            <i class="ion-android-star"></i>
                                            <i class="ion-android-star"></i>
                                            @break
                                        @case(2)
                                            <i class="ion-android-star colorear-estrella"></i>
                                            <i class="ion-android-star colorear-estrella"></i>
                                            <i class="ion-android-star"></i>
                                            <i class="ion-android-star"></i>
                                            <i class="ion-android-star"></i>
                                            @break
                                        @case(3)
                                            <i class="ion-android-star colorear-estrella"></i>
                                            <i class="ion-android-star colorear-estrella"></i>
                                            <i class="ion-android-star colorear-estrella"></i>
                                            <i class="ion-android-star"></i>
                                            <i class="ion-android-star"></i>
                                            @break
                                        @case(4)
                                            <i class="ion-android-star colorear-estrella"></i>
                                            <i class="ion-android-star colorear-estrella"></i>
                                            <i class="ion-android-star colorear-estrella"></i>
                                            <i class="ion-android-star colorear-estrella"></i>
                                            <i class="ion-android-star"></i>
                                            @break
                                        @case(5)
                                            <i class="ion-android-star colorear-estrella"></i>
                                            <i class="ion-android-star colorear-estrella"></i>
                                            <i class="ion-android-star colorear-estrella"></i>
                                            <i class="ion-android-star colorear-estrella"></i>
                                            <i class="ion-android-star colorear-estrella"></i>
                                            @break
                                        @default
                                            <i class="ion-android-star"></i>
                                            <i class="ion-android-star"></i>
                                            <i class="ion-android-star"></i>
                                            <i class="ion-android-star"></i>
                                            <i class="ion-android-star"></i>
                                    @endswitch

                                </div>
                            </div>
                        </div>
                        <div class="footer-social-icon d-flex">
                            <div class="heading-info div-titulo-redes">Visitanos en Nuestras Redes Sociales:</div>
                            <div class="social-icon">
                                <ul>
                                    @isset($productor->link_facebook)
                                        <li class="facebook clasefacebook">
                                            <a href="{{$productor->link_facebook}}" target="_blank"><i class="ion-social-facebook"></i></a>
                                        </li>
                                    @endisset
                                    @isset($productor->link_twiter)
                                        <li class="twitter clasetwitter">
                                            <a href="{{$productor->link_twiter}}" target="_blank"><i class="ion-social-twitter"></i></a>
                                        </li>
                                    @endisset
                                    @isset($productor->link_youtube)
                                        <li class="youtube claseyoutube">
                                            <a href="{{$productor->link_youtube}}" target="_blank"><i class="ion-social-youtube"></i></a>
                                        </li>
                                    @endisset
                                    @isset($productor->link_instagram)
                                        <li class="instagram claseinstagram">
                                            <a href="{{$productor->link_instagram}}" target="_blank"><i class="ion-social-instagram"></i></a>
                                        </li>
                                    @endisset
                                </ul>
                            </div>
                        </div>

                        <div class="footer-social-icon d-flex">
                            <div class="heading-info div-titulo-redes">Comunícate con nosotros:</div>
                            <div class="social-icon">
                                <ul>
                                    @isset($productor->celular_wp)
                                        <li class="clasewhatsapp">
                                            <a href="#" onclick="event.preventDefault();enviarMensajeWhatsapp('{{$productor->celular_wp}}','Hola, quisiera saber mas sobre sus productos');"><i class="ion-social-whatsapp"></i></a>
                                        </li>
                                    @endisset
                                    <li class="clasemensaje">
                                        <a href="{{url('mensajes/chat/'.$productor->usr_id)}}"><i class="ion-email"></i></a>
                                    </li>
                                </ul>
                            </div>
                        </div>

                    </div>
                    <div class="col-lg-6">
                        <div class="about-content">
                            <div class="about-title">
                                <h2>{{$productor->nombre_tienda}}</h2>
                            </div>
                            <p class="mb-30px">
                                {{$productor->actividad}}
                            </p>
                            @isset($productor->nombre_propietario)
                                <p><b>Propietario:</b> {{$productor->nombre_propietario}}</p>
                            @endisset
                            @isset($productor->email)
                                <p><b>Correo Electrónico:</b> {{$productor->email}}</p>
                            @endisset
                            @isset($productor->telefono_1)
                                <p><b>Teléfono 1:</b> {{$productor->telefono_1}}</p>
                            @endisset
                            @isset($productor->telefono_2)
                                <p><b>Teléfono 2:</b> {{$productor->telefono_2}}</p>
                            @endisset
                            @isset($productor->celular)
                                <p><b>Celular:</b> {{$productor->celular}}</p>
                            @endisset
                            @isset($productor->celular_wp)
                                <p><b>Whatsapp:</b> {{$productor->celular_wp}}</p>
                            @endisset
                            @isset($productor->direccion)
                                <p><b>Dirección:</b> {{$productor->direccion}}</p>
                            @endisset
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- About Area End -->

        <!--MAPA-->
        <h4>Nuestra Dirección:</h4>
        <div id="map" class="map"><div id="popup"></div></div>
        <!--MAPA end-->

        <!-- Shop Category Area End -->
        <div class="shop-category-area mt-30px">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <!-- Shop Top Area Start -->
                        <div class="shop-top-bar d-flex">
                            <!-- Left Side start -->
                            <div class="shop-tab nav d-flex">
                                <a class="active"  href="#shop-1" data-toggle="tab">
                                    <i class="fa fa-th"></i>
                                </a>

                                <p>Nuestros productos: Total {{$productos->count()}} productos</p>
                            </div>
                            <!-- Left Side End -->
                            <!-- Right Side Start -->
                            <div class="select-shoing-wrap d-flex">
                            </div>
                            <!-- Right Side End -->
                        </div>
                        <!-- Shop Top Area End -->

                        <!-- Shop Bottom Area Start -->
                        <div class="shop-bottom-area mt-35">
                            <!-- Shop Tab Content Start -->
                            <div class="tab-content jump">
                                <!-- Tab One Start -->
                                <div id="shop-1" class="tab-pane active">
                                    <div class="row m-0">

                                        @foreach($productos as $key=>$producto)
                                            @php
                                                $enoferta = false;
                                                if(isset($producto->precio_oferta) && isset($producto->fecha_inicio_oferta) && isset($producto->fecha_fin_oferta)){
                                                    $fechaActual = date('Y-m-d');
                                                    if($producto->fecha_inicio_oferta <= $fechaActual && $producto->fecha_fin_oferta >= $fechaActual ){
                                                        $enoferta = true;
                                                    }
                                                }else{
                                                    $enoferta = false;
                                                }
                                            @endphp

                                            @if($enoferta == true)
                                                <div class="mb-30px col-md-4 col-lg-3 col-sm-6  p-0">
                                                    <div class="slider-single-item">
                                                        <!-- Single Item -->
                                                        <article class="list-product p-0 text-center">
                                                            <div class="product-inner">
                                                                <div class="img-block">
                                                                    <a href="{{url('producto/ver/'.$producto->prd_id)}}" target="_blank" class="thumbnail">
                                                                        @php
                                                                            $contador = 1;
                                                                        @endphp
                                                                        @foreach($producto->imagenesProducto as $key => $imagen)
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
                                                                    <li class="new">-{{$producto->descuento}}%</li>
                                                                </ul>
                                                                <div class="product-decs">
                                                                    <a class="inner-link" target="_blank" href="{{url('productor/tienda/'.$producto->pro_id)}}"><span>{{$producto->productor->nombre_tienda}}</span></a>
                                                                    <h2><a target="_blank" href="{{url('producto/ver/'.$producto->prd_id)}}" class="product-link">{{$producto->nombre_producto}}</a></h2>
                                                                    <div class="pricing-meta">
                                                                        <ul>
                                                                            <li class="old-price">Bs.{{$producto->precio}}</li>
                                                                            <li class="current-price">Bs.{{$producto->precio_oferta}}</li>
                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                                <div class="cart-btn">
                                                                    <a href="#" onclick="event.preventDefault();agregarProductoCarrito('{{$producto->prd_id}}');" class="add-to-curt" title="Agregar a mi Carrito">Agregar a mi Carrito</a>
                                                                </div>
                                                            </div>
                                                        </article>
                                                        <!-- Single Item -->
                                                    </div>
                                                </div>
                                            @else
                                                <div class="mb-30px col-md-4 col-lg-3 col-sm-6  p-0">
                                                    <div class="slider-single-item">
                                                        <!-- Single Item -->
                                                        <article class="list-product p-0 text-center">
                                                            <div class="product-inner">
                                                                <div class="img-block">
                                                                    <a href="{{url('producto/ver/'.$producto->prd_id)}}" target="_blank" class="thumbnail">
                                                                        @php
                                                                            $contador = 1;
                                                                        @endphp
                                                                        @foreach($producto->imagenesProducto as $key => $imagen)
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
                                                                    @php
                                                                        $esNuevo = false;
                                                                        $fechaActual = date('Y-m-d');
                                                                        $fechaDesde = date("Y-m-d",strtotime($fechaActual."- $diasNuevos days"));
                                                                        if($producto->fecha_registro >= $fechaDesde && $producto->fecha_registro <= $fechaActual){
                                                                            $esNuevo = true;
                                                                        }
                                                                    @endphp
                                                                    @if($esNuevo)
                                                                        <li class="new">Nuevo</li>
                                                                    @endif
                                                                </ul>
                                                                <div class="product-decs">
                                                                    <a class="inner-link" target="_blank" href="{{url('productor/tienda/'.$producto->pro_id)}}"><span>{{$producto->productor->nombre_tienda}}</span></a>
                                                                    <h2><a target="_blank" href="{{url('producto/ver/'.$producto->prd_id)}}" class="product-link">{{$producto->nombre_producto}}</a></h2>
                                                                    <div class="pricing-meta">
                                                                        <ul>
                                                                            <li class="current-price">Bs.{{$producto->precio}}</li>
                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                                <div class="cart-btn">
                                                                    <a href="#" onclick="event.preventDefault();agregarProductoCarrito('{{$producto->prd_id}}');" class="add-to-curt" title="Agregar a mi Carrito">Agregar a mi Carrito</a>
                                                                </div>
                                                            </div>
                                                        </article>
                                                        <!-- Single Item -->
                                                    </div>
                                                </div>
                                            @endif
                                        @endforeach


                                    </div>
                                </div>
                                <!-- Tab One End -->
                            </div>
                            <!-- Shop Tab Content End -->
                        </div>
                        <!-- Shop Bottom Area End -->
                    </div>
                </div>
            </div>
        </div>
        <!-- Shop Category Area End -->

        <!-- Valoraciones-->
        <div class="description-review-area mb-50px bg-light-gray-3 ptb-50px">
            <div class="container">
                <div class="description-review-wrapper">
                    <div class="description-review-topbar nav">
                        <a class="active" data-toggle="tab" href="#des-details3">Valoraciones</a>
                    </div>
                    <div class="tab-content description-review-bottom">
                        <div id="des-details3" class="tab-pane active">
                            <div class="row">
                                <div class="col-lg-7 div-comentarios" id="div-comentarios">
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
                                        <h3>Puntuar al Productor</h3>
                                        <div class="ratting-form">
                                            <form action="#" id="formularioValoracion">
                                                <div class="star-box">
                                                    <span>Tú Puntuación:</span>
                                                    <div class="rating-product">
                                                        <input type="hidden" id="puntaje" value="3">
                                                        <input type="hidden" id="pro_id" value="{{$productor->pro_id}}">
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
                                                                <input type="button" class="btn disabled" title="Ingresa al página para poder comentar y puntuar a los productores" value="Enviar" />
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


    </div>

@endsection
@section('footer_scripts')
    <script type="text/javascript" src="{{asset('js/ol.js')}}"></script>
    <script>
        var latitud = {{$productor->latitud}};
        var longitud = {{$productor->longitud}};
        var direccion = '{{$productor->direccion}}';
        var zoom = {{$zoom ?? 18}};
        $(document).ready(function(){

            //seteamos la ruta para realizar denuncia
            $("#linkrealizardenuncia").attr("href", '{{url('denuncia/midenuncia'.'?pro_id='.$productor->pro_id)}}');

            //$("#div-comentarios").scroll
            //el scroll de comentarios hacia abajo
            //$("#div-comentarios").animate({ scrollTop: $('#div-comentarios').height()}, 1000);
            //el scroll de comentarios hacia arriba
            $("#div-comentarios").animate({ scrollTop: 0}, 1000);


            //##############MAPA
            var iconFeature = new ol.Feature({
                geometry: new ol.geom.Point(ol.proj.fromLonLat([longitud, latitud])),
                name: direccion,
                population: 4000,
                rainfall: 500
            });

            var iconStyle = new ol.style.Style({
                image: new ol.style.Icon(/** @type {olx.style.IconOptions} */ ({
                    anchor: [0.5, 70],
                    scale: 0.9,
                    opacity: 0.80,
                    anchorXUnits: 'fraction',
                    anchorYUnits: 'pixels',
                    src: '{{asset('images/icons/icon.png')}}'
                }))
            });

            iconFeature.setStyle(iconStyle);

            var vectorSource = new ol.source.Vector({
                features: [iconFeature]
            });

            var vectorLayer = new ol.layer.Vector({
                source: vectorSource
            });

            var osm = new ol.layer.Tile({
                source: new ol.source.OSM()
            });

            var map = new ol.Map({
                layers: [ osm,vectorLayer],
                target: document.getElementById('map'),
                view: new ol.View({
                    center: ol.proj.fromLonLat([longitud, latitud]),
                    zoom: zoom
                })
            });

            var element = document.getElementById('popup');

            var popup = new ol.Overlay({
                element: element,
                positioning: 'bottom-center',
                stopEvent: false,
                offset: [0, -50]
            });
            map.addOverlay(popup);

            map.on('click', function(evt) {
                var feature = map.forEachFeatureAtPixel(evt.pixel,
                    function(feature) {
                        return feature;
                    });
                if (feature) {
                    var coordinates = feature.getGeometry().getCoordinates();
                    popup.setPosition(coordinates);
                    $(element).popover({
                        'placement': 'top',
                        'html': true,
                        'content': feature.get('name')
                    });
                    $(element).popover('toggle');
                } else {
                    $(element).popover('dispose');
                }
            });
            //##############END MAPA

            //envio de valoracion
            $("#btnEnviar").click(function (){
                var puntaje = $("#puntaje").val();
                var comentario = $("#comentario").val();
                var cantidadComentario = comentario.length;
                console.log(cantidadComentario);
                var pro_id = $("#pro_id").val();
                if(cantidadComentario <= 500){
                    console.log('dice '+puntaje+' '+comentario);
                    loaderR.showPleaseWait();
                    $.ajax({
                        url : '{{url("productor/tienda/_guardarValoracion")}}',
                        data : {
                            pro_id:pro_id,
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
    </script>
@stop
