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
                            <li><a href="{{ url('feriavirtual') }}">Ferias virtuales</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb Area End-->
    <div class="row justify-content-center">
        <div class="col-md-8">
            @if ($certificado->bac_id == 0)
                <h3 align="center">Configuración Certificado</h3>
            @endif
            <br>
            <form class="form-horizontal" id="formulario" enctype="multipart/form-data" autocomplete="off" method="POST" action="{{ url('certificadoferia/store') }}">
                {{ csrf_field() }}
                <div class="form-group row">
                    <label class="col-md-2 col-form-label"></label>
                    <label class="col-md-2 col-form-label" for="sigla">IP*:</label>
                    <div class="col-md-4">
                        <input type="text" value="{{ old('ip',$certificado->ip) }}" class="form-control form-control-sm"  name="ip" id="ip" required readonly>
                        @error('ip')
                        <p class="form-text text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-2 col-form-label"></label>
                    <label class="col-md-2 col-form-label" for="nombre">Usuario*:</label>
                    <div class="col-md-4">
                        {{Form::hidden('cef_id',$certificado->cef_id)}}
                        {{Form::hidden('fev_id',$certificado->fev_id)}}
                        {{Form::hidden('estado',$certificado->estado)}}
                        <input type="text" value="{{ old('usuario',$certificado->usuario) }}" class="form-control form-control-sm"  name="usuario" id="usuario" required readonly>
                        @error('usuario')
                        <p class="form-text text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-1 col-form-label"></label>
                    <label class="col-md-3 col-form-label">Fondo Actual:</label>
                    <div class="col-md-8">
                        @php
                            $ruta = "#";
                            if(!empty($certificado->fondo)){
                                $ruta = asset('storage/uploads/'.$certificado->fondo);
                            }
                        @endphp
                        <a href="{{$ruta}}" target="_blank">
                            {{
                                  Html::image(asset('storage/uploads/'.$certificado->fondo), 'Sin Imagen', array('id'=>'imagen_icono', 'class' =>'img-thumbnail','width'=>'150'))
                            }}
                        </a>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-1 col-form-label"></label>
                    <label class="col-md-3 col-form-label">Nuevo Fondo:</label>
                    <div class="col-md-8">
                        <input type="file" required accept="image/png" class="form-control-file form-control-sm" id="imagen_icono_imagen" name="fondo">
                        <p style="font-size:12px">  La nueva imagen debe ser 3059x2315 pixeles a 300 ppp y debe de ser en formato png</p>
                        @error('fondo')
                            <p class="form-text text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="row justify-content-center" style="margin-top: 10px;">
                    <div class="col-md-2">
                        <button id="btn_guardar" class="btn btn-primary" type="submit" id="btnGuardar">Guardar</button>
                    </div>
                    <div class="col-md-2">
                        <a href="{{ url('feriavirtual') }}" class="btn btn-danger">Cancelar</a>
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
