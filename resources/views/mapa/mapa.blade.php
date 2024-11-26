<!DOCTYPE html>
<html class="no-js" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta name="author" content="Gobernación de Cochabamba">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />


    {{--<link rel="shortcut icon" type="image/x-icon" href="{{asset('images/favicon/favicon.png')}}" />--}}
    <link rel="shortcut icon" type="image/png" href="{{ asset('images/favicon.png') }}">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Muli:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&amp;display=swap" type="text/css" media="all">
    <link rel="stylesheet" href="{{asset('css/vendor/vendor.min.css')}}" />
    <link rel="stylesheet" href="{{asset('css/plugins/plugins.min.css')}}" />
    <link rel="stylesheet" href="{{asset('css/style.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/jquery-confirm.min.css')}}" type='text/css'>
    <link rel="stylesheet" href="{{asset('css/toastr.min.css')}}" type="text/css">
    <link rel="stylesheet" href="{{asset('css/bootstrap-datepicker3.min.css')}}" type="text/css">
    <link rel="stylesheet" href="{{asset('css/ol.css')}}" type="text/css">
    <style rel="stylesheet">
        .map {
            height:100%;
            width:100%;
            overflow:hidden;
        }
    </style>
</head>

<body>

<div id="map" class="map">
    <div id="popup"></div>
</div>

<script src="{{asset('js/vendor/vendor.min.js')}}"></script>
<script src="{{asset('js/plugins/plugins.min.js')}}"></script>
<script src="{{asset('js/main.js')}}"></script>
<script type="text/javascript" src="{{ asset('js/jquery-confirm.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/toastr.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/jquery.numeric.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/bootstrap-datepicker.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/bootstrap-datepicker.es.min.js') }}"></script>
<script type="text/javascript" src="{{asset('js/util.js')}}"></script>
<script type="text/javascript" src="{{asset('js/ol.js')}}"></script>

<script>
    var latitud = {{$latitud}};
    var longitud = {{$longitud}};
    var direccion = '{{$direccion}}';
    var zoom = {{$zoom ?? 18}};
    $(document).ready(function (){
        //##############MAPA
        var iconFeature = new ol.Feature({
            geometry: new ol.geom.Point(ol.proj.fromLonLat([longitud, latitud])),
            name: direccion,
            population: 4000,
            rainfall: 500
        });

        var iconStyle = new ol.style.Style({
            image: new ol.style.Icon(/** @type {olx.style.IconOptions} */ ({
                anchor: [0.5, 70],
                scale: 0.9,
                opacity: 0.80,
                anchorXUnits: 'fraction',
                anchorYUnits: 'pixels',
                src: '{{asset('images/icons/icon.png')}}'
            }))
        });

        iconFeature.setStyle(iconStyle);

        var vectorSource = new ol.source.Vector({
            features: [iconFeature]
        });

        var vectorLayer = new ol.layer.Vector({
            source: vectorSource
        });

        var osm = new ol.layer.Tile({
            source: new ol.source.OSM()
        });

        var map = new ol.Map({
            layers: [ osm,vectorLayer],
            target: document.getElementById('map'),
            view: new ol.View({
                center: ol.proj.fromLonLat([longitud, latitud]),
                zoom: zoom
            })
        });

        var element = document.getElementById('popup');

        var popup = new ol.Overlay({
            element: element,
            positioning: 'bottom-center',
            stopEvent: false,
            offset: [0, -50]
        });
        map.addOverlay(popup);

        map.on('click', function(evt) {
            var feature = map.forEachFeatureAtPixel(evt.pixel,
                function(feature) {
                    return feature;
                });
            if (feature) {
                var coordinates = feature.getGeometry().getCoordinates();
                popup.setPosition(coordinates);
                $(element).popover({
                    'placement': 'top',
                    'html': true,
                    'content': feature.get('name')
                });
                $(element).popover('toggle');
            } else {
                $(element).popover('dispose');
            }
        });
        //##############END MAPA
    });
</script>

</body>
</html>
