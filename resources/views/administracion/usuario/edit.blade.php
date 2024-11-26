@extends('layouts.layout_main',['noMostrarHeaderBuscar'=>'1'])

@section('header_styles')
    <style type="text/css">

    </style>
@endsection
@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h3 align="center">Editar Usuario</h3>
            <br>
            <form class="form-horizontal" id="formulario" autocomplete="off" method="POST" action="{{ url('administracion/usuarios/update') }}">
                {{ csrf_field() }}
                <div class="form-group row">
                    <label class="col-md-1 col-form-label"></label>
                    <label class="col-md-3 col-form-label" for="nombre">Nombre Completo*:</label>
                    <div class="col-md-8">
                        {{Form::hidden('id',$usuario->id)}}
                        {{Form::hidden('estado',$usuario->estado)}}
                        <input type="text" value="{{ old('name',$usuario->name) }}" class="form-control form-control-sm"  name="name" id="name" required >
                        @error('name')
                            <p class="form-text text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-1 col-form-label"></label>
                    <label class="col-md-3 col-form-label" for="nombre">Celular*:</label>
                    <div class="col-md-8">
                        <input type="text" value="{{ old('celular',$usuario->celular) }}" class="form-control form-control-sm"  name="celular" id="celular" required >
                        @error('celular')
                        <p class="form-text text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-1 col-form-label"></label>
                    <label class="col-md-3 col-form-label" for="nombre">Dirección*:</label>
                    <div class="col-md-8">
                        <input type="text" value="{{ old('direccion',$usuario->direccion) }}" class="form-control form-control-sm"  name="direccion" id="direccion" required >
                        @error('direccion')
                        <p class="form-text text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-1 col-form-label"></label>
                    <label class="col-md-3 col-form-label">Correo Electrónico*:</label>
                    <div class="col-md-8">
                        <input type="email" value="{{ old('email',$usuario->email) }}" class="form-control form-control-sm"  name="email" id="email" required >
                        @error('email')
                            <p class="form-text text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-1 col-form-label"></label>
                    <label class="col-md-3 col-form-label">Rol*:</label>
                    <div class="col-md-8">
                        {{
                            Form::select('rol',$roles,$usuario->rol,  ['class' => 'form-control form-control-sm','id' => 'rol','required'=>'required'])
                        }}
                        @error('rol')
                            <p class="form-text text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <div class="row justify-content-center" style="margin-top: 10px;">
                    <div class="col-md-2">
                        <button id="btn_guardar" class="btn btn-primary" type="submit" id="btnGuardar">Guardar</button>
                    </div>
                    <div class="col-md-2">
                        <a href="{{ url('administracion/usuarios')}}" class="btn btn-danger">Cancelar</a>
                    </div>
                </div>
            </form>
        </div>
    </div>

@endsection

@section('footer_scripts')
    <script type="text/javascript">
        $(document).ready(function(){
            validarInputEntero($("#celular"));
            $("#formulario").submit(function (){
                loaderR.showPleaseWait();
            });
        });
    </script>
@endsection
