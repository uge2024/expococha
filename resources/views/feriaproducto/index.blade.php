@extends('layouts.layout_main',['noMostrarHeaderBuscar'=>'1'])

@section('header_styles')
    <style type="text/css">
    </style>
@endsection
@section('content')

    {{-- MODAL LISTA DE PRODUCTOS--}}
    <div class="modal" id="modallistaProductos" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header btn-warning">
                    <h5 class="modal-title">Seleccionar productos de la tienda</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                    <div class="modal-body">
                        <form id="formModalpagonota" autocomplete="off" >
                            <div class="modal-body" style="height: 400px;">
                                <div class="col-md-12 row" style="margin-top:-30px; max-height:400px;overflow-y: scroll;" id="contenidoLista">
                                </div>
                                <input type="hidden" value="{{$fpd_id_modal}}" id="fpd_id_modal" name="fpd_id_modal">
                                <input type="hidden" value="{{$pro_id_modal}}" id="pro_id_modal" name="pro_id_modal">
                                <input type="hidden" id="bandera" name="bandera">
                            </div>
                            <div class="modal-footer">
                                <a href="#" id="enviar"  class="btn btn-flat btn-primary"> Guardar Lista</a>
                                <button type="button" class="btn btn-flat btn-danger btn-flat" data-dismiss="modal">Cerrar</button>
                            </div>
                        </form>
                    </div>
            </div>
        </div>
    </div>
    {{-- END MODAL LISTA DE PRODUCTOS --}}

    <!-- Breadcrumb Area Start -->
    <div class="breadcrumb-area">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="breadcrumb-content">
                        <ul class="nav">
                            <li><a href="{{url('/')}}">Inicio</a></li>
                            <li>Productos de mi feria</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb Area End-->
    <h3 align="center">{{$titulo}}</h3>
<br>
    <div class="col-md-12">
        <div class="col-md-12">
        <button type="button" class="btn btn-primary btn-sm" onclick="crearNuevoFeriaProducto2();"><i class="fa fa-plus"></i> Nuevo Producto</button>
        <button type="button" class="btn btn-warning btn-sm" onclick="abrirModalListaProductos();"><i class="fa fa-list"></i> Añadir Producto lista</button>
          <input type="hidden" class="form-control form-control-sm" value="{{$fpd_id}}"  name="fpd_id" id="fpd_id"  >
          <input type="hidden" class="form-control form-control-sm" value="{{$pro_id}}"  name="pro_id" id="pro_id"  >
            <form class="col-md-12" action="{{url('feriaproducto/'.$pro_id.'/'.$fpd_id.'/lista')}}" method="get">
                <div class="row">
                    <div class="col-md-1"></div>
                    <div class="col-md-1">
                        <label for="search">Buscar por:</label>
                    </div>
                    <div class="col-md-2">
                        {{
                            Form::select('searchtype',[1=>'Nombre Producto',2=>'Descripcion corta'],$searchtype,  ['class' => 'form-control form-control-sm','id' => 'searchtype'])
                        }}
                    </div>
                    <div class="col-md-3">
                        <input type="text" class="form-control form-control-sm" placeholder="Ingrese su busqueda" id="search" name="search" value="{{$search}}">
                    </div>
                    <div class="col-md-1">
                        <label>Ordenar por:</label>
                    </div>
                    <div class="col-md-2">
                        {{
                            Form::select('sort',[1=>'Nombre Producto',2=>'Descripcion corta',3=>'Stock',4=>'Precio'],$sort,  ['class' => 'form-control form-control-sm','id' => 'sort'])
                        }}
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-search"></i> Buscar</button>
                    </div>
                </div>
            </form>
        <div class="content" id="contenidoLista">
           <table class="table table-hover table-responsive-xl table-sm" id="tablaContenido">
                <thead>
                <tr>
                    <th>
                        N°
                    </th>
                    <th>
                        Nombre producto
                    </th>
                    <th>
                        Descripcion corta
                    </th>
                    <th>
                        Stock
                    </th>
                    <th>
                        Precio
                    </th>
                    <th>
                        Imagen
                    </th>
                    <th width="17%">
                        Acciones
                    </th>
                </tr>
                </thead>
                <tbody>
               @php
                   $contador = 0;
               @endphp
               @foreach ($lista as $key =>  $item)
                    <tr>
                        <td>
                            {{$lista->firstItem() + $key}}
                        </td>
                        <td>
                            {{$item->nombre_producto}}
                        </td>
                        <td>
                            {{$item->descripcion1}}
                        </td>
                        <td>
                            {{$item->existencia}}
                        </td>
                        <td>
                            {{$item->precio}}
                        </td>
                        <td>
                            @php
                                $bandera = true;
                            @endphp
                            @foreach ($item->imagenesFeriaProductos as $imagen)
                                @if($imagen->estado == 'AC' && $imagen->tipo == 12)
                                    @if($bandera)
                                        {{
                                            Html::image(asset('storage/uploads/'.$imagen->imagen), 'Sin Imagen', array('id'=>'imagen', 'class' =>'img-thumbnail','width'=>'90'))
                                        }}
                                        @php
                                            $bandera = false;
                                        @endphp
                                    @endif
                                @endif
                            @endforeach
                        </td>
                        <td>
                            @if ($item->estado == 'AC')
                                <a href="{{ url('feriaproducto/edit/'.$item->fpr_id.'/'.$item->pro_id.'/'.$item->fpd_id) }}" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i> Editar</a>
                            @endif
                            @if ($item->estado != 'AC')
                            @endif
                            @if ($item->estado == 'AC')
                                <button type="button" class="btn btn-danger btn-sm" onclick="modificarEstado('{{$item->fpr_id}}','{{$item->nombre_producto}}','inhabilitar');"><i class="fa fa-trash"></i> Inhabilitar</button>
                            @endif
                            @if ($item->estado != 'AC')
                                <button type="button" class="btn btn-success btn-sm" onclick="modificarEstado('{{$item->fpr_id}}','{{$item->nombre_producto}}','habilitar');"><i class="fa fa-trash"></i> Habilitar</button>
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <div class="d-flex justify-content-center">
                {{ $lista->links() }}
            </div>
        </div>
      </div>
    </div>

