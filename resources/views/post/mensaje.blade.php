@extends('layouts.layout_main')

@section('header_styles')
    <link rel="stylesheet" href="{{asset('css/ol.css')}}" type="text/css">
    <style type="text/css">
        .container-mensaje {
            border: 2px solid #dedede;
            background-color: #f1f1f1;
            border-radius: 5px;
            padding: 10px;
            margin: 10px 0;
        }
        .container-mensaje > p{
            color: black;
        }

        .darker {
            border-color: #ccc;
            background-color: #ddd;
        }

        .container-mensaje::after {
            content: "";
            clear: both;
            display: table;
        }

        .container-mensaje img {
            float: left;
            max-width: 60px;
            width: 100%;
            margin-right: 20px;
            border-radius: 50%;
        }

        .persona-left{
            float: left;
            max-width: 60px;
            width: 100%;
            margin-right: 20px;
            border-radius: 50%;
        }

        .persona-right{
            float: right;
            margin-left: 20px;
            margin-right:0;
            max-width: 60px;
            width: 100%;
            border-radius: 50%;
        }

        .container-mensaje img.right {
            float: right;
            margin-left: 20px;
            margin-right:0;
        }

        .time-right {
            float: right;
            color: #aaa;
            text-align: end;
        }

        .time-left {
            float: left;
            color: #999;
            text-align: start;
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
                            <li>Productor:</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb Area End-->
    <div class="container">
        <button id="btnAgregar" class="btn btn-primary" type="button">agregar</button>
        <button id="btnParar" class="btn btn-danger" type="button">parar</button>
    </div>
    <div class="container" id="contenedorMensajes" style="max-height: 500px;height: 500px;overflow-y: scroll;">
        <div id="divMensajes">
            <div class="container-mensaje">
                <p class="persona-left"><b>Fernando del rincon y castillo</b></p>
                <p>Hello. How are you today?</p>
                <span class="time-right">20/12/2020 11:00 <br> Visto</span>
            </div>

            <div class="container-mensaje darker">
                <p class="persona-right"><b>Persona izquierda</b></p>
                <p>Hey! I'm fine. Thanks for asking!</p>
                <span class="time-left">20/12/2020 11:01 <br> Visto</span>
            </div>

            <div class="container-mensaje">
                <p class="persona-left"><b>Fernando del rincon y castillo</b></p>
                <p>Sweet! So, what do you wanna do today?</p>
                <span class="time-right">20/12/2020 11:02 <br> Visto</span>
            </div>

            <div class="container-mensaje darker">
                <p class="persona-right"><b>Persona izquierda</b></p>
                <p>Nah, I dunno. Play soccer.. or learn more coding perhaps?
                    sssssssssss sssssssssd ddddddddddd ssssssssssss dsdsds sssssssssssss asdfsdf asdfsdfsd asdfasdfas asdfasdfasdf asdfasdfe sddfsdfs
                    sssssssssss sssssssssd ddddddddddd ssssssssssss dsdsds sssssssssssss asdfsdf asdfsdfsd asdfasdfas asdfasdfasdf asdfasdfe sddfsdfs
                    sssssssssss sssssssssd ddddddddddd ssssssssssss dsdsds sssssssssssss asdfsdf asdfsdfsd asdfasdfas asdfasdfasdf asdfasdfe sddfsdfs
                    sssssssssss sssssssssd ddddddddddd ssssssssssss dsdsds sssssssssssss asdfsdf asdfsdfsd asdfasdfas asdfasdfasdf asdfasdfe sddfsdfs
                    sssssssssss sssssssssd ddddddddddd ssssssssssss dsdsds sssssssssssss asdfsdf asdfsdfsd asdfasdfas asdfasdfasdf asdfasdfe sddfsdfs
                </p>
                <span class="time-left">20/12/2020 11:05 <br> Enviado</span>
            </div>
        </div>
        <div class="row">
            <div class="col-md-1"></div>
            <div class="col-md-8">
                <textarea class="form-control" placeholder="escriba su mensaje" rows="1"></textarea>
            </div>
            <div class="col-md-2">
                <button class="btn btn-sm btn-primary">Enviar</button>
            </div>
        </div>
    </div>

@endsection
@section('footer_scripts')

    <script>
        var tiempoRecarga = 10000;
        var tiempo;
        $(document).ready(function(){
            //$("#div-comentarios").scroll
            //el scroll de comentarios hacia abajo
            //$("#div-comentarios").animate({ scrollTop: $('#div-comentarios').height()}, 1000);
            //el scroll de comentarios hacia arriba
            //$("#div-comentarios").animate({ scrollTop: 0}, 1000);
            $("#contenedorMensajes").animate({ scrollTop: ($('#divMensajes').height()+100)}, 200);

            $("#btnAgregar").click(function (){
                cargarMensajes();
            });

            $("#btnParar").click(function (){
                clearInterval(tiempo);
            });

            empezarMensajes();

        });

        function empezarMensajes(){
            tiempo = setInterval(cargarMensajes,tiempoRecarga);
        }

        function cargarMensajes(){
            var scrollPosicionActual = $("#contenedorMensajes").scrollTop() + $('#contenedorMensajes').height();
            var tamanioDivMensajes  = $('#divMensajes').height() + 74;
            var banderaScroll = true;
            console.log(scrollPosicionActual+' '+tamanioDivMensajes);
            if(scrollPosicionActual < tamanioDivMensajes){
                banderaScroll = false;
            }
            console.log(banderaScroll);

            $.ajax({
                url : '{{url("_mensaje")}}',
                data : {
                },
                type : 'POST',
                success : function(resp) {
                    //console.log(resp);
                    $("#divMensajes").append(resp);

                },
                error : function(xhr, status) {
                    toastr.error('no se pudo cargar mas mensajes','');
                    clearInterval(tiempo);
                    empezarMensajes();
                },
                complete : function(xhr, status) {
                    if(banderaScroll){
                        $("#contenedorMensajes").animate({ scrollTop: $('#divMensajes').height()}, 200);
                    }
                }
            });
        }

    </script>
@stop
