<?php


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

Route::group(['middleware' => ['guest']], function () {
    Route::get('/', 'App\Http\Controllers\Auth\LoginController@showLoginForm');
    Route::post('/', 'App\Http\Controllers\Auth\LoginController@login')->name('login');
});

Route::group(['middleware' => ['auth']], function () {
    Route::post('/logout', 'App\Http\Controllers\Auth\LoginController@logout')->name('logout');
    Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');
    Route::resource('user', App\Http\Controllers\UserController::class)->names('user');
    Route::resource('roles', App\Http\Controllers\RoleController::class)->except('show')->names('roles');
    Route::resource('mantenimientoweb/whatsapp', App\Http\Controllers\WhatsappController::class)->except('show,edit,create')->names('whatsapp');
    Route::resource('mantenimiento/hotel', App\Http\Controllers\HotelController::class)->except('show,edit,create')->names('hotel');
    Route::resource('mantenimiento/pasajero', App\Http\Controllers\PasajeroController::class)->except('show,edit,create,destroy')->names('pasajero');
    Route::resource('mantenimiento/medio', App\Http\Controllers\MedioController::class)->except(' show,edit,create')->names('medio');
    Route::resource('mantenimiento/guia', App\Http\Controllers\GuiaController::class)->except('show,edit,create')->names('guia');
    Route::resource('mantenimiento/restaurante', App\Http\Controllers\RestauranteController::class)->except('show,edit,create')->names('restaurante');
    Route::resource('mantenimiento/transporte', App\Http\Controllers\TransporteController::class)->except('show,edit,create')->names('transporte');
    Route::resource('mantenimiento/agencia', App\Http\Controllers\AgenciaController::class)->except('show,edit,create')->names('agencia');
    Route::resource('mantenimiento/proveedor', App\Http\Controllers\ProveedorController::class)->except('show,edit,create')->names('proveedor');
    Route::resource('mantenimientoweb/categoria', App\Http\Controllers\CategoriaController::class)->except('show,edit,create')->names('categoria');
    Route::resource('mantenimientoweb/ubicacion', App\Http\Controllers\UbicacionController::class)->except('show,edit,create')->names('ubicacion');
    Route::resource('reserva', App\Http\Controllers\ReservaController::class)->except('show', 'index')->names('reserva');
    Route::resource('mantenimiento/servicio', App\Http\Controllers\ServicioController::class)->except('show,edit,create')->names('servicio');
    Route::resource('mantenimientoweb/tour', App\Http\Controllers\TourController::class)->names('tour');
    Route::resource('mantenimientoweb/comentario', App\Http\Controllers\ComentarioController::class)->except('show,edit,create,store,update')->names('comentario');
    Route::resource('mantenimientoweb/paquete', App\Http\Controllers\PaqueteWebController::class)->names('paqueteweb');
    Route::resource('mantenimientoweb/blog', App\Http\Controllers\BlogController::class)->names('blog');
    Route::get('mantenimiento/traducirblog/{lang}/{blog}', [App\Http\Controllers\BlogController::class,'traducir'])->name('blog.traducir');
    Route::post('mantenimiento/blogtraducido/{blog}', [App\Http\Controllers\BlogController::class,'blogtraducido'])->name('blog.blogtraducido');
    Route::resource('mantenimientoweb/cabecera', App\Http\Controllers\CabeceraController::class)->except('show,edit,create')->names('cabecera');
    Route::resource('mantenimientoweb/nosotros', App\Http\Controllers\NosotroController::class)->except('show,edit,create')->names('nosotros');
    Route::resource('mantenimientoweb/menu', App\Http\Controllers\MenuController::class)->except('edit,create,show')->names('menu');
    Route::get('mantenimientoweb/menu/traducir/{lang}/{menu}', [App\Http\Controllers\MenuController::class,'traducir'])->name('menu.traducir');
    Route::resource('mantenimientoweb/certificados', App\Http\Controllers\CertificacioController::class)->except('show,edit,create')->names('certificados');
    Route::get('mantenimientoweb/cabeceralista', [App\Http\Controllers\CabeceraController::class, 'lista'])->name('administracion.mantenimientoweb.cabecera.lista');


    Route::get('mantenimiento/traducir/{lang}/{tour}', [App\Http\Controllers\TourController::class,'traducir'])->name('tour.traducir');
    Route::get('mantenimientoweb/traducirpaquete/{lang}/{paquete}', [App\Http\Controllers\PaqueteWebController::class,'traducir'])->name('paquete.traducir');
    Route::get('mantenimientoweb/traducircertificado/{lang}/{certificado}', [App\Http\Controllers\CertificacioController::class,'traducir'])->name('certificados.traducir');
    Route::get('mantenimientoweb/traducircabecera/{lang}/{cabecera}', [App\Http\Controllers\CabeceraController::class,'traducir'])->name('cabecera.traducir');
    Route::get('mantenimientoweb/traducirnosotros/{lang}/{nosotros}', [App\Http\Controllers\NosotroController::class,'traducir'])->name('nosotros.traducir');
    Route::post('mantenimiento/guardartraducido/{tour}', [App\Http\Controllers\TourController::class,'guardartraducido'])->name('tour.guardartraducido');

    Route::post('mantenimiento/paqueteguardar/{paquete}', [App\Http\Controllers\PaqueteWebController::class,'guardartraducido'])->name('paquete.guardartraducido');
    Route::get('paquete/pdf/{paquete}', [App\Http\Controllers\PaqueteController::class, 'pdf'])->name('paquete.pdf');






    // Route::get('mantenimientoweb/cabecera/{operar}', [App\Http\Controllers\CabeceraController::class, 'lista'])->name('mantenimiento.cabecera');

    Route::get('reportes/reservas/', [App\Http\Controllers\ReporteController::class, 'reservas'])->name('reportes.reservas');
    Route::get('pdf/reservaspdf/{fechainicio?}/{fechafin?}/{usuario2?}', [App\Http\Controllers\ReporteController::class, 'reservaspdf'])->name('reportes.reservaspdf');
    Route::get('excel/reservasexcel/{fechainicio?}/{fechafin?}/{usuario2?}', [App\Http\Controllers\ReporteController::class, 'reservasexcel'])->name('reportes.reservasexcel');


    Route::get('webscraping', [App\Http\Controllers\DashboardController::class, 'webscraping'])->name('webscraping');


    Route::resource('endoseinn', App\Http\Controllers\EndoseInnController::class)->parameters(['endoseinn' => 'reserva'])->names('endoseinn');
    Route::resource('endoseout', App\Http\Controllers\EndoseOutController::class)->parameters(['endoseout' => 'operar'])->except('show')->names('endoseout');
    Route::resource('mantenimientoweb/idioma', App\Http\Controllers\LanguageController::class)->except(['show','edit','create'])->names('language');
    Route::get('endoseout/mensaje/{operar}', [App\Http\Controllers\EndoseOutController::class, 'mensaje'])->name('endoseout.mensaje');
    Route::get('endoseout/ver/{operar}', [App\Http\Controllers\EndoseOutController::class, 'ver'])->name('endoseout.ver');
    Route::get('reserva/lista', [App\Http\Controllers\ReservaController::class, 'index'])->name('reserva.index');
    Route::get('reserva/ver/{reserva}', [App\Http\Controllers\ReservaController::class, 'ver'])->name('reserva.ver');
    Route::get('reserva/seguimiento', [App\Http\Controllers\ReservaController::class, 'seguimiento'])->name('reserva.seguimiento');
    Route::get('reserva/pdfticket/{reserva}', [App\Http\Controllers\ReservaController::class, 'pdfticket'])->name('reserva.ticket');
    Route::get('reserva/pasajeros/{reserva}', [App\Http\Controllers\ReservaController::class, 'pasajeros'])->name('reserva.pasajeros');
    Route::get('reserva/notificar/{reserva}', [App\Http\Controllers\ReservaController::class, 'notificar'])->name('reserva.notificar');

    Route::resource('operar', App\Http\Controllers\OperarController::class)->except('show', 'index')->names('operar');
    Route::get('operar/lista-tour', [App\Http\Controllers\OperarController::class, 'index'])->name('operar.index');
    Route::get('operar/crear-tour', [App\Http\Controllers\OperarController::class, 'createtour'])->name('operar.createtour');
    Route::get('operar/lista-servicio', [App\Http\Controllers\OperarController::class, 'servicio'])->name('operar.servicio');
    Route::get('operar/ver/{operar}', [App\Http\Controllers\OperarController::class, 'ver'])->name('operar.ver');
    Route::get('operar/pdf/{operar}', [App\Http\Controllers\OperarController::class, 'pdf'])->name('operar.pdf');
    Route::get('operar/show-tour/{operar}', [App\Http\Controllers\OperarController::class, 'showtour'])->name('operar.showtour');
    Route::post('operar/show-tour', [App\Http\Controllers\OperarController::class, 'showtourguardar'])->name('operar.showtourguardar');

    Route::resource('liquidacion', App\Http\Controllers\LiquidacionController::class)->except('show', 'index')->names('liquidacion');
    Route::get('liquidacion/ingreso', [App\Http\Controllers\LiquidacionController::class, 'ingreso'])->name('liquidacion.ingreso');
    Route::get('liquidacion/salida', [App\Http\Controllers\LiquidacionController::class, 'salida'])->name('liquidacion.salida');
    Route::get('liquidacion/ingresocreate', [App\Http\Controllers\LiquidacionController::class, 'ingresocreate'])->name('liquidacion.ingresocreate');
    Route::get('liquidacion/salidacreate', [App\Http\Controllers\LiquidacionController::class, 'salidacreate'])->name('liquidacion.salidacreate');
    Route::get('liquidacion/ver/{liquidacion}', [App\Http\Controllers\LiquidacionController::class, 'ver'])->name('liquidacion.ver');
    Route::get('liquidacion/pdf/{liquidacion}', [App\Http\Controllers\LiquidacionController::class, 'pdf'])->name('liquidacion.pdf');

    Route::resource('paquete', App\Http\Controllers\PaqueteController::class)->except('show', 'index')->names('paquete');
    Route::get('paquete/lista', [App\Http\Controllers\PaqueteController::class, 'index'])->name('paquete.lista');
    Route::get('paquete/ver/{paquete}', [App\Http\Controllers\PaqueteController::class, 'ver'])->name('paquete.ver');
    Route::get('paquete/pdf/{paquete}', [App\Http\Controllers\PaqueteController::class, 'pdf'])->name('paquete.pdf');
    Route::get('paquete/vender/{paquete}', [App\Http\Controllers\PaqueteController::class, 'vender'])->name('paquete.vender');

    Route::group(['prefix' => 'error'], function () {
        Route::get('404', function () {
            return view('pages.error.404');
        });
        Route::get('500', function () {
            return view('pages.error.500');
        });
    });
});
