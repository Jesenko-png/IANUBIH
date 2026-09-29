<?php

use Illuminate\Support\Facades\Route;

Route::view('/privacy-policy', 'pages.legal', ['document' => 'privacy'])->name('privacy');
Route::view('/cookie-policy', 'pages.legal', ['document' => 'cookies'])->name('cookies');
Route::view('/terms-of-use', 'pages.legal', ['document' => 'terms'])->name('terms');
