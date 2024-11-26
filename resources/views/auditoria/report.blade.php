<head>
    <style type="text/css">
        html{
            margin-top: 1cm;
            margin-right: 1cm;
            margin-bottom: 1cm;
            margin-left: 1cm;
            font-family: "Times New Roman", Times, serif;

        }
        body {
            padding: 2px;
        }
        .page-break {
            page-break-after: always;
        }
        .div-cuerpo{
            padding: 2px;
            /*border: solid 1px black;
            border-radius: 5px;*/
        }
        .tablacabecera{
            width: 100%;
            border-collapse: collapse;
            border-radius: 4px;
        }
        .tablacabecera > thead > tr > th > h2{
            margin: 0;
            padding: 0;
            text-align: center;
            vertical-align: middle;
        }
        .parrafoedificio{
            font-size: 10px;
            text-align: left;
            font-weight: lighter;
            margin: 0;
        }
        .imagenlogo{
            width: 200px;
            height: 90px;
            border-radius: 5px;
            padding: 1px;
            margin: 1px 0 1px 0;
        }
        .div-numero-recibo{
            width: 100%;
            border-radius: 5px;
            /*border: solid 1px black;*/
            padding: 3px;
            margin: 2px;
        }
        .div-numero-recibo > p{
            text-align: right;
            font-weight: lighter;
            margin: 0;
            font-size: 11px;
        }
        .tablacontenido{
            width: 100%;
            border-collapse: collapse;
            border-radius: 4px;
        }
        .tablacontenido > thead > tr > th{
            border: solid 1px black;
        }
        .tablacontenido > tbody > tr > td{
            border: solid 1px black;
        }
        .tablacontenido > tfoot > tr > td{
            border: solid 1px black;
        }
        .div-contenido{
            width: 100%;
            display: block;
            padding: 0;
            margin: 10px 10px 10px 10px;
        }
        .div-columna-uno{
            width: 80%;
            display: inline-block;
            padding: 0;
            margin: 0;
        }
        .div-columna-dos{
            width: 20%;
            display: inline-block;
            padding: 0;
            margin: 0;
        }
        .div-footer{
            width: 100%;
            text-align: right;
        }
        .texto-footer{
            padding: 0;
            margin: 0;
            font-size: 8pt;
        }

    </style>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Reporte</title>
</head>

<body>

<div class="div-cuerpo">
    <table class="tablacabecera">
        <thead>
        <tr>
            <th colspan="3">
                <p class="parrafoedificio">{{$institucion->nombre}} - Dirección: {{$institucion->direccion}} Telf.: {{$institucion->celular}}</p>
            </th>
        </tr>
        <tr>
            <th style="width: 30%;" valign="top">
                <div>
                    <img alt="No encontrado" src="{{asset('storage/uploads/'.$institucion->imagen_reporte)}}" class="imagenlogo">

                </div>
            </th>
            <th style="width: 40%;" valign="middle">
                <h2>{{$tituloReporte}}</h2>
                <h4>{{$subtituloReporte}}</h4>
            </th>
            <th style="width: 30%;" valign="top">
                <div class="div-numero-recibo">
                    <p><b>Fecha: </b>{{date('d/m/Y H:i:s')}}</p>
                    <p><b>Usuario: </b>{{$user->name}}</p>
                </div>
            </th>
        </tr>
        </thead>
    </table>
    <div class="div-contenido">
        <table class="tablacontenido" id="tablaContenido">
            <thead>
            <tr>
                <th width="10%">N°</th>
                <th width="20%">IP</th>
                <th width="20%">Usuario</th>
                <th width="10%">Tabla</th>
                <th width="20%">Fecha</th>
                <th width="20%">Acción</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($lista as $key => $item)
                <tr>
                    <td>{{$key + 1 }}</td>
                    <td>{{$item->ip}}</td>
                    <td>{{$item->usuario}}</td>
                    <td>{{$item->tabla}}</td>
                    <td>{{date('d/m/Y H:i:s',strtotime(str_replace('/','-',$item->fecha)))}}</td>
                    <td>{{$item->accion}}</td>
                </tr>
                <tr>
                    <td>Datos: </td>
                    <td colspan="5">
                        <p style="font-size: 8pt;">{{str_replace([',',':'],[' , ',' : '],$item->datos)}}</p>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

</div>

<script type="text/php">
    if (isset($pdf)) {
      $font = $fontMetrics->getFont("Arial", "bold");
      $pdf->page_text(550, 770, "Página {PAGE_NUM} de {PAGE_COUNT}", $font, 7, array(0, 0, 0));
    }
</script>


</body>
