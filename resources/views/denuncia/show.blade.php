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
                            <li>Denuncia</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb Area End-->
    <div class="row justify-content-center">

        <div class="col-md-7">
                <h3 align="center">Denuncia</h3>
            <br>
            <form class="form-horizontal" id="formulario" autocomplete="off" method="POST" enctype="multipart/form-data" action="{{ url('denuncia/store') }}">
                {{ csrf_field() }}

                <div class="form-group row">
                    <label class="col-md-3 col-form-label text-right">Usuario:</label>
                    <div class="col-md-9">
                        {{Form::hidden('estado',$denuncia->estado)}}
                        <input type="text" value="{{$correo_usuario}}" class="form-control form-control-sm"  name="correo_usuario" id="correo_usuario" disabled="">
                    </div>
                </div>

                @if ($nombre_tienda == '0') @endif
                @if ($nombre_tienda != '0')
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label text-right">Productor:</label>
                        <div class="col-md-9">
                            <p class="form-control ">{{$nombre_tienda}}</p>
                        </div>
                    </div>
                @endif
                @if ($nombre_producto == '0') @endif
                @if ($nombre_producto != '0')
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label text-right">Producto:</label>
                        <div class="col-md-9">
                            <p class="form-control form-control-sm">{{$nombre_producto}}</p>
                        </div>
                    </div>
                @endif

                @if ($nombre_producto_feria == '0') @endif
                @if ($nombre_producto_feria != '0')
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label text-right">Producto feria:</label>
                        <div class="col-md-9">
                            <p class="form-control form-control-sm">{{$nombre_producto_feria}}</p>
                        </div>
                    </div>
                @endif

                <div class="form-group row">
                    <label class="col-md-3 col-form-label text-right">Denuncia:</label>
                    <div class="col-md-9">
                        <textarea rows="6" cols="40"   type="text"  class="form-control form-control-sm" name="denuncia" id="denuncia" disabled >{{ old('denuncia',$denuncia->denuncia) }}</textarea>
                    </div>
                </div>

                <div class="row justify-content-center" style="margin-top: 10px;">
                    <div class="col-md-3"></div>
                    <div class="col-md-3">
                        <a href="{{ url('denuncia/') }}" class="btn btn-primary btn-lg">Atras</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('footer_scripts')
    <script type="text/javascript">
        $(document).ready(function(){
            $("#formulario").submit(function (){
                loaderR.showPleaseWait();
            });
        });
    </script>
@endsection
