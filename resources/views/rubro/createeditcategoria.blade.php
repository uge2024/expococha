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
                            <li>Categorias</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb Area End-->
    <div class="row justify-content-center">
        <div class="col-md-8">
            @if ($categoriaRubro->cat_id == 0)
                <h3 align="center">Nueva Categoria Rubro</h3>
            @else
                <h3 align="center">Editar Categoria Rubro</h3>
            @endif
            <br>
            <form class="form-horizontal" autocomplete="off" id="formulario" method="POST" enctype="multipart/form-data" action="{{ url('rubro/categoriarubro/store') }}">
                {{ csrf_field() }}
                <div class="form-group row">
                    <label class="col-md-1 col-form-label"></label>
                    <label class="col-md-3 col-form-label" for="nombre">Nombre*:</label>
                    <div class="col-md-8">
                        {{Form::hidden('cat_id',$categoriaRubro->cat_id)}}
                        {{Form::hidden('estado',$categoriaRubro->estado)}}
                        <input type="text" value="{{ old('nombre',$categoriaRubro->nombre) }}" class="form-control form-control-sm" name="nombre" id="nombre"   >
                        @error('nombre')
                        <p class="form-text text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-1 col-form-label"></label>
                    <label class="col-md-3 col-form-label">Descripcion*:</label>
                    <div class="col-md-8">
                        <textarea rows="2" cols="40" maxlength="200" type="text"  class="form-control form-control-sm" name="descripcion" id="descripcion"   >{{ old('descripcion',$categoriaRubro->descripcion) }}</textarea>
                        @error('descripcion')
                        <p class="form-text text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-1 col-form-label"></label>
                    <label class="col-md-3 col-form-label">Rubro*:</label>
                    <div class="col-md-5">
                    {{--    {{
                           Form::select('rub_id',$listarubro, $categoriaRubro->rub_id,  ['class' => 'form-control','id' => 'rub_id','style' => 'width:100%;' , 'onchange' =>'combocategoriasbyrubro();'])
                        }}
                        --}}
                        <input type="hidden" value="{{$rub_id}}"  name="rub_id" id="rub_id">
                        <p class="form-text text-dark">{{ $nombrerubro }}</p>

                    </div>
                    @error('rub_id')
                    <p class="form-text text-danger">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group row">
                    <label class="col-md-1 col-form-label"></label>
                    <label class="col-md-3 col-form-label">Categoria Padre:</label>
                    <div class="col-md-5"  id="contenidoCombo">
                            {{
                               Form::select('padre_id',$listaCategoriaRubrosPadre, $categoriaRubro->padre_id,  ['class' => 'form-control','id' => 'padre_id','style' => 'width:100%;' ,null])
                            }}
                    </div>
                    @error('padre_id')
                    <p class="form-text text-danger">{{ $message }}</p>
                    @enderror
                </div>

                <div class="row justify-content-center" style="margin-top: 10px;">
                    <div class="col-md-2">
                        <button id="btn_guardar" class="btn btn-primary" type="submit" id="btnGuardar">Guardar</button>
                    </div>
                    <div class="col-md-2">
                        <a href="{{ url('rubro/categoriarubro/listacategoria/'.$rub_id) }}" class="btn btn-danger">Cancelar</a>
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


        function combocategoriasbyrubro(){
            var rub_id = $("#rub_id").val();
            loaderR.showPleaseWait();
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url : '{{url("rubro/categoriarubro/_cargarComboCategoriasByRubro")}}',
                data : {
                    rub_id:rub_id
                },
                type : 'POST',
                success : function(resp) {
                    $("#contenidoCombo").html(resp);
                    loaderR.hidePleaseWait();
                },
                error : function(xhr, status) {
                    loaderR.hidePleaseWait();
                    alert('Disculpe, existió un problema');
                },
                complete : function(xhr, status) {

                }
            });
        }


    </script>
@endsection
