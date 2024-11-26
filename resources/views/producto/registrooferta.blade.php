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
                            <li>Productos</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb Area End-->
    <div class="row justify-content-center">
        <div class="col-md-8">
              <h3 align="center">Oferta para - {{$producto->nombre_producto}}</h3><br>

            <form class="form-horizontal" id="formulario" autocomplete="off" method="POST" enctype="multipart/form-data" action="{{ url('producto/registrooferta') }}">
                {{ csrf_field() }}
                <input type="hidden" value="{{ old('prd_id',$producto->prd_id) }}"  name="prd_id" id="prd_id">
                <input type="hidden" value="{{$usr_id}}"  name="usr_id" id="usr_id">
                <div class="form-group row">
                	<div class="col-md-2"></div>
                    <label class="col-md-3 col-form-label text-right" >Precio actual:</label>
                    <div class="col-md-4">
                        <input type="text" value="{{ old('precio',$producto->precio) }}" class="form-control form-control-sm"  name="precioa" id="precioa" disabled="disabled" >
                        <input type="hidden" value="{{ old('precio',$producto->precio) }}" class="form-control form-control-sm"  name="precio" id="precio"  >
                    </div>
                </div>

                <div class="form-group row">
                	<div class="col-md-2"></div>
                    <label class="col-md-3 col-form-label text-right" >Cantidad:</label>
                    <div class="col-md-4">
                        <input type="text" value="{{ old('existencia',$producto->existencia) }}" class="form-control form-control-sm"  name="existencia" id="existencia" disabled="disabled">
                    </div>
                </div> 

                <div class="form-group row">
                	<div class="col-md-2"></div>
                    <label class="col-md-3 col-form-label text-right" >Precio oferta:</label>
                    <div class="col-md-4">
                        <input type="text" class="form-control form-control-sm" value="{{ old('precio_oferta',$producto->precio_oferta) }}" name="precio_oferta" id="precio_oferta" required="required">
                        @error('precio_oferta')
                                <p class="form-text text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                @if ($producto->fecha_inicio_oferta != null)
                    <div class="form-group row">
                        <div class="col-md-2"></div>
                        <label class="col-md-3 col-form-label text-right" >Fecha Inicio promocion:</label>
                        <div class="col-md-4">
                        <input type="text" value="{{ old('fecha_inicio_oferta',date('d/m/Y',strtotime($producto->fecha_inicio_oferta))) }}" class="form-control form-control-sm"  name="fecha_inicio_oferta" id="fecha_inicio_oferta" onkeypress="return false;" required="required">
                        @error('fecha_inicio_oferta')
                                <p class="form-text text-danger">{{ $message }}</p>
                        @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-2"></div>
                        <label class="col-md-3 col-form-label text-right" >Fecha Fin promocion:</label>
                        <div class="col-md-4">
                        <input type="text"   value="{{ old('fecha_fin_oferta',date('d/m/Y',strtotime($producto->fecha_fin_oferta))) }}" class="form-control form-control-sm"  name="fecha_fin_oferta" id="fecha_fin_oferta" onkeypress="return false;" required="required">
                        </div>
                    </div>
                @else
                    <div class="form-group row">
                        <div class="col-md-2"></div>
                        <label class="col-md-3 col-form-label text-right" >Fecha Inicio promocion:</label>
                        <div class="col-md-4">
                            <input type="text" value="{{date('d/m/Y')}}" class="form-control form-control-sm"  name="fecha_inicio_oferta" id="fecha_inicio_oferta" onkeypress="return false;" required="required">
                        @error('fecha_inicio_oferta')
                                <p class="form-text text-danger">{{ $message }}</p>
                        @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-2"></div>
                        <label class="col-md-3 col-form-label text-right" >Fecha Fin promocion:</label>
                        <div class="col-md-4">
                            <input type="text" value="{{date('d/m/Y')}}" class="form-control form-control-sm"  name="fecha_fin_oferta" id="fecha_fin_oferta" onkeypress="return false;" required="required">
                        </div>
                    </div>
                @endif

                <div class="row justify-content-center" style="margin-top: 10px;">
                    <div class="col-md-2">
                        <button id="btn_guardar" class="btn btn-primary btn-sm" type="submit" id="btnGuardar">Guardar</button>
                    </div>
                    <div class="col-md-2">
                        <a href="{{ url('producto/'.$usr_id.'/lista') }}" class="btn btn-danger btn-sm">Cancelar</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('footer_scripts')
    <script type="text/javascript">

        $(document).ready(function(){
            validarInputDecimal("#precio_oferta",2);
            validarInputDecimal("#costo_maximo",2);
            asignarDatepicker("#fecha_fin_oferta");
            asignarDatepicker("#fecha_inicio_oferta");
            $("#formulario").submit(function (){
                loaderR.showPleaseWait();
            });
        });
    </script>
@endsection
