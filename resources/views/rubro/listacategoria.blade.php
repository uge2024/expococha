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
                            <li><a href="{{url('rubro')}}">Rubros y Categorias</a></li>
                            <li>Categorias del Rubro {{$titulo}}</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb Area End-->
    <h3 align="center">Lista de Categorias de {{$titulo}}</h3>
    <div class="col-md-12">
        <div class="col-md-12">
            <a href="{{ url('rubro/categoriarubro/create/'.$rub_id) }}" class="btn btn-primary btn-sm" id="btnNuevo"><i class="fa fa-plus"></i> Agregar</a>
            <a href="{{ url('rubro') }}" class="btn btn-warning btn-sm" ><i class="fa fa-list"></i> Listas de rubros</a>
            <br>

        <div class="content" id="contenidoLista">
            <table class="table table-hover table-responsive-xl table-sm" id="tablaContenido">
                <thead>
                <tr>
                    <th>
                        N°
                    </th>
                    <th>
                        Nombre
                    </th>
                    <th>
                        Descripcion
                    </th>
                    <th>
                        Nivel
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
                            {{$item->nombre}}
                        </td>
                        <td>
                            {{$item->descripcion}}
                        </td>
                        <td>
                            @if ($item->nivel == '1')
                                Padre
                            @else
                                {{$item->categoriaRubros->nombre}}
                            @endif
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
                                <a href="{{ url('rubro/categoriarubro/edit/'.$item->cat_id.'/'.$item->rub_id) }}" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i> Editar</a>
                            @endif
                            @if ($item->estado != 'AC')
                            @endif

                            @if ($item->estado == 'AC')
                                <button type="button" class="btn btn-danger btn-sm" onclick="modificarEstado('{{$item->cat_id}}','{{$item->nombre}}','inhabilitar');"><i class="fa fa-trash"></i> Inhabilitar</button>
                            @endif
                            @if ($item->estado != 'AC')
                                <button type="button" class="btn btn-success btn-sm" onclick="modificarEstado('{{$item->cat_id}}','{{$item->nombre}}','habilitar');"><i class="fa fa-trash"></i> Habilitar</button>
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

@endsection

@section('footer_scripts')
    <script type="text/javascript">
        $(document).ready(function(){
        });

        function modificarEstado(cat_id,nombre,texto)
        {
            var mensajeConsulta = '¿Desea '+texto+' la Categoria rubro: '+nombre+'?';
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
                                url : '{{url("rubro/categoriarubro/_modificarEstado")}}',
                                data : {
                                    cat_id:cat_id,
                                    texto:texto
                                },
                                type : 'POST',
                                success : function(resp) {
                                    console.log(resp);
                                    if(resp.res == true){
                                        toastr.success('Operación completada ','');
                                        location.reload(true);
                                    }else{
                                        toastr.error('Ocurrio un error al eliminar la categoria rubro','');
                                    }
                                },
                                error : function(xhr, status) {
                                    toastr.error('Ocurrio un error al eliminar la categoria rubro','');
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
