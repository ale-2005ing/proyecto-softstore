<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

use App\Http\Controllers\InventarioController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ReporteController;

/*
|--------------------------------------------------------------------------
| RUTAS PARA EL ADMINISTRADOR
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'admin'])->group(function () {
    // Panel del administrador
    Route::get('/dashboard-admin', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');

    // Rutas exclusivas del administrador
   // Route::resource('/inventario', InventarioController::class);
    //Route::resource('/usuarios', UserController::class);
    //Route::get('/reportes', [ReporteController::class, 'index'])->name('reportes.index');
});

/*
|--------------------------------------------------------------------------
| RUTAS PARA EL EMPLEADO
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'empleado'])->group(function () {
    // Panel del empleado
    Route::get('/dashboard-empleado', function () {
        return view('empleado.dashboard');
    })->name('empleado.dashboard');

    // El empleado solo puede ver o actualizar inventario
    //Route::resource('/inventario', InventarioController::class)
    //    ->only(['index', 'show', 'update']);
});

// 👑 Ruta para el Administrador
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/dashboard', function () {
        return view('admin.panel');
    })->name('admin.panel');
});

// 👷 Ruta para el Empleado
Route::middleware(['auth', 'empleado'])->group(function () {
    Route::get('/empleado/dashboard', function () {
        return view('empleado.panel');
    })->name('empleado.panel');
});
