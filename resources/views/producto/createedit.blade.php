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
                            @guest
                            @else
                                @if(Auth::user()->rol == 3)
                                    <li><a href="{{url('/administracion/productores')}}">Administración / Productores</a></li>
                                    <li><a href="{{url('producto/'.$usr_id.'/lista')}}">Revisar Productos</a></li>
                                    <li>Productos</li>
                                @elseif(Auth::user()->rol == 2)
                                    <li><a href="{{url('producto/'.$usr_id.'/lista')}}">Mi Tienda / Mis Productos</a></li>
                                    <li>Productos</li>
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
            @if ($producto->prd_id == 0)
                <h3 align="center">Nuevo Producto</h3>
            @else
                <h3 align="center">Editar Producto</h3>
            @endif
                @if ($producto->prd_id == 0)
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Paso 1 (Datos generales)</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Paso 2 (Imagenes)</a>
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
                    </ul>
                    <div class="tab-content" id="myTabContent">
                @endif
                    <br>
                    <form class="form-horizontal" id="formulario" autocomplete="off" method="POST" enctype="multipart/form-data" action="{{ url('producto/store') }}">
                        {{ csrf_field() }}
                        <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                        <div class="col-md-12 row">
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label class="col-md-4 col-form-label text-right">Categoria*:</label>
                                    <div class="col-md-8">
                                        {{
                                             Form::select('cat_id',$listacategoria, $producto->cat_id,  ['class' => 'form-control form-control-sm','id' => 'cat_id','style' => 'width:100%;' ,'name'=>'cat_id','require'=>'require'])
                                        }}
                                    </div>
                                    @error('cat_id')
                                    <p class="form-text text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-4 col-form-label text-right" for="nombre_producto">Nombre producto*:</label>
                                    <div class="col-md-8">
                                        {{Form::hidden('estado',$producto->estado)}}
                                        <input type="hidden" value="{{$pro_id}}"  name="pro_id" id="pro_id">
                                        <input type="hidden" value="{{$usr_id}}"  name="usr_id" id="usr_id">
                                        <input type="text" value="{{ old('nombre_producto',$producto->nombre_producto) }}" class="form-control form-control-sm"  name="nombre_producto" id="nombre_producto" required >
                                        @error('nombre_producto')
                                        <p class="form-text text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-4 col-form-label text-right">Descripcion corta*:</label>
                                    <div class="col-md-8">
                                        <textarea rows="2" cols="40" maxlength="200" type="text"  class="form-control form-control-sm" name="descripcion1" id="descripcion1" required >{{ old('descripcion1',$producto->descripcion1) }}</textarea>
                                        @error('descripcion1')
                                        <p class="form-text text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-4 col-form-label text-right">Precio:</label>
                                    <div class="col-md-4">
                                        <input type="text" value="{{ old('precio',$producto->precio) }}" class="form-control form-control-sm"  name="precio" id="precio">
                                        @error('precio')
                                        <p class="form-text text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-4 col-form-label text-right">Existencia:</label>
                                    <div class="col-md-4">
                                        <input type="text" value="{{ old('existencia',$producto->existencia) }}" class="form-control form-control-sm"  name="existencia" id="existencia">
                                        @error('existencia')
                                        <p class="form-text text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-4 col-form-label text-right">Existencia minima:</label>
                                    <div class="col-md-4">
                                        <input type="text" value="{{ old('existencia_minima',$producto->existencia_minima) }}" class="form-control form-control-sm"  name="existencia_minima" id="existencia_minima">
                                        @error('existencia_minima')
                                        <p class="form-text text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row"  >
                                    <label class="col-md-4 col-form-label text-right">Imagen QR:</label>
                                    <div class="col-md-3"  id="vistaparcial">
                                         {{
                                             Html::image(asset('storage/uploads/'.$producto->codigo_qr_venta), 'Sin Imagen', array('id'=>'codigo_qr_venta', 'class' =>'img-thumbnail','width'=>'120'))
                                         }}
                                    </div>

                                    @if ($producto->prd_id == 0)
                                    @else
                                        <div class="col-md-3">
                                            <button type="button" class="btn btn-danger btn-sm" title="Elimina la Imagen QR" onclick="eliminarImagenQR('{{$producto->prd_id}}','{{$producto->codigo_qr_venta}}');"><i class="fa fa-trash"></i> </button>
                                        </div>
                                    @endif
                                </div>

                                <div class="form-group row">
                                    <label class="col-md-4 col-form-label text-right">Nueva Imagen QR:</label>
                                    <div class="col-md-8">
                                        <input type="file" class="form-control-file form-control-sm" id="codigo_qr_venta_imagen" name="codigo_qr_venta_imagen" accept="image/JPG, image/JPEG, image/jpg, image/jpeg" >
                                        <p style="font-size:12px">  La imagen no puede ser mayor a 600 x 600 pixeles y debe de ser en formato jpg o jpeg menor a 2Mb </p>
                                    </div>
                                </div><br>
                            </div>
                            <div class="col-md-6" style="text-align: right">
                                <div class="form-group row">
                                    <label class="col-md-4 col-form-label text-left">Detalles del producto*:</label><br>
                                    <div class="col-md-12">
                                        <textarea rows="2" cols="40" maxlength="200" type="text"  class="form-control form-control-sm" name="descripcion2" id="descripcion2"   >{{ old('descripcion2',$producto->descripcion2) }}</textarea>
                                        @error('descripcion2')
                                        <p class="form-text text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            @if ($producto->prd_id == 0)

                            @else
                            <br><br><br>
                                <div class="row justify-content-center" style="margin-top: 10px;">
                                    <div class="col-md-1"></div>
                                    <div class="col-md-4">
                                       <button class="btn btn-primary btn-sm" type="submit" >Guardar</button>
                                    </div>
                                    <div class="col-md-4">
                                        <a href="{{ url('producto/'.$usr_id.'/lista') }}" class="btn btn-danger btn-sm">Cancelar</a>
                                    </div>
                                </div>
                            @endif
                            </div>
                        </div>

                        </div>
                        <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">

                                @if ($producto->prd_id == 0)
                                <h5>Puede subir un maximo de 5 imagenes por producto</h5><br><br><br>
                                <div class="form-group row">
                                    <div class="col-md-2"></div>
                                    <label class="col-md-3 col-form-label">Imagen Principal de 600x600 pixeles:</label>
                                    <div class="col-md-6">
                                        <input type="file" class="form-control-file form-control-sm" id="imagen_producto" name="imagen_producto[]" accept="image/JPG, image/JPEG, image/jpg, image/jpeg" multiple="multiple" >
                                        <p style="font-size:12px">  Las imagenes no puede ser mayores a 600 x 600 pixeles y debe de ser en formato jpg o jpeg menor a 2Mb </p>
                                        @error('imagen_producto')
                                        <p class="form-text text-danger">{{ $message }}</p>
                                        @enderror
                                        @error('imagen_producto.*')
                                        <p class="form-text text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div><br><br>
                                <div class="row justify-content-center" style="margin-top: 10px;">
                                    <div class="col-md-3"></div>
                                    <div class="col-md-4">
                                     <button class="btn btn-primary btn-sm" type="submit" >Guardar</button>
                                    </div>
                                    <div class="col-md-4">
                                        <a href="{{ url('producto/'.$usr_id.'/lista') }}" class="btn btn-danger btn-sm">Cancelar</a>
                                    </div>
                                </div>
                                @else
                                 <div class="col-md-12 row">
                                    <div class="col-md-6">
                                        <input type="hidden" value="{{$prd_id}}"  name="prd_id" id="prd_id">
                                        <div class="content" id="contenidoLista">
                                          <h5>Puede subir un maximo de {{$limiteImagen}} imagenes por producto</h5>
                                          <input type="hidden" value="{{$cantidadimageneshay}}" id="cantidadimageneshay" name="cantidadimageneshay">
                                          <table class="table table-hover table-responsive-xl table-sm" id="tablaContenido">
                                            <thead>
                                            <tr>
                                                <th></th>
                                                <th><center>Imagenes banner de 600 x 600 px</center> </th>
                                                <th width="8%"> </th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @php
                                                $indice = 1;
                                            @endphp
                                            @foreach ($imagen_productos as $item)
                                                <tr>
                                                    <td>
                                                        {{$indice++}}
                                                    </td>
                                                    <td><center>
                                                        {{
                                                            Html::image(asset('storage/uploads/'.$item->imagen), 'Sin Imagen', array('id'=>'imagen_icono', 'class' =>'img-thumbnail','width'=>'140'))
                                                        }}</center>
                                                    </td>
                                                    <td>
                                                        <button type="button" class="btn btn-danger btn-sm" onclick="eliminarImagen('{{$item->ipd_id}}','{{$item->prd_id}}','{{$item->numero_imagen}}');"><i class="fa fa-trash"></i> </button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table><br>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label class="col-md-4 col-form-label">Nuevas Imagenes de 600x600 pixeles:</label>
                                            <div class="col-md-8">
                                                <input type="file" class="form-control-file form-control-sm" id="imagen_producto" name="imagen_producto[]" accept="image/JPG, image/JPEG, image/jpg, image/jpeg" multiple="multiple" >
                                                <p style="font-size:12px">  Las imagenes no puede ser mayores a 600 x 600 pixeles y debe de ser en formato jpg o jpeg menor a 2Mb </p>
                                                @error('imagen_producto')
                                                <p class="form-text text-danger">{{ $message }}</p>
                                                @enderror
                                                @error('imagen_producto.*')
                                                <p class="form-text text-danger">{{ $message }}</p>
                                                @enderror
                                            </div>
                                        </div><br><br>
                                        <div class="row justify-content-center" style="margin-top: 10px;">
                                            <div class="col-md-3"></div>
                                            <div class="col-md-4">
                                                <button class="btn btn-primary btn-sm" type="submit" >Guardar</button>
                                            </div>
                                            <div class="col-md-4">
                                                <a href="{{ url('producto/'.$usr_id.'/lista') }}" class="btn btn-danger btn-sm">Cancelar</a>
                                            </div>
                                        </div>
                                    </div>
                                 </div>

                                @endif

                            </div>
                    </form>
                    </div>
        </div>
        </div>
    </div>
