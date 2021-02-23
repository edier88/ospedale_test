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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/register', [App\Http\Controllers\Auth\RegisterController::class, 'index'])->name('register');
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/mostrarUsuarios/{id?}', [App\Http\Controllers\HomeController::class, 'mostrarUsuarios'])->name('mostrarUsuarios');

Route::post('/update', [App\Http\Controllers\HomeController::class, 'updateUser'])->name('update');
Route::post('/create', [App\Http\Controllers\HomeController::class, 'createUser'])->name('create');
Route::post('/remove/{id}', [App\Http\Controllers\HomeController::class, 'removeUser'])->name('removeUser');
