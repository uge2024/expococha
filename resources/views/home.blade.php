{{--@extends('layouts.layout_main',['noMostrarHeaderBuscar'=>'1'])--}}
@extends('layouts.layout_main')

@section('header_styles')
    <style rel="stylesheet">
        .titulo-banner{
            width: 100%;
            border-radius: 25px;
            padding: 10px;
            background: rgba(40,3,3,0.48);
            /*background: rgba(25,3,40,0.5);*/
            /*background: rgba(48,9,74,0.79);*/
        }
    </style>
@endsection

@section('content')

    <!-- Slider Start -->
    <div class="slider-area slider-dots-style-3">
        <div class="hero-slider-wrapper">
            <!--PRIMER SLIDER ES DE LA PAGINA-->
            @isset($datospagina->imagen_banner)
                <!-- Single Slider  -->
                <div class="single-slide slider-height-3 bg-img d-flex" data-bg-image="{{url('storage/uploads/'.$datospagina->imagen_banner)}}">
                    <div class="col-md-12 align-self-center">
                        <div class="slider-content-1 slider-animated-1 text-left">
                            <h1 class="animated color-white titulo-banner" style="color: white;">
                                {{$datospagina->nombre}}
                                <br />
                                {{$datospagina->descripcion}}
                            </h1>
                        </div>
                    </div>
                </div>
            @endisset
            @if($bannersPublicidad->count() == 0)
                <!-- Single Slider  -->
                <div class="single-slide slider-height-3 bg-img d-flex" onclick="window.open('{{url('/')}}','_blank');" data-bg-image="images/banner-image/espacio_disponible_banner.jpg">
                    <div class="container align-self-center">
                        <div class="slider-content-1 slider-animated-2 text-left ">
                        </div>
                    </div>
                </div>
                <!-- Single Slider  -->
                <div class="single-slide slider-height-3 bg-img d-flex" onclick="window.open('{{url('/')}}','_blank');" data-bg-image="images/banner-image/espacio_disponible_banner.jpg">
                    <div class="container align-self-center">
                        <div class="slider-content-1 slider-animated-3 text-left">
                        </div>
                    </div>
                </div>
                <!-- Single Slider  -->
            @else
                @foreach($bannersPublicidad as $key=>$bannpub)
                    <div class="single-slide slider-height-3 bg-img d-flex" onclick="window.open('{{$bannpub->link_destino}}','_blank');" data-bg-image="{{asset('storage/uploads/'.$bannpub->imagen)}}">
                        <div class="container align-self-center">
                            <div class="slider-content-1 slider-animated-3 text-left">
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
    <!-- Slider End -->

    @if($productosEnOferta->count() == 0)
        <!-- PRODUCTOS NORMALES -->
        <div class="arrival-area mt-20px mb-20px">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="section-title">
                            <h2><a href="{{url('/producto/todos')}}" target="_blank">Nuestros Productos</a></h2>
                            <!-- Nav tabs -->
                            <ul class="nav nav-tabs sub-category">
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#">&nbsp;</a>
                                </li>
                            </ul>
                            <!-- Nav tabs -->
                        </div>
                    </div>
                </div>
                <!-- tab content -->
                <div class="tab-content">
                    <!-- First-Tab -->
                    <div id="tab-1" class="tab-pane active fade">
                        <!-- Arrivel slider start -->
                        <div class="arrival-slider-wrapper slider-nav-style-1">

                            @foreach($productos as $key => $producto)
                                <div class="slider-single-item">
                                    <!-- Single Item -->
                                    <article class="list-product text-center">
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
                            @endforeach
                        </div>
                        <!-- Arrivel slider end -->
                    </div>
                    <!-- First-Tab -->

                </div>
                <!-- tab content end-->
            </div>
        </div>
        <!-- PRODUCTOS NORMALES End -->
    @else
        <!-- PRODUCTOS EN OFERTA -->
        <div class="arrival-area mt-20px mb-20px">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="section-title">
                            <h2><a href="{{url('/producto/ofertas')}}" target="_blank">Ofertas</a></h2>
                            <!-- Nav tabs -->
                            <ul class="nav nav-tabs sub-category">
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#">&nbsp;</a>
                                </li>
                            </ul>
                            <!-- Nav tabs -->
                        </div>
                    </div>
                </div>
                <!-- tab content -->
                <div class="tab-content">
                    <!-- First-Tab -->
                    <div id="tab-1" class="tab-pane active fade">
                        <!-- Arrivel slider start -->
                        <div class="arrival-slider-wrapper slider-nav-style-1">

                            @foreach($productosEnOferta as $key => $producto)
                                <div class="slider-single-item">
                                    <!-- Single Item -->
                                    <article class="list-product text-center">
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
                            @endforeach
                        </div>
                        <!-- Arrivel slider end -->
                    </div>
                    <!-- First-Tab -->

                </div>
                <!-- tab content end-->
            </div>
        </div>
        <!-- PRODUCTOS EN OFERTA End -->
    @endif


    <!-- Banner Publicidad tipo 2 -->
    <div class="col-md-12">
        <div id="demo" class="carousel slide" data-ride="carousel">

            @if($cajas1Publicidad->count() == 0)
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <div class="banner-area mt-50px mb-20px ">
                            <div class="container">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="banner-wrapper">
                                            <a href="#"><img src="images/banner-image/espacio_disponible.jpg" alt="Espacio Disponible" /></a>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="banner-wrapper">
                                            <a href="#"><img src="images/banner-image/espacio_disponible.jpg" alt="Espacio Disponible" /></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <div class="banner-area mt-50px mb-20px ">
                            <div class="container">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="banner-wrapper">
                                            <a href="#"><img src="images/banner-image/espacio_disponible.jpg" alt="Espacio Disponible" /></a>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="banner-wrapper">
                                            <a href="#"><img src="images/banner-image/espacio_disponible.jpg" alt="Espacio Disponible" /></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="carousel-inner">
                    @php
                        $flag1 = true;
                    @endphp
                    @for($i = 0;$i<$cajas1Publicidad->count();$i += 2)
                        <div class="carousel-item @if($flag1) active @endif">
                            <div class="banner-area mt-50px mb-20px ">
                                <div class="container">
                                    <div class="row">
                                        <div class="col-md-6">
                                            @if(isset($cajas1Publicidad[$i]))
                                                <div class="banner-wrapper">
                                                    <a target="_blank" href="{{$cajas1Publicidad[$i]->link_destino}}"><img src="{{asset('storage/uploads/'.$cajas1Publicidad[$i]->imagen)}}" alt="Espacio Disponible" /></a>
                                                </div>
                                            @else
                                                <div class="banner-wrapper">
                                                    <a href="#"><img src="images/banner-image/espacio_disponible.jpg" alt="Espacio Disponible" /></a>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="col-md-6">
                                            @if(isset($cajas1Publicidad[$i+1]))
                                                <div class="banner-wrapper">
                                                    <a target="_blank" href="{{$cajas1Publicidad[$i+1]->link_destino}}"><img src="{{asset('storage/uploads/'.$cajas1Publicidad[$i+1]->imagen)}}" alt="Espacio Disponible" /></a>
                                                </div>
                                            @else
                                                <div class="banner-wrapper">
                                                    <a href="#"><img src="images/banner-image/espacio_disponible.jpg" alt="Espacio Disponible" /></a>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @php
                            $flag1 = false;
                        @endphp
                    @endfor
                </div>
            @endif

            <!-- Left and right controls -->
            <a class="carousel-control-prev" href="#demo" data-slide="prev">
                <span class="carousel-control-prev-icon" style="background-color: black;"></span>
            </a>
            <a class="carousel-control-next" href="#demo" data-slide="next">
                <span class="carousel-control-next-icon" style="background-color: black;"></span>
            </a>
        </div>
    </div>
    <!-- Banner Publicidad End -->

    @if($productosNuevos->count() == 0)
        <!-- PRODUCTOS NORMALES -->
        <div class="arrival-area mt-20px mb-20px">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="section-title">
                            <h2><a href="{{url('/producto/todos')}}" target="_blank">Nuestros Productos</a></h2>
                            <!-- Nav tabs -->
                            <ul class="nav nav-tabs sub-category">
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#">&nbsp;</a>
                                </li>
                            </ul>
                            <!-- Nav tabs -->
                        </div>
                    </div>
                </div>
                <!-- tab content -->
                <div class="tab-content">
                    <!-- First-Tab -->
                    <div id="tab-1" class="tab-pane active fade">
                        <!-- Arrivel slider start -->
                        <div class="arrival-slider-wrapper slider-nav-style-1">

                            @foreach($productosDos as $key => $producto)
                                <div class="slider-single-item">
                                    <!-- Single Item -->
                                    <article class="list-product text-center">
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
                            @endforeach
                        </div>
                        <!-- Arrivel slider end -->
                    </div>
                    <!-- First-Tab -->

                </div>
                <!-- tab content end-->
            </div>
        </div>
        <!-- PRODUCTOS NORMALES End -->
    @else
        <!-- PRODUCTOS NUEVOS -->
        <div class="arrival-area mt-20px mb-20px">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="section-title">
                            <h2><a href="{{url('/producto/nuevos')}}" target="_blank">Nuevos Productos</a></h2>
                            <!-- Nav tabs -->
                            <ul class="nav nav-tabs sub-category">
                                <li class="nav-item">
                                    <a class="nav-link active" data-toggle="tab" href="#">&nbsp;</a>
                                </li>
                            </ul>
                            <!-- Nav tabs -->
                        </div>
                    </div>
                </div>
                <!-- tab content -->
                <div class="tab-content">
                    <!-- First-Tab -->
                    <div id="tab-1" class="tab-pane active fade">
                        <!-- Arrivel slider start -->
                        <div class="arrival-slider-wrapper slider-nav-style-1">

                            @foreach($productosNuevos as $key => $producto)
                                <div class="slider-single-item">
                                    <!-- Single Item -->
                                    <article class="list-product text-center">
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
                                                <li class="new">Nuevo</li>
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
                            @endforeach

                        </div>
                        <!-- Arrivel slider end -->
                    </div>
                    <!-- First-Tab -->

                </div>
                <!-- tab content end-->
            </div>
        </div>
        <!-- PRODUCTOS NUEVOS End -->
    @endif

    <!-- Banner Publicidad tipo 3 -->
    <div class="col-md-12">
        <div id="demo2" class="carousel slide" data-ride="carousel">

            @if($cajas2Publicidad->count() == 0)
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <div class="banner-area mt-50px mb-20px ">
                            <div class="container">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="banner-wrapper">
                                            <a href="#"><img src="images/banner-image/espacio_disponible.jpg" alt="Espacio Disponible" /></a>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="banner-wrapper">
                                            <a href="#"><img src="images/banner-image/espacio_disponible.jpg" alt="Espacio Disponible" /></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <div class="banner-area mt-50px mb-20px ">
                            <div class="container">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="banner-wrapper">
                                            <a href="#"><img src="images/banner-image/espacio_disponible.jpg" alt="Espacio Disponible" /></a>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="banner-wrapper">
                                            <a href="#"><img src="images/banner-image/espacio_disponible.jpg" alt="Espacio Disponible" /></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="carousel-inner">
                    @php
                        $flag2 = true;
                    @endphp
                    @for($i = 0;$i<$cajas2Publicidad->count();$i += 2)
                        <div class="carousel-item @if($flag2) active @endif">
                            <div class="banner-area mt-50px mb-20px ">
                                <div class="container">
                                    <div class="row">
                                        <div class="col-md-6">
                                            @if(isset($cajas2Publicidad[$i]))
                                                <div class="banner-wrapper">
                                                    <a target="_blank" href="{{$cajas2Publicidad[$i]->link_destino}}"><img src="{{asset('storage/uploads/'.$cajas2Publicidad[$i]->imagen)}}" alt="Espacio Disponible" /></a>
                                                </div>
                                            @else
                                                <div class="banner-wrapper">
                                                    <a href="#"><img src="images/banner-image/espacio_disponible.jpg" alt="Espacio Disponible" /></a>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="col-md-6">
                                            @if(isset($cajas2Publicidad[$i+1]))
                                                <div class="banner-wrapper">
                                                    <a target="_blank" href="{{$cajas2Publicidad[$i+1]->link_destino}}"><img src="{{asset('storage/uploads/'.$cajas2Publicidad[$i+1]->imagen)}}" alt="Espacio Disponible" /></a>
                                                </div>
                                            @else
                                                <div class="banner-wrapper">
                                                    <a href="#"><img src="images/banner-image/espacio_disponible.jpg" alt="Espacio Disponible" /></a>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @php
                            $flag2 = false;
                        @endphp
                    @endfor
                </div>
            @endif

            <!-- Left and right controls -->
            <a class="carousel-control-prev" href="#demo2" data-slide="prev">
                <span class="carousel-control-prev-icon" style="background-color: black;"></span>
            </a>
            <a class="carousel-control-next" href="#demo2" data-slide="next">
                <span class="carousel-control-next-icon" style="background-color: black;"></span>
            </a>
        </div>
    </div>
    <!-- Banner Publicidad End -->

    <!--MAS PRODUCTOS-->
    <!-- PRODUCTOS NORMALES -->
    <div class="arrival-area mt-20px mb-20px">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="section-title">
                        <h2><a href="{{url('/producto/todos')}}" target="_blank">Mas Productos</a></h2>
                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs sub-category">
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#">&nbsp;</a>
                            </li>
                        </ul>
                        <!-- Nav tabs -->
                    </div>
                </div>
            </div>
            <!-- tab content -->
            <div class="tab-content">
                <!-- First-Tab -->
                <div id="tab-1" class="tab-pane active fade">
                    <!-- Arrivel slider start -->
                    <div class="arrival-slider-wrapper slider-nav-style-1">

                        @foreach($productos as $key => $producto)
                            <div class="slider-single-item">
                                <!-- Single Item -->
                                <article class="list-product text-center">
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
                        @endforeach
                    </div>
                    <!-- Arrivel slider end -->
                </div>
                <!-- First-Tab -->

            </div>
            <!-- tab content end-->
        </div>
    </div>
    <!-- PRODUCTOS NORMALES End -->
    <!--MAS PRODUCTOS END-->

    <!-- category Area Start -->
    <div class="popular-categories-area popular-categories-area-2  bg-light-gray pt-50px pb-50px">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="section-title">
                        <h2 class="section-heading">Rubros</h2>
                    </div>
                </div>
            </div>
            <div class="popular-category-slider-wrapper slider-nav-style-2">
                @foreach($rubros as $key=>$rubro)
                    <div class="single-slider-item">
                        <div class="thumb-category">
                            <a href="{{url('producto/rubros/'.$rubro->rub_id.'/lista')}}" target="_blank">
                                <img src="{{asset('storage/uploads/'.$rubro->imagen_icono)}}" alt="rubro-image.jpg" />
                            </a>
                        </div>
                        <div class="category-discript">
                            <h4>{{$rubro->nombre}}</h4>
                            <ul>
                                @php
                                    $categorias = $rubro->categoriaRubros->filter(function ($value, $key) {
                                        return $value->nivel == 2;
                                    });
                                    $categorias = $categorias->sortBy('nombre');
                                    if($categorias->count() > $limiteCategoriasRubro){
                                        $categorias = $categorias->random($limiteCategoriasRubro);
                                    }
                                @endphp
                                @foreach($categorias as $key => $categoria)
                                    <li><a target="_blank" href="{{url('producto/categorias/'.$categoria->cat_id.'/lista')}}">{{$categoria->nombre}}</a></li>
                                @endforeach
                            </ul>
                            <a href="{{url('producto/rubros/'.$rubro->rub_id.'/lista')}}" target="_blank" class="view-all-btn">Ver Todos</a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <!-- category Area End -->

@endsection
@section('footer_scripts')

    <script>
        $(document).ready(function(){

        });
    </script>
@stop
