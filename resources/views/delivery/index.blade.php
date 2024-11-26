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
                            <li>Deliverys</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb Area End-->
    <h3 align="center">Lista de Deliverys - {{$titulo}}</h3>
    <div class="col-md-12">
        <div class="col-md-12">
            <a href="{{ url('delivery/create/'.$pro_id.'/'.$usr_id) }}" class="btn btn-primary btn-sm" id="btnNuevo"><i class="fa fa-plus"></i> Agregar</a>
        <br>
        <div class="content" id="contenidoLista">
            <table class="table table-hover table-responsive-xl table-sm" id="tablaContenido">
                <thead>
                <tr>
                    <th>
                        N°
                    </th>
                    <th>
                        Razon social
                    </th>
                    <th>
                        Propietario
                    </th>
                    <th>
                        Tipo transporte
                    </th>
                    <th>
                        Disponible
                    </th>
                    <th>
                        Costo Min.
                    </th>
                    <th>
                        Costo Max.
                    </th>
                    <th>
                        Estado
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
                            {{$item->razon_social}}
                        </td>
                        <td>
                            {{$item->propietario}}
                        </td>
                        <td>
                            {{$item->tipo_transporte}}
                        </td>
                        <td>
                            @if ($item->disponible == '1')
                                <p style="color:#00A600 "> <b>SI</b></p>
                            @endif
                            @if ($item->disponible != '1')
                                <p style="color:#FF0000 "> <b>NO</b></p>
                            @endif
                        </td>
                        <td>
                            {{$item->costo_minimo}}
                        </td>
                        <td>
                            {{$item->costo_maximo}}
                        </td>
                        <td>
                            @if ($item->estado == 'AC')
                                <p style="color:#00A600 "> <b>Habilitado</b></p>
                            @endif
                            @if ($item->estado != 'AC')
                                <p style="color:#FF0000 "> <b>Inhabilitado</b></p>
                            @endif
                        </td>
                        <td>
                            @if ($item->razon_social == 'Sin delivery')

                            @endif
                            @if ($item->razon_social != 'Sin delivery')

                                @if ($item->estado == 'AC')
                                    <a href="{{ url('delivery/edit/'.$item->del_id) }}" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i> Editar</a>
                                @endif
                                @if ($item->estado != 'AC')
                                @endif
                                @if ($item->estado == 'AC')
                                <button type="button" class="btn btn-danger btn-sm" onclick="modificarEstado('{{$item->del_id}}','{{$item->razon_social}}','inhabilitar');"><i class="fa fa-trash"></i> Inhabilitar</button>
                                @endif
                                @if ($item->estado != 'AC')
                                    <button type="button" class="btn btn-success btn-sm" onclick="modificarEstado('{{$item->del_id}}','{{$item->razon_social}}','habilitar');"><i class="fa fa-trash"></i> Habilitar</button>
                                @endif

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
        $(document).ready(function(){
        });

        function modificarEstado(del_id,razon_social,texto)
        {
            var mensajeConsulta = '¿Desea '+texto+' el delivery: '+razon_social+'?';
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
                                url : '{{url("delivery/_modificarEstado")}}',
                                data : {
                                    del_id:del_id,
                                    texto:texto
                                },
                                type : 'POST',
                                success : function(resp) {
                                    console.log(resp);
                                    if(resp.res == true){
                                        toastr.success('Operación completada','');
                                        location.reload(true);
                                    }else{
                                        toastr.error('Ocurrio un error al eliminar el delivery','');
                                    }
                                },
                                error : function(xhr, status) {
                                    toastr.error('Ocurrio un error al eliminar el delivery','');
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
