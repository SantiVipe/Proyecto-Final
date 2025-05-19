<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\ClienteController;  // corregido typo ClienteController
use App\Http\Controllers\VentaController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');  // corregido AUthController a AuthController

Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register.form');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');
Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::middleware(['auth', 'checkrole:admin'])->group(function () {
    

    Route::prefix('productos')->group(function () {
        Route::get('/', [ProductoController::class, 'index'])->name('productos.index');
        Route::get('/crear', [ProductoController::class, 'create'])->name('productos.create');
        Route::post('/', [ProductoController::class, 'store'])->name('productos.store');  // corregido 'produtos.store'
        Route::get('/{producto}', [ProductoController::class, 'show'])->name('productos.show');  // corregido nombre route
        Route::get('/{producto}/editar', [ProductoController::class, 'edit'])->name('productos.edit');
        Route::put('/{producto}', [ProductoController::class, 'update'])->name('productos.update');  // corregido nombre route
        Route::delete('/{producto}', [ProductoController::class, 'destroy'])->name('productos.destroy');
    });

    Route::prefix('clientes')->group(function () {
        Route::get('/', [ClienteController::class, 'index'])->name('clientes.index');  // corregido 'route' a 'Route'
        Route::get('/crear', [ClienteController::class, 'create'])->name('clientes.create');
        Route::post('/', [ClienteController::class, 'store'])->name('clientes.store');
        Route::get('/{cliente}', [ClienteController::class, 'show'])->name('clientes.show');
        Route::get('/{cliente}/editar', [ClienteController::class, 'edit'])->name('clientes.edit');  // corregido 'route' a 'Route'
        Route::put('/{cliente}', [ClienteController::class, 'update'])->name('clientes.update');
        Route::delete('/{cliente}', [ClienteController::class, 'destroy'])->name('clientes.destroy');  // corregido 'route' a 'Route'
    });

    Route::prefix('ventas')->group(function () {
        Route::get('/', [VentaController::class, 'index'])->name('ventas.index');
        Route::get('/crear', [VentaController::class, 'create'])->name('ventas.create');  // corregido 'route' a 'Route'
        Route::post('/', [VentaController::class, 'store'])->name('ventas.store');
        Route::get('/{venta}', [VentaController::class, 'show'])->name('ventas.show');
        Route::get('/{venta}/editar', [VentaController::class, 'edit'])->name('ventas.edit');  // corregido nombre route y mayúsculas
        Route::put('/{venta}', [VentaController::class, 'update'])->name('ventas.update');  // corregido nombre route
        Route::delete('/{venta}', [VentaController::class, 'destroy'])->name('ventas.destroy');  // corregido 'route' a 'Route'
    });

    Route::prefix('usuarios')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('usuarios.index');
        Route::get('/crear', [UserController::class, 'create'])->name('usuarios.create');  // corregido 'route' a 'Route'
        Route::post('/', [UserController::class, 'store'])->name('usuarios.store');
        Route::get('/{usuario}/editar', [UserController::class, 'edit'])->name('usuarios.edit');  // corregido 'route' a 'Route'
        Route::put('/{usuario}', [UserController::class, 'update'])->name('usuarios.update');
        Route::delete('/{usuario}', [UserController::class, 'destroy'])->name('usuarios.destroy');
    });
});
