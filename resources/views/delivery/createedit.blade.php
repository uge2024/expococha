@extends('layouts.layout_main',['noMostrarHeaderBuscar'=>'1'])

@section('header_styles')
    <style type="text/css">

    </style>
@endsection
@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            @if ($delivery->del_id == 0)
                <h3 align="center">Nuevo Delivery</h3>
            @else
                <h3 align="center">Editar Delivery</h3>
            @endif
            <br>
            <form class="form-horizontal" id="formulario" autocomplete="off" method="POST" enctype="multipart/form-data" action="{{ url('delivery/store') }}">
                {{ csrf_field() }}
                <div class="form-group row">
                    <label class="col-md-3 col-form-label text-right" for="nombre">Razon social*:</label>
                    <div class="col-md-8">
                        {{Form::hidden('del_id',$delivery->del_id)}}
                        {{Form::hidden('estado',$delivery->estado)}}
                        <input type="hidden" value="{{$usr_id}}" name="usr_id" id="usr_id">
                        <input type="hidden" value="{{$pro_id}}" name="pro_id" id="pro_id">
                        <input type="text" maxlength="100" value="{{ old('razon_social',$delivery->razon_social) }}" class="form-control form-control-sm"  name="razon_social" id="razon_social" required >
                        @error('razon_social')
                            <p class="form-text text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-3 col-form-label text-right" >propietario*:</label>
                    <div class="col-md-8">
                        <input type="text" maxlength="200" value="{{ old('propietario',$delivery->propietario) }}" class="form-control form-control-sm"  name="propietario" id="propietario" >
                        @error('propietario')
                        <p class="form-text text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-3 col-form-label text-right" for="trasnporte">Tipo trasnporte*:</label>
                    <div class="col-md-8">
                        {{   Form::select('tipo_transporte',["Camion" =>"Camion",
                                                             "Auto" =>"Auto",
                                                             "Moto" =>"Moto",
                                                             "Bicicleta" =>"Bicicleta",
                                                             "Mixto" =>"Mixto",
                                                             "Otros" =>"Otros"
                             ],$delivery->tipo_transporte,['class'=>'form-control','id'=>'tipo_transporte'])
                        }}
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-3 col-form-label text-right" for="disponible">Disponible:</label>
                    <div class="col-md-8">
                        {{   Form::select('disponible',["1"=>"SI" ,
                                                        "2" =>"NO"
                             ],$delivery->disponible,['class'=>'form-control','id'=>'disponible'])
                        }}
                    </div>
                </div><br>

                <div class="form-group row">
                    <label class="col-md-3 col-form-label text-right" >Costo minimo*:</label>
                    <div class="col-md-8">
                        <input type="text" value="{{ old('costo_minimo',$delivery->costo_minimo) }}" class="form-control form-control-sm"  name="costo_minimo" id="costo_minimo" >

                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-3 col-form-label text-right" >Costo Maximo*:</label>
                    <div class="col-md-8">
                        <input type="text" value="{{ old('costo_maximo',$delivery->costo_maximo) }}" class="form-control form-control-sm"  name="costo_maximo" id="costo_maximo" >

                    </div>
                </div>

                <div class="row justify-content-center" style="margin-top: 10px;">
                    <div class="col-md-2">
                        <button id="btn_guardar" class="btn btn-primary btn-sm" type="submit" id="btnGuardar">Guardar</button>
                    </div>
                    <div class="col-md-2">
                        <a href="{{ url('delivery/'.$usr_id) }}" class="btn btn-danger btn-sm">Cancelar</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('footer_scripts')
    <script type="text/javascript">
        validarInputDecimal("#costo_minimo",2);
        validarInputDecimal("#costo_maximo",2);

        $(document).ready(function(){
            $("#formulario").submit(function (){
                loaderR.showPleaseWait();
            });
        });
    </script>
@endsection
