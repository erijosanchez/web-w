<?php

use App\Http\Controllers\Admin\AdminsController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Auth\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProfileAdminController;

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('auth/web-w/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('login', [AuthController::class, 'login'])->name('login.submit');
    Route::get('logout', [AuthController::class, 'logout'])->name('logout');


    /* Rutas protegistas */
    Route::prefix('web-w')->middleware('auth:admin')->group(function () {
        /* PERFIL DE ADMINISTRADOR */
        Route::controller(ProfileAdminController::class)->group(function () {
            Route::get('/perfil', 'index')->name('profile');
            Route::post('/profile-update', 'update_profile')->name('update.profile');
        });

        /* OTROS MODULOS DEL PANEL DE ADMINISTRACIÓN */
        Route::controller(DashboardController::class)->group(function () {
            Route::get('/dashboard', 'index')->name('dashboard');
        });

        /* ADMINISTRADORES */
        Route::controller(AdminsController::class)->group(function () {
            /** CREAR ADMINISTRADORES CON SUS ROLES */
            Route::get('/create-admin', 'createAdminIndex')->name('createAdmin');
            Route::post('/store-admin', 'storeAdmin')->name('StoreAdmin');
            /** VISTA DEL LISTADO DE CADA ADMINISTRADOR SEGUN SU ROL */
            Route::get('/superadmins', 'saindex')->middleware('admin.permission:superadmins')->name('superadmins');
            Route::get('/admins', 'adminindex')->middleware('admin.permission:admins')->name('admins');
            Route::get('/supervisores', 'supervisorindex')->middleware('admin.permission:supervisores')->name('supervisores');
        });
    });
});
