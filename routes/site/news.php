<?php

use App\Http\Controllers\NewsController;
use Illuminate\Support\Facades\Route;

Route::get('/news', [NewsController::class, 'index'])->name('news');
Route::get('/news/{newsPost:slug}', [NewsController::class, 'show'])->name('news.show');
