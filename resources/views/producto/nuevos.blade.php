
@extends('layouts.layout_main')

@section('header_styles')
    <style rel="stylesheet">

    </style>
@endsection

@section('content')

    <!-- Shop Category Area Start -->
    <div class="shop-category-area mt-30px">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <!-- Shop Top Area Start -->
                    <form action="{{url('producto/nuevos')}}" id="formOrdenar" method="get">
                        <div class="shop-top-bar d-flex">
                            <!-- Left Side start -->
                            <div class="shop-tab nav d-flex">
                                <a class="active"  href="#shop-1" data-toggle="tab">
                                    <i class="fa fa-th"></i>
                                </a>
                                <a href="#shop-2" data-toggle="tab">
                                    <i class="fa fa-list"></i>
                                </a>
                                <p>Hay {{$productos->total()}} Productos.</p>
                            </div>
                            <!-- Left Side End -->
                            <!-- Right Side Start -->
                            <div class="select-shoing-wrap d-flex">
                                <div class="shot-product">
                                    <p>Ordenar Por:</p>
                                </div>
                                <div class="shop-select">
                                    {{
                                        Form::select('sort',[1=>'Nombre de Productos (A a Z)',2=>'Precio',3=>'Puntuación'],$sort,  ['onchange' => 'this.form.submit();','id' => 'sort'])
                                    }}
                                </div>
                            </div>
                            <!-- Right Side End -->
                        </div>
                    </form>
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
                            <!-- Tab Two Start -->
                            <div id="shop-2" class="tab-pane">

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
                                        <div class="shop-list-wrap mb-30px scroll-zoom">
                                            <div class="slider-single-item">
                                                <div class="row list-product m-0px">
                                                    <div class="col-md-12 padding-0px product-inner">
                                                        <div class="row">
                                                            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 p-0">
                                                                <div class="left-img">
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
                                                                        <ul class="product-flag">
                                                                            <li class="new">-{{$producto->descuento}}%</li>
                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8 p-0">
                                                                <div class="product-desc-wrap">
                                                                    <div class="product-decs">
                                                                        <h2><a target="_blank" href="{{url('producto/ver/'.$producto->prd_id)}}" class="product-link">{{$producto->nombre_producto}}</a></h2>
                                                                        <a class="inner-link" target="_blank" href="{{url('productor/tienda/'.$producto->pro_id)}}"><span>{{$producto->productor->nombre_tienda}}</span></a>
                                                                        <div class="product-intro-info">
                                                                            <p>{{$producto->descripcion1}}</p>
                                                                        </div>
                                                                    </div>
                                                                    <div class="box-inner d-flex">
                                                                        <div class="align-self-center">
                                                                            <div class="in-stock">Disponibles: <span>{{$producto->existencia}} en Stock</span></div>
                                                                            <div class="pricing-meta">
                                                                                <ul>
                                                                                    <li class="old-price">Bs.{{$producto->precio}}</li>
                                                                                    <li class="current-price">Bs.{{$producto->precio_oferta}}</li>
                                                                                </ul>
                                                                            </div>
                                                                            <div class="cart-btn">
                                                                                <a href="#" onclick="event.preventDefault();agregarProductoCarrito('{{$producto->prd_id}}');" class="add-to-curt" title="Agregar a mi Carrito">Agregar a mi Carrito</a>
                                                                            </div>
                                                                            <div class="add-to-link">
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
                                    @else
                                        <div class="shop-list-wrap mb-30px scroll-zoom">
                                            <div class="slider-single-item">
                                                <div class="row list-product m-0px">
                                                    <div class="col-md-12 padding-0px product-inner">
                                                        <div class="row">
                                                            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 p-0">
                                                                <div class="left-img">
                                                                    <div class="img-block">
                                                                        <a href="{{url('producto/ver/'.$producto->prd_id)}}" class="thumbnail">
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
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8 p-0">
                                                                <div class="product-desc-wrap">
                                                                    <div class="product-decs">
                                                                        <h2><a href="{{url('producto/ver/'.$producto->prd_id)}}" class="product-link">{{$producto->nombre_producto}}</a></h2>
                                                                        <a class="inner-link" href="{{url('productor/tienda/'.$producto->pro_id)}}"><span>{{$producto->productor->nombre_tienda}}</span></a>
                                                                        <div class="product-intro-info">
                                                                            <p>{{$producto->descripcion1}}</p>
                                                                        </div>
                                                                    </div>
                                                                    <div class="box-inner d-flex">
                                                                        <div class="align-self-center">
                                                                            <div class="in-stock">Disponibles: <span>{{$producto->existencia}} en Stock</span></div>
                                                                            <div class="pricing-meta">
                                                                                <ul>
                                                                                    <li class="current-price">Bs.{{$producto->precio}}</li>
                                                                                </ul>
                                                                            </div>
                                                                            <div class="cart-btn">
                                                                                <a href="#" onclick="event.preventDefault();agregarProductoCarrito('{{$producto->prd_id}}');" class="add-to-curt" title="Agregar a mi Carrito">Agregar a mi Carrito</a>
                                                                            </div>
                                                                            <div class="add-to-link">
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
                                    @endif
                                @endforeach

                            </div>
                            <!-- Tab Two End -->
                        </div>
                        <!-- Shop Tab Content End -->
                        <!--  Pagination Area Start -->
                        <div class="d-flex justify-content-center">
                            {{ $productos->appends(['sort'=>$sort])->links() }}
                        </div>
                        <!--  Pagination Area End -->
                    </div>
                    <!-- Shop Bottom Area End -->
                </div>
            </div>
        </div>
    </div>
    <!-- Shop Category Area End -->

@endsection
@section('footer_scripts')

    <script>
        $(document).ready(function(){

        });
    </script>
@stop
