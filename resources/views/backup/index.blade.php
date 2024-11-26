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
                            <li>Administración / Backups / Backups Sistema</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb Area End-->
    <h3 align="center">Backups Sistema</h3>
    <div class="col-md-12">
        <form class="col-md-12" action="{{url('backups')}}" method="get">
            <div class="row">
                <div class="col-md-1"></div>
                <div class="col-md-1">
                    <label for="search">Buscar por:</label>
                </div>
                <div class="col-md-2">
                    {{
                        Form::select('searchtype',[1=>'Usuario'],$searchtype,  ['class' => 'form-control form-control-sm','id' => 'searchtype'])
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
                        Form::select('sort',[1=>'Fecha',2=>'Usuario'],$sort,  ['class' => 'form-control form-control-sm','id' => 'sort'])
                    }}
                </div>


            </div>

            <div class="row m-2">
                <div class="col-md-1"></div>
                <div class="col-md-1">
                    <label>Desde:</label>
                </div>
                <div class="col-md-2">
                    <input type="text" class="form-control form-control-sm" onkeydown="return false;" name="fecha_inicio" id="fecha_inicio" value="{{$fecha_inicio}}">
                </div>
                <div class="col-md-1">
                    <label>Hasta:</label>
                </div>
                <div class="col-md-2">
                    <input type="text" class="form-control form-control-sm" onkeydown="return false;" name="fecha_fin" id="fecha_fin" value="{{$fecha_fin}}">
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-sm btn-primary" name="btnsearch" id="btnsearch" value="1"><i class="fa fa-search"></i> Buscar</button>
                </div>
                <div class="col-md-2">
                </div>
            </div>
        </form>
        <div class="row">
            <div class="col-md-12 m-2">
                <a class="btn btn-primary btn-sm" href="{{url('backups/create')}}"><i class="fa fa-plus"></i> Crear Nuevo Backup</a>
            </div>
        </div>
        <div class="col-md-12">
            <div class="content" id="contenidoLista">
                <table class="table table-hover table-responsive-xl table-sm" id="tablaContenido">
                    <thead>
                    <tr>
                        <th width="10%">N°</th>
                        <th width="20%">IP</th>
                        <th width="30%">Usuario</th>
                        <th width="20%">Fecha</th>
                        <th width="20%">Archivo</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($lista as $key => $item)
                        <tr>
                            <td>{{$lista->firstItem() + $key}}</td>
                            <td>{{$item->ip}}</td>
                            <td>{{$item->usuario}}</td>
                            <td>{{date('d/m/Y H:i:s',strtotime(str_replace('/','-',$item->fecha)))}}</td>
                            <td>
                                <a class="btn btn-sm btn-warning" href="{{'storage/uploads/'.$item->archivo}}" target="_blank"><i class="fa fa-download"></i> Descargar</a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <div class="d-flex justify-content-center">
                    {{ $lista->appends(['searchtype'=>$searchtype,'search'=>$search,'sort'=>$sort,'fecha_inicio'=>$fecha_inicio,'fecha_fin'=>$fecha_fin])->links() }}
                </div>
            </div>
        </div>
    </div>

@endsection

@section('footer_scripts')
    <script type="text/javascript">

        $(document).ready(function(){
            asignarDatepicker($("#fecha_inicio"));
            asignarDatepicker($("#fecha_fin"));
        });

        function modificarEstado(id,email,estado)
        {
            var mensaje = estado == 'EL'?'banear':'activar';
            var mensajeConsulta = '¿Desea '+mensaje+' al usuario: '+email+'?';
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
                                url : '{{url("administracion/usuarios/_modificarEstado")}}',
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
                                        toastr.error('Ocurrio un error al modificar el usuario','');
                                    }
                                },
                                error : function(xhr, status) {
                                    toastr.error('Ocurrio un error al modificar el usuario','');
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
