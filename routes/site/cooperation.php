<?php

use App\Http\Controllers\CooperationController;
use Illuminate\Support\Facades\Route;

Route::get('/cooperation', [CooperationController::class, 'show'])->name('cooperation');
Route::post('/cooperation', [CooperationController::class, 'store'])
    ->middleware('throttle:5,10')
    ->name('cooperation.inquiry');
