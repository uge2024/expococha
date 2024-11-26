<!DOCTYPE html>
<html class="no-js" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-NQYPCDQ8R9"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'G-NQYPCDQ8R9');
    </script>
    <!--INJECTIONS CLASE PARA DATOS DE LA PAGINA, CARRITO Y MENSAJES-->
    @inject('carrito','App\Injection\Carrito')
    @php
        $datosPagina = $carrito->getDatosPagina();
        $totalCarrito = $carrito->cantidadCarrito();
        $totalMensajes = $carrito->cantidadMensajesSinLeer();
    @endphp

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="robots" content="all" />
    @isset($datosPagina->nombre)
        <title>{{$datosPagina->nombre}}</title>
    @else
        <title>{{ config('app.name', 'Laravel') }}</title>
    @endisset
    @isset($datosPagina->descripcion)
        <meta name="description" content="{{$datosPagina->descripcion}}" />
    @endisset

    <meta name="author" content="Gobernación de Cochabamba">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    @yield('header_metas')

    <!-- Favicon -->
    {{--<link rel="shortcut icon" type="image/x-icon" href="{{asset('images/favicon/favicon.png')}}" />--}}
    <link rel="shortcut icon" type="image/png" href="{{ asset('images/favicon.png') }}">

    <!-- Google Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Muli:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&amp;display=swap" type="text/css" media="all">

    <!-- CSS
    ============================================ -->

    <!-- Vendor CSS (Bootstrap & Icon Font) -->
    {{--<link rel="stylesheet" href="{{asset('css/vendor/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/vendor/ionicons.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/vendor/linearicon.css')}}">
    <link rel="stylesheet" href="{{asset('css/vendor/sofiaPro.css')}}">
    <link rel="stylesheet" href="{{asset('css/vendor/font-awesome.min.css')}}">--}}

    <!-- Plugins CSS (All Plugins Files) -->
    {{--<link rel="stylesheet" href="{{asset('css/plugins/animate.css')}}">
    <link rel="stylesheet" href="{{asset('css/plugins/jquery-ui.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/plugins/slick.css')}}">--}}

    <!-- Use the minified version files listed below for better performance and remove the files listed above -->
    <link rel="stylesheet" href="{{asset('css/vendor/vendor.min.css')}}" />
    <link rel="stylesheet" href="{{asset('css/plugins/plugins.min.css')}}" />
    <link rel="stylesheet" href="{{asset('css/style.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/jquery-confirm.min.css')}}" type='text/css'>
    <link rel="stylesheet" href="{{asset('css/toastr.min.css')}}" type="text/css">
    <link rel="stylesheet" href="{{asset('css/bootstrap-datepicker3.min.css')}}" type="text/css">

    <!-- Main Style CSS -->
    {{--<link rel="stylesheet" href="{{asset('css/style.css')}}" />--}}

    <style rel="stylesheet">
        :root {
            --cantidadcarrito: "{{$totalCarrito}}";
            --cantidadmensajes: "{{$totalMensajes}}";
        }
        .header-tools .cart-info .carrito::before {
            width: 30px;
            height: 20px;
            {{--content: "{{$totalCarrito}}";--}}
            content: var(--cantidadcarrito);
        }
        .header-tools .cart-info .mensajes::before {
            width: 30px;
            height: 20px;
            {{--content: "{{$totalMensajes}}";--}}
            content: var(--cantidadmensajes);
        }

        .shop-list-wrap .list-product .product-decs{
            padding-left: 4px;
        }

        .breadcrumb-area{
            padding: 10px;
        }
        .btn{
            margin: 1px;
        }
        .slider-area .bg-img::after{
            background: none;
        }
        .slider-area .bg-img{
            background-size: 100% 100%;
            background-repeat: no-repeat;
        }
    </style>

    @yield('header_styles')
</head>

