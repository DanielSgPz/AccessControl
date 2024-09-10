<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admincontroller;
use App\Http\Controllers\AuthController;

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

Route::group(['middleware' => ['auth', 'superuser']], function () {
    Route::get('initialize', [AdminController::class, 'showInitializationForm'])->name('initialize');
    Route::post('initialize', [AdminController::class, 'initialize'])->name('initialize.submit');
    Route::get('/admin/edit/{id}', [Admincontroller::class, 'editAdmin'])->name('admin.edit');
    Route::put('/admin/update/{id}', [Admincontroller::class, 'updateAdmin'])->name('admin.update');
    Route::delete('admin/{id}/delete', [AdminController::class, 'deleteAdmin'])->name('admin.delete');
});

Route::get('/', function () {
    return view('welcome');
});

//login management
Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('login', [AuthController::class, 'login'])->name('login.submit');
Route::post('logout', [AuthController::class, 'logout'])->name('logout');
