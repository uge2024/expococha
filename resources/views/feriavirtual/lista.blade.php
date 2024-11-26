
@extends('layouts.layout_main',['noMostrarHeaderBuscar'=>'1'])

@section('header_styles')
    <style rel="stylesheet">
        .list-product .new{
            width: auto;
        }
    </style>
@endsection

@section('content')

    <!-- Shop Category Area Start -->
    <div class="shop-category-area mt-30px">
        <div class="container">
            <h3 class="text-center">Ferias Virtuales</h3>
            <div class="row">
                <div class="col-md-12">
                    <!-- Shop Top Area Start -->
                    <form action="{{url('feriavirtual/lista')}}" id="formOrdenar" method="get">
                        <div class="shop-top-bar d-flex">
                            <!-- Left Side start -->
                            <div class="shop-tab nav d-flex">
                                <a class="active" href="#shop-2" data-toggle="tab">
                                    <i class="fa fa-list"></i>
                                </a>
                                <p>Hay {{$ferias->total()}} Ferias.</p>
                            </div>
                            <!-- Left Side End -->
                            <!-- Right Side Start -->
                            <div class="select-shoing-wrap d-flex">
                                <div class="shot-product">
                                    <p>Ordenar Por:</p>
                                </div>
                                <div class="shop-select">
                                    {{
                                        Form::select('sort',[1=>'Nombre de Feria (A a Z)',2=>'Fecha Incio Ascendente',3=>'Fecha Inicio Descendente'],$sort,  ['onchange' => 'this.form.submit();','id' => 'sort'])
                                    }}
                                </div>
                            </div>
                            <!-- Right Side End -->
                        </div>
                    </form>
                    <!-- Shop Top Area End -->

                    <!-- Shop Bottom Area Start -->
                    <div class="shop-bottom-area mt-35">
                        <!-- Shop Tab Content Start -->
                        <div class="tab-content jump">
                            <!-- Tab Two Start -->
                            <div id="shop-2" class="tab-pane active">
                                @foreach($ferias as $key=>$feria)
                                    @php
                                        $rutaVerFeria = url('feriavirtual/ver').'/'.$feria->fev_id;
                                        $esProxima = false;
                                        $fechaActual = date('Y-m-d');
                                        if($fechaActual < $feria->fecha_inicio){
                                            $esProxima = true;
                                        }
                                        $esFeriaPasada = false;
                                        if($fechaActual > $feria->fecha_final){
                                            $esFeriaPasada = true;
                                            //$rutaVerFeria = '#';
                                        }
                                    @endphp
                                    <div class="shop-list-wrap mb-30px scroll-zoom">
                                        <div class="slider-single-item">
                                            <div class="row list-product m-0px">
                                                <div class="col-md-12 padding-0px product-inner">
                                                    <div class="row">
                                                        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 p-0">
                                                            <div class="left-img">
                                                                <div class="img-block">
                                                                    <a href="{{$rutaVerFeria}}" class="thumbnail">
                                                                        @php
                                                                            $contador = 1;
                                                                        @endphp
                                                                        @foreach($feria->imagenFerias as $key => $imagen)
                                                                            @if($imagen->estado == 'AC' && $imagen->tipo == 20)
                                                                                <img class="first-img" src="{{asset('storage/uploads/'.$imagen->imagen)}}" alt="" />
                                                                                @break
                                                                            @endif
                                                                        @endforeach
                                                                    </a>
                                                                    <ul class="product-flag">
                                                                        @if($esProxima)
                                                                            <li class="new">Proximamente</li>
                                                                        @endif
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8 p-0">
                                                            <div class="product-desc-wrap">
                                                                <div class="product-decs">
                                                                    <h2><a href="{{$rutaVerFeria}}" class="product-link">{{$feria->nombre}}</a></h2>
                                                                    <div class="product-intro-info">
                                                                        <p>{{$feria->descripcion}}</p>
                                                                        <p><b>Lugar: </b>{{$feria->lugar}}</p>
                                                                        <p><b>Dirección: </b>{{$feria->direccion}}</p>
                                                                    </div>
                                                                </div>
                                                                <div class="box-inner d-flex">
                                                                    <div class="align-self-center">
                                                                        <div class="in-stock">Fecha Inicio: <span>{{date('d/m/Y',strtotime($feria->fecha_inicio))}}</span></div>
                                                                        <div class="in-stock">Fecha Final: <span>{{date('d/m/Y',strtotime($feria->fecha_final))}}</span></div>
                                                                        <div class="pricing-meta">
                                                                            @if($esProxima)
                                                                                <ul>
                                                                                    <li class="current-price">
                                                                                        Faltan:
                                                                                        <input class="clasecontador" type="hidden" id="hid-{{$feria->fev_id}}" value="{{$feria->fev_id}}">
                                                                                        <input type="hidden" id="fecha-{{$feria->fev_id}}" value="{{date('Y/m/d',strtotime($feria->fecha_inicio))}}">
                                                                                        <div id="conta-{{$feria->fev_id}}">
                                                                                        </div>
                                                                                    </li>
                                                                                </ul>
                                                                            @endif
                                                                        </div>
                                                                        <div class="cart-btn">
                                                                            <a href="{{$rutaVerFeria}}" class="add-to-curt" title="Ver la Feria">Ver la Feria</a>
                                                                        </div>
                                                                        <div class="add-to-link">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <!-- Tab Two End -->
                        </div>
                        <!-- Shop Tab Content End -->
                        <!--  Pagination Area Start -->
                        <div class="d-flex justify-content-center">
                            {{ $ferias->appends(['sort'=>$sort])->links() }}
                        </div>
                        <!--  Pagination Area End -->
                    </div>
                    <!-- Shop Bottom Area End -->
                </div>
            </div>
        </div>
    </div>
    <!-- Shop Category Area End -->

@endsection
@section('footer_scripts')

    <script>
        $(document).ready(function(){

            $( ".clasecontador" ).each(function( index,value ) {
                var id = $(this).val();
                var fecha = $("#fecha-"+id).val();
                $("#conta-"+id).countdown(""+fecha, function(event) {
                    $(this).text(
                        event.strftime('%D dias %H:%M:%S')
                    );
                });
            });

        });
    </script>
@stop
