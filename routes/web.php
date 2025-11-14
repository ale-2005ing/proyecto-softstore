<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\ClienteController;

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
Route::resource('productos', ProductoController::class);

// Gestión de clientes
Route::resource('clientes', ClienteController::class);

// Carga de rutas de autenticación
require __DIR__.'/auth.php';

use App\Http\Controllers\ReporteController;

Route::get('/reportes', [ReporteController::class, 'index'])
    ->middleware(['auth', 'role:admin'])
    ->name('reportes.index');
