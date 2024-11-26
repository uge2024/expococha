<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/*Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', 'HomeController@index')->name('home');*/

Route::get('/', 'HomeController@index');
Route::get('/politica-privacidad', 'HomeController@privacidad');
Route::get('/acerca-de-nosotros', 'HomeController@acerca');
Route::post('/checkstates','HomeController@getestados');

//Auth::routes();
// Authentication Routes...
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');

// Registration Routes...
Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('register', 'Auth\RegisterController@register');

//Verification email
Route::post('sendVerification', 'Auth\VerificarCorreoController@reenviarCorreoVerificacion')->name('register.sendverification');
Route::get('sendVerification/{token}', 'Auth\VerificarCorreoController@validarCorreoVerificacion')->name('register.validateverification');

// Password Reset Routes...
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('password.update');

Route::get('tienda','PostController@tienda');
Route::get('mensaje','PostController@mensaje');
Route::post('_mensaje','PostController@_mensaje');
Route::get('enviarmasivo','PostController@enviarmasivo');
Route::resource('post','PostController');
Route::get('ejecutarSql','PostController@ejecutarSql');
//USUARIO
Route::group(['prefix' => 'usuario'], function() {
    Route::get('/miperfil','UserController@miPerfil');
    Route::post('/perfilstoredatos','UserController@storeDatos');
    Route::post('/perfilstorecontrasenia','UserController@storeContrasenia');
});


Route::group(['prefix' => 'rubro'], function() {
    Route::get('/','RubroController@index');
    Route::get('/create','RubroController@create');
    Route::post('/store','RubroController@store');
    Route::get('/edit/{pos_id}','RubroController@edit');
    Route::post('/_modificarEstado','RubroController@_modificarEstado');
    //Rutas de categoria rubros
    Route::get('/categoriarubro/create/{rub_id}','CategoriaRubroController@create');
    Route::post('/categoriarubro/store','CategoriaRubroController@store');
    Route::get('/categoriarubro/edit/{cat_id}/{rub_id}','CategoriaRubroController@edit');
    Route::post('/categoriarubro/_modificarEstado','CategoriaRubroController@_modificarEstado');
    Route::post('/categoriarubro/_cargarComboCategoriasByRubro','CategoriaRubroController@_cargarComboCategoriasByRubro');
    Route::get('/categoriarubro/listacategoria/{rub_id}','CategoriaRubroController@listacategoria');
});

Route::group(['prefix' => 'productor'], function() {
    Route::get('/{usr_id}','ProductorController@index');
    Route::post('/store','ProductorController@store')->middleware('auth');
    Route::post('/_modificarEstado','ProductorController@_modificarEstado')->middleware('auth');
    Route::post('/_eliminarimagenbanner','ProductorController@_eliminarimagenbanner')->middleware('auth');
    Route::get('/createeditproductor/{usr_id}','ProductorController@createeditproductor')->middleware('auth');
    Route::get('/tienda/{pro_id}','ProductorController@tienda');
    Route::post('/tienda/_guardarValoracion','ProductorController@_guardarValoracion')->middleware('auth');
    Route::post('/_eliminarimagen_icono','ProductorController@_eliminarimagen_icono')->middleware('auth');
});

Route::group(['prefix' => 'delivery'], function() {
    Route::get('/{pro_id}','DeliveryController@index');
    Route::get('/create/{pro_id}/{usr_id}','DeliveryController@create');
    Route::get('/edit/{del_id}','DeliveryController@edit');
    Route::post('/store','DeliveryController@store');
    Route::post('/_modificarEstado','DeliveryController@_modificarEstado');
});

Route::group(['prefix' => 'asociacion'], function() {
    Route::get('/','AsociacionController@index');
    Route::get('/create','AsociacionController@create');
    Route::get('/edit/{aso_id}','AsociacionController@edit');
    Route::post('/store','AsociacionController@store');
    Route::post('/_modificarEstado','AsociacionController@_modificarEstado');
});

