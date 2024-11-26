@extends('layouts.layout_main',['noMostrarHeaderBuscar'=>'1'])

@section('header_styles')
    <style type="text/css">

    </style>
@endsection
@section('content')
    <div class="breadcrumb-area">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="breadcrumb-content">
                        <ul class="nav">
                            <li><a href="{{url('/')}}">Inicio</a></li>
                            <li><a href="{{ url('backups') }}">Administración / Backups / Backups Sistema</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb Area End-->
    <div class="row justify-content-center">
        <div class="col-md-8">
            @if ($backup->bac_id == 0)
                <h3 align="center">Nuevo Backup</h3>
            @endif
            <br>
            <form class="form-horizontal" id="formulario" autocomplete="off" method="POST" action="{{ url('backups/store') }}">
                {{ csrf_field() }}
                <div class="form-group row">
                    <label class="col-md-2 col-form-label"></label>
                    <label class="col-md-2 col-form-label" for="sigla">IP*:</label>
                    <div class="col-md-4">
                        <input type="text" value="{{ old('ip',$backup->ip) }}" class="form-control form-control-sm"  name="ip" id="ip" required readonly>
                        @error('ip')
                        <p class="form-text text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-2 col-form-label"></label>
                    <label class="col-md-2 col-form-label" for="nombre">Usuario*:</label>
                    <div class="col-md-4">
                        {{Form::hidden('bac_id',$backup->bac_id)}}
                        <input type="text" value="{{ old('usuario',$backup->usuario) }}" class="form-control form-control-sm"  name="usuario" id="usuario" required readonly>
                        @error('usuario')
                        <p class="form-text text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="row justify-content-center" style="margin-top: 10px;">
                    <div class="col-md-2">
                        <button id="btn_guardar" class="btn btn-primary" type="submit" id="btnGuardar">Guardar</button>
                    </div>
                    <div class="col-md-2">
                        <a href="{{ url('backups') }}" class="btn btn-danger">Cancelar</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('footer_scripts')
    <script type="text/javascript">
        validarInputEntero("#telefono");
        validarInputEntero("#celular");

        $(document).ready(function(){
            $("#formulario").submit(function (){
                loaderR.showPleaseWait();
            });
        });
    </script>
@endsection
