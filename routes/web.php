<?php

use Illuminate\Support\Facades\Route;

// Controladores
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\VentaController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\ProveedorController;
use App\Http\Controllers\ReporteController;
use App\Http\Controllers\NotificacionController;
use App\Http\Controllers\EntradaController;
use App\Http\Controllers\EntradaDetalleController;

/*
|--------------------------------------------------------------------------
| Página principal
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return view('welcome');
});

/*
|--------------------------------------------------------------------------
| Dashboard
|--------------------------------------------------------------------------
*/
Route::get('/dashboard', function () {
    return view('admin.panel');
})->middleware(['auth', 'verified'])->name('dashboard');

/*
|--------------------------------------------------------------------------
| Perfil
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/*
|--------------------------------------------------------------------------
| Paneles por Rol
|--------------------------------------------------------------------------
*/
Route::get('/admin/panel', fn() => view('admin.panel'))
    ->middleware(['auth', 'role:admin'])
    ->name('admin.panel');

Route::get('/empleado/panel', fn() => view('empleado.panel'))
    ->middleware(['auth', 'role:empleado'])
    ->name('empleado.panel');

/*
|--------------------------------------------------------------------------
| RUTAS SOLO PARA ADMIN
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:admin'])->group(function () {

    // Categorías - Resource automáticamente maneja store() para AJAX y formularios
    Route::resource('categorias', CategoriaController::class);

    // Proveedores - Resource automáticamente maneja store() para AJAX y formularios
    Route::resource('proveedores', ProveedorController::class)->parameters([
    'proveedores' => 'proveedor'
]);

    // Reportes
    Route::get('/reportes', [ReporteController::class, 'index'])
        ->name('reportes.index');

    // Entradas
    Route::resource('entradas', EntradaController::class);

    // Detalles de entrada
    Route::get('entrada-detalle/{id}', [EntradaDetalleController::class, 'show'])
        ->name('entrada.detalle.show');
    
    Route::get('/detalles/{detalle}', [EntradaDetalleController::class, 'show'])
        ->name('detalles.show');

    // Productos - Solo admin puede crear, editar y eliminar
    Route::get('/productos/create', [ProductoController::class, 'create'])->name('productos.create');
    Route::post('/productos', [ProductoController::class, 'store'])->name('productos.store');
    Route::get('/productos/{producto}/edit', [ProductoController::class, 'edit'])->name('productos.edit');
    Route::put('/productos/{producto}', [ProductoController::class, 'update'])->name('productos.update');
    Route::delete('/productos/{producto}', [ProductoController::class, 'destroy'])->name('productos.destroy');

    // Clientes - Solo admin puede eliminar
    Route::delete('/clientes/{id}', [ClienteController::class, 'destroy'])->name('clientes.destroy');
    Route::patch('/clientes/{id}/estado', [ClienteController::class, 'cambiarEstado'])
        ->name('clientes.estado');

    // Ventas - Solo admin puede editar y eliminar
    Route::get('/ventas/{id}/edit', [VentaController::class, 'edit'])->name('ventas.edit');
    Route::put('/ventas/{id}', [VentaController::class, 'update'])->name('ventas.update');
    Route::delete('/ventas/{id}', [VentaController::class, 'destroy'])->name('ventas.destroy');
});

/*
|--------------------------------------------------------------------------
| RUTAS COMPARTIDAS ADMIN + EMPLEADO
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:admin|empleado'])->group(function () {

    // PRODUCTOS - Admin y Empleado pueden ver (empleado solo lectura)
    Route::get('/productos', [ProductoController::class, 'index'])->name('productos.index');
    Route::get('/productos/{producto}', [ProductoController::class, 'show'])->name('productos.show');

    // CLIENTES - Admin y Empleado (empleado no puede eliminar)
    Route::get('/clientes', [ClienteController::class, 'index'])->name('clientes.index');
    Route::get('/clientes/create', [ClienteController::class, 'create'])->name('clientes.create');
    Route::post('/clientes', [ClienteController::class, 'store'])->name('clientes.store');
    Route::get('/clientes/{id}', [ClienteController::class, 'show'])->name('clientes.show');
    Route::get('/clientes/{id}/edit', [ClienteController::class, 'edit'])->name('clientes.edit');
    Route::put('/clientes/{id}', [ClienteController::class, 'update'])->name('clientes.update');

    // VENTAS
    Route::get('/ventas', [VentaController::class, 'index'])->name('ventas.index');
    Route::get('/ventas/create', [VentaController::class, 'create'])->name('ventas.create');
    Route::post('/ventas', [VentaController::class, 'store'])->name('ventas.store');
    Route::get('/ventas/{venta}', [VentaController::class, 'show'])->name('ventas.show');
    Route::get('/ventas/{venta}/factura', [VentaController::class, 'factura'])->name('ventas.factura');
    Route::get('ventas/{id}/pdf', [VentaController::class, 'pdf'])->name('ventas.pdf');
    Route::get('ventas/{id}/ver-pdf', [VentaController::class, 'verPDF'])->name('ventas.ver-pdf');
});

/*
|--------------------------------------------------------------------------
| Notificaciones (admin + empleado)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:admin|empleado'])->group(function () {
    Route::get('/notificaciones', [NotificacionController::class, 'index'])
        ->name('notificaciones.index');

    Route::patch('/notificaciones/{id}/leer', [NotificacionController::class, 'marcarComoLeida'])
        ->name('notificaciones.marcarLeida');

    Route::post('/notificaciones/leer-todas', [NotificacionController::class, 'marcarTodasLeidas'])
        ->name('notificaciones.marcarTodasLeidas');
});

/*
|--------------------------------------------------------------------------
| Logout
|--------------------------------------------------------------------------
*/
Route::post('/logout', function () {
    auth()->logout();
    return redirect('/');
})->name('logout');

// Auth routes
require __DIR__.'/auth.php';