Route::group(['prefix' => 'producto'], function() {
    Route::get('/ver/{prd_id}','ProductoController@ver');
    Route::post('/ver/_guardarValoracion','ProductoController@_guardarValoracion')->middleware('auth');
    Route::get('/buscar','ProductoController@buscar');
    Route::get('/todos','ProductoController@todos');
    Route::get('/ofertas','ProductoController@ofertas');
    Route::get('/nuevos','ProductoController@nuevos');
    Route::get('/rubros/{rub_id}/lista','ProductoController@rubros');
    Route::get('/categorias/{cat_id}/lista','ProductoController@categorias');

    Route::get('/{usr_id}/lista','ProductoController@index')->middleware('auth');
    Route::get('/create/{pro_id}/{usr_id}','ProductoController@create')->middleware('auth');
    Route::get('/edit/{prd_id}/{pro_id}/{usr_id}','ProductoController@edit')->middleware('auth');
    Route::post('/store','ProductoController@store');
    Route::post('/_modificarEstado','ProductoController@_modificarEstado')->middleware('auth');
    Route::post('/_eliminarimagen_producto','ProductoController@_eliminarimagen_producto')->middleware('auth');
    Route::get('/registro_oferta_crear/{prd_id}/{usr_id}','ProductoController@registro_oferta_crear');
    Route::post('/registrooferta','ProductoController@registrooferta');
    Route::post('/_eliminarimagen_qr','ProductoController@_eliminarimagen_qr')->middleware('auth');
});

Route::group(['prefix' => 'institucion'], function() {
    Route::get('/createedit','InstitucionController@createedit');
    Route::post('/store','InstitucionController@store');
});

Route::group(['prefix' => 'feriavirtual'], function() {

    //vista de ferias al publico
    Route::get('/lista','FeriaVirtualController@lista');
    Route::get('/ver/{fev_id}','FeriaVirtualController@ver');
    Route::get('/verproducto/{fpr_id}','FeriaVirtualController@verproducto');
    //end vista de ferias al publico

    Route::get('/','FeriaVirtualController@index')->middleware('auth');
    Route::get('/create','FeriaVirtualController@create')->middleware('auth');
    Route::get('/edit/{fev_id}','FeriaVirtualController@edit')->middleware('auth');
    Route::post('/store','FeriaVirtualController@store')->middleware('auth');
    Route::post('/_modificarEstado','FeriaVirtualController@_modificarEstado')->middleware('auth');
    Route::post('/_eliminarimagenbanner','FeriaVirtualController@_eliminarimagenbanner')->middleware('auth');

});

Route::group(['prefix' => 'denuncia'], function() {
    Route::get('/','DenunciaController@index');
    Route::get('/midenuncia','DenunciaController@midenuncia');
    Route::get('/show/{den_id}','DenunciaController@show');
    Route::post('/store','DenunciaController@store');
    Route::post('/_modificarEstado','DenunciaController@_modificarEstado');
});

Route::group(['prefix' => 'invitacionproductor'], function() {
    Route::get('/','InvitacionProductoresController@index');
    Route::get('/listainvitacion','InvitacionProductoresController@listainvitacion');
    Route::post('/mandarlista','InvitacionProductoresController@mandarlista');
    Route::post('/obtenerlistaproductorbyrubro','InvitacionProductoresController@obtenerlistaproductorbyrubro');
    Route::post('/_obtenerdatosemail','InvitacionProductoresController@_obtenerdatosemail');
});

Route::group(['prefix' => 'feriaproductor'], function() {
    Route::get('/{fev_id}','FeriaProductorController@index');
    Route::get('/create/{fev_id}','FeriaProductorController@create');
    Route::get('/edit/{fpd_id}','FeriaProductorController@edit');
    Route::post('/store','FeriaProductorController@store');
    Route::post('/_modificarEstado','FeriaProductorController@_modificarEstado');
    Route::post('/_selectproductores','FeriaProductorController@_selectproductores');
    //certificado
    Route::post('/certificado/existecertificado','FeriaProductorController@existecertificado');
    Route::post('/certificado/existencertificados','FeriaProductorController@existencertificados');
    Route::get('/certificado/{fpd_id}/{pro_id}','FeriaProductorController@certificado');
    Route::get('/certificados/{fev_id}','FeriaProductorController@certificados');
});

Route::group(['prefix' => 'inscripcionproducto'], function() {
    Route::get('/','InscripcionProductoController@index');
    Route::get('/listainvitacion','InscripcionProductoController@listainvitacion');
});

Route::group(['prefix' => 'feriaproducto'], function() {
    Route::get('/misferias/{usr_id}/lista','FeriaProductoController@misferias');
    Route::get('/{pro_id}/{fpd_id}/lista','FeriaProductoController@index');
    Route::get('/create/{pro_id}/{fpd_id}','FeriaProductoController@create');
    Route::get('/edit/{fpr_id}/{pro_id}/{fpd_id}','FeriaProductoController@edit');
    Route::post('/store','FeriaProductoController@store');
    Route::post('/_eliminarimagen_producto','FeriaProductoController@_eliminarimagen_producto');


    Route::post('/_modificarEstado','FeriaProductoController@_modificarEstado');
    Route::get('/createlistaproductos/{pro_id}/{fpd_id}','FeriaProductoController@createlistaproductos');
    Route::post('/mandarlistacheck','FeriaProductoController@mandarlistacheck'); //quitar
    Route::post('/_obtenerlistaproductos','FeriaProductoController@_obtenerlistaproductos');
});


