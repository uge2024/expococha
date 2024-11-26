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
                            <li><a href="{{ url('venta/'.$usr_id_vendedor.'/misventas') }}">Mis ventas</a></li>
                            <li>Editar Delivery</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb Area End-->
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h3 align="center">Editar Delivery de la Venta</h3>
            <br>
            <form class="form-horizontal" id="formulario" autocomplete="off" method="POST" action="{{ url('venta/updateDelivery') }}">
                {{ csrf_field() }}
                <div class="form-group row">
                    <label class="col-md-1 col-form-label"></label>
                    <label class="col-md-3 col-form-label" for="nombre">Cliente*:</label>
                    <div class="col-md-8">
                        {{Form::hidden('ven_id',$venta->ven_id)}}
                        {{Form::hidden('usr_id_vendedor',$usr_id_vendedor)}}
                        <input type="text" value="{{$venta->usuario->name}}" class="form-control form-control-sm" readonly>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-1 col-form-label"></label>
                    <label class="col-md-3 col-form-label">Producto*:</label>
                    <div class="col-md-8">
                        @if(isset($venta->prd_id))
                            <input type="text" value="{{$venta->producto->nombre_producto}}" class="form-control form-control-sm" readonly>
                        @elseif(isset($venta->fpr_id))
                            <input type="text" value="{{$venta->feriaProducto->nombre_producto}}" class="form-control form-control-sm" readonly>
                        @endif
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-1 col-form-label"></label>
                    <label class="col-md-3 col-form-label" for="nombre">Cantidad*:</label>
                    <div class="col-md-8">
                        <input type="text" value="{{$venta->cantidad}}" name="cantidad" id="cantidad" class="form-control form-control-sm" readonly>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-1 col-form-label"></label>
                    <label class="col-md-3 col-form-label" for="nombre">Precio*:</label>
                    <div class="col-md-8">
                        <input type="text" value="{{$venta->precio_venta}}" name="precio_venta" id="precio_venta" class="form-control form-control-sm" readonly>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-1 col-form-label"></label>
                    <label class="col-md-3 col-form-label" for="nombre">Delivery*:</label>
                    <div class="col-md-8">
                        <select class="form-control form-control-sm" name="del_id" id="del_id" required>
                            @foreach($deliveries as $key=>$delivery)
                                @if($venta->del_id == $delivery->del_id)
                                    <option data-precio="{{$delivery->costo_minimo}}" value="{{$delivery->del_id}}" selected>{{$delivery->razon_social}}</option>
                                @else
                                    <option data-precio="{{$delivery->costo_minimo}}" value="{{$delivery->del_id}}">{{$delivery->razon_social}}</option>
                                @endif
                            @endforeach
                        </select>
                        @error('del_id')
                            <p class="form-text text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-1 col-form-label"></label>
                    <label class="col-md-3 col-form-label" for="nombre">Precio Delivery*:</label>
                    <div class="col-md-8">
                        <input type="text" value="{{$venta->precio_base_delivery}}" onkeyup="actualizarTotal();" name="precio_base_delivery" id="precio_base_delivery" class="form-control form-control-sm" required>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-1 col-form-label"></label>
                    <label class="col-md-3 col-form-label" for="nombre">Total*:</label>
                    <div class="col-md-8">
                        <input type="text" value="{{$venta->subtotal}}" name="subtotal" id="subtotal" class="form-control form-control-sm" readonly>
                    </div>
                </div>

                <div class="row justify-content-center" style="margin-top: 10px;">
                    <div class="col-md-2">
                        <button id="btn_guardar" class="btn btn-primary" type="submit" id="btnGuardar">Guardar</button>
                    </div>
                    <div class="col-md-2">
                        <a href="{{ url('venta/'.$usr_id_vendedor.'/misventas') }}" class="btn btn-danger">Cancelar</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('footer_scripts')
    <script type="text/javascript">
        $(document).ready(function(){
            validarInputDecimal($("#precio_base_delivery"),2);
            $("#del_id").change(function (){
               var del_id = $("#del_id").val();
               var costo = $('#del_id option:selected').data('precio');
               console.log(del_id+' '+costo);
               $("#precio_base_delivery").val(costo);
                actualizarTotal();
            });
        });
        function actualizarTotal(){
            var cantidad = $("#cantidad").val();
            cantidad = tratarComoNumeroV2(cantidad);
            var precio = $("#precio_venta").val();
            precio = tratarComoNumeroV2(precio);
            precio = roundNumber(precio,2);
            var precio_delivery = $("#precio_base_delivery").val();
            precio_delivery = tratarComoNumeroV2(precio_delivery);
            precio_delivery = roundNumber(precio_delivery,2);
            var total = (cantidad*precio) + precio_delivery;
            total = roundNumber(total,2);
            $("#subtotal").val(total);
        }
    </script>
@endsection
