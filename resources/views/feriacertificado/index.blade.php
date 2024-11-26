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
                            <li>Ferias virtuales</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb Area End-->
    <h3 align="center">Lista de fera Certificados</h3>
    <div class="col-md-12">
        <div class="col-md-12">
            <a href="{{ url('feriavirtual/create') }}" class="btn btn-primary btn-sm" id="btnNuevo"><i class="fa fa-plus"></i> Agregar</a>
        <br>
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
                    <th>
                        Nombre
                    </th>
                    <th>
                        Descripcion
                    </th>
                    <th>
                        Lugar
                    </th>
                    <th>
                        Fecha Inicio
                    </th>
                    <th>
                        Fecha final
                    </th>
                    <th>
                        Estado
                    </th>
                     <th width="20%">
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
                            {{$item->rubro->nombre}}
                        </td>
                        <td>
                            {{$item->nombre}}
                        </td>
                        <td>
                            {{$item->descripcion}}
                        </td>
                        <td>
                            {{$item->lugar}}
                        </td>
                        <td>
                            {{date('d/m/Y',strtotime($item->fecha_inicio))}}
                        </td>
                        <td>
                            {{date('d/m/Y',strtotime($item->fecha_final))}}
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
                            @if ($item->estado == 'AC')
                                <a href="{{ url('feriavirtual/edit/'.$item->fev_id) }}" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i> Editar</a>
                            @endif
                            @if ($item->estado != 'AC')
                            @endif
                            @if ($item->estado == 'AC')
                                <button type="button" class="btn btn-danger btn-sm" onclick="modificarEstado('{{$item->fev_id}}','{{$item->nombre}}','inhabilitar');"><i class="fa fa-trash"></i> Inhabilitar</button>
                            @endif
                            @if ($item->estado != 'AC')
                                <button type="button" class="btn btn-success btn-sm" onclick="modificarEstado('{{$item->fev_id}}','{{$item->nombre}}','habilitar');"><i class="fa fa-trash"></i> Habilitar</button>
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
