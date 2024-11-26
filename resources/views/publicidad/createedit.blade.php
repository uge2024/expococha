@extends('layouts.layout_main',['noMostrarHeaderBuscar'=>'1'])

@section('header_styles')
    <style type="text/css">

    </style>
@endsection
@section('content')
    <div class="row justify-content-center">
        <div class="col-md-1"></div>
        <div class="col-md-11">
            @if ($publicidad->pub_id == 0)
                <h3 align="center">Nueva Publicidad</h3>
            @else
                <h3 align="center">Editar Publicidad</h3>
            @endif
            <br><br>
            <form class="form-horizontal" id="formulario" autocomplete="off" method="POST" enctype="multipart/form-data" action="{{ url('publicidad/store') }}">
                {{ csrf_field() }}
                <div class="col-md-12 row">
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label text-right" for="nombre">Tipo publicidad*:</label>
                            <div class="col-md-8">
                                {{Form::hidden('pub_id',$publicidad->pub_id)}}
                                {{Form::hidden('estado',$publicidad->estado)}}

                                {{
                                     Form::select('tpu_id',$listacombo, $publicidad->tpu_id,  ['class' => 'form-control form-control-sm','id' => 'tpu_id','style' => 'width:100%;' ,'name'=>'tpu_id', 'onchange' => 'CambiarTexto();'])
                                }}
                            </div>
                        </div>
                        @if ($publicidad->pub_id != 0)
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label text-right" >Fecha desde:</label>
                                <div class="col-md-3">
                                    <input type="text"   value="{{ old('fecha_desde',date('d/m/Y',strtotime($publicidad->fecha_desde))) }}" class="form-control form-control-sm"  name="fecha_desde" id="fecha_desde" onkeypress="return false;" required="required">
                                </div>
                                <label class="col-md-1 col-form-label text-right" >Hasta:</label>
                                <div class="col-md-3">
                                    <input type="text"   value="{{ old('fecha_hasta',date('d/m/Y',strtotime($publicidad->fecha_hasta))) }}" class="form-control form-control-sm"  name="fecha_hasta" id="fecha_hasta" onkeypress="return false;" required="required">
                                </div>
                            </div>
                        @else
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label text-right" >Fecha desde:</label>
                                <div class="col-md-3">
                                    <input type="text" value="{{date('d/m/Y')}}" class="form-control form-control-sm"  name="fecha_desde" id="fecha_desde" onkeypress="return false;" required="required">
                                </div>
                                <label class="col-md-1 col-form-label" >Hasta:</label>
                                <div class="col-md-3">
                                    <input type="text" value="{{date('d/m/Y')}}" class="form-control form-control-sm"  name="fecha_hasta" id="fecha_hasta" onkeypress="return false;" required="required">
                                </div>
                            </div>
                        @endif
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label text-right" >Solicitante*:</label>
                            <div class="col-md-8">
                                <input type="text" maxlength="200" value="{{ old('solicitante',$publicidad->solicitante) }}" class="form-control form-control-sm"  name="solicitante" id="solicitante" >
                                @error('solicitante')
                                <p class="form-text text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label text-right" >Documento*:</label>
                            <div class="col-md-8">
                                <input type="text" maxlength="200" value="{{ old('documento',$publicidad->documento) }}" class="form-control form-control-sm"  name="documento" id="documento" >
                                @error('documento')
                                <p class="form-text text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label text-right" >Documento Pago:</label>
                            <div class="col-md-8">
                                <textarea rows="2" cols="40"  type="text"  class="form-control form-control-sm" name="doc_pago" id="doc_pago" >{{ old('doc_pago',$publicidad->doc_pago) }}</textarea>
                            </div>
                        </div>
                        @if ($publicidad->pub_id != 0)
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label text-right" >Fecha pago:</label>
                                <div class="col-md-4">
                                    <input type="text"   value="{{ old('fecha_pago',date('d/m/Y',strtotime($publicidad->fecha_pago))) }}" class="form-control form-control-sm"  name="fecha_pago" id="fecha_pago" onkeypress="return false;">
                                </div>
                            </div>
                        @else
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label text-right" >Fecha pago:</label>
                                <div class="col-md-4">
                                    <input type="text" value="{{date('d/m/Y')}}" class="form-control form-control-sm"  name="fecha_pago" id="fecha_pago" onkeypress="return false;" >
                                </div>
                            </div>
                        @endif
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label text-right" >Monto:</label>
                            <div class="col-md-4">
                                <input type="text"  value="{{ old('monto',$publicidad->monto) }}"  class="form-control form-control-sm"  name="monto" id="monto" >
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label text-right" >Link destino:</label>
                            <div class="col-md-8">
                                <input type="text"  value="{{ old('link_destino',$publicidad->link_destino) }}" class="form-control form-control-sm"  name="link_destino" id="link_destino"  required="required">
                            </div>
                        </div>

                        @if ($publicidad->pub_id == 0)
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label text-right">Imagen publicidad:</label>
                                <div class="col-md-8">
                                    <input type="file" class="form-control-file form-control-sm" id="imagen" name="imagen" 
                                    accept="image/PNG, image/JPG, image/JPEG , image/GIF, image/png image/jpg, image/jpeg, image/gif" required  >
                                    @error('imagen')
                                    <p class="form-text text-danger">{{ $message }}</p>
                                    @enderror
                                    <div id= "contenidottext"></div>
                                </div>
                            </div><br>
                        @else
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label text-right">Imagen  actual:</label>
                                <div class="col-md-8">
                                    {{
                                        Html::image(asset('storage/uploads/'.$publicidad->imagen), 'Sin Imagen', array('id'=>'imagen', 'class' =>'img-thumbnail'))
                                    }}
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label text-right">Nueva Imagen icono:</label>
                                <div class="col-md-8">
                                    <input type="file" class="form-control-file form-control-sm" id="imagen" name="imagen" accept="image/PNG, image/JPG, image/JPEG , image/GIF, image/png image/jpg, image/jpeg, image/gif" >
                                    <div id= "contenidottext"></div>
                                </div>
                            </div>
                        @endif
                        <br><br><br>
                        <div class="row justify-content-center" style="margin-top: 10px;">
                            <div class="col-md-2">
                                <button id="btn_guardar" class="btn btn-primary btn-sm" type="submit" id="btnGuardar">Guardar</button>
                            </div>
                            <div class="col-md-2">
                                <a href="{{ url('publicidad/') }}" class="btn btn-danger btn-sm">Cancelar</a>
                            </div>
                        </div>
                    </div>
                </div>
            </form>

        </div>
    </div>
@endsection

@section('footer_scripts')
    <script type="text/javascript">
        validarInputDecimal("#monto",2);
        validarInputDecimal("#costo_maximo",2);

        $(document).ready(function(){
            asignarDatepicker("#fecha_desde");
            asignarDatepicker("#fecha_hasta");
            asignarDatepicker("#fecha_pago");

            $("#formulario").submit(function (){
                loaderR.showPleaseWait();
            });
        });

        
        function CambiarTexto() {    
             var tpu_id = $("#tpu_id").val();
             if(tpu_id > 0){
                $.ajax({    
                    url : '{{url("publicidad/_cambiartextoavisoimagen")}}',
                    data : { 
                        tpu_id:tpu_id
                    },
                    type : 'POST',  
                    success : function(resp) {
                        $("#contenidottext").html(resp);                        
                    },
                    error : function(xhr, status) {
                        alert('Disculpe, existió un problema');
                    },
                    complete : function(xhr, status) {
                                           
                    }
                });
            }else{
                toastr.warning('Debe de seleccionar un Tipo de publicidad','');
            }

        };  
    </script>
@endsection