Route::group(['prefix' => 'enviarcorreomasivo'], function() {
    Route::get('/','EnviarCorreoMasivoController@index');
    Route::post('/mandarlista','EnviarCorreoMasivoController@mandarlista');
});


//ADMINISTRACION
Route::group(['prefix' => 'administracion'], function() {
    //administracion de usuarios
    Route::get('/usuarios','AdministracionController@usuarios');
    Route::get('/usuarios/create','AdministracionController@usuarioCreate');
    Route::get('/usuarios/edit/{id}','AdministracionController@usuarioEdit');
    Route::post('/usuarios/store','AdministracionController@usuarioStore');
    Route::post('/usuarios/update','AdministracionController@usuarioUpdate');
    Route::get('/usuarios/changepassword/{id}','AdministracionController@changepassword');
    Route::post('/usuarios/changepassword','AdministracionController@storechangepassword');
    Route::post('/usuarios/_modificarEstado','AdministracionController@_modificarEstado');
    //administracion de productores
    Route::get('/productores','AdministracionController@productores');
    Route::post('/productores/_modificarEstadoProductor','AdministracionController@_modificarEstadoProductor');
    Route::get('/productores/catalogoProductor/{pro_id}','AdministracionController@catalogoProductor');
});

//MENSAJES
Route::group(['prefix' => 'mensajes'], function() {
    Route::get('/','MensajeUsuarioController@index');
    Route::get('chat/{usr_id_r}','MensajeUsuarioController@chat');
    Route::post('_chat','MensajeUsuarioController@_chat');
    Route::post('store','MensajeUsuarioController@store');
});

//CARRITO
Route::group(['prefix' => 'carrito'], function() {
    Route::get('/ver','CarritoController@ver');
    Route::post('/_agregarACarrito','CarritoController@_agregarACarrito');
    Route::post('/quitarCarrito','CarritoController@quitarCarrito');
    Route::post('/quitarTodoCarrito','CarritoController@quitarTodoCarrito');

});

//VENTA
Route::group(['prefix' => 'venta'], function() {
    Route::post('/_store','VentaController@_store');
    Route::post('/_storeqr','VentaController@_storeqr');
    Route::post('/_storedeposito','VentaController@_storedeposito');

    Route::get('/miscompras','VentaController@miscompras');
    Route::post('/_verEstadoDelivery','VentaController@_verEstadoDelivery');
    Route::post('/_marcarEntregado','VentaController@_marcarEntregado');

    Route::get('/{usr_id}/misventas','VentaController@misventas');
    Route::post('/_modificarEstadoDelivery','VentaController@_modificarEstadoDelivery');
    Route::post('/_cancelarVenta','VentaController@_cancelarVenta');
    Route::post('/_ventaCompletada','VentaController@_ventaCompletada');
    Route::get('/editDelivery/{ven_id}','VentaController@editDelivery');
    Route::post('/updateDelivery','VentaController@updateDelivery');

    Route::get('/ventassistema','VentaController@ventassistema');

});

//PUBLICIDAD
Route::group(['prefix' => 'publicidad'], function() {
    Route::get('/','PublicidadController@index');
    Route::get('/create','PublicidadController@create');
    Route::get('/edit/{den_id}','PublicidadController@edit');
    Route::post('/store','PublicidadController@store');
    Route::post('/_modificarEstado','PublicidadController@_modificarEstado');
    Route::post('/_cambiartextoavisoimagen','PublicidadController@_cambiartextoavisoimagen');

});

//MAPA PUBLICO
Route::group(['prefix' => 'mapa'], function() {
    Route::get('/mapview','MapaController@mapa');
});

//LOGS
Route::group(['prefix' => 'logsistema'], function() {
    Route::get('/','AuditoriaController@index');

});

//BACKUPS
Route::group(['prefix' => 'backups'], function() {
    Route::get('/','BackupController@index');
    Route::get('/create','BackupController@create');
    Route::post('/store','BackupController@store');
});

//CERTIFICADO FERIA
Route::group(['prefix' => 'certificadoferia'], function() {
    Route::get('/createedit/{fev_id}','CertificadoFeriaController@createedit');
    Route::post('/store','CertificadoFeriaController@store');
});
