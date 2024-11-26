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
                            <li>Mis ferias</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb Area End-->
    <h3 align="center">Mis ferias</h3>
    <form class="col-md-12" action="{{url('producto/'.$usr_id.'/lista')}}" method="get">
        <div class="row">
            <div class="col-md-1"></div>
            <div class="col-md-1">
                <label for="search">Buscar por:</label>
            </div>
            <div class="col-md-2">
                {{
                    Form::select('searchtype',[1=>'Nombre Producto',2=>'Descripcion corta'],$searchtype,  ['class' => 'form-control form-control-sm','id' => 'searchtype'])
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
                    Form::select('sort',[1=>'Nombre Producto',2=>'Descripcion corta',3=>'Stock',4=>'Precio'],$sort,  ['class' => 'form-control form-control-sm','id' => 'sort'])
                }}
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-search"></i> Buscar</button>
            </div>
        </div>
    </form>

    <div class="col-md-12">
        <div class="col-md-12">

        <div class="content" id="contenidoLista">
            <table class="table table-hover table-responsive-xl table-sm" id="tablaContenido">
                <thead>
                <tr>
                    <th>
                        N°
                    </th>
                    <th>
                        Feria
                    </th>
                    <th>
                        Descricpion
                    </th>
                    <th>
                        Version
                    </th>
                    <th>
                        Fecha final
                    </th>
                     <th width="14%">
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
                            {{$item->feriaVirtual->nombre}}
                        </td>
                        <td>
                            {{$item->feriaVirtual->descripcion}}
                        </td>
                        <td>
                            {{$item->feriaVirtual->version}}
                        </td>
                        <td>
                            {{date('d/m/Y',strtotime($item->feriaVirtual->fecha_final))}}
                        </td>

                        <td>
                            @if ($item->comprobante == 'activo')
                                <a href="{{ url('feriaproducto/'.$item->productor->pro_id.'/'.$item->fpd_id.'/lista') }}" class="btn btn-warning btn-sm"><i class="fa fa-edit"></i> Lista de Productos</a>
                            @endif
                            @if ($item->comprobante != 'activo')
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


    </script>
@endsection
