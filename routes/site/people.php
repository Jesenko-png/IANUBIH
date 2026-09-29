<?php

use App\Http\Controllers\PeopleController;
use Illuminate\Support\Facades\Route;

Route::get('/people', [PeopleController::class, 'index'])->name('people');
Route::get('/people/{slug}', [PeopleController::class, 'show'])->name('people.show');
