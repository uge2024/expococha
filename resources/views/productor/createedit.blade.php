@extends('layouts.layout_main',['noMostrarHeaderBuscar'=>'1'])

@section('header_styles')
    <link rel="stylesheet" href="{{asset('css/ol.css')}}" type="text/css">
    <style type="text/css">
        .map {
            height: 400px;
            width: 100%;
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
                            @guest
                            @else
                                @if(Auth::user()->rol == 3)
                                    <li><a href="{{url('/administracion/productores')}}">Administración / Productores</a></li>
                                    <li>Datos Productor</li>
                                @elseif(Auth::user()->rol == 2)
                                    <li>Mi Tienda / Mis Datos</li>
                                @else
                                @endif
                            @endguest

                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb Area End-->
    <div class="row justify-content-center">
        <div class="col-md-11">
            @if ($productor->pro_id == 0)
                <h4 align="center">Mis datos</h4>
            @else
                <h4 align="center">Modificar mis datos</h4>
            @endif
            @if ($productor->pro_id == 0)
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Paso 1 (Datos generales)</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Paso 2 (Imagenes)</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">Paso 3 (Ubicacion)</a>
                        </li>
                    </ul>
                    <div class="tab-content" id="myTabContent">
            @else
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Datos generales</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Imagenes</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">Ubicacion</a>
                        </li>
                        </ul>
                    <div class="tab-content" id="myTabContent">
            @endif

            <br>
            <form class="form-horizontal" id="formulario" autocomplete="off" method="POST" enctype="multipart/form-data" action="{{ url('productor/store') }}">
                {{ csrf_field() }}
                <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                    <div class="col-md-12 row">
                    <div class="col-md-6">
                        @if ($tipoUsuario == 3  )
                            <div class="form-group row">
                                <label class="col-md-1 col-form-label"></label>
                                <label class="col-md-3 col-form-label text-right">Asociacion*:</label>
                                <div class="col-md-8">
                                    {{
                                         Form::select('aso_id',$listaasociaciones, $productor->aso_id,  ['class' => 'form-control form-control-sm','id' => 'aso_id','style' => 'width:100%;' ,'name'=>'aso_id','require'=>'require'])
                                    }}
                                </div>
                                @error('aso_id')
                                <p class="form-text text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="form-group row">
                                <label class="col-md-1 col-form-label"></label>
                                <label class="col-md-3 col-form-label text-right">Rubro*:</label>
                                <div class="col-md-8">
                                    {{
                                         Form::select('rub_id',$listarubro, $productor->rub_id,  ['class' => 'form-control form-control-sm','id' => 'rub_id','style' => 'width:100%;' ,'name'=>'rub_id','require'=>'require'])
                                    }}
                                </div>
                                @error('rub_id')
                                <p class="form-text text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        @else
                        @endif
                        @if ($tipoUsuario == 2)
                            <div class="form-group row">
                                <label class="col-md-1 col-form-label"></label>
                                <label class="col-md-3 col-form-label text-right">Asociacion*:</label>
                                <div class="col-md-8">
                                    <label class="col-form-label text-right">{{$nombreAsociacion}}</label>
                                    <input type="hidden" value="{{$productor->aso_id}}" name="aso_id" id="aso_id">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-1 col-form-label"></label>
                                <label class="col-md-3 col-form-label text-right">Rubro*:</label>
                                <div class="col-md-8">
                                <label class="col-form-label text-right">{{$nombreRubro}}</label>
                                <input type="hidden" value="{{$productor->rub_id}}" name="rub_id" id="rub_id">
                                </div>
                            </div>
                        @else
                        @endif

                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-right " for="nombre" >Nombre y apellido*:</label>
                            <div class="col-md-8">
                                {{Form::hidden('pro_id',$productor->pro_id)}}
                                {{Form::hidden('estado',$productor->estado)}}
                                {{Form::hidden('estado_tienda',$productor->estado_tienda)}}
                                <input type="hidden"  value="{{$usr_id}}" name="usr_id" id="usr_id">
                                <input type="text" maxlength="255" value="{{ old('nombre_propietario',$productor->nombre_propietario) }}" class="form-control form-control-sm"  name="nombre_propietario" id="nombre_propietario" required>
                                @error('nombre_propietario')
                                    <p class="form-text text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-1 col-form-label"></label>
                            <label class="col-md-3 col-form-label text-right">Direccion*:</label>
                            <div class="col-md-8">
                                <textarea rows="2" cols="40"  type="text"  class="form-control form-control-sm" name="direccion" id="direccion" required >{{ old('direccion',$productor->direccion) }}</textarea>
                                @error('direccion')
                                <p class="form-text text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-1 col-form-label"></label>
                            <label class="col-md-3 col-form-label text-right">Telefono 1:</label>
                            <div class="col-md-8">
                                <input type="text" maxlength="10" value="{{ old('telefono_1',$productor->telefono_1) }}" class="form-control form-control-sm"  name="telefono_1" id="telefono_1">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-1 col-form-label"></label>
                            <label class="col-md-3 col-form-label text-right">Telefono 2:</label>
                            <div class="col-md-8">
                                <input type="text" maxlength="10" value="{{ old('telefono_2',$productor->telefono_2) }}" class="form-control form-control-sm"  name="telefono_2" id="telefono_2">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-1 col-form-label"></label>
                            <label class="col-md-3 col-form-label text-right">Celular*:</label>
                            <div class="col-md-8">
                                <input type="text" maxlength="10" value="{{ old('celular',$productor->celular) }}" class="form-control form-control-sm"  name="celular" id="celular" required >
                                @error('celular')
                                <p class="form-text text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-right">Celular(Whats App)*:</label>
                            <div class="col-md-8">
                                <input type="text" maxlength="10" value="{{ old('celular_wp',$productor->celular_wp) }}" class="form-control form-control-sm"  name="celular_wp" id="celular_wp" required >
                                @error('celular_wp')
                                <p class="form-text text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-1 col-form-label"></label>
                            <label class="col-md-3 col-form-label text-right">Nombre tienda*:</label>
                            <div class="col-md-8">
                                <textarea rows="2" cols="40" maxlength="255" type="text"  class="form-control form-control-sm" name="nombre_tienda" id="nombre_tienda" required >{{ old('nombre_tienda',$productor->nombre_tienda) }}</textarea>
                                @error('nombre_tienda')
                                <p class="form-text text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">

                        <div class="form-group row">
                            <label class="col-md-3 col-form-label text-right">Actividad*:</label>
                            <div class="col-md-8">
                                <textarea rows="2" cols="40" maxlength="500" type="text"  class="form-control form-control-sm" name="actividad" id="actividad" required >{{ old('actividad',$productor->actividad) }}</textarea>
                                @error('actividad')
                                <p class="form-text text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-3 col-form-label text-right">Correo*:</label>
                            <div class="col-md-8">
                                <input type="email"  value="{{ old('email',$productor->email) }}" class="form-control form-control-sm"  name="email" id="email" required>
                                @error('email')
                                <p class="form-text text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label text-right">Entidad financiera:</label>
                            <div class="col-md-8">
                                <input type="text" maxlength="500" value="{{ old('entidad_financiera',$productor->entidad_financiera)}}" class="form-control form-control-sm"  name="entidad_financiera" id="entidad_financiera" >
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label text-right">Cuenta:</label>
                            <div class="col-md-8">
                                <input type="text" maxlength="100" value="{{ old('cuenta',$productor->cuenta)}}" class="form-control form-control-sm"  name="cuenta" id="cuenta" >
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label text-right">Titular Cuenta:</label>
                            <div class="col-md-8">
                                <input type="text" maxlength="100" value="{{ old('titular_cuenta',$productor->titular_cuenta)}}" class="form-control form-control-sm"  name="titular_cuenta" id="titular_cuenta" >
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label text-right">Link facebook:</label>
                            <div class="col-md-8">
                                <input type="text"  value="{{ old('link_facebook',$productor->link_facebook)}}" class="form-control form-control-sm"  name="link_facebook" id="link_facebook" >
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label text-right">Link twiter:</label>
                            <div class="col-md-8">
                                <input type="text"  value="{{ old('link_twiter',$productor->link_twiter)}}" class="form-control form-control-sm"  name="link_twiter" id="link_twiter" >
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label text-right">Link instagram:</label>
                            <div class="col-md-8">
                                <input type="text"  value="{{ old('link_instagram',$productor->link_instagram)}}" class="form-control form-control-sm"  name="link_instagram" id="link_instagram" >
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label text-right">Link youtube:</label>
                            <div class="col-md-8">
                                <input type="text"  value="{{ old('link_youtube',$productor->link_youtube)}}" class="form-control form-control-sm"  name="link_youtube" id="link_youtube" >
                            </div>
                        </div>
                        @if ($productor->pro_id == 0)
                        @else
                            <div class="row justify-content-center" style="margin-top: 10px;">
                                <div class="col-md-2"></div>
                                <div class="col-md-2">
                                    <button   class="btn btn-primary" type="submit">Guardar</button>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
                </div>
                <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                    @if ($productor->pro_id == 0)
                        <div class="col-md-12">
                            <div class="form-group row">
                                <div class="col-md-2"></div>
                                <label class="col-md-2 col-form-label">Imagenes banner:</label>
                                <div class="col-md-8">
                                    <input type="file" class="form-control-file form-control-sm" id="imagen_banner" name="imagen_banner[]" accept="image/JPG, image/JPEG, image/jpg, image/jpeg" accept="image/JPG" multiple="multiple" required  >
                                    @error('imagen_banner')
                                    <p class="form-text text-danger">{{ $message }}</p>
                                    @enderror
                                    <p style="font-size:12px">La imagen no puede ser mayor a 1920 x 480 pixeles y debe de ser en formato jpg o jpeg menor a 2Mb </p>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-2"></div>
                                <label class="col-md-2 col-form-label">Nuevo Imagen icono:</label>
                                <div class="col-md-8">
                                    <input type="file" class="form-control-file form-control-sm" id="imagen_icono" name="imagen_icono" accept="image/JPG, image/JPEG, image/jpg, image/jpeg" required  >
                                    @error('imagen_icono')
                                    <p class="form-text text-danger">{{ $message }}</p>
                                    @enderror
                                    <p style="font-size:12px">  La imagen no puede ser mayor a 600 x 600 pixeles y debe de ser en formato jpg o jpeg menor a 2Mb </p>
                                </div>
                            </div><br>

                        </div>
                    @else

                        <input type="hidden" value="{{$productor->pro_id}}" id="pro_id" name="pro_id">
                        <input type="hidden" value="{{$ipd_id_medio}}" id="ipd_id_medio" name="ipd_id_medio">
                        <input type="hidden" value="{{$ipd_id_icono}}" id="ipd_id_icono" name="ipd_id_icono">
                        <div class="col-md-12 row">
                            <div class="col-md-1"></div>
                            <div class="col-md-6">
                                <div class="content" id="contenidoLista">
                                    <h5>Puede subir un maximo de {{$limiteImagen}} imagenes por producto</h5>
                                    <input type="hidden" value="{{$cantidadimagenesbannerhay}}" id="cantidadimagenesbannerhay" name="cantidadimagenesbannerhay">
                                    <table class="table table-hover table-responsive-xl table-sm" id="tablaContenido">
                                        <thead>
                                        <tr>
                                            <th></th>
                                            <th><center>Imagenes banner de 1920 x 480 px</center></th>
                                            <th width="8%"></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @php
                                            $indice = 1;
                                        @endphp
                                        @foreach ($imagenesBanners as $item)
                                            <tr>
                                                <td>
                                                    {{$indice++}}
                                                </td>
                                                <td>
                                                    {{
                                                        Html::image(asset('storage/uploads/'.$item->imagen), 'Sin Imagen', array('id'=>'imagen_icono', 'class' =>'img-thumbnail'))
                                                    }}
                                                </td>
                                                <td>
                                                    <button type="button" class="btn btn-danger btn-sm" onclick="eliminarImagenBanner('{{$item->ipd_id}}','{{$item->imagen}}');"><i class="fa fa-trash"></i> </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table><br>
                                </div>
                                <div class="form-group row" >
                                    <label class="col-md-3 col-form-label">Imagenes banner:</label>
                                    <div class="col-md-9">
                                        <input type="file" class="form-control-file form-control-sm" id="imagen_banner" name="imagen_banner[]" accept="image/JPG, image/JPEG, image/jpg, image/jpeg" multiple="multiple"   >
                                        <p style="font-size:12px">  Las imagenes no puede ser mayores a 1920 x 480 pixeles y debe de ser en formato jpg o jpeg menor a 2Mb</p>
                                        @error('imagen_banner')
                                        <p class="form-text text-danger">{{ $message }}</p>
                                        @enderror
                                        @error('imagen_banner.*')
                                        <p class="form-text text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="form-group row">

                                    <label class="col-md-3 col-form-label">Imagen Principal de 600x600 pixeles:</label>
                                    <div class="col-md-8" id="vistaparcial">
                                       {{
                                             Html::image(asset('storage/uploads/'.$imagenIcono), 'Sin Imagen', array('id'=>'ipd_id_icono', 'class' =>'img-thumbnail'))
                                       }}
                                    </div>

                                    <div class="col-md-1">
                                            <button type="button" class="btn btn-danger btn-sm" title="Elimina la Imagen QR" onclick="eliminarImagenIcono('{{$productor->pro_id}}','{{$imagenIcono}}');"><i class="fa fa-trash"></i> </button>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-1 col-form-label"></label>
                                    <label class="col-md-3 col-form-label">Nueva Imagen icono:</label>
                                    <div class="col-md-8">
                                        <input type="file" class="form-control-file form-control-sm" id="imagen_icono" name="imagen_icono"  >
                                        <p style="font-size:12px">  La nueva imagen no puede ser mayor a  600x600 pixeles y debe de ser en formato jpg o jpeg menor a 2Mb </p>
                                        @error('imagen_icono')
                                        <p class="form-text text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div><br>
                                <div class="row justify-content-center" style="margin-top: 10px;">
                                    <div class="col-md-2"></div>
                                    <div class="col-md-2">
                                        <button   class="btn btn-primary" type="submit"  >Guardar</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
                <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
                    <!--MAPA-->
                    <div class="row">
                        <div class="col-md-6"><h4>Marque en el mapa la dirección de su negocio</h4></div>
                        <div class="col-md-6"><button   class="btn btn-primary" type="submit">Guardar</button></div>
                    </div>
                    <br>
                    <div id="map" class="map"><div id="popup"></div></div>
                    <!--MAPA end-->
                    <br>
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-3"></div>
                            <div class="col-md-3">
                                <label id="latitudVista" class="col-form-label text-right">Latitud: {{$productor->latitud}}</label>
                            </div>
                            <div class="col-md-3">
                                <label id="longitudVista" class="col-form-label text-right">Longitud: {{$productor->longitud}}</label>
                            </div>
                            <div class="col-md-2">
                                <input type="hidden"  value="{{$productor->latitud}}" name="latitud" id="latitud">
                                <input type="hidden"  value="{{$productor->longitud}}"  name="longitud" id="longitud">
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
    <script type="text/javascript" src="{{asset('js/ol.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/proj4.js')}}"></script>
    <script type="text/javascript">
        validarInputEntero("#telefono_1");
        validarInputEntero("#telefono_2");
        validarInputEntero("#celular");
        validarInputEntero("#celular_wp");

        var latitud = {{$productor->latitud}};
        var longitud = {{$productor->longitud}};
        var zoom = {{$zoom ?? 18}};

        $(document).ready(function(){
            $("#formulario").submit(function (){
                    loaderR.showPleaseWait();
            });

            //mapa
            //capa de open street map
            raster = new ol.layer.Tile({
                source: new ol.source.OSM()
            });
            //capa de vector para trazar sobre ella
            source = new ol.source.Vector({wrapX: false});
            //styles para punto y linea
            stylePoint = new ol.style.Style({
                image: new ol.style.Circle({
                    radius: 12,
                    stroke: new ol.style.Stroke({
                        color: 'white',
                        width: 3
                    }),
                    fill: new ol.style.Fill({
                        color: '#266cfb'
                    })
                })
            });
            vector = new ol.layer.Vector({
                source: source,
                style: [stylePoint]
            });

            var puntoInicial = new ol.Feature({
                geometry: new ol.geom.Point(ol.proj.fromLonLat([longitud, latitud])),
                labelPoint: new ol.geom.Point(ol.proj.fromLonLat([longitud, latitud])),
                name: 'My Polygon'
            });
            //colocamos el punto inicial
            vector.getSource().addFeature(puntoInicial);
            //event cuando se termina de dibujar
            vector.getSource().on('addfeature', function(event) {
                console.log(event);
                var features = vector.getSource().getFeatures();
                var cantidad = features.length;
                var indice = 0;
                var feactureRemover = null;
                //controlamos que sea solo un punto
                features.forEach(function(feature) {
                    if (cantidad == 2){
                        if (indice == 0){
                            feactureRemover = feature;
                        }
                    }
                    indice++;
                });
                if (feactureRemover != null){
                    vector.getSource().removeFeature(feactureRemover);
                }
                //escogemos el punto a mostrar
                var featuresDos = vector.getSource().getFeatures();
                featuresDos.forEach(function (feature){
                    var puntoCoordenada = feature.getGeometry().getCoordinates();
                    var conversion = ol.proj.transform(puntoCoordenada, 'EPSG:3857','EPSG:4326');
                    console.log(puntoCoordenada);
                    console.log(conversion);
                    $("#latitudVista").text('Latitud: '+conversion[1]);
                    $("#longitudVista").text('Longitud: '+conversion[0]);
                    $("#latitud").val(conversion[1]);
                    $("#longitud").val(conversion[0]);
                });
            });

            //creacion del mapa
            map = new ol.Map({
                layers: [raster, vector],
                target: 'map',
                view: new ol.View({
                    center: ol.proj.fromLonLat([longitud, latitud]),
                    zoom: zoom,
                    projection: 'EPSG:3857'//utm
                })
            });
            //creacion full screen
            fullscreen = new ol.control.FullScreen();
            map.addControl(fullscreen);

            draw = new ol.interaction.Draw({
                source: source,
                type: 'Point'
            });

            map.addInteraction(draw);

        });

        function eliminarImagenBanner(ipd_id,imagen){
            var cantIma =  $("#cantidadimagenesbannerhay").val();
            if(cantIma>=2) {
                var pro_id = $("#pro_id").val();
                loaderR.showPleaseWait();
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: '{{url("productor/_eliminarimagenbanner")}}',
                    data: {
                        ipd_id: ipd_id,
                        pro_id: pro_id
                    },
                    type: 'POST',
                    success: function (resp) {
                        loaderR.hidePleaseWait();
                        console.log(resp);
                        $("#contenidoLista").html(resp);
                    },
                    error: function (xhr, status) {
                        loaderR.hidePleaseWait();
                        alert('Disculpe, existió un problema');
                    },
                    complete: function (xhr, status) {

                    }
                });
            }else{
                toastr.warning('Como minimo debe de tener 2 imagenes para borrar 1 de las imagenes','');
            }

        }

        function eliminarImagenIcono(pro_id,imagenIcono){
        console.log("salio asi:"+pro_id);
            if(imagenIcono != ''){
                loaderR.showPleaseWait();
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: '{{url("productor/_eliminarimagen_icono")}}',
                    data: {
                        pro_id: pro_id
                    },
                    type: 'POST',
                    success: function (resp) {
                        loaderR.hidePleaseWait();
                        console.log(resp);
                        $("#vistaparcial").html(resp);
                           toastr.success('Operación completada','');
                    },
                    error: function (xhr, status) {
                        loaderR.hidePleaseWait();
                            toastr.warning('No se pudo eliminar la imagen qr','');
                    },
                    complete: function (xhr, status) {

                    }
                });
            }else{
                toastr.warning('No existe una imagen icono','');
            }

        }
    </script>
@endsection
