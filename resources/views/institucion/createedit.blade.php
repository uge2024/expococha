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
                            <li>Institucion</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb Area End-->
    <div class="row justify-content-center">
        <div class="col-md-1"></div>
        <div class="col-md-11">
            <br>
                @if ($institucion->ins_id == 0)
                    <h3 align="center">Institucion</h3>
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Paso 1 (Datos generales)</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Paso 2 (Imagenes)</a>
                        </li>
                    </ul>
                @else
                    <h3 align="center">Editar institucion</h3>
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Datos generales</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Imagenes</a>
                        </li>
                    </ul>
                @endif
                    <br>
                <div class="tab-content" id="myTabContent">
                    <form class="form-horizontal" id="formulario" autocomplete="off" method="POST" enctype="multipart/form-data" action="{{ url('institucion/store') }}">
                        {{ csrf_field() }}
                        <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                            <div class="col-md-11 row">
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label class="col-md-3 col-form-label text-right" for="nombre">Sigla*:</label>
                                        <div class="col-md-8">
                                            {{Form::hidden('ins_id',$institucion->ins_id)}}
                                            {{Form::hidden('estado',$institucion->estado)}}
                                            <input type="text" maxlength="50" value="{{ old('sigla',$institucion->sigla) }}" class="form-control form-control-sm"  name="sigla" id="sigla" required >
                                            @error('sigla')
                                            <p class="form-text text-danger">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-3 col-form-label text-right" for="nombre">Nombre página*:</label>
                                        <div class="col-md-8">
                                            <input type="text" maxlength="200" value="{{ old('nombre',$institucion->nombre) }}" class="form-control form-control-sm"  name="nombre" id="nombre" required >
                                            @error('nombre')
                                            <p class="form-text text-danger">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-3 col-form-label text-right">Descripcion*:</label>
                                        <div class="col-md-8">
                                            <textarea rows="2" cols="40" type="text" class="form-control form-control-sm" name="descripcion" id="descripcion" required >{{ old('descripcion',$institucion->descripcion) }}</textarea>
                                            @error('descripcion')
                                            <p class="form-text text-danger">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-3 col-form-label text-right" for="direccion">Direccion*:</label>
                                        <div class="col-md-8">
                                            <input type="text" maxlength="100" value="{{ old('direccion',$institucion->direccion) }}" class="form-control form-control-sm"  name="direccion" id="direccion" required >
                                            @error('direccion')
                                            <p class="form-text text-danger">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group row">

                                        <label class="col-md-3 col-form-label text-right">Celular*:</label>
                                        <div class="col-md-8">
                                            <input type="text" value="{{ old('celular',$institucion->celular) }}" class="form-control form-control-sm"  name="celular" id="celular" required >
                                            @error('celular')
                                            <p class="form-text text-danger">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-3 col-form-label text-right">Celular(Whats App)*:</label>
                                        <div class="col-md-8">
                                            <input type="text"  value="{{ old('celular_wp',$institucion->celular_wp) }}" class="form-control form-control-sm"  name="celular_wp" id="celular_wp" required >
                                            @error('celular_wp')
                                            <p class="form-text text-danger">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label class="col-md-3 col-form-label text-right">Link facebook:</label>
                                        <div class="col-md-8">
                                            <input type="text" value="{{ old('link_facebook',$institucion->link_facebook)}}" class="form-control form-control-sm"  name="link_facebook" id="link_facebook" >
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-3 col-form-label text-right">Link twiter:</label>
                                        <div class="col-md-8">
                                            <input type="text" value="{{ old('link_twiter',$institucion->link_twiter)}}" class="form-control form-control-sm"  name="link_twiter" id="link_twiter" >
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-3 col-form-label text-right">Link instagram:</label>
                                        <div class="col-md-8">
                                            <input type="text" value="{{ old('link_instagram',$institucion->link_instagram)}}" class="form-control form-control-sm"  name="link_instagram" id="link_instagram" >
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-3 col-form-label text-right">Link youtube:</label>
                                        <div class="col-md-8">
                                            <input type="text" value="{{ old('link_youtube',$institucion->link_youtube)}}" class="form-control form-control-sm"  name="link_youtube" id="link_youtube" >
                                        </div>
                                    </div><br><br>

                                    @if ($institucion->ins_id == 0)
                                    @else
                                        <div class="row justify-content-center" style="margin-top: 10px;">
                                            <div class="col-md-12 row">
                                                <div class="col-md-5"></div>
                                                <div class="col-md-6">
                                                    <button id="btn_guardar" class="btn btn-primary btn-sm" type="submit" id="btnGuardar">Guardar</button>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                            <div class="form-group row">
                                <label class="col-md-1 col-form-label"></label>
                                <label class="col-md-3 col-form-label">Imagen icono 112x27 pixeles:</label>
                                <div class="col-md-8">
                                    {{
                                          Html::image(asset('storage/uploads/'.$institucion->imagen_icono), 'Sin Imagen', array('id'=>'imagen_icono', 'class' =>'img-thumbnail','width'=>'150'))
                                    }}
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-1 col-form-label"></label>
                                <label class="col-md-3 col-form-label">Nueva Imagen icono:</label>
                                <div class="col-md-8">
                                    <input type="file" class="form-control-file form-control-sm" id="imagen_icono_imagen" name="imagen_icono_imagen"  >
                                    <p style="font-size:12px">  La nueva imagen no puede ser mayor a 112x27 pixeles y debe de ser en formato jpg o jpeg </p>
                                    @error('imagen_icono_imagen')
                                    <p class="form-text text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-1 col-form-label"></label>
                                <label class="col-md-3 col-form-label">Imagen reporte 224x54 pixeles:</label>
                                <div class="col-md-8">
                                    {{
                                          Html::image(asset('storage/uploads/'.$institucion->imagen_reporte), 'Sin Imagen', array('id'=>'imagen_reporte', 'class' =>'img-thumbnail','width'=>'200'))
                                    }}
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-1 col-form-label"></label>
                                <label class="col-md-3 col-form-label">Nueva Imagen reporte:</label>
                                <div class="col-md-8">
                                    <input type="file" class="form-control-file form-control-sm" id="imagen_reporte_imagen" name="imagen_reporte_imagen"  >
                                    <p style="font-size:12px">  La nueva imagen no puede ser mayor a 224x54 pixeles y debe de ser en formato jpg o jpeg </p>
                                    @error('imagen_reporte')
                                    <p class="form-text text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div><br>

                            <div class="form-group row">
                                <label class="col-md-1 col-form-label"></label>
                                <label class="col-md-3 col-form-label">Imagen banner 1920x480 pixeles:</label>
                                <div class="col-md-8">
                                    {{
                                          Html::image(asset('storage/uploads/'.$institucion->imagen_banner), 'Sin Imagen', array('id'=>'imagen_banner', 'class' =>'img-thumbnail','width'=>'300'))
                                    }}
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-1 col-form-label"></label>
                                <label class="col-md-3 col-form-label">Nueva Imagen banner:</label>
                                <div class="col-md-8">
                                    <input type="file" class="form-control-file form-control-sm" id="imagen_banner_imagen" name="imagen_banner_imagen"  >
                                    <p style="font-size:12px">  La nueva imagen no puede ser mayor a 1920x480 pixeles y debe de ser en formato jpg o jpeg </p>
                                    @error('imagen_banner')
                                    <p class="form-text text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div><br>

                            <div class="row justify-content-center" style="margin-top: 10px;">
                                <div class="col-md-12 row">
                                        <div class="col-md-5"></div>
                                        <div class="col-md-6">
                                            <button id="btn_guardar" class="btn btn-primary btn-sm" type="submit" id="btnGuardar">Guardar</button>
                                        </div>
                                </div>
                            </div>
                        </div>


                    </form>
                </div>
        </div>
    </div>
@endsection

@section('footer_scripts')
    <script type="text/javascript">
        validarInputEntero("#celular");
        validarInputEntero("#celular_wp");

        $(document).ready(function(){
            $("#formulario").submit(function (){
                loaderR.showPleaseWait();
            });
        });
    </script>
@endsection
