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
        $feriaMeta = preg_replace('/\s+/', ', ', $feria->nombre);
    @endphp
    <meta name="keywords" content="{{$feria->nombre}}">
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
                            <li>{{$feria->nombre}}</li>
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
            @foreach($feria->imagenFerias as $key => $baner)
                @if($baner->tipo == 1 && $baner->estado == 'AC')
                    <!-- Single Slider  -->
                        <div class="single-slide slider-height-3 bg-img d-flex" data-bg-image="{{asset('storage/uploads/'.$baner->imagen)}}">
                            <div class="container align-self-center">
                                <div class="slider-content-1 slider-animated-1 text-left">
                                    <h1 class="animated color-black">
                                        {{$feria->nombre}}
                                    </h1>
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
                            @foreach($feria->imagenFerias as $key => $baner)
                                @if($baner->tipo == 20 && $baner->estado == 'AC')
                                    <img src="{{asset('storage/uploads/'.$baner->imagen)}}" alt="Imagen no Encontrada" class="img-responsive" />
                                @endif
                            @endforeach
                        </div>
                        <div class="footer-social-icon d-flex">
                            <div class="heading-info div-titulo-redes">Información:</div>
                            <div class="social-icon">
                                <ul>

                                </ul>
                            </div>
                        </div>



                    </div>
                    <div class="col-lg-6">
                        <div class="about-content">
                            <div class="about-title">
                                <h2>{{$feria->nombre}}</h2>
                            </div>
                            <p class="mb-30px">
                                {{$feria->descripcion}}
                            </p>
                            @isset($feria->direccion)
                                <p><b>Dirección:</b> {{$feria->direccion}}</p>
                            @endisset
                            @isset($feria->lugar)
                                <p><b>Lugar:</b> {{$feria->lugar}}</p>
                            @endisset
                        </div>
                        <div class="footer-social-icon d-flex">
                            <div class="heading-info div-titulo-redes">Compartir por:</div>
                            <div class="social-icon">
                                <ul>
                                    <li class="facebook clasefacebook">
                                        <a href="#" title="Compartir por Facebook" onclick="event.preventDefault();compartirPorFacebook('{{url('feriavirtual/ver/'.$feria->fev_id)}}');"><i class="ion-social-facebook"></i></a>
                                    </li>
                                    <li class="clasewhatsapp">
                                        <a href="#" title="Compartir por Whatsapp" onclick="event.preventDefault();compartirPorWhatsapp('{{url('feriavirtual/ver/'.$feria->fev_id)}}');"><i class="ion-social-whatsapp"></i></a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- About Area End -->

        <!--MAPA-->
        <h4>Dirección:</h4>
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

                                <p>Productos de la feria: Total {{$productos->count()}} productos</p>
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
                                            <div class="mb-30px col-md-4 col-lg-3 col-sm-6  p-0">
                                                <div class="slider-single-item">
                                                    <!-- Single Item -->
                                                    <article class="list-product p-0 text-center">
                                                        <div class="product-inner">
                                                            <div class="img-block">
                                                                <a href="{{url('feriavirtual/verproducto/'.$producto->fpr_id)}}" target="_blank" class="thumbnail">
                                                                    @php
                                                                        $contador = 1;
                                                                    @endphp
                                                                    @foreach($producto->imagenesFeriaProductos as $key => $imagen)
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
                                                                <h2><a target="_blank" href="{{url('feriavirtual/verproducto/'.$producto->fpr_id)}}" class="product-link">{{$producto->nombre_producto}}</a></h2>
                                                                <div class="pricing-meta">
                                                                    <ul>
                                                                        <li class="current-price">Bs.{{$producto->precio}}</li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                            <div class="cart-btn">

                                                            </div>
                                                        </div>
                                                    </article>
                                                    <!-- Single Item -->
                                                </div>
                                            </div>
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





    </div>

@endsection
@section('footer_scripts')
    <script type="text/javascript" src="{{asset('js/ol.js')}}"></script>
    <script>
        var latitud = {{$feria->latitud}};
        var longitud = {{$feria->longitud}};
        var direccion = '{{$feria->direccion}}';
        var zoom = {{$zoom ?? 18}};
        $(document).ready(function(){


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


        });

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


    </script>
@stop
