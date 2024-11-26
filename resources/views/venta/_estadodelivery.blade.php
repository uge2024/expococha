@php
    $producto = null;
    if(isset($venta->prd_id)){
        $producto = $venta->producto;
    }else{
        $producto = $venta->feriaProducto;
    }
@endphp

<div class="row col-md-12">
    <div class="col-md-2"></div>
    <div class="col-md-10">
        <div class="row" style="margin: 4px;">
            <div class="col-md-4">
                <p><b>Producto: </b></p>
            </div>
            <div class="col-md-6">
                <p>{{$producto->nombre_producto}}</p>
            </div>
        </div>
        <div class="row" style="margin: 4px;">
            <div class="col-md-4">
                <p><b>Cantidad: </b></p>
            </div>
            <div class="col-md-6">
                <p>{{$venta->cantidad}}</p>
            </div>
        </div>
        <div class="row" style="margin: 4px;">
            <div class="col-md-4">
                <p><b>Precio Venta: </b></p>
            </div>
            <div class="col-md-6">
                <p>Bs.  {{$venta->precio_venta}}</p>
            </div>
        </div>
        <div class="row" style="margin: 4px;">
            <div class="col-md-4">
                <p><b>Precio Delivery: </b></p>
            </div>
            <div class="col-md-6">
                <p>Bs.  {{$venta->precio_base_delivery}}</p>
            </div>
        </div>
        <div class="row" style="margin: 4px;">
            <div class="col-md-4">
                <p><b>Total: </b></p>
            </div>
            <div class="col-md-6">
                <p>Bs.  {{$venta->subtotal}}</p>
            </div>
        </div>
        <div class="row" style="margin: 4px;">
            <div class="col-md-4">
                <p><b>Estado Delivery: </b></p>
            </div>
            <div class="col-md-6">
                <p>{{$estado_deliverys[$venta->estado_delivery]}}</p>
                <i class="fa fa-truck fa-4x"></i>
            </div>
        </div>
        <div class="row" style="margin: 4px;">
            <div class="col-md-4">
                <p><b>Delivery: </b></p>
            </div>
            <div class="col-md-6">
                <p>{{$venta->delivery->razon_social}}</p>
            </div>
        </div>
    </div>
    <div class="col-md-2"></div>
</div>
