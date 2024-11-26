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
                            <li>Rubro</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb Area End-->
    <div class="row justify-content-center">
        <div class="col-md-8">
            @if ($rubro->rub_id == 0)
                <h3 align="center">Nuevo Rubro</h3>
            @else
                <h3 align="center">Editar Rubro</h3>
            @endif
            <br>
            <form class="form-horizontal" id="formulario" autocomplete="off" method="POST" enctype="multipart/form-data" action="{{ url('rubro/store') }}">
                {{ csrf_field() }}
                <div class="form-group row">
                    <label class="col-md-1 col-form-label"></label>
                    <label class="col-md-3 col-form-label" for="nombre">Nombre*:</label>
                    <div class="col-md-8">
                        {{Form::hidden('rub_id',$rubro->rub_id)}}
                        {{Form::hidden('estado',$rubro->estado)}}
                        <input type="text" value="{{ old('nombre',$rubro->nombre) }}" class="form-control form-control-sm"  name="nombre" id="nombre" required >
                        @error('nombre')
                            <p class="form-text text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-1 col-form-label"></label>
                    <label class="col-md-3 col-form-label">Descripcion*:</label>
                    <div class="col-md-8">
                        <textarea rows="2" cols="40" maxlength="200" type="text"  class="form-control form-control-sm" name="descripcion" id="descripcion" required >{{ old('descripcion',$rubro->descripcion) }}</textarea>
                        @error('descripcion')
                        <p class="form-text text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                @if ($rubro->rub_id == 0)
                    <div class="form-group row">
                        <label class="col-md-1 col-form-label"></label>
                        <label class="col-md-3 col-form-label">Nuevo Imagen banner:</label>
                        <div class="col-md-8">
                            <input type="file" class="form-control-file form-control-sm" id="imagen_banner_imagen" name="imagen_banner_imagen" accept="image/jpeg" accept="image/jpg" accept="image/JPEG" accept="image/JPG" required  >
                            @error('imagen_banner_imagen')
                            <p class="form-text text-danger">{{ $message }}</p>
                            @enderror
                            <p style="font-size:12px">  La imagen no puede ser mayor a 1920 x 480 pixeles y debe de ser en formato jpg o jpeg </p>
                        </div>

                    </div>
                @else
                    <div class="form-group row">
                        <label class="col-md-1 col-form-label"></label>
                        <label class="col-md-3 col-form-label">Imagen banner actual:</label>
                        <div class="col-md-8">
                           {{
                                Html::image(asset('storage/uploads/'.$rubro->imagen_banner), 'Sin Imagen', array('id'=>'imagen_banner', 'class' =>'img-thumbnail'))
                            }}
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-1 col-form-label"></label>
                        <label class="col-md-3 col-form-label">Nuevo Imagen banner:</label>
                        <div class="col-md-8">
                            <input type="file" class="form-control-file form-control-sm" id="imagen_banner_imagen" name="imagen_banner_imagen"  >
                            <p style="font-size:12px">  La nueva imagen no puede ser mayor a 1920 x 480 pixeles y debe de ser en formato jpg o jpeg </p>
                        </div>
                    </div>
                @endif

                @if ($rubro->rub_id == 0)
                    <div class="form-group row">
                        <label class="col-md-1 col-form-label"></label>
                        <label class="col-md-3 col-form-label">Nueva Imagen icono:</label>
                        <div class="col-md-8">
                            <input type="file" class="form-control-file form-control-sm" id="imagen_icono_imagen" name="imagen_icono_imagen" accept="image/jpeg" accept="image/jpg" accept="image/JPEG" accept="image/JPG" required >
                            @error('imagen_icono_imagen')
                            <p class="form-text text-danger">{{ $message }}</p>
                            @enderror
                            <p style="font-size:12px">  La imagen no puede ser mayor a 255 x 165 pixeles y debe de ser en formato jpg o jpeg </p>
                        </div>
                    </div>
                @else
                    <div class="form-group row">
                        <label class="col-md-1 col-form-label"></label>
                        <label class="col-md-3 col-form-label">Imagen icono actual:</label>
                        <div class="col-md-8">
                            {{
                                Html::image(asset('storage/uploads/'.$rubro->imagen_icono), 'Sin Imagen', array('id'=>'imagen_icono', 'class' =>'img-thumbnail'))
                            }}
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-1 col-form-label"></label>
                        <label class="col-md-3 col-form-label">Nueva Imagen icono:</label>
                        <div class="col-md-8">
                            <input type="file" class="form-control-file form-control-sm" id="imagen_icono_imagen" name="imagen_icono_imagen" accept="image/jpeg" accept="image/jpg" accept="image/JPEG" accept="image/JPG" >
                            <p style="font-size:12px">  La nueva imagen no puede ser mayor a 255 x 165 pixeles y debe de ser en formato jpg o jpeg </p>
                        </div>
                    </div>
                @endif

                <div class="row justify-content-center" style="margin-top: 10px;">
                    <div class="col-md-2">
                        <button id="btn_guardar" class="btn btn-primary" type="submit" id="btnGuardar">Guardar</button>
                    </div>
                    <div class="col-md-2">
                        <a href="{{ url('rubro/') }}" class="btn btn-danger">Cancelar</a>
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
