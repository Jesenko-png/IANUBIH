<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Admin\CooperationInquiryController as AdminCooperationInquiryController;
use App\Http\Controllers\Admin\NewsController as AdminNewsController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
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
    Route::get('/forgot-password', [ForgotPasswordController::class, 'create'])
        ->name('password.request');
    Route::post('/forgot-password', [ForgotPasswordController::class, 'store'])
        ->middleware('throttle:3,10')
        ->name('password.email');
    Route::get('/reset-password/{token}', [ResetPasswordController::class, 'create'])
        ->name('password.reset');
    Route::post('/reset-password', [ResetPasswordController::class, 'store'])
        ->middleware('throttle:6,1')
        ->name('password.update');
});

Route::middleware('auth')->group(function () {
    Route::get('/account', [AccountController::class, 'show'])->name('account.show');
    Route::post('/logout', [AdminAuthController::class, 'destroy'])->name('logout');

    Route::prefix('admin')->name('admin.')->middleware('admin')->group(function () {
        Route::redirect('/', '/admin/news')->name('home');
        Route::resource('news', AdminNewsController::class)
            ->parameters(['news' => 'newsPost'])
            ->except('show');
        Route::resource('cooperation-inquiries', AdminCooperationInquiryController::class)
            ->parameters(['cooperation-inquiries' => 'cooperationInquiry'])
            ->only(['index', 'show']);

        Route::middleware('super_admin')->group(function () {
            Route::post('/cooperation-inquiries/setup', [AdminCooperationInquiryController::class, 'setup'])
                ->name('cooperation-inquiries.setup');
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
