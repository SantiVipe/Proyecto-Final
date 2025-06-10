<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\VentaController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\DashboardController;

Route::get('/',[AuthController::class, 'showLoginForm'])->name('login'); 
Route::post('/', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class,'logout'])->name('logout');
Route::get('/test', function () {
    return view('test');
});

Route::get('password/forgot', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');

Route::get('password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('password/reset', [ResetPasswordController::class, 'reset'])->name('password.update');

Route::prefix('productos')->group(function () {
    Route::get('/', [ProductoController::class, 'index'])->name('productos.index');
    Route::get('/crear', [ProductoController::class, 'create'])->name('productos.create');
    Route::post('/',[ProductoController::class, 'store'])->name('productos.store');
    Route::get('/{producto}', [ProductoController::class, 'show'])->name('productos.show');
    Route::get('/{producto}/editar', [ProductoController::class, 'edit'])->name('productos.edit');
    Route::put('/{producto}', [ProductoController::class, 'update'])->name('productos.update');
    Route::delete('/{producto}', [ProductoController::class, 'destroy'])->name('productos.destroy');
});

Route::prefix('clientes')->group(function (){
    Route::get('/', [ClienteController::class, 'index'])->name('clientes.index');
    Route::get('/crear',[ClienteController::class, 'create'])->name('clientes.create');
    Route::post('/',[ClienteController::class, 'store'])->name('clientes.store');
    Route::get('/{cliente}',[ClienteController::class, 'show'])->name('clientes.show');
    Route::get('/{cliente}/editar', [ClienteController::class, 'edit'])->name('clientes.edit');
    Route::put('/{cliente}', [ClienteController::class, 'update'])->name('clientes.update');
    Route::delete('/{cliente}', [ClienteController::class, 'destroy'])->name('clientes.destroy');
});

Route::prefix('ventas')->group(function (){
    Route::get('/', [VentaController::class, 'index'])->name('ventas.index');
    Route::get('/crear', [VentaController::class, 'create'])->name('ventas.create');
    Route::post('/',[VentaController::class, 'store'])->name('ventas.store');
    Route::get('/{venta}',[VentaController::class, 'show'])->name('ventas.show');
    Route::get('/{venta}/editar',[VentaController::class, 'edit'])->name('ventas.edit');
    Route::put('/{venta}', [VentaController::class, 'update'])->name('ventas.update');
    Route::delete('/{venta}', [VentaController::class, 'destroy'])->name('ventas.destroy');
});

Route::middleware(['auth'])->get('/empleados', function () {
    return view('empleados.dashboard');
})->name('empleado.dashboard');

Route::middleware(['auth', 'checkrole:admin'])->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    Route::prefix('usuarios')->group(function (){
        Route::get('/', [UserController::class, 'index'])->name('usuarios.index');
        Route::get('/crear', [UserController::class, 'create'])->name('usuarios.create');
        Route::post('/', [UserController::class, 'store'])->name('usuarios.store');
        Route::get('/{usuario}',[UserController::class, 'show'])->name('usuarios.show');
        Route::get('/{usuario}/editar', [UserController::class, 'edit'])->name('usuarios.edit');
        Route::put('/{usuario}', [UserController::class, 'update'])->name('usuarios.update');
        Route::delete('/{usuario}', [UserController::class, 'destroy'])->name('usuarios.destroy');
    });
});

Route::middleware(['auth'])->group(function () {
    Route::get('/home', [App\Http\Controllers\AuthController::class, 'home'])->name('home');
});

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');