@endsection

@section('footer_scripts')
    <script type="text/javascript">
        var modelo = {idUsuario:1};
        modelo.datos = new Array();

        $(document).ready(function() {

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
                            loaderR.hidePleaseWait();
                            if(resp.res == true){
                                toastr.success('Se guardo correctamente los productos seleccionados', '');
                                $('#modallistaProductos').modal('hide');
                                var fpd_id = resp.fpd_id;
                                var pro_id = resp.pro_id;
                               recargar(pro_id,fpd_id);
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
                    toastr.error('Debe seleccionar por lo menos a un Producto.','');
                }
            });
        });


        function buscarFeriaProductosPorFeriaProductor() {
            var fpd_id = $("#fpd_id").val();
            loaderR.showPleaseWait();
            $.ajax({
                url : '{{url("feriaproducto/_buscarproductosbyferiaproductor")}}',
                data : {
                    fpd_id:fpd_id
                },
                type : 'POST',
                success : function(resp) {
                    loaderR.hidePleaseWait();
                    console.log(resp);
                    $("#contenidoLista").html(resp);
                },
                error : function(xhr, status) {
                    loaderR.hidePleaseWait();
                    alert('Disculpe, existió un problema');
                },
                complete : function(xhr, status) {

                }
            });
        };

        function crearNuevoFeriaProducto2()
        {
            var pro_id = $("#pro_id").val();
            var fpd_id = $("#fpd_id").val();
            location.href = '{{ url('feriaproducto/create') }}'+'/'+pro_id+'/'+fpd_id ;
        }

        function modificarEstado(fpr_id,nombre,texto)
        {
            var mensajeConsulta = '¿Desea '+texto+' el producto: '+nombre+'?';
            $.confirm({
                theme: 'modern',
                title: false,
                content: mensajeConsulta,
                buttons: {
                    SI: {
                        text: 'SI',
                        btnClass: 'btn-blue',
                        keys: ['enter'],
                        action: function(){
                            $.ajax({
                                url : '{{url("feriaproducto/_modificarEstado")}}',
                                data : {
                                    fpr_id : fpr_id,
                                    texto:texto
                                },
                                type : 'POST',
                                success : function(resp) {
                                    console.log(resp);
                                    if(resp.res == true){
                                        toastr.success('Operación completada','');
                                        location.reload(true);
                                    }else{
                                        toastr.error('Ocurrio un error al eliminar la feria Productor','');
                                    }
                                },
                                error : function(xhr, status) {
                                    toastr.error('Ocurrio un error al eliminar la feria Productor','');
                                },
                                complete : function(xhr, status) {
                                }
                            });
                        }
                    },
                    NO: {
                        text: 'NO',
                        btnClass: 'btn-red',
                        action: function(){
                            //location.reload(true);
                        }
                    }
                }
            });
        }
///------------------------------------  MODAL ------------------------------------

        function abrirModalListaProductos() {
            var fpd_id = $("#fpd_id").val();
            var pro_id = $("#pro_id").val();

            loaderR.showPleaseWait();
            $.ajax({
                url : '{{url("feriaproducto/_obtenerlistaproductos")}}',
                data : {
                    fpd_id:fpd_id,
                    pro_id:pro_id
                },
                type : 'POST',
                success : function(resp) {
                    loaderR.hidePleaseWait();
                    $("#contenidoLista").html(resp);
                    $('#modallistaProductos').modal('show');
                    $("#fpd_id_modal").val(fpd_id);
                    $("#pro_id_modal").val(pro_id);
                },
                error : function(xhr, status) {
                    loaderR.hidePleaseWait();
                    alert('Disculpe, existió un problema');
                },
                complete : function(xhr, status) {
                }
            });
        }

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

        function recargar(pro_id,fpd_id){
            location.href = '{{ url('feriaproducto') }}'+'/'+pro_id+'/'+fpd_id+'/lista' ;
        }


    </script>
@endsection
