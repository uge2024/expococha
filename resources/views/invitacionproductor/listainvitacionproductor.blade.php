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
                            <li>Lista de invitaciones al productor</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb Area End-->
    <h3 align="center">Lista de invitaciones de productor</h3>
    <br><br>
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
                            Enviado por
                        </th>
                        <th>
                            Recibido por
                        </th>
                        <th>
                            Asunto
                        </th>
                        <th>
                            Descripcion
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
                                {{$item->enviado_por}}
                            </td>
                            <td>
                                {{$item->enviado_a}}
                            </td>
                            <td>
                                {{$item->asunto}}
                            </td>
                            <td>
                                {{$item->descripcion}}
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
