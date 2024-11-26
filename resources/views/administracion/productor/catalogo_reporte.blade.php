<!DOCTYPE html>
<html lang="es">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Catalogo Productor</title>
    <style type="text/css">
        html{
            margin-top: 1cm;
            margin-right: 2cm;
            margin-bottom: 1cm;
            margin-left: 2cm;
            font-family: Arial, Helvetica, sans-serif;
        }
        .page_break { page-break-before: always; }
        .tablaCabecera{
            width: 100%;
            border-collapse: collapse;
            border-spacing: 0;
            margin: 1px;
            font-size: 8pt;
            font-family: Arial, Helvetica, sans-serif;
        }
        .tablaCabecera > tbody > tr > td {
            padding: 1px;
            margin: 1px;
            border-collapse: collapse;
            border-spacing: 0px;

        }
        .tablaCabecera > tbody > tr > td > p {
            font-size: 8pt;
            padding: 0;
            margin: 1px;
            font-family: Arial, Helvetica, sans-serif;
        }
        .tablaCuerpo{
            width: 100%;
            border-collapse: collapse;
            border-spacing: 0;
            margin: 1px;
            font-size: 8pt;
            font-family: Arial, Helvetica, sans-serif;
        }
        .tablaCuerpo > tbody > tr > td,
        .tablaCuerpo > thead > tr > th,
        .tablaCuerpo > tfoot > tr > td
        {
            /*border: 1px solid black;*/
        }
        .tablaActividad{
            width: 100%;
            border-collapse: collapse;
            border-spacing: 0;
            margin: 1px;
            font-size: 12pt;
            font-family: Arial, Helvetica, sans-serif;
        }
        .tablaDatosProductor{
            width: 100%;
            border-collapse: collapse;
            border-spacing: 0;
            margin: 1px;
            font-size: 12pt;
            font-family: Arial, Helvetica, sans-serif;
        }

    </style>
</head>
<body>
<table class="tablaCabecera">
    <thead>
    <tr>
        <th width="30%" align="left">
            <img src="{{asset('storage/uploads/'.$institucion->imagen_reporte)}}" width="150" height="50">
        </th>
        <th width="40%" align="center"> <h1>{{$titulo}}</h1><h2>{{$subtitulo}}</h2> </th>
        <th width="30%" align="right"><p><b>Fecha:</b> {{date('d-m-Y H:i')}}</p></th>
    </tr>
    </thead>
</table>

    <table class="tablaCuerpo">
        <tbody>
        <tr>
            <td width="60%">
                @foreach($productor->imagenProductores as $key => $baner)
                    @if($baner->tipo == 8 && $baner->estado == 'AC')
                        <img src="{{asset('storage/uploads/'.$baner->imagen)}}" alt="Imagen no Encontrada" style="width: 100%;" height="600" />
                        @break
                    @endif
                @endforeach
            </td>
            <td width="40%" valign="top">
                <table class="tablaActividad">
                    <tbody>
                    <tr>
                        <td>
                            {{$productor->actividad}}
                        </td>
                    </tr>
                    </tbody>
                </table>
                <table class="tablaDatosProductor">
                    <tbody>
                    <tr>
                        <td><b>Propietario:</b></td>
                        <td>{{$productor->nombre_propietario}}</td>
                    </tr>
                    <tr>
                        <td><b>Correo Electrónico:</b></td>
                        <td>{{$productor->email}}</td>
                    </tr>
                    <tr>
                        <td><b>Celular:</b></td>
                        <td>{{$productor->celular}}</td>
                    </tr>
                    <tr>
                        <td><b>Whatsapp:</b></td>
                        <td>{{$productor->celular_wp}}</td>
                    </tr>
                    <tr>
                        <td><b>Dirección:</b></td>
                        <td>{{$productor->direccion}}</td>
                    </tr>
                    </tbody>
                </table>
            </td>
        </tr>
        </tbody>
    </table>
    <div class="page_break"></div>

    @foreach($productos as $key=>$producto)
        @php
            $imagenesTodo = $producto->imagenesProducto;
            $imagenes = array();
            foreach ($imagenesTodo as $ima8){
                if ($ima8->tipo == 8 && $ima8->estado == 'AC'){
                    array_push($imagenes,$ima8->imagen);
                }
            }

        @endphp
        <table class="tablaCuerpo" style="height: 700px;max-height: 700px;">
            <tbody>
            <tr>
                <td width="50%" valign="top">
                    <table class="tablaDatosProductor">
                        <tbody>
                            <tr>
                                <td><b>Producto:</b></td>
                                <td>{{$producto->nombre_producto}}</td>
                            </tr>
                            <tr>
                                <td><b>Precio:</b></td>
                                <td>Bs. {{number_format($producto->precio,2, '.', ',')}}</td>
                            </tr>
                        </tbody>
                    </table>
                    <table>
                        <tbody>
                        @for($i=1;$i<5;$i+=2)
                            <tr>
                                <td width="50%">
                                    @if(isset($imagenes[$i]))
                                        <img src="{{asset('storage/uploads/'.$imagenes[$i])}}" alt="Imagen no Encontrada" style="width: 100%;" height="250" />
                                    @endif
                                </td>
                                <td width="50%">
                                    @if(isset($imagenes[$i+1]))
                                        <img src="{{asset('storage/uploads/'.$imagenes[$i+1])}}" alt="Imagen no Encontrada" style="width: 100%;" height="250" />
                                    @endif
                                </td>
                            </tr>
                        @endfor

                        </tbody>
                    </table>
                </td>
                <td width="50%" valign="top">
                    <table>
                        <tbody>
                            <tr>
                                <td>
                                    @if(isset($imagenes[0]))
                                        <img src="{{asset('storage/uploads/'.$imagenes[0])}}" alt="Imagen no Encontrada" style="width: 100%;" height="520" />
                                    @else
                                        <img src="{{asset('storage/uploads/'.'sinimagen.jpg')}}" alt="Imagen no Encontrada" style="width: 100%;" height="520" />
                                    @endif
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
            </tbody>
        </table>

    @endforeach


</body>
</html>
