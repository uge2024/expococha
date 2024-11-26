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
                            <li>Administración / Productores</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb Area End-->
    <h3 align="center">Lista de Productores</h3>
    <div class="col-md-12">
        <form class="col-md-12" action="{{url('administracion/productores')}}" method="get">
            <div class="row">
                <div class="col-md-1"></div>
                <div class="col-md-1">
                    <label for="search">Buscar por:</label>
                </div>
                <div class="col-md-2">
                    {{
                        Form::select('searchtype',[1=>'Nombre Propietario',2=>'Nombre Tienda',3=>'Nombre Usuario'],$searchtype,  ['class' => 'form-control form-control-sm','id' => 'searchtype'])
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
                        Form::select('sort',[1=>'Nombre Propietario',2=>'Nombre Tienda',3=>'Correo Electrónico',4=>'Rubro'],$sort,  ['class' => 'form-control form-control-sm','id' => 'sort'])
                    }}
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-search"></i> Buscar</button>
                </div>

            </div>
        </form>
        <div class="col-md-12">
            <div class="content" id="contenidoLista">
                <table class="table table-hover table-responsive-xl table-sm" id="tablaContenido">
                    <thead>
                    <tr>
                        <th>N°</th>
                        <th>Usuario</th>
                        <th>Nombre Propietario</th>
                        <th>Nombre Tienda</th>
                        <th>Correo Electrónico</th>
                        <th>Rubro</th>
                        <th>Estado</th>
                        <th>Estado Tienda</th>
                        <th width="20%">Acciones</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($lista as $key => $item)
                        <tr>
                            <td>
                                {{$lista->firstItem() + $key}}
                            </td>
                            <td>{{$item->name}}</td>
                            <td>{{$item->nombre_propietario}}</td>
                            <td>{{$item->nombre_tienda}}</td>
                            <td>{{$item->email}}</td>
                            <td>{{$item->rubro}}</td>
                            <td>
                                @php
                                    $estado = 'Activo';
                                    if($item->estado == 'EL'){
                                        $estado = 'Eliminado';
                                    }
                                @endphp
                                {{$estado}}
                            </td>
                            <td>
                                @php
                                    $estado_tienda = 'Habilitado';
                                    if($item->estado_tienda == 'EL'){
                                        $estado_tienda = 'Inhabilitado';
                                    }
                                @endphp
                                {{$estado_tienda}}
                            </td>
                            <td>
                                <a href="{{ url('productor/createeditproductor/'.$item->usr_id) }}" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i> Modificar Datos</a>
                                <a href="{{ url('producto/'.$item->usr_id.'/lista') }}" class="btn btn-success btn-sm"><i class="fa fa-edit"></i> Revisar Productos</a>
                                @if(!empty($item->pro_id))
                                    <a href="{{ url('delivery/'.$item->usr_id) }}" class="btn btn-success btn-sm"><i class="fa fa-edit"></i> Revisar Deliverys</a>
                                    <a href="{{ url('administracion/productores/catalogoProductor/'.$item->pro_id) }}" target="_blank" class="btn btn-warning btn-sm"><i class="fa fa-file-pdf"></i> Catalogo Productor</a>

                                    @if($item->estado_tienda == 'AC')
                                        <button type="button" class="btn btn-danger btn-sm" onclick="modificarEstado('{{$item->pro_id}}','{{$item->nombre_tienda}}','EL');"><i class="fa fa-trash"></i> Inhabilitar Tienda</button>
                                    @else
                                        <button type="button" class="btn btn-primary btn-sm" onclick="modificarEstado('{{$item->pro_id}}','{{$item->nombre_tienda}}','AC');"><i class="fa fa-trash"></i> Habilitar Tienda</button>
                                    @endif
                                @endif
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

        function modificarEstado(id,nombre,estado)
        {
            var mensaje = estado == 'EL'?'inhabilitar':'habilitar';
            var mensajeConsulta = '¿Desea '+mensaje+' la tienda: '+nombre+'?';
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
                            loaderR.showPleaseWait();
                            $.ajax({
                                url : '{{url("administracion/productores/_modificarEstadoProductor")}}',
                                data : {
                                    id : id,
                                    estado:estado
                                },
                                type : 'POST',
                                success : function(resp) {
                                    console.log(resp);
                                    if(resp.res == true){
                                        toastr.success('Operación completada','');
                                        location.reload(true);
                                    }else{
                                        toastr.error('Ocurrio un error al modificar el productor','');
                                    }
                                },
                                error : function(xhr, status) {
                                    toastr.error('Ocurrio un error al modificar el productor','');
                                },
                                complete : function(xhr, status) {
                                    loaderR.hidePleaseWait();
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
