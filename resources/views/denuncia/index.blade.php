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
    <h3 align="center">Lista de Denuncias</h3>
    <div class="col-md-12">
        <div class="col-md-12">
        <br>
            {{--
            <form class="col-md-12" action="{{url('denuncia')}}" method="get">
                <div class="row">
                    <div class="col-md-1"></div>
                    <div class="col-md-1">
                        <label for="search">Buscar por:</label>
                    </div>
                    <div class="col-md-2">
                        {{
                            Form::select('searchtype',[1=>'Nombre feria',2=>'Descripcion'],$searchtype,  ['class' => 'form-control form-control-sm','id' => 'searchtype'])
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
                            Form::select('sort',[1=>'Nombre feria',2=>'Descripcion',3=>'Lugar',4=>'Rubro'],$sort,  ['class' => 'form-control form-control-sm','id' => 'sort'])
                        }}
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-search"></i> Buscar</button>
                    </div>
                </div>
            </form>--}}
   <br>
        <div class="content" id="contenidoLista">
            <table class="table table-hover table-responsive-xl table-sm" id="tablaContenido">
                <thead>
                <tr>
                    <th>
                        N°
                    </th>
                    <th>
                        Usuario
                    </th>
                    <th>
                        Productor
                    </th>
                    <th>
                        Producto
                    </th>
                    <th width="50%">
                        Denuncia
                    </th>
                    <th>
                        Estado
                    </th>
                     <th width="5%">
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
                            {{$item->usuario->email}}
                        </td>
                        <td>
                            @php
                                $nombre_tienda = '';
                                if(isset($item->productor->nombre_tienda))
                                {
                                    $nombre_tienda = $item->productor->nombre_tienda;
                                }
                            @endphp
                                {{$nombre_tienda}}
                        </td>
                        <td>
                            @php
                                $nombre_producto = '';
                                if(isset($item->producto->nombre_producto))
                                {
                                    $nombre_producto = $item->producto->nombre_producto;
                                }
                            @endphp
                            {{$nombre_producto}}
                        </td>
                        <td>

                           {{$item->denuncia}}
                        </td>
                        <td>
                            @if ($item->estado_visto == '1')
                                <p style="color:#00A600 "> <b>No visto</b></p>
                            @endif
                            @if ($item->estado_visto != '1')
                                <p style="color:#FF0000 "> <b>Visto</b></p>
                            @endif
                        </td>
                        <th width="5%">
                            <a href="{{ url('denuncia/show/'.$item->den_id) }}" class="btn btn-warning btn-sm"><i class="fa fa-eye"></i> Ver</a>
                        </th>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <div class="d-flex justify-content-center">
                {{ $lista->links() }}
            </div>
        </div>
{{--
            <form class="d-flex" action="{{url('denuncia/midenuncia')}}" method="get">
                user:<input type="text" value="{{$usr_id}}"  name="usr_id" id="usr_id">
                productor:<input type="text"   name="pro_id" id="pro_id">
                producto:<input type="text"   name="prd_id" id="prd_id">
                ferpor:<input type="text"   name="fpr_id" id="fpr_id">
                <button id="btn_guardar" class="btn btn-primary btn-lg" type="submit" >Enviar</button>
            </form>
--}}
      </div>
    </div>

@endsection

@section('footer_scripts')
    <script type="text/javascript">

        $(document).ready(function(){
        });

        function modificarEstado(rub_id,nombre,texto)
        {
            var mensajeConsulta = '¿Desea '+texto+' el Rubro: '+nombre+'?';
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
                                url : '{{url("rubro/_modificarEstado")}}',
                                data : {
                                    rub_id : rub_id,
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
