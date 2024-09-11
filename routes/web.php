<?php

use App\Http\Controllers\Accesscontroller;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admincontroller;
use App\Http\Controllers\Admindepartment;
use App\Http\Controllers\AdminUsers;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;

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

Route::get('/accessControlRoom', function () {
    return view('accessControlRoom');
});
Route::post('/access', [Accesscontroller::class, 'validateAccess'])->name('validateAccess');
Route::get('/success', [Accesscontroller::class, 'accessSuccess'])->name('success');
Route::get('/denied', [Accesscontroller::class, 'accessDenied'])->name('denied');


// Authentication Routes
Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('login', [AuthController::class, 'login'])->name('login.submit');
Route::post('logout', [AuthController::class, 'logout'])->name('logout');

// Admin Routes
Route::group(['middleware' => ['auth', 'superuser']], function () {
    Route::get('initialize', [AdminController::class, 'showInitializationForm'])->name('initialize');
    Route::post('initialize', [AdminController::class, 'initialize'])->name('initialize.submit');
    Route::get('/admin/edit/{id}', [Admincontroller::class, 'editAdmin'])->name('admin.edit');
    Route::put('/admin/update/{id}', [Admincontroller::class, 'updateAdmin'])->name('admin.update');
    Route::delete('admin/{id}/delete', [AdminController::class, 'deleteAdmin'])->name('admin.delete');
});

//Management access control
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/employeeLogs', [DashboardController::class, 'employeeLogs'])->name('employeeLogs');

    Route::post('/upload-employees', [AdminUsers::class, 'bulkUpload'])->name('bulkUpload');

    Route::get('/employees/export-pdf/{id?}', [DashboardController::class, 'exportEmployeeHistory'])->name('employees.export-pdf');


    Route::get('/adminUsers', [AdminUsers::class, 'index'])->name('adminusers');
    Route::post('/employees', [AdminUsers::class, 'store'])->name('employees.store');
    Route::get('/employees/{id}', [AdminUsers::class, 'update'])->name('employees.update');
    Route::delete('/employees/{id}', [AdminUsers::class, 'destroy'])->name('employees.delete');

    Route::post('/department', [Admindepartment::class, 'store'])->name('departments.store');
    Route::put('/department/{id}', [Admindepartment::class, 'update'])->name('departments.update');
    Route::delete('/department/{id}', [Admindepartment::class, 'destroy'])->name('departments.delete');
});
