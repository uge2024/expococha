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
    <h3 align="center">Enviar invitacion a productores</h3>
    <br>
    <form id="formid" >
 <div class="col-md-12 row">
    <div class="col-md-7">
        <center><h5> Lista de ferias virtuales vigentes</h5></center>
            <table class="table table-hover table-responsive-xl table-sm" style="margin-bottom:-2.5px;">
                <thead>
                <tr>
                    <th width="3%">
                        N°
                    </th>
                    <th>
                        Feria
                    </th>
                    <th width="17%">
                        Fecha Inicio
                    </th>
                    <th width="17%">
                        Fecha final
                    </th>
                    <th width="19%">

                    </th>
                </tr>
                </thead>
            </table>
        <div style="max-height:350px;overflow-y: scroll;" >
        <table class="table table-hover table-responsive-xl table-sm" id="tablaContenido">
            <tbody>
            @php
                $indice = 1;
            @endphp
            @foreach ($lista as $item)
                <tr>
                    <td width="3%">
                        {{$indice++}}
                    </td>
                    <td>
                        {{$item->nombre}}
                    </td>
                    <td width="17%">
                        {{date('d/m/Y',strtotime($item->fecha_inicio))}}
                    </td>
                    <td width="17%">
                        {{date('d/m/Y',strtotime($item->fecha_final))}}
                    </td>
                    <td width="19%">
                        <button type="button" class="btn btn-warning btn-sm" onclick="listaProductores('{{$item->fev_id}}','{{$item->rub_id}}');"><i class="fa fa-list"></i> Productores</button>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        </div>
     </div>
     <div class="col-md-5" style="max-height:900px;overflow-y: scroll;" id="contenidoLista">
         <center><h5> Lista de productores</h5></center>
                <table class="table table-hover table-responsive-xl table-sm" >
                    <thead>
                    <tr>
                        <th>N°</th>
                        <th>Nombre de tienda</th>
                        <th>Nombre del propietario</th>
                        <th width="17%"></th>
                    </tr>
                    </thead>
                    <tbody>
                    @php
                        $indice = 1;
                    @endphp
                    @foreach ($listaProductores as $item)
                        <tr>
                            <td>
                                {{$indice++}}
                            </td>
                            <td>
                                {{$item->nombre_tienda}}
                            </td>
                            <td>
                                {{$item->nombre_propietario}}
                            </td>
                            <td>
                                <input type="checkbox" class="btn btn-danger btn-sm" value="{{$item}}" name="page" class="up">
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
    </div>
</div>
<br><br>
    <div class="col-md-12 row">
        <div class="col-md-7" style="background:#F3F3F3">
            <br>
            <h5 align="center">Enviar invitacion a productores</h5>
            <br>
            <div class="form-group row">
                <label class="col-md-2 col-form-label text-right">De :</label>
                <div class="col-md-9">
                    <input type="text" class="form-control form-control-sm"  name="remitente" id="remitente" disabled>
                    <input type="hidden" class="form-control form-control-sm"  name="fev_id" id="fev_id" >
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-2 col-form-label text-right">A :</label>
                <div class="col-md-9">
                    <input type="text" class="form-control form-control-sm" value=" " name="destinatario" id="destinatario" disabled>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-2 col-form-label text-right">Asunto :</label>
                <div class="col-md-9">
                    <input type="text" class="form-control form-control-sm"  name="asunto" id="asunto" >
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-2 col-form-label text-right">Descripcion:</label>
                <div class="col-md-9">
                    <textarea rows="6" cols="100"  type="text"  class="form-control form-control-sm" name="descripcion" id="descripcion" required ></textarea>
                </div>


            </div>
            <center>
                <input type="hidden" id="bandera" name="bandera">
                <input type="hidden"  id="pro_id" name="pro_id">
                {{-- <input type="hidden" value="2" id="pro_id" name="pro_id">--}}
                <a href="#" id="enviar2"  class="btn btn-flat btn-primary btn-lg"><i class="fa fa-mail-bulk"></i> Enviar Invitacion</a>
            </center><br>
        </div>
    </div>

    </form>


@endsection

