<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Auth\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProfileAdminController;
use App\Http\Controllers\Admin\AdminsEditController;
use App\Http\Controllers\Admin\PermisionRoleController;

Route::prefix('admin')->name('admin.')->group(function () {
    Route::middleware(['guest', 'redirect.admin'])->group(function () {
        Route::get('auth/web-w/login', [AuthController::class, 'showLoginForm'])->name('login');
        Route::post('login', [AuthController::class, 'login'])->name('login.submit');
    });

    /* Rutas protegistas */
    Route::prefix('web-w')->middleware('admin.auth')->group(function () {
        Route::get('logout', [AuthController::class, 'logout'])->name('logout');
        /* PERFIL DE ADMINISTRADOR */
        Route::controller(ProfileAdminController::class)->group(function () {
            Route::get('/perfil', 'index')->name('profile');
            Route::put('/profile-update', 'update_profile')->name('update.profile');
            Route::put('/profile/password', 'updatePassword')->name('update.password');
            Route::post('/profile/photo', 'updatePhoto')->name('update.photo');
            Route::delete('/profile/photo', 'destroyPhoto')->name('delete.photo');
        });

        /* OTROS MODULOS DEL PANEL DE ADMINISTRACIÓN */
        Route::controller(DashboardController::class)->group(function () {
            Route::get('/dashboard', 'index')->name('dashboard');
        });

        /* Rutas para la ediion y muestra de todos los administradores del sistema */
        Route::controller(AdminsEditController::class)->group(function () {
            /** CREAR ADMINISTRADORES CON SUS ROLES */
            Route::get('/create-admin', 'createAdminIndex')->name('createAdmin');
            Route::post('/store-admin', 'storeAdmin')->name('StoreAdmin');
            /** VISTA DEL LISTADO DE CADA ADMINISTRADOR SEGUN SU ROL */
            Route::get('/superadmins', 'saindex')->middleware('admin.permission:superadmins')->name('superadmins');
            Route::get('/admins', 'adminindex')->middleware('admin.permission:admins')->name('admins');
            Route::get('/supervisores', 'supervisorindex')->middleware('admin.permission:supervisores')->name('supervisores');
        });

        /** Rutas para a edicion, creación y listado de los roles y permisos*/
        Route::controller(PermisionRoleController::class)->group(function () {
            /** CREAR ADMINISTRADORES CON SUS ROLES */
            /**Roles*/
            Route::get('/role', 'index')->name('roles');
            Route::get('/role/create', 'create')->name('roles.create');
            Route::post('/role/store', 'store')->name('roles.store');
            Route::get('/role/edit/{role}', 'edit')->name('roles.edit');
            Route::put('/role/update/{role}', 'update')->name('roles.update');
            Route::delete('/role/delete/{role}', 'delete')->name('roles.delete');
            /**end roles routes */

            /**Permisos */
            Route::get('/permission', 'indexPermission')->name('permission');
            Route::get('/permission/create', 'permissionCreate')->name('permission.create');
            Route::post('/permission/store', 'permissionStore')->name('permission.store');
            Route::get('/permission/edit/{permission}', 'permissionEdit')->name('permission.edit');
            Route::put('/permission/update/{permission}', 'permissionUpdate')->name('permission.update');
            Route::delete('/permission/delete/{permission}', 'permissionDelete')->name('permission.delete');
            /**end permisos routes */

            /**End Permisos routes */
            Route::post('/store-admin', 'storeAdmin')->name('StoreAdmin');
            /** VISTA DEL LISTADO DE CADA ADMINISTRADOR SEGUN SU ROL */
            Route::get('/superadmins', 'saindex')->middleware('admin.permission:superadmins')->name('superadmins');
            Route::get('/admins', 'adminindex')->middleware('admin.permission:admins')->name('admins');
            Route::get('/supervisores', 'supervisorindex')->middleware('admin.permission:supervisores')->name('supervisores');
        });
    });
});
