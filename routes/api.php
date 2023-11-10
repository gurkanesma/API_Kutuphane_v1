<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

if(isset($_REQUEST['token']) AND $_REQUEST['token']=='s5dg465g465dfg456dfg56dg45f43d1g6f5d4g56d5gd')
{

    //Books
    Route::get('books', [App\Http\Controllers\BookController::class, 'index']); //listeleme
    Route::post('books', [App\Http\Controllers\BookController::class, 'store']); //ekleme
    Route::put('books/{id}', [App\Http\Controllers\BookController::class, 'update']); //güncelleme
    Route::delete('books/{id}', [App\Http\Controllers\BookController::class, 'destroy']); //silme

    //User
    Route::post('register', [App\Http\Controllers\UserController::class, 'register']); //Kullanıcı Kaydı
    Route::post('login', [App\Http\Controllers\UserController::class, 'login']); //Kullanıcı girişi
    Route::post('logout', [App\Http\Controllers\UserController::class, 'logout']); //Kullanıcı çıkışı

}

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
