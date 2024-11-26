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
    <h3 align="center">Lista de ferias virtuales</h3>
    <div class="col-md-12">
        <div class="col-md-12">
            <a href="{{ url('feriavirtual/create') }}" class="btn btn-primary btn-sm" id="btnNuevo"><i class="fa fa-plus"></i> Agregar</a>
             {{-- <a href="{{ url('denuncia/midenuncia') }}" class="btn btn-primary btn-sm" id="btnNuevo"><i class="fa fa-plus"></i> Agregarass</a>--}}
        <br>
            <form class="col-md-12" action="{{url('feriavirtual')}}" method="get">
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
            </form>
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
                        Lugar
                    </th>
                    <th>
                        Fecha Inicio
                    </th>
                    <th>
                        Fecha final
                    </th>
                    <th>
                        Rubro
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
                            {{$item->rubro}}
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

                            @if ($item->estado == 'AC')
                                <a href="{{ url('feriaproductor/'.$item->fev_id) }}" class="btn btn-warning btn-sm"><i class="fa fa-edit"></i> Lista de Participantes</a>
                            @endif

                            @if ($item->estado == 'AC')
                                <a href="{{ url('certificadoferia/createedit/'.$item->fev_id) }}" class="btn btn-success btn-sm"><i class="fa fa-edit"></i> Configurar Certificado</a>
                            @endif

                            @if ($item->estado == 'AC')
                                @if(strtotime(date('Y-m-d')) > strtotime($item->fecha_final) )
                                    {{--<a class="btn btn-sm btn-warning" target="_blank" href="{{url('feriaproductor/certificados/'.$item->fev_id)}}" ><i class="fa fa-print"></i> Certificados</a>--}}
                                    <button type="button" class="btn btn-sm btn-warning" onclick="buscarCertificado('{{$item->fev_id}}');"><i class="fa fa-print"></i> Certificados</button>
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

        function buscarCertificado(fev_id) {
            loaderR.showPleaseWait();
            $.ajax({
                url : '{{url("feriaproductor/certificado/existencertificados")}}',
                data : {
                    fev_id:fev_id
                },
                type : 'POST',
                success : function(resp) {
                    console.log(resp);
                    if(resp.res == true){
                        consultaImpresion(true,fev_id)
                    }else{
                        consultaImpresion(false,fev_id)
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

        function consultaImpresion(existe,fev_id)
        {
            if(existe==true){
                $.confirm({
                    theme: 'modern',
                    title: false,
                    content: "Algunos certificados ya se imprimieron <br/> ¿Desea reimprimir todos los certificados?",
                    buttons: {
                        SI: {
                            text: 'SI',
                            btnClass: 'btn-blue',
                            keys: ['enter'],
                            action: function(){
                                window.open("{{url("feriaproductor/certificados")}}"+"/"+fev_id, '_blank').focus();
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
                window.open("{{url("feriaproductor/certificados")}}"+"/"+fev_id, '_blank').focus();
            }

        }

    </script>



@endsection
