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
                            <li>Feria productor</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb Area End-->
    <div class="row justify-content-center">
        <div class="col-md-8">
            @if ($feriaProductor->fpd_id == 0)
                <h3 align="center">Registrar productor a {{$titulo}}</h3>
            @else
                <h3 align="center">Editar Registro de productor a {{$titulo}}</h3>
            @endif
            <br><br><br>
            <form class="form-horizontal" id="formulario" autocomplete="off" method="POST" enctype="multipart/form-data" action="{{ url('feriaproductor/store') }}">
                {{ csrf_field() }}
                <div class="form-group row">
                    <label class="col-md-1 col-form-label"></label>
                    <label class="col-md-3 col-form-label" for="nombre">Elegir Rubro*:</label>
                    <div class="col-md-8">
                        {{
                             Form::select('rub_id',$rubros, $rub_id,  ['class' => 'form-control form-control-sm','id' => 'rub_id','style' => 'width:100%;' ,'name'=>'pro_id'])
                        }}
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-1 col-form-label"></label>
                    <label class="col-md-3 col-form-label" for="nombre">Elegir Productor*:</label>
                    <div class="col-md-8">
                        {{Form::hidden('fpd_id',$feriaProductor->fpd_id)}}
                        {{Form::hidden('estado',$feriaProductor->estado)}}
                        <div id="divselect">
                            {{
                                 Form::select('pro_id',$listaProductores, $feriaProductor->pro_id,  ['class' => 'form-control form-control-sm','id' => 'pro_id','style' => 'width:100%;' ,'name'=>'pro_id'])
                            }}
                        </div>
                    </div>
                </div>
                @if ($feriaProductor->fpd_id == 0)
                    <div class="form-group row">
                        <label class="col-md-1 col-form-label"></label>
                        <label class="col-md-3 col-form-label" >Fecha de inscripcion:</label>
                        <div class="col-md-4">
                            <input type="text"  value="{{date('d/m/Y')}}" class="form-control form-control-sm"  name="fecha_inscripcion" id="fecha_inscripcion" onkeypress="return false;"  required >
                            @error('fecha_inscripcion')
                            <p class="form-text text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                @else
                    <div class="form-group row">
                        <label class="col-md-1 col-form-label"></label>
                        <label class="col-md-3 col-form-label" >Fecha de inscripcion:</label>
                        <div class="col-md-4">
                            <input type="text" value="{{ old('fecha_inscripcion',date('d/m/Y',strtotime($feriaProductor->fecha_inscripcion))) }}" class="form-control form-control-sm"  name="fecha_inscripcion" id="fecha_inscripcion" onkeypress="return false;"  required >
                            @error('fecha_inscripcion')
                            <p class="form-text text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                @endif
                <div class="form-group row">
                    <label class="col-md-1 col-form-label"></label>
                    <label class="col-md-3 col-form-label"  >Nro. comprobante:</label>
                    <div class="col-md-3">
                        <input type="text" class="form-control form-control-sm" value="{{ old('comprobante',$feriaProductor->comprobante) }}"  name="comprobante" id="comprobante" required >
                        @error('comprobante')
                        <p class="form-text text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                @if ($feriaProductor->fpd_id == 0)
                    <div class="form-group row">
                        <label class="col-md-1 col-form-label"></label>
                        <label class="col-md-3 col-form-label"  >Fecha de comprobante:</label>
                        <div class="col-md-4">
                            <input type="text" value="{{date('d/m/Y')}}" class="form-control form-control-sm"  name="fecha_pago" id="fecha_pago" onkeypress="return false;"  required >
                            @error('fecha_pago')
                            <p class="form-text text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                @else
                    <div class="form-group row">
                        <label class="col-md-1 col-form-label"></label>
                        <label class="col-md-3 col-form-label"  >Fecha de comprobante sin formato:</label>
                        <div class="col-md-4">
                            <input type="text" value="{{ old('fecha_pago',date('d/m/Y',strtotime($feriaProductor->fecha_pago))) }}" class="form-control form-control-sm"  name="fecha_pago" id="fecha_pago" onkeypress="return false;"  required >
                            @error('fecha_pago')
                            <p class="form-text text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                @endif
                <div class="form-group row">
                    <label class="col-md-1 col-form-label"></label>
                    <label class="col-md-3 col-form-label" for="nombre">Monto pagado:</label>
                    <div class="col-md-3">
                        <input type="text" class="form-control form-control-sm" value="{{ old('monto',$feriaProductor->monto) }}"  name="monto" id="monto" required >
                        @error('monto')
                        <p class="form-text text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-1 col-form-label"></label>
                    <label class="col-md-3 col-form-label" for="nombre">Registrado por:</label>
                    <div class="col-md-4">
                        <input type="text" class="form-control form-control-sm" value="{{$nombreUsuario}}"  name="nombreUsuario" id="nombreUsuario" disabled="disabled">
                        <input type="hidden" class="form-control form-control-sm" value="{{$usr_id}}"  name="usr_id" id="usr_id"  >
                        <input type="hidden" class="form-control form-control-sm" value="{{$fev_id}}"  name="fev_id" id="fev_id"  >
                    </div>
                </div>
                <br>
                <div class="row justify-content-center" style="margin-top: 10px;">
                    <div class="col-md-2">
                        <button id="btn_guardar" class="btn btn-primary  btn-sm" type="submit" id="btnGuardar">Guardar</button>
                    </div>
                    <div class="col-md-2">
                        <a href="{{ url('feriaproductor/'.$fev_id) }}" class="btn btn-danger btn-sm">Cancelar</a>
                    </div>
                </div>
                <br>
            </form>
        </div>
    </div>
@endsection

@section('footer_scripts')
    <script type="text/javascript">
        $(document).ready(function(){

            asignarDatepicker("#fecha_inscripcion");
            asignarDatepicker("#fecha_pago");
            validarInputDecimal("#monto",2);
            validarInputEntero("#comprobante");

            $("#formulario").submit(function (){
                loaderR.showPleaseWait();
            });

            $("#rub_id").change(function (){
                var rub_id = $("#rub_id").val();
                loaderR.showPleaseWait();
                $.ajax({
                    url : '{{url("feriaproductor/_selectproductores")}}',
                    data : {
                        rub_id:rub_id
                    },
                    type : 'POST',
                    success : function(resp) {
                        $("#divselect").html(resp);
                    },
                    error : function(xhr, status) {
                        toastr.error('Ocurrio un error al obtener los datos','');
                    },
                    complete : function(xhr, status) {
                        loaderR.hidePleaseWait();
                    }
                });
            });

        });
    </script>
@endsection