<body>
    <!-- Header Section Start From Here -->
    <header class="header-wrapper">
        {{--@include('layouts.header')--}}
        {{--@include('layouts.header_buscar')--}}

        <x-header :datospagina="$datosPagina"/>

        <!--Mensaje de validacion de correo electronico-->
        @guest
        @else
            @if(Auth::user()->correo_validado == 0)
                <div class="alert alert-warning text-center" role="alert">
                    Por favor verifique su correo electrónico, se le envió un correo para que pueda verificar su correo,
                    si no lo recibió puede enviar un nuevo correo haciendo clic al siguiente enlace:<br>
                    <a style="text-decoration: underline;" href="#" onclick="event.preventDefault(); enviarCorreoValidacion();" class="alert-link">Reenviar Link de Verificación de Correo</a>
                </div>
            @endif
        @endguest
        <!--END Mensaje de validacion de correo electronico-->

        @if(!empty($noMostrarHeaderBuscar))

        @else
            <x-header-buscar/>
        @endif
    </header>
    <!-- Header Section End Here -->


    @if(!empty($noMostrarHeaderBuscar))
        @php
            $nomostrarbuscar = 1;
        @endphp
        <x-header-buscar-movil :nomostrarheaderbuscar="$nomostrarbuscar" :datospagina="$datosPagina"/>
    @else
        @php
            $nomostrarbuscar = 0;
        @endphp
        <x-header-buscar-movil :nomostrarheaderbuscar="$nomostrarbuscar" :datospagina="$datosPagina"/>
    @endif


    <x-menu-lateral-movil :datospagina="$datosPagina"/>

    <div class="offcanvas-overlay"></div>




    @yield('content')






    {{--<x-footer-paginas/>--}}

    <x-footer :datospagina="$datosPagina"/>






    <!-- JS
    ============================================ -->

    <!-- Vendors JS -->
    {{--<script src="{{asset('js/vendor/jquery-3.5.1.min.js')}}"></script>
    <script src="{{asset('js/vendor/bootstrap.bundle.min.js')}}"></script>
    <script src="{{asset('js/vendor/jquery-migrate-3.3.0.min.js')}}"></script>
    <script src="{{asset('js/vendor/modernizr-3.7.1.min.js')}}"></script>--}}

    <!-- Plugins JS -->
    {{--<script src="{{asset('js/plugins/jquery-ui.min.js')}}"></script>
    <script src="{{asset('js/plugins/slick.js')}}"></script>
    <script src="{{asset('js/plugins/countdown.js')}}"></script>
    <script src="{{asset('js/plugins/scrollup.js')}}"></script>
    <script src="{{asset('js/plugins/elevateZoom.js')}}"></script>--}}

    <!-- Use the minified version files listed below for better performance and remove the files listed above -->
    <script src="{{asset('js/vendor/vendor.min.js')}}"></script>
    <script src="{{asset('js/plugins/plugins.min.js')}}"></script>


    <!-- Main Activation JS -->
    <script src="{{asset('js/main.js')}}"></script>

    <script type="text/javascript" src="{{ asset('js/jquery-confirm.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/toastr.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/jquery.numeric.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/bootstrap-datepicker.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/bootstrap-datepicker.es.min.js') }}"></script>

    <script type="text/javascript" src="{{asset('js/util.js')}}"></script>

    <!--Mensaje toastr-->
    {!! Toastr::message() !!}

    <!-- Section para agregar csrf token a todas las llamadas ajax de jquery -->
    <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $(function(){
            if (!$.fn.bootstrapDP && $.fn.datepicker && $.fn.datepicker.noConflict) {
                var datepicker = $.fn.datepicker.noConflict();
                $.fn.bootstrapDP = datepicker;
            }
        });
    </script>
    <!-- Envio email confirmation -->
    <script>
        $(document).ready(function (){

        });
        function enviarCorreoValidacion(){
            console.log('envio de correo de validacion');
            loaderR.showPleaseWait();
            $.ajax({
                url : '{{route("register.sendverification")}}',
                data : {},
                type : 'POST',
                success : function(resp) {
                    console.log(resp);
                    if(resp.res == true)
                    {
                        console.log('todo bien');
                        toastr.success('Link de verificación enviado.','');
                        //location.reload(true);
                    }
                    else
                    {
                        console.log('error '+resp.mensaje);
                        toastr.error('No se pudo enviar el link de verificación.','');
                    }

                },
                error : function(xhr, status) {
                    alert('Disculpe, existió un problema');
                },
                complete : function(xhr, status) {
                    loaderR.hidePleaseWait();
                }
            });
        }
        //control para el submenu de la version movil
        function cambiarEstadoMenuMovil(elemento){
            console.log('eledd'+elemento);
            $(elemento).slideToggle("slow");
        }
        //Agregar producto a mi carrito
        function agregarProductoCarrito(prd_id)
        {
            //console.log('se agrega el producto'+prd_id);
            var cantidad = $("#cantidad_compra").val();
            var datos = {};
            if (cantidad !== undefined){
                if (cantidad != ''){
                    datos = {
                        prd_id:prd_id,
                        cantidad:cantidad
                    }
                }
            }else{
                datos = {
                    prd_id:prd_id
                }
            }
            //console.log('prd_id '+prd_id + ' cantidad '+cantidad+' datos ');
            //console.log(datos);
            loaderR.showPleaseWait();
            $.ajax({
                url : '{{url("carrito/_agregarACarrito")}}',
                data : datos,
                type : 'POST',
                success : function(resp) {
                    console.log(resp);
                    if(resp.res == true){
                        //actualizamos la cantidad
                        var cantidadc = ''+resp.cantidad+'';
                        document.documentElement.style.setProperty('--cantidadcarrito', "\'"+cantidadc+"\'");
                        toastr.success(resp.mensaje,'');
                    }else{
                        toastr.warning(resp.mensaje,'');
                        setTimeout(function () {
                            window.open("{{url("login")}}",'_self');
                        }, 3000);
                    }
                },
                error : function(xhr, status) {
                    toastr.error('No se pudo agregar el producto al carrito.','');
                },
                complete : function(xhr, status) {
                    loaderR.hidePleaseWait();
                }
            });

        }


    </script>
    @auth
        <script>
            //control de revision
            $(document).ready(function (){
                empezarcomprobarestados();
            });
            var tiempoRecargaEstado = 30000;
            var tiempoEstado;
            var cantidadMensajesInicial = {{ $totalMensajes?: 0 }};

            function empezarcomprobarestados(){
                tiempoEstado = setInterval(comprobarestados,tiempoRecargaEstado);
            }

            function detenercomprobarestados(){
                clearInterval(tiempoEstado);
            }

            function comprobarestados(){

                detenercomprobarestados();
                $.ajax({
                    url : '{{url("checkstates")}}',
                    data : {},
                    type : 'POST',
                    success : function(resp) {

                        if(resp.res == true){
                            var cantidadUpdateCarrito = ''+resp.cantidadcarrito+'';
                            var cantidadUpdateMensaje = ''+resp.cantidadmensajes+'';
                            if(cantidadMensajesInicial != cantidadUpdateMensaje && cantidadUpdateMensaje != 0){
                                toastr.warning('!Tiene un nuevo mensaje en su bandeja¡','');
                            }
                            if(cantidadMensajesInicial != cantidadUpdateMensaje){
                                cantidadMensajesInicial = cantidadUpdateMensaje;
                            }

                            document.documentElement.style.setProperty('--cantidadcarrito', "\'"+cantidadUpdateCarrito+"\'");
                            document.documentElement.style.setProperty('--cantidadmensajes', "\'"+cantidadUpdateMensaje+"\'");

                        }else{
                            toastr.error('Conexión perdida, revise su internet por favor.','');
                        }

                    },
                    error : function(xhr, status) {
                        toastr.error('Conexión perdida, revise su internet por favor.','');
                    },
                    complete : function(xhr, status) {
                        empezarcomprobarestados();
                        console.log('dos');
                    }
                });

            }
        </script>
    @endauth
@yield('footer_scripts')
</body>
</html>

