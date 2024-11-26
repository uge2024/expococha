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
                            <li>Denuncia</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb Area End-->
    <h4 align="center">Lista de Productores</h4>
    <h4 align="center">{{$titulo}}</h4>

<br>
    <div class="col-md-12">
            <div class="form-group row">
                <div class="col-md-2">
                    <button type="button" class="btn btn-primary btn-sm" onclick="crearFeriaProductor();"><i class="fa fa-plus"></i> Agregar</button>
                </div>
                <input type="hidden" value="{{$fev_id}}" id="fev_id" name="fev_id">
            </div>

        <div class="content" id="contenidoLista">
            <table class="table table-hover table-responsive-xl table-sm" id="tablaContenido">
                <thead>
                <tr>
                    <th>
                        N°
                    </th>
                    <th>
                        Rubro
                    </th>
                    <th width="20%">
                        Productor
                    </th>
                    <th>
                        Fecha Inscripcion
                    </th>
                    <th>
                        N. Comprobante
                    </th>
                    <th width="15%">
                        Acciones
                    </th>
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
                            {{$item->productor->rubro->nombre}}
                        </td>
                        <td>
                            <p>{{$item->productor->nombre_propietario}}</p>
                            <p>({{$item->productor->nombre_tienda}})</p>
                        </td>
                        <td>
                            {{date('d/m/Y',strtotime($item->fecha_inscripcion))}}
                        </td>
                        <td>
                            {{$item->comprobante}}
                        </td>
                        <th>
                            @if ($item->estado == 'AC')
                                <a href="{{ url('feriaproductor/edit/'.$item->fpd_id) }}" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i> Editar</a>
                            @endif

                            @if ($item->estado != 'AC')
                            @endif

                            @if ($item->estado == 'AC')
                                 <button type="button" class="btn btn-danger btn-sm" onclick="modificarEstado('{{$item->fpd_id}}','{{$item->productor->nombre_propietario}}','inhabilitar');"><i class="fa fa-trash"></i> Inhabilitar</button>
                            @endif

                            @if ($item->estado != 'AC')
                                 <button type="button" class="btn btn-success btn-sm" onclick="modificarEstado('{{$item->fpd_id}}','{{$item->productor->nombre_propietario}}','habilitar');"><i class="fa fa-trash"></i> Habilitar</button>
                            @endif

                            @if ($item->estado == 'AC')
                                <a href="{{ url('feriaproducto/'.$item->productor->pro_id.'/'.$item->fpd_id.'/lista') }}" class="btn btn-warning btn-sm"><i class="fa fa-edit"></i> Lista de Productos</a>
                            @endif

                            @if ($item->estado == 'AC')
                                @if(strtotime(date('Y-m-d')) > strtotime($item->feriaVirtual->fecha_final) )
                                    {{--<a class="btn btn-sm btn-warning" target="_blank" href="{{url('feriaproductor/certificado/'.$item->fpd_id.'/'.$item->productor->pro_id)}}" ><i class="fa fa-print"></i> Certificado</a>--}}
                                    <button type="button" class="btn btn-sm btn-warning" onclick="buscarCertificado('{{$item->fpd_id}}','{{$item->productor->pro_id}}');"><i class="fa fa-print"></i> Certificado</button>
                                @endif
                            @endif
                        </th>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <div class="d-flex justify-content-center">
                {{ $lista->links() }}
            </div>
        </div>
    </div>

@endsection

@section('footer_scripts')
    <script type="text/javascript">
        $(document).ready(function(){
        });

        function buscarProductorePorFeria() {
            var fev_id = $("#fev_id").val();
            loaderR.showPleaseWait();
            $.ajax({
                url : '{{url("feriaproductor/_buscarproductoresxferia")}}',
                data : {
                    fev_id:fev_id
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

        function crearFeriaProductor()
        {
            var fev_id = $("#fev_id").val();
            location.href = '{{ url('feriaproductor/create') }}'+'/'+fev_id ;
        }


        function modificarEstado(fpd_id,nombre,texto)
        {
            var mensajeConsulta = '¿Desea '+texto+' la feria productor: '+nombre+'?';
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
                                url : '{{url("feriaproductor/_modificarEstado")}}',
                                data : {
                                    fpd_id : fpd_id,
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

        function buscarCertificado(fpd_id,pro_id) {
            loaderR.showPleaseWait();
            $.ajax({
                url : '{{url("feriaproductor/certificado/existecertificado")}}',
                data : {
                    fpd_id:fpd_id,
                    pro_id:pro_id
                },
                type : 'POST',
                success : function(resp) {
                    console.log(resp);
                    if(resp.res == true){
                        consultaImpresion(true,resp.fecha,resp.usuario,fpd_id,pro_id);
                    }else{
                        consultaImpresion(false,'','',fpd_id,pro_id);
                    }
                },
                error : function(xhr, status) {
                    alert('Disculpe, existió un problema');
                },
                complete : function(xhr, status) {
                    loaderR.hidePleaseWait();
                }
            });
        }

        function consultaImpresion(existe,fecha,usuario,fpd_id,pro_id)
        {
            if(existe==true){
                $.confirm({
                    theme: 'modern',
                    title: false,
                    content: "Este certificado ya se imprimio el: "+fecha+" por el usuario:"+usuario+" <br/> ¿Desea reimprimir el certificado?",
                    buttons: {
                        SI: {
                            text: 'SI',
                            btnClass: 'btn-blue',
                            keys: ['enter'],
                            action: function(){
                                window.open("{{url("feriaproductor/certificado")}}"+"/"+fpd_id+"/"+pro_id, '_blank').focus();
                            }
                        },
                        NO: {
                            text: 'NO',
                            btnClass: 'btn-red',
                            action: function(){

                            }
                        }
                    }
                });
            }else{
                window.open("{{url("feriaproductor/certificado")}}"+"/"+fpd_id+"/"+pro_id, '_blank').focus();
            }

        }

    </script>
@endsection
