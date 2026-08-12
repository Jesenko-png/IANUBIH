<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Admin\NewsController as AdminNewsController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/bs');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AdminAuthController::class, 'create'])->name('login');
    Route::post('/login', [AdminAuthController::class, 'store'])
        ->middleware('throttle:6,1')
        ->name('login.store');
    Route::post('/register', [AdminAuthController::class, 'register'])
        ->middleware('throttle:3,10')
        ->name('register');
});

Route::middleware('auth')->group(function () {
    Route::get('/account', [AccountController::class, 'show'])->name('account.show');
    Route::post('/logout', [AdminAuthController::class, 'destroy'])->name('logout');

    Route::prefix('admin')->name('admin.')->middleware('admin')->group(function () {
        Route::redirect('/', '/admin/news')->name('home');
        Route::resource('news', AdminNewsController::class)
            ->parameters(['news' => 'newsPost'])
            ->except('show');

        Route::middleware('super_admin')->group(function () {
            Route::get('/users', [AdminUserController::class, 'index'])->name('users.index');
            Route::patch('/users/{user}/role', [AdminUserController::class, 'update'])->name('users.update');
        });
    });
});

Route::prefix('{locale}')
    ->where(['locale' => 'bs|en'])
    ->middleware('locale')
    ->group(function () {
        require __DIR__.'/site.php';
    });
