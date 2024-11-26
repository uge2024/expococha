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
                            <li>Asociacion</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb Area End-->
    <div class="row justify-content-center">
        <div class="col-md-8">
            @if ($asociacion->aso_id == 0)
                <h3 align="center">Nueva Asociacion</h3>
            @else
                <h3 align="center">Editar Asociacion</h3>
            @endif
            <br>
            <form class="form-horizontal" id="formulario" autocomplete="off" method="POST" enctype="multipart/form-data" action="{{ url('asociacion/store') }}">
                {{ csrf_field() }}
                <div class="form-group row">
                    <label class="col-md-1 col-form-label"></label>
                    <label class="col-md-3 col-form-label" for="sigla">Sigla*:</label>
                    <div class="col-md-4">
                        <input type="text" value="{{ old('sigla',$asociacion->sigla) }}" class="form-control form-control-sm"  name="sigla" id="sigla" required >
                        @error('sigla')
                        <p class="form-text text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-1 col-form-label"></label>
                    <label class="col-md-3 col-form-label" for="nombre">Nombre*:</label>
                    <div class="col-md-8">
                        {{Form::hidden('aso_id',$asociacion->aso_id)}}
                        {{Form::hidden('estado',$asociacion->estado)}}
                        <input type="text" value="{{ old('nombre',$asociacion->nombre) }}" class="form-control form-control-sm"  name="nombre" id="nombre" required >
                        @error('nombre')
                            <p class="form-text text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-1 col-form-label"></label>
                    <label class="col-md-3 col-form-label">Actividad*:</label>
                    <div class="col-md-8">
                        <textarea rows="2" cols="40" type="text"  class="form-control form-control-sm" name="actividad" id="actividad" required >{{ old('actividad',$asociacion->actividad) }}</textarea>
                        @error('actividad')
                        <p class="form-text text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-1 col-form-label"></label>
                    <label class="col-md-3 col-form-label" for="direccion">Direccion*:</label>
                    <div class="col-md-8">
                        <input type="text" value="{{ old('direccion',$asociacion->direccion) }}" class="form-control form-control-sm"  name="direccion" id="direccion" required >
                        @error('direccion')
                        <p class="form-text text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-1 col-form-label"></label>
                    <label class="col-md-3 col-form-label" for="telefono">Telefono:</label>
                    <div class="col-md-4">
                        <input type="text" value="{{ old('telefono',$asociacion->telefono) }}" class="form-control form-control-sm"  name="telefono" id="telefono"  >
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-1 col-form-label"></label>
                    <label class="col-md-3 col-form-label" for="celular">Celular:</label>
                    <div class="col-md-4">
                        <input type="text" value="{{ old('celular',$asociacion->celular) }}" class="form-control form-control-sm"  name="celular" id="celular"  >
                    </div>
                </div>
                <div class="row justify-content-center" style="margin-top: 10px;">
                    <div class="col-md-2">
                        <button id="btn_guardar" class="btn btn-primary" type="submit" id="btnGuardar">Guardar</button>
                    </div>
                    <div class="col-md-2">
                        <a href="{{ url('asociacion/') }}" class="btn btn-danger">Cancelar</a>
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
