<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\VentaController;

// Página principal
Route::get('/', function () {
    return view('welcome');
});

// Dashboard general
Route::get('/dashboard', function () {
    return view('admin.panel');
})->middleware(['auth', 'verified'])->name('dashboard');

// Rutas de perfil
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});



Route::middleware(['auth'])->group(function () {
    Route::get('ventas', [VentaController::class, 'index'])->name('ventas.index');
    Route::get('ventas/create', [VentaController::class, 'create'])->name('ventas.create');
    Route::post('ventas', [VentaController::class, 'store'])->name('ventas.store');
    Route::get('ventas/{venta}', [VentaController::class, 'show'])->name('ventas.show');
    Route::get('ventas/{venta}/pdf', [VentaController::class, 'pdf'])->name('ventas.pdf');
});

// Cerrar sesión
Route::post('/logout', function () {
    auth()->logout();
    return redirect('/');
})->name('logout');

// Rutas de administración (solo admin)
Route::get('/admin/panel', function () {
    return view('admin.panel');
})->middleware(['auth', 'role:admin'])->name('admin.panel');

Route::get('/empleado/panel', function () {
    return view('empleado.panel');
})->middleware(['auth', 'role:empleado'])->name('empleado.panel');

// Aquí puedes agregar más rutas de empleado
// Gestión de categorías
Route::resource('categorias', CategoriaController::class);

// Gestión de productos
use App\Http\Controllers\ProductoController;
Route::resource('productos', ProductoController::class);

// Gestión de clientes
Route::resource('clientes', ClienteController::class);

// Carga de rutas de autenticación
require __DIR__.'/auth.php';

use App\Http\Controllers\ReporteController;

Route::get('/reportes', [ReporteController::class, 'index'])
    ->middleware(['auth', 'role:admin'])
    ->name('reportes.index');
    
//gestion de ventas y facturas 

// Lista de ventas
Route::get('/ventas', [VentaController::class, 'index'])->name('ventas.index');

// Formulario de venta
Route::get('/ventas/create', [VentaController::class, 'create'])->name('ventas.create');

// Guardar venta
Route::post('/ventas', [VentaController::class, 'store'])->name('ventas.store');

// Mostrar factura de una venta específica
Route::get('/ventas/{venta}/factura', [VentaController::class, 'factura'])->name('ventas.factura');

// Notificaciones
use App\Http\Controllers\NotificacionController;
Route::get('/notificaciones', [NotificacionController::class, 'index'])->name('notificaciones.index');
Route::patch('/notificaciones/{id}/leer', [NotificacionController::class, 'marcarComoLeida'])->name('notificaciones.marcarLeida');
Route::post('/notificaciones/leer-todas', [NotificacionController::class, 'marcarTodasLeidas'])->name('notificaciones.marcarTodasLeidas');

//GESTION DE ENTRADAS 
use App\Http\Controllers\EntradaController;
Route::resource('entradas', EntradaController::class);

//GESTION DE DETALLES ENTRADAS 
use App\Http\Controllers\EntradaDetalleController;
Route::get('entrada-detalle/{id}', [EntradaDetalleController::class, 'show'])->name('entrada.detalle.show');
Route::get('detalles/{id}', [EntradaDetalleController::class, 'show'])
        ->name('detalles.show');
    
//GESTION DE PROVEEDORES
use App\Http\Controllers\ProveedorController;

Route::resource('proveedores', ProveedorController::class)->parameters([
    'proveedores' => 'proveedor'
]);
Route::get('ventas/{id}/pdf', [VentaController::class, 'pdf'])->name('ventas.pdf');
Route::get('ventas/{id}/ver-pdf', [VentaController::class, 'verPdf'])->name('ventas.ver-pdf');

