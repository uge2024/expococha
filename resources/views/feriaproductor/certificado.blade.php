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
            /*background-color: #f7f7f7;*/
            background-image: url('{{$fondo}}');
            background-repeat: no-repeat;
            background-attachment: fixed;
            background-size: 100% 100%;
        }
        .page-break {
            page-break-after: always;
        }

        .tabla-cabecera{
            width: 100%;
            min-height: 180px;
            height: 180px;
            border-collapse: collapse;
            border-radius: 4px;
        }
        .glosa-participacion{
            width: 100%;
            margin-left: 30px;
            margin-right: 30px;
            font-size: 20pt;
            text-align: justify;
            font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
        }
        .tabla-firmas{
            width: 100%;
            border-collapse: collapse;
        }
        footer {
            position: absolute;
            bottom: 0;
            width: 100%;
            height: 110px;
        }
        .texto-gobernacion{
            background: #3b579d;
            color: white;
            width: 100%;
            text-align: left;
            font-size: 14pt;
            font-family: Arial, Helvetica, sans-serif;
            font-weight: bold;
            margin: 15px 1px 1px 1px;
            padding: 0;
        }
        .texto-codigo{
            font-weight: bold;
            position: absolute;
            bottom: 0;
            top: 740px;
            right: 15px;
            width: 100%;
            text-align: right;
            font-size: 9pt;
            font-family: "Times New Roman", Times, serif;
            padding: 0;
            margin: 1px 1px 1px 1px;
        }
    </style>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Certificado</title>
</head>

<body>
    @php
        $cantidad = $certificados->count();
    @endphp
    @foreach($certificados as $key=>$certificado)
        <div style="margin: 95px;">

            <div>
                <table class="tabla-cabecera">
                    <thead>
                    <tr>
                        <th style="width: 30%;" valign="top" align="left">
                            {{--<img alt="No encontrado" src="{{asset('images/logogobernacion.png')}}" class="imagenlogo">--}}
                        </th>
                        <th style="width: 40%;" valign="middle">

                        </th>
                        <th style="width: 30%;" valign="middle" align="right">
                            {{--<img alt="No encontrado" src="{{asset('storage/uploads/'.$institucion->imagen_reporte)}}" class="imagenlogo">--}}
                        </th>
                    </tr>
                    </thead>
                </table>

                <p class="glosa-participacion">
                    Este documento certifica que <b>{{$certificado->nombre}}</b> participo en la <b>{{$certificado->feria}}</b> versión {{$certificado->version}}.
                    Llevada a cabo desde el <b>{{date('d/m/Y',strtotime($certificado->fecha_inicio))}}</b> al <b>{{date('d/m/Y',strtotime($certificado->fecha_final))}}</b>.
                </p>
            </div>


            {{--<footer>
                <table class="tabla-firmas">
                    <thead>
                    <tr>
                        <th>
                            <div style="align-content: center;">
                                <p>............................................</p>
                            </div>
                        </th>
                    </tr>
                    </thead>
                </table>

                <p class="texto-gobernacion">Gobierno Autónomo Departamental de Cochabamba</p>
                <p class="texto-codigo">{{$certificado->codigo}}</p>
            </footer>--}}

        </div>
        <p class="texto-codigo">{{$certificado->codigo}}</p>
        @if($cantidad < ($key+1))
            <div class="page-break"></div>
        @endif
    @endforeach

<script type="text/php">
    if (isset($pdf)) {
      $font = $fontMetrics->getFont("Arial", "bold");
      $pdf->page_text(10, 10, "Página {PAGE_NUM} de {PAGE_COUNT}", $font, 7, array(0, 0, 0));
    }
</script>


</body>
