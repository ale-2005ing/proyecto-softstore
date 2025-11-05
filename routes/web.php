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
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/panel', fn() => view('admin.panel'))->name('admin.panel');
});

Route::middleware(['auth', 'role:empleado'])->group(function () {
    Route::get('/empleado/panel', fn() => view('empleado.panel'))->name('empleado.panel');
});



    // Aquí puedes agregar más rutas de empleado
// Gestión de categorías
Route::resource('categorias', CategoriaController::class);

// Gestión de productos
Route::resource('productos', ProductoController::class);

// Gestión de clientes
Route::resource('clientes', ClienteController::class);

// Carga de rutas de autenticación
require __DIR__.'/auth.php';
