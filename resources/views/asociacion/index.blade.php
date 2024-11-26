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
                            <li>Asociacion</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb Area End-->
    <h3 align="center">Lista de Asociación</h3>
    <div class="col-md-12">
        <div class="col-md-12">
            <a href="{{ url('asociacion/create') }}" class="btn btn-primary btn-sm" id="btnNuevo"><i class="fa fa-plus"></i> Agregar</a>
            <form class="col-md-12" action="{{url('asociacion/')}}" method="get">
                <div class="row">
                    <div class="col-md-1"></div>
                    <div class="col-md-1">
                        <label for="search">Buscar por:</label>
                    </div>
                    <div class="col-md-2">
                        {{
                            Form::select('searchtype',[1=>'Nombre asociacion',2=>'Actividad '],$searchtype,  ['class' => 'form-control form-control-sm','id' => 'searchtype'])
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
                            Form::select('sort',[1=>'Nombre asociacion',2=>'Actividad',3=>'Sigla',4=>'direccion'],$sort,  ['class' => 'form-control form-control-sm','id' => 'sort'])
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
                        Sigla
                    </th>
                    <th>
                        Nombre Asociacion
                    </th>
                    <th>
                        Actividad
                    </th>
                    <th>
                        Direccion
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
                            {{$item->sigla}}
                        </td>
                        <td>
                            {{$item->nombre}}
                        </td>
                        <td>
                            {{$item->actividad}}
                        </td>
                        <td>
                            {{$item->direccion}}
                        </td>
                        <td>
                            <a href="{{ url('asociacion/edit/'.$item->aso_id) }}" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i> Editar</a>
                            <button type="button" class="btn btn-danger btn-sm" onclick="modificarEstado('{{$item->aso_id}}','{{$item->nombre}}');"><i class="fa fa-trash"></i> Eliminar</button>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <div class="d-flex justify-content-center">
                {{ $lista->appends(['searchtype'=>$searchtype,'search'=>$search,'sort'=>$sort])->links() }}
            </div>
        </div>
      </div>
    </div>

@endsection

@section('footer_scripts')
    <script type="text/javascript">

        $(document).ready(function(){
        });

        function modificarEstado(aso_id,nombre)
        {
            var mensajeConsulta = '¿Desea eliminar la asociacion: '+nombre+'?';
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
                                url : '{{url("asociacion/_modificarEstado")}}',
                                data : {
                                    aso_id:aso_id
                                },
                                type : 'POST',
                                success : function(resp) {
                                    console.log(resp);
                                    if(resp.res == true){
                                        toastr.success('Operación completada','');
                                        location.reload(true);
                                    }else{
                                        toastr.error('Ocurrio un error al eliminar la asociacion','');
                                    }
                                },
                                error : function(xhr, status) {
                                    toastr.error('Ocurrio un error al eliminar la asociacion','');
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
