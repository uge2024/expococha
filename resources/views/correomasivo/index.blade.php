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
                            <li>Enviar Promocion</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb Area End-->
    <h3 align="center">Envío de Correos Masivos a Usuarios Consumidores</h3>
    <br>
    <form id="formid" >
 <div class="col-md-12 row">
    <div class="col-md-6" style="max-height:600px;overflow-y: scroll;">   <br> 
        <center><h5> Lista de usuarios validados</h5></center>   <br><br><br>
        <table class="table table-hover table-responsive-xl table-sm" >
            <thead>
            <tr>
                <th>N°</th>
                <th>Nombre</th>
                <th>Correo</th>
                <th width="7%"> <a onclick="getTodosSeleccionados();" class=" btn-sm" style="color: #003eff">Todos</a></th>
            </tr>
            </thead>
            <tbody>
            @php
                $indice = 1;
            @endphp
            @foreach ($lista as $item)
                <tr>
                    <td>
                        {{$indice++}}
                    </td>
                    <td>
                        {{$item->name}}
                    </td>
                    <td>
                        {{$item->email}}
                    </td>
                    <td>
                        <input type="checkbox" class="btn btn-danger btn-sm" value="{{$item}}" name="page" class="up">
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
     </div>
     <div class="col-md-6"  id="contenidoLista">
         <br>
         <h5 align="center">Enviar Promociones a usuarios</h5>
         <br><br><br>
         <div class="form-group row">
             <label class="col-md-2 col-form-label text-right">De :</label>
             <div class="col-md-9">
                 <input type="text" class="form-control form-control-sm" value="{{$remitente}}" name="remitente" id="remitente" disabled>
                 <input type="hidden" class="form-control form-control-sm"  name="fev_id" id="fev_id" >
             </div>
         </div>
         <div class="form-group row">
             <label class="col-md-2 col-form-label text-right">A :</label>
             <div class="col-md-9">
                 <input type="text" class="form-control form-control-sm"  value="{{$enviar_a}}" name="enviar_a" id="enviar_a" disabled>
             </div>
         </div>
         <div class="form-group row">
             <label class="col-md-2 col-form-label text-right">Asunto :</label>
             <div class="col-md-9">
                 <input type="text" class="form-control form-control-sm"  value="{{$asunto}}" name="asunto" id="asunto" >
             </div>
         </div>
         <div class="form-group row">
             <label class="col-md-2 col-form-label text-right">Descripcion:</label>
             <div class="col-md-9">
                 <textarea rows="6" cols="100"  type="text"  class="form-control form-control-sm" name="descripcion" id="descripcion" required >{{$descripcion}}</textarea>
             </div>

                <input type="hidden" id="bandera" name="bandera">
                 
         </div>
         <center>
             <a href="#" id="enviar2"  class="btn btn-flat btn-primary btn-lg"><i class="fa fa-mail-bulk"></i> Enviar Invitacion</a>
         </center><br>
    </div>
</div>
<br><br>
    </form>


@endsection

@section('footer_scripts')
    <script src="{{asset('js/tinymce.min.js')}}"></script>
    <script type="text/javascript">
        seteareditor();    
        

        var modelo = {idUsuario:1};
        modelo.datos = new Array();

        $(document).ready(function() { 

            $("#bandera").val("0");
            $('#enviar2').click(function() {
                var seleccionados = [];
                $(":checkbox[name=page]").each(function() {
                    if (this.checked) {
                        seleccionados.push($(this).val());
                    }
                });

                var descripcion = tinymce.get("descripcion").getContent();
                var asunto = $("#asunto").val();
                modelo.asunto = asunto;
                modelo.descripcion = descripcion;
                modelo.datos = seleccionados;
                var datosEnviar = JSON.stringify(modelo);
                if (seleccionados.length) {
                    loaderR.showPleaseWait();
                    $.ajax({
                        url: '{{url("enviarcorreomasivo/mandarlista")}}',
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
                    toastr.error('Debe seleccionar por lo menos a un Usuario.','');
                }
            });
        });

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



    </script>



@endsection
