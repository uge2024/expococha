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

        <div class="col-md-5">
                <h3 align="center">Nueva Denuncia</h3>
            <br>
            <form class="form-horizontal" id="formulario" autocomplete="off" method="POST" enctype="multipart/form-data" action="{{ url('denuncia/store') }}">
                {{ csrf_field() }}

                <div class="form-group row">
                    <div class="col-md-12">
                        {{Form::hidden('estado',$denuncia->estado)}}
                        <input type="hidden" value="{{$usr_id}}"  name="usr_id" id="usr_id">
                        <input type="hidden" value="{{$pro_id}}"  name="pro_id" id="pro_id">
                        <input type="hidden" value="{{$prd_id}}"  name="prd_id" id="prd_id">
                        <input type="hidden" value="{{$fpr_id}}"  name="fpr_id" id="fpr_id">
                        <input type="text" value="{{$correo_usuario}}" class="form-control form-control-sm"  name="correo_usuario" id="correo_usuario" disabled="">
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-md-12">
                        <textarea rows="6" cols="40"   type="text"  class="form-control form-control-sm" name="denuncia" id="denuncia" required >{{ old('denuncia',$denuncia->denuncia) }}</textarea>
                        @error('denuncia')
                        <p class="form-text text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="row justify-content-center" style="margin-top: 10px;">
                    <div class="col-md-3">
                        <button id="btn_guardar" class="btn btn-primary btn-lg" type="submit" >Enviar</button>
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
