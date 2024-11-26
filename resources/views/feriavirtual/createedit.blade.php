@extends('layouts.layout_main',['noMostrarHeaderBuscar'=>'1'])

@section('header_styles')
    <link rel="stylesheet" href="{{asset('css/ol.css')}}" type="text/css">
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
                            <li>Ferias virtuales</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb Area End-->
    <div class="row justify-content-center">
        <div class="col-md-11">
                @if($feriavirtual->fev_id == 0)
                <h4 align="center">Nueva Feria Virtual</h4>
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
                    <h4 align="center">Editar Feria Virtual</h4>
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
            <form class="form-horizontal" id="formulario" autocomplete="off" method="POST" enctype="multipart/form-data" action="{{ url('feriavirtual/store') }}">
                {{ csrf_field() }}
                <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                    <div class="col-md-12 ">
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label text-right">Rubro*:</label>
                            <div class="col-md-6">
                                {{
                                    Form::select('rub_id',$listarubro, $feriavirtual->rub_id,  ['class' => 'form-control form-control-sm','id' => 'rub_id','style' => 'width:100%;' ])
                                }}
                            </div>
                            @error('rub_id')
                            <p class="form-text text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label text-right" for="nombre">Nombre*:</label>
                            <div class="col-md-6">
                                {{Form::hidden('estado',$feriavirtual->estado)}}
                                <input type="text" value="{{ old('nombre',$feriavirtual->nombre) }}" class="form-control form-control-sm"  name="nombre" id="nombre" required >
                                @error('nombre')
                                    <p class="form-text text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label text-right">Descripcion*:</label>
                            <div class="col-md-6">
                                <textarea rows="2" cols="40" maxlength="200" type="text"  class="form-control form-control-sm" name="descripcion" id="descripcion" required >{{ old('descripcion',$feriavirtual->descripcion) }}</textarea>
                                @error('descripcion')
                                <p class="form-text text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label text-right" for="version">Version*:</label>
                            <div class="col-md-6">
                                <input type="text" maxlength="255" value="{{ old('version',$feriavirtual->version) }}" class="form-control form-control-sm"  name="version" id="version" required >
                                @error('version')
                                <p class="form-text text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        @if($feriavirtual->fev_id == 0)
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label text-right" >Fecha Inicio:</label>
                                <div class="col-md-4">
                                    <input type="text"  value="{{date('d/m/Y')}}" class="form-control form-control-sm"  name="fecha_inicio" id="fecha_inicio" onkeypress="return false;" required>
                                    @error('fecha_inicio')
                                    <p class="form-text text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label text-right" >Fecha Fin:</label>
                                <div class="col-md-4">
                                    <input type="text" value="{{date('d/m/Y')}}" class="form-control form-control-sm"  name="fecha_final" id="fecha_final" onkeypress="return false;" required>
                                    @error('fecha_final')
                                    <p class="form-text text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        @else
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label text-right" >Fecha Inicio:</label>
                                <div class="col-md-4">
                                    <input type="text" value="{{ old('fecha_inicio',date('d/m/Y',strtotime($feriavirtual->fecha_inicio))) }}" class="form-control form-control-sm"  name="fecha_inicio" id="fecha_inicio" onkeypress="return false;" required="required">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label text-right" >Fecha Fin:</label>
                                <div class="col-md-4">
                                    <input type="text" value="{{ old('fecha_final',date('d/m/Y',strtotime($feriavirtual->fecha_final))) }}"  class="form-control form-control-sm"  name="fecha_final" id="fecha_final" onkeypress="return false;" required="required">
                                </div>
                            </div>
                        @endif
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label text-right" for="lugar">Lugar*:</label>
                            <div class="col-md-6">
                                <input type="text" value="{{ old('lugar',$feriavirtual->lugar) }}" class="form-control form-control-sm"  name="lugar" id="lugar" required >
                                @error('lugar')
                                <p class="form-text text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">

                            <label class="col-md-3 col-form-label text-right">Direccion*:</label>
                            <div class="col-md-6">
                                <textarea rows="2" cols="40"  type="text"  class="form-control form-control-sm" name="direccion" id="direccion" required >{{ old('direccion',$feriavirtual->direccion) }}</textarea>
                                @error('direccion')
                                <p class="form-text text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        @if($feriavirtual->fev_id == 0)
                        @else
                        <div class="row justify-content-center" style="margin-top: 10px;">
                            <div class="col-md-2"></div>
                            <div class="col-md-2">
                                <button   class="btn btn-primary btn-sm" type="submit"  >Guardar</button>
                            </div>
                            <div class="col-md-2">
                                <a href="{{ url('feriavirtual') }}" class="btn btn-danger btn-sm">Cancelar</a>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
                <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                    @if($feriavirtual->fev_id == 0)
                        <h5>Puede subir un maximo de 5 imagenes banner</h5><br><br><br>
                        <div class="col-md-12 row">
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <div class="col-md-2"></div>
                                    <label class="col-md-2 col-form-label text-right">Imagenes banner:</label>
                                    <div class="col-md-8">
                                        <input type="file" class="form-control-file form-control-sm" id="imagen_banner" name="imagen_banner[]" accept="image/JPG, image/JPEG, image/jpg, image/jpeg" multiple="multiple" required  >
                                        @error('imagen_banner')
                                        <p class="form-text text-danger">{{ $message }}</p>
                                        @enderror
                                        <p style="font-size:12px">  La imagen no puede ser mayor a 1920 x 480 pixeles y debe de ser en formato jpg o jpeg menor a 2Mb </p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <div class="col-md-2"></div>
                                    <label class="col-md-2 col-form-label text-right">Nuevo Imagen afiche:</label>
                                    <div class="col-md-8">
                                        <input type="file" class="form-control-file form-control-sm" id="imagen_afiche" name="imagen_afiche" accept="image/JPG, image/JPEG, image/jpg, image/jpeg" required  >
                                        @error('imagen_afiche')
                                        <p class="form-text text-danger">{{ $message }}</p>
                                        @enderror
                                        <p style="font-size:12px">  La imagen no puede ser mayor a 600 x 600 pixeles y debe de ser en formato jpg o jpeg menor a 2Mb </p>
                                    </div>
                                </div><br>
                            </div>
                        </div>
                    @else
                        <h5>Puede subir un maximo de 5 imagenes banner</h5><br>
                        <input type="hidden" value="{{$feriavirtual->fev_id}}" id="fev_id" name="fev_id">
                        <input type="hidden" value="{{$ife_id_afiche}}" id="ife_id_afiche" name="ife_id_afiche">
                        <div class="col-md-12 row">
                            <div class="col-md-6">
                                <div class="content" id="contenidoLista">
                                    <input type="hidden" value="{{$cantidadimagenesbannerhay}}" id="cantidadimagenesbannerhay" name="cantidadimagenesbannerhay">
                                    <table class="table table-hover table-responsive-xl table-sm" id="tablaContenido">
                                        <thead>
                                        <tr>
                                            <th>
                                            </th>
                                            <th>
                                                <center>Imagenes banner de 1920 x 480 px</center>
                                            </th>
                                            <th width="8%">
                                            </th>
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
                                                        Html::image(asset('storage/uploads/'.$item->imagen), 'Sin Imagen', array('id'=>'imagen', 'class' =>'img-thumbnail'))
                                                    }}
                                                </td>
                                                <td>
                                                    <button type="button" class="btn btn-danger btn-sm" onclick="eliminarImagenBanner('{{$item->ife_id}}','{{$item->imagen}}');"><i class="fa fa-trash"></i> </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table><br>
                                </div>
                                <div class="form-group row" >
                                    <label class="col-md-3 col-form-label text-right">Imagenes banner:</label>
                                    <div class="col-md-9">
                                        <input type="file" class="form-control-file form-control-sm" id="imagen_banner" name="imagen_banner[]" accept="image/JPG, image/JPEG, image/jpg, image/jpeg" multiple="multiple"   >
                                        <p style="font-size:12px">  Las imagenes no puede ser mayores a 1920 x 480 pixeles y debe de ser en formato jpg o jpeg menor a 2Mb </p>
                                        @error('imagen_banner')
                                        <p class="form-text text-danger">{{ $message }}</p>
                                        @enderror
                                        @error('imagen_banner.*')
                                        <p class="form-text text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label class="col-md-4 col-form-label text-right">Imagen afiche de 550x850 pixeles:</label>
                                    <div class="col-md-8"><br>
                                        {{
                                              Html::image(asset('storage/uploads/'.$imagen_afiche), 'Sin Imagen', array('id'=>'imagen_afiche', 'class' =>'img-thumbnail'))
                                        }}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-4 col-form-label text-right">Nueva Imagen afiche:</label>
                                    <div class="col-md-8">
                                        <input type="file" class="form-control-file form-control-sm" id="imagen_afiche" name="imagen_afiche"  >
                                        <p style="font-size:12px">  La nueva imagen no puede ser mayor a  550x850 pixeles y debe de ser en formato jpg o jpeg menor a 2Mb </p>
                                        @error('imagen_afiche')
                                            <p class="form-text text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div><br>
                                <div class="row justify-content-center" style="margin-top: 10px;">
                                    <div class="col-md-2"></div>
                                    <div class="col-md-2">
                                        <button   class="btn btn-primary btn-sm" type="submit"  >Guardar</button>
                                    </div>
                                    <div class="col-md-2">
                                        <a href="{{ url('feriavirtual') }}" class="btn btn-danger btn-sm">Cancelar</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                </div>
                <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
                    <!--MAPA-->
                    <div class="row">
                        <div class="col-md-6"><h5>Marque en el mapa la dirección de la Feria</h5></div>
                        <div class="col-md-2"><button   class="btn btn-primary btn-sm" type="submit">Guardar</button></div>
                        <div class="col-md-2"><a href="{{ url('feriavirtual') }}" class="btn btn-danger btn-sm">Cancelar</a></div>
                    </div>
                    <br>
                    <div id="map" class="map"><div id="popup"></div></div>
                    <!--MAPA end-->
                    <br>
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-3"></div>
                            <div class="col-md-3">
                                <label id="latitudVista" class="col-form-label text-right">Latitud: {{$feriavirtual->latitud}}</label>
                            </div>
                            <div class="col-md-3">
                                <label id="longitudVista" class="col-form-label text-right">Longitud: {{$feriavirtual->longitud}}</label>
                            </div>
                            <div class="col-md-2">
                                <input type="hidden"  value="{{$feriavirtual->latitud}}" name="latitud" id="latitud">
                                <input type="hidden"  value="{{$feriavirtual->longitud}}"  name="longitud" id="longitud">
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
                var latitud = {{$feriavirtual->latitud}};
                var longitud = {{$feriavirtual->longitud}};
                var zoom = {{$zoom ?? 18}};

                $(document).ready(function(){

                    asignarDatepicker("#fecha_inicio");
                    asignarDatepicker("#fecha_final");
                    //validarInputDecimal("#version",2);
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

                function eliminarImagenBanner(ife_id,imagen){
                    var cantIma =  $("#cantidadimagenesbannerhay").val();
                    if(cantIma>=2) {
                        var fev_id = $("#fev_id").val();
                        loaderR.showPleaseWait();
                        $.ajax({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            url: '{{url("feriavirtual/_eliminarimagenbanner")}}',
                            data: {
                                ife_id: ife_id,
                                fev_id: fev_id
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

            </script>
@endsection
