<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group([
    'prefix' => 'auth'
], function () {
    Route::post('login', 'AuthController@login');
    Route::post('signup', 'AuthController@signUp');

    Route::group([
      'middleware' => 'auth:api'
    ], function() {
        Route::get('logout', 'AuthController@logout');
    });
});

//usuario
Route::group(['prefix' => 'usuario'], function() {
    Route::get('/user','Api\UsuarioControllerApi@getUsuarioLogeado')->middleware('auth:api');
});

//inicio
Route::group(['prefix' => 'inicio'], function() {
    Route::get('/ofertas','Api\ProductoControllerApi@ofertasinicio');
    Route::get('/nuevos','Api\ProductoControllerApi@nuevosinicio');
    Route::get('/productos','Api\ProductoControllerApi@productosinicio');
    Route::get('/rubros','Api\RubroControllerApi@rubros');
    Route::get('/informacion','Api\DatosControllerApi@datosIniciales');
});

//rubros
Route::group(['prefix' => 'rubros'], function() {
    Route::get('/categorias/{rub_id}','Api\CategoriaControllerApi@getCategoriasByRubro');
    Route::get('/productos/{rub_id}/lista','Api\RubroControllerApi@getProductosByRubro');
});

//categorias
Route::group(['prefix' => 'categorias'], function() {
    Route::get('/productos/{cat_id}/lista','Api\CategoriaControllerApi@getProductosByCategoria');
});

//producto
Route::group(['prefix' => 'producto'], function() {
    Route::get('/ver/{prd_id}','Api\ProductoControllerApi@ver');
    Route::get('/buscar','Api\ProductoControllerApi@buscarProducto');
    Route::get('/valoraciones/{prd_id}','Api\ProductoControllerApi@valoraciones');
    Route::post('storeValoracion','Api\ProductoControllerApi@storeValoracion')->middleware('auth:api');
});

//productor
Route::group(['prefix' => 'productor'], function() {
    Route::get('/ver/{pro_id}','Api\ProductorControllerApi@ver');
    Route::get('/productos/{pro_id}','Api\ProductorControllerApi@productos');
    Route::get('/valoraciones/{pro_id}','Api\ProductorControllerApi@valoraciones');
    Route::post('storeValoracion','Api\ProductorControllerApi@storeValoracion')->middleware('auth:api');
});

//ventas compras
Route::group(['prefix' => 'venta'], function() {
    Route::get('/miscompras','Api\VentaControllerApi@miscompras')->middleware('auth:api');
    Route::post('/comprarRedes','Api\VentaControllerApi@store')->middleware('auth:api');
    Route::post('/comprarQr','Api\VentaControllerApi@storeqr')->middleware('auth:api');
    Route::post('/comprarDeposito','Api\VentaControllerApi@storedeposito')->middleware('auth:api');

    Route::get('/estadoDelivery/{ven_id}','Api\VentaControllerApi@estadoDelivery')->middleware('auth:api');
    Route::post('/marcarEntregado','Api\VentaControllerApi@marcarEntregado')->middleware('auth:api');
});

//ferias virtuales
Route::group(['prefix' => 'feria'], function() {
    Route::get('/ferias','Api\FeriaVirtualControllerApi@ferias');
    Route::get('/ver/{fev_id}','Api\FeriaVirtualControllerApi@ver');
    Route::get('/productos/{fev_id}/lista','Api\FeriaVirtualControllerApi@productos');
});

//feria producto
Route::group(['prefix' => 'feriaproducto'], function() {
    Route::get('/ver/{fpr_id}','Api\FeriaVirtualControllerApi@verProductoFeria');
});


//carrito de compra
Route::group(['prefix' => 'carrito'], function() {
    Route::post('/agregarCarrito','Api\CarritoControllerApi@agregarACarrito')->middleware('auth:api');
    Route::post('/quitarCarrito','Api\CarritoControllerApi@quitarCarrito')->middleware('auth:api');
    Route::get('/miCarrito','Api\CarritoControllerApi@miCarrito')->middleware('auth:api');
});