@section('footer_scripts')
    <script src="{{asset('js/tinymce.min.js')}}"></script>
    <script type="text/javascript">
        var modelo = {idUsuario:1};
        modelo.datos = new Array();

        $(document).ready(function() { //seteareditor(); //editor

            $("#bandera").val("0");
            $('#enviar2').click(function() {
                var seleccionados = [];
                $(":checkbox[name=page]").each(function() {
                    if (this.checked) {
                        seleccionados.push($(this).val());
                    }
                });
                //var descripcion = $("#descripcion").val();
                var descripcion = tinymce.get('descripcion').getContent();
                var asunto = $("#asunto").val();
                var fev_id = $("#fev_id").val();
                var pro_id = $("#pro_id").val();
                modelo.fev_id = fev_id;
                modelo.pro_id = pro_id;
                modelo.asunto = asunto;
                modelo.descripcion = descripcion;
                modelo.datos = seleccionados;
                var datosEnviar = JSON.stringify(modelo);
                if (seleccionados.length) {
                    loaderR.showPleaseWait();
                    $.ajax({
                        url: '{{url("invitacionproductor/mandarlista")}}',
                        data: datosEnviar,
                        type: 'POST',
                        contentType: "json",
                        success: function (resp) {
                            console.log(resp);
                            loaderR.hidePleaseWait();
                            toastr.success('Invitaciones enviadas','');
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

        function listaProductores(fev_id,rub_id) {
            loaderR.showPleaseWait();
            $.ajax({
                url : '{{url("invitacionproductor/obtenerlistaproductorbyrubro")}}',
                data : {
                    fev_id:fev_id,
                    rub_id:rub_id
                },
                type : 'POST',
                success : function(resp) {
                    loaderR.hidePleaseWait();
                    console.log(resp);
                    $("#contenidoLista").html(resp);
                    obtenerdatosemail(fev_id);
                },
                error : function(xhr, status) {
                    loaderR.hidePleaseWait();
                    alert('Disculpe, existió un problema');
                },
                complete : function(xhr, status) {
                }
            });
        }

        function obtenerdatosemail(fev_id) {
            $.ajax({
                url : '{{url("invitacionproductor/_obtenerdatosemail")}}',
                data : {
                    fev_id:fev_id
                },
                type : 'POST',
                success : function(resp) {
                    if(resp.res == true){ //toastr.success("Se guardo correctamente el cliente.","COMPLETADO");
                        $("#remitente").val(resp.remitente);
                        $("#asunto").val(resp.asunto);
                        $("#descripcion").val(resp.descripcion);
                        tinymce.remove();
                        seteareditor();
                        $("#fev_id").val(resp.fev_id);
                    }else{
                        toastr.error("Ocurrio un error al obtener datos para el email.","ERROR");
                    }
                },
                error : function(xhr, status) {
                    alert('Disculpe, existió un problema');
                },
                complete : function(xhr, status) {
                }
            });
        }

        function seteareditor(){
            tinymce.init({
                selector: '#descripcion',
                language: 'es',
                theme: 'modern',
                //width: 600,
                height: 200,
                plugins: [
                    'advlist lists charmap preview hr searchreplace wordcount visualblocks visualchars fullscreen',
                    'insertdatetime nonbreaking table contextmenu directionality paste'
                ],
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










































        $(document).ready(function() {
          $('#enviaassdsdr').click(function() {
            var seleccionados = [];
            $(":checkbox[name=page]").each(function() {
              if (this.checked) {
                seleccionados.push($(this).val());
              }
            });
            if (seleccionados.length) {
                loaderR.showPleaseWait();
                   var selected = JSON.stringify(seleccionados);
                  $.ajax({
                    url : '{{url("invitacionproductor/mandarlista")}}',
                    data : selected,
                    contentType : "json",
                    type : 'POST',
                        success: function(data) {
                          loaderR.hidePleaseWait();
                          toastr.success('Se guardo correctamente.','');
                        },
                        error : function(xhr, status) {
                            toastr.error('Ocurrio un error al eliminar el rubro','');
                        },
                        complete : function(xhr, status) {
                        }
                  });
            } else
                toastr.error('Debe seleccionar al menos a un Productor.','');
            return false;
          });
        });



        function modificarEstado(fev_id,nombre,texto)
        {
            var mensajeConsulta = '¿Desea '+texto+' la feria virtual: '+nombre+'?';
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
                                url : '{{url("feriavirtual/_modificarEstado")}}',
                                data : {
                                    fev_id:fev_id,
                                    texto:texto
                                },
                                type : 'POST',
                                success : function(resp) {
                                    console.log(resp);
                                    if(resp.res == true){
                                        toastr.success('Operación completada','');
                                        location.reload(true);
                                    }else{
                                        toastr.error('Ocurrio un error al eliminar el rubro','');
                                    }
                                },
                                error : function(xhr, status) {
                                    toastr.error('Ocurrio un error al eliminar el rubro','');
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

    </script>



@endsection