@endsection

@section('footer_scripts')
    <script src="{{asset('js/tinymce.min.js')}}"></script>
    <script type="text/javascript">

        $(document).ready(function(){
            validarInputDecimal("#precio",2);
            validarInputDecimal("#existencia",2);
            validarInputDecimal("#existencia_minima",2);
            $("#formulario").submit(function (){
                loaderR.showPleaseWait();
            });

            tinymce.init({
                selector: '#descripcion2',
                language: 'es',
                theme: 'modern',
               // width: 660,
                height: 200,
                plugins: [
                    'advlist lists charmap preview hr searchreplace wordcount visualblocks visualchars fullscreen',
                    'insertdatetime nonbreaking table contextmenu directionality paste'
                ],
            });

        });

        function eliminarImagen(ipd_id,prd_id,numero_imagen){
            var cantIma =  $("#cantidadimageneshay").val();
            if(cantIma>=2) {

                loaderR.showPleaseWait();
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: '{{url("producto/_eliminarimagen_producto")}}',
                    data: {
                        ipd_id: ipd_id,
                        prd_id: prd_id,
                        numero_imagen:numero_imagen
                    },
                    type: 'POST',
                    success: function (resp) {
                        loaderR.hidePleaseWait();
                        console.log(resp);
                        $("#contenidoLista").html(resp);
                           toastr.success('Operación completada','');
                    },
                    error: function (xhr, status) {
                        loaderR.hidePleaseWait();
                            toastr.warning('No se pudo eliminar la imagen producto','');
                    },
                    complete: function (xhr, status) {

                    }
                });
            }else{
                toastr.warning('Como minimo debe de tener 2 imagenes para borrar 1 de las imagenes','');
            }

        }

        function eliminarImagenQR(prd_id,imagen){
        console.log("salio asi:"+imagen);
            if(imagen != ''){
                loaderR.showPleaseWait();
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: '{{url("producto/_eliminarimagen_qr")}}',
                    data: {
                        prd_id: prd_id,
                        imagen:imagen
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
                toastr.warning('No existe una imagen qr','');
            }

        }

    </script>
@endsection
