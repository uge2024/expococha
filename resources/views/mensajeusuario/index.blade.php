@extends('layouts.layout_main',['noMostrarHeaderBuscar'=>'1'])

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
                            <li>Mensajes</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb Area End-->
    <h3 align="center">Mis Mensajes</h3>
    <div class="col-md-12 row">
        <div class="col-md-1"></div>
        <div class="col-md-10" style="max-height: 600px;height: 600px;overflow-y: scroll;">
            @if($usuarios->count() == 0)
                <div class="empty-text-contant text-center">
                    <i class="lnr lnr-alarm"></i>
                    <h1>No tiene ninguna conversación.</h1>
                </div>
            @else
                <div class="list-group">
                    @php
                        $indice = 1;
                    @endphp
                    @foreach($usuarios as $usuario)
                        @if($usuario->rol == 2)
                            @foreach($usuario->productores as $productor)
                                @if($usuario->esrecivido == 1)
                                    <a href="{{url('mensajes/chat/'.$usuario->id)}}" class="list-group-item list-group-item-action">
                                        <div class="row">
                                            <div class="col-md-8">
                                                <b>{{$indice++}}) Productor:</b> {{$productor->nombre_tienda}} - ({{$usuario->name}})
                                            </div>
                                            <div class="col-md-4 text-lg-right">
                                                @if($usuario->esvisto == 0)
                                                    <span class="badge badge-primary badge-pill">Sin Leer</span>
                                                @else
                                                    <br>
                                                @endif
                                                <p>Enviado el: {{date('d/m/Y H:i:s',strtotime($usuario->fechaenvio))}}</p>
                                            </div>
                                        </div>
                                    </a>
                                @else
                                    <a href="{{url('mensajes/chat/'.$usuario->id)}}" class="list-group-item list-group-item-action">
                                        <div class="row">
                                            <div class="col-md-8">
                                                <b>{{$indice++}}) Productor:</b> {{$productor->nombre_tienda}} - ({{$usuario->name}})
                                            </div>
                                            <div class="col-md-4 text-lg-right">
                                                <br>
                                                <p>Enviado el: {{date('d/m/Y H:i:s',strtotime($usuario->fechaenvio))}} </p>
                                            </div>
                                        </div>
                                    </a>
                                @endif
                            @endforeach
                        @elseif($usuario->rol == 3)
                            @if($usuario->esrecivido == 1)
                                <a href="{{url('mensajes/chat/'.$usuario->id)}}" class="list-group-item list-group-item-action">
                                    <div class="row">
                                        <div class="col-md-8">
                                            <b>{{$indice++}}) Administrador:</b> {{$usuario->name}}
                                        </div>
                                        <div class="col-md-4 text-lg-right">
                                            @if($usuario->esvisto == 0)
                                                <span class="badge badge-primary badge-pill">Sin Leer</span>
                                            @else
                                                <br>
                                            @endif
                                            <p>Enviado el: {{date('d/m/Y H:i:s',strtotime($usuario->fechaenvio))}}</p>
                                        </div>
                                    </div>
                                </a>
                            @else
                                <a href="{{url('mensajes/chat/'.$usuario->id)}}" class="list-group-item list-group-item-action">
                                    <div class="row">
                                        <div class="col-md-8">
                                            <b>{{$indice++}}) Administrador:</b> {{$usuario->name}}
                                        </div>
                                        <div class="col-md-4 text-lg-right">
                                            <br>
                                            <p>Enviado el: {{date('d/m/Y H:i:s',strtotime($usuario->fechaenvio))}}</p>
                                        </div>
                                    </div>
                                </a>
                            @endif
                        @else
                            @if($usuario->esrecivido == 1)
                                <a href="{{url('mensajes/chat/'.$usuario->id)}}" class="list-group-item list-group-item-action">
                                    <div class="row">
                                        <div class="col-md-8">
                                            <b>{{$indice++}}) </b>{{$usuario->name}}
                                        </div>
                                        <div class="col-md-4 text-lg-right">
                                            @if($usuario->esvisto == 0)
                                                <span class="badge badge-primary badge-pill">Sin Leer</span>
                                            @else
                                                <br>
                                            @endif
                                            <p>Enviado el: {{date('d/m/Y H:i:s',strtotime($usuario->fechaenvio))}}</p>
                                        </div>
                                    </div>
                                </a>
                            @else
                                <a href="{{url('mensajes/chat/'.$usuario->id)}}" class="list-group-item list-group-item-action">
                                    <div class="row">
                                        <div class="col-md-8">
                                            <b>{{$indice++}}) </b>{{$usuario->name}}
                                        </div>
                                        <div class="col-md-4 text-lg-right">
                                            <br>
                                            <p>Enviado el: {{date('d/m/Y H:i:s',strtotime($usuario->fechaenvio))}}</p>
                                        </div>
                                    </div>
                                </a>
                            @endif
                        @endif
                    @endforeach
                </div>
            @endif
        </div>
        <div class="col-md-1"></div>
    </div>

@endsection

@section('footer_scripts')
    <script type="text/javascript">

        $(document).ready(function(){
        });



    </script>
@endsection
