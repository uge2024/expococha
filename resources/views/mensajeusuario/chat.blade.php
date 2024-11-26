@extends('layouts.layout_main',['noMostrarHeaderBuscar'=>'1'])

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
            max-width: 100px;
            width: 100%;
            margin-right: 20px;
            border-right: 1px solid black;
            /*border-radius: 50%;*/
        }

        .persona-right{
            float: right;
            margin-left: 30px;
            padding-left: 5px;
            max-width: 100px;
            width: 100%;
            border-left: 1px solid black;
            /*border-radius: 50%;*/
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
            font-size: 10px;
        }

        .time-left {
            float: left;
            color: #999;
            text-align: start;
            font-size: 10px;
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
                            <li><a href="{{url('/mensajes')}}">Mensajes</a></li>
                            <li>Chat: Con {{$usuarioRemitente->name}} </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb Area End-->
    <div class="container" id="contenedorMensajes" style="max-height: 400px;height: 400px;overflow-y: scroll;margin-top: 15px;background-color: #c1f5f2;">
        <div id="divMensajes">
            @php
                $meu_id = 0;
            @endphp
            @foreach($mensajes as $key=>$mensaje)
                @php
                    $meu_id = $mensaje->meu_id;
                @endphp
                @if($mensaje->usr_id_r == $user->id)
                    <div class="container-mensaje" id="divmen-{{$mensaje->meu_id}}">
                        <p class="persona-left"><b>{{$mensaje->usuarioEnvia->name}}</b></p>
                        <p>{{$mensaje->mensaje}}</p>
                        <span class="time-right">{{date('d/m/Y H:i:s',strtotime($mensaje->fecha))}}
                            <br>
                            {{--<p id="visto-{{$mensaje->meu_id}}">Visto</p>--}}
                        </span>
                    </div>
                @else
                    <div class="container-mensaje darker" id="divmen-{{$mensaje->meu_id}}">
                        <p class="persona-right"><b>{{$mensaje->usuarioEnvia->name}}</b></p>
                        <p class="text-lg-right">{{$mensaje->mensaje}}</p>
                        <span class="time-left">{{date('d/m/Y H:i:s',strtotime($mensaje->fecha))}}
                            <br>
                            @if($mensaje->visto == 0)
                                <p class="miclasevisto" id="visto-{{$mensaje->meu_id}}">Enviado</p>
                            @else
                                <p class="miclasevisto" id="visto-{{$mensaje->meu_id}}">Visto</p>
                            @endif
                        </span>
                    </div>
                @endif
            @endforeach

        </div>
    </div>
    <div class="container" style="background-color: #c1f5f2;padding: 4px;">
        <form action="#" id="formMensaje">
            <div class="row">
                <div class="col-md-1"></div>
                <div class="col-md-8">
                    <input type="hidden" id="meu_id" value="{{$meu_id}}">
                    <input type="hidden" id="usr_id_r" value="{{$usr_id_r}}">
                    <textarea class="form-control" id="mensaje" placeholder="Escriba su mensaje" rows="1"></textarea>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-sm btn-primary" id="btnEnviar">Enviar</button>
                </div>
            </div>
        </form>
    </div>

@endsection
@section('footer_scripts')

    <script>
        var tiempoRecarga = 10000;
        var tiempo;
        $(document).keypress(
            function(event){
                if (event.which == '13') {
                    event.preventDefault();
                    enviarMensaje();
                }
            });
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

            $("#formMensaje").submit(function (event) {
                event.preventDefault();
                console.log('llego');
                enviarMensaje();
            })

        });

        function empezarMensajes(){
            tiempo = setInterval(cargarMensajes,tiempoRecarga);
        }

        function cargarMensajes(){
            var scrollPosicionActual = $("#contenedorMensajes").scrollTop() + $('#contenedorMensajes').height();
            var tamanioDivMensajes  = $('#divMensajes').height() + 15;
            var banderaScroll = true;
            //console.log(scrollPosicionActual+' '+tamanioDivMensajes);
            if(scrollPosicionActual < tamanioDivMensajes){
                banderaScroll = false;
            }
            console.log(banderaScroll);
            var usr_id = $("#usr_id_r").val();
            var meu_id = $("#meu_id").val();
            clearInterval(tiempo);
            $.ajax({
                url : '{{url("mensajes/_chat")}}',
                data : {
                    usr_id:usr_id,
                    meu_id:meu_id
                },
                type : 'POST',
                success : function(resp) {
                    //console.log(resp);
                    if(resp.res == true){
                        $("#meu_id").val(resp.meu_id);
                        $("#divMensajes").append(resp.html);
                        actualizarMisMensajesEnviados(resp.ultimovisto);
                        //empezarMensajes();
                    }else{
                        toastr.error('no se pudo cargar mas mensajes','');
                        //clearInterval(tiempo);
                        //empezarMensajes();
                    }


                },
                error : function(xhr, status) {
                    toastr.error('no se pudo cargar mas mensajes','');
                    //clearInterval(tiempo);
                    //empezarMensajes();
                },
                complete : function(xhr, status) {
                    if(banderaScroll){
                        $("#contenedorMensajes").animate({ scrollTop: $('#divMensajes').height()}, 200);
                    }
                    empezarMensajes();
                }
            });
        }

        function enviarMensaje(){
            var usr_id_r = $("#usr_id_r").val();
            var mensaje = $("#mensaje").val();
            if (mensaje!=''){
                if(!mensaje.trim().length){

                }else{
                    $.ajax({
                        url : '{{url("mensajes/store")}}',
                        data : {
                            usr_id_r:usr_id_r,
                            mensaje:mensaje
                        },
                        type : 'POST',
                        success : function(resp) {
                            //console.log(resp);
                            if(resp.res == true){

                            }else{
                                toastr.error('no se pudo enviar su mensaje','');

                            }

                        },
                        error : function(xhr, status) {
                            toastr.error('no se pudo enviar su mensaje','');
                        },
                        complete : function(xhr, status) {
                            $("#mensaje").val('');
                            cargarMensajes();
                        }
                    });
                }
            }
        }

        function actualizarMisMensajesEnviados(estadoVistoUltimoMensaje)
        {
            console.log('llego  '+estadoVistoUltimoMensaje);
            var all = $(".miclasevisto").map(function() {
                return this;
            }).get();
            //console.log(all);
            all.forEach(function callback(currentValue, index, array) {
                //console.log(currentValue.id);
                var texto = $("#"+currentValue.id).text();
                if(texto=='Visto'){
                    //console.log('es visto '+currentValue.id);
                }else{
                    //console.log('no es visto '+currentValue.id);
                    if (estadoVistoUltimoMensaje == 1){
                        $("#"+currentValue.id).text('Visto');
                    }
                }
            });
        }

    </script>
@stop
