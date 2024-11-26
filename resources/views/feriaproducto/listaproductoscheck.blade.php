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
                            <li>Enviar invitacion a productores</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb Area End-->
    <h3 align="center">Seleccionar productos de la tienda</h3>
    <br>
    <form id="formid" >
        <div class="col-md-12 row">
         <div class="col-md-1"></div>
         <div class="col-md-10" style="max-height:400px;overflow-y: scroll;" id="contenidoLista">
                    <table class="table table-hover table-responsive-xl table-sm" >
                        <thead>
                        <tr>
                            <th>N°</th>
                            <th width="30%">Nombre de producto</th>
                            <th width="30%">Nombre del descripcion</th>
                            <th>Precio</th>
                            <th>Existencia</th>
                            <th>Puntuacion</th>
                            <th width="3%">
                                <a onclick="getTodosSeleccionados();" class=" btn-sm" style="color: #003eff">Todos</a>
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        @php
                            $indice = 1;
                        @endphp
                        @foreach ($listaProductos as $item)
                            <tr>
                                <td>
                                    {{$indice++}}
                                </td>
                                <td>
                                    {{$item->nombre_producto}}
                                </td>
                                <td>
                                    {{$item->descripcion1}}
                                </td>
                                <td>
                                    {{$item->precio}}
                                </td>
                                <td>
                                    {{$item->existencia}}
                                </td>
                                <td>
                                    {{$item->puntuacion}}
                                </td>
                                <td>
                                    <input type="checkbox" class="btn btn-danger btn-sm" value="{{$item->prd_id}}" name="page" class="up">
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
           </div>
        </div>
        <div class="row justify-content-center" style="margin-top: 10px;">
            <div class="col-md-2">
                <a href="#" id="enviar"  class="btn btn-flat btn-primary btn-lg"><i class="fa fa-mail-bulk"></i> Guardar Lista</a>
            </div>
        </div>


        <input type="hidden" value="{{$fpd_id}}" id="fpd_id" name="fpd_id"> 
        <input type="hidden" value="{{$fpd_id}}" id="pro_id" name="pro_id">
        <input type="hidden" id="bandera" name="bandera">
    </form>
@endsection
@section('footer_scripts')

    <script type="text/javascript">
        var modelo = {idUsuario:1};
        modelo.datos = new Array();

        $(document).ready(function() { //seteareditor(); //editor
            $("#bandera").val("0");
            $('#enviar').click(function() {
                var seleccionados = [];
                $(":checkbox[name=page]").each(function() {
                    if (this.checked) {
                        seleccionados.push($(this).val());
                    }
                });

                var fpd_id = $("#fpd_id").val();
                modelo.fpd_id = fpd_id;
                modelo.datos = seleccionados;
                var datosEnviar = JSON.stringify(modelo);
                if (seleccionados.length) {
                    loaderR.showPleaseWait();
                    $.ajax({
                        url: '{{url("feriaproducto/mandarlistacheck")}}',
                        data: datosEnviar,
                        type: 'POST',
                        contentType: "json",
                        success: function (resp) {
                            console.log(resp);
                            loaderR.hidePleaseWait();
                             if(resp.res == true){
                                toastr.success('Se guardo correctamente los productos seleccionados', '');
                                var pro_id = resp.pro_id;
                                location.href = '{{ url('feriaproducto') }}'+'/'+pro_id ;
                             }else{
                                toastr.warning('No guardo correctamente los prodcutos seleccionados', '');
                             }
                        },
                        error: function (xhr, status) {
                            loaderR.hidePleaseWait();
                            alert('Disculpe, existió un problema');
                        },
                        complete: function (xhr, status) {
                        }
                    });
                }else{
                    toastr.error('Debe seleccionar por lo menos a un Productor.','');
                }
            });
        });

        function getTodosSeleccionados() {
            var bandera = $("#bandera").val();
            if(bandera == "0"){
                $(":checkbox[name=page]").each(function() {
                    this.checked = true;
                });
                $("#bandera").val("1");
            }else{
                $(":checkbox[name=page]").each(function() {
                    this.checked = false;
                });
                $("#bandera").val("0");
            }
        }



    </script>
@endsection
