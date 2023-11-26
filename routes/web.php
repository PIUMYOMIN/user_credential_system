<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });


Route::get('/', function () {
    return view('index');
});

Route::get('/login',[UserController::class,'login'])->name('user.login');

Route::get('/register',[UserController::class,'register'])->name('user.register');

Route::post('/user/register_create',[UserController::class,'user_register'])->name('user.register_create');

Route::post('/user/user_login',[UserController::class,'user_login'])->name('user.user_login');

Route::post('/user/logout',[UserController::class,'logout'])->name('user.logout');

Route::middleware('auth')->group(function () {
    Route::get('/admin', function () {
        return view('admin');
    });
});