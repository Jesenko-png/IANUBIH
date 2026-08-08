<?php

use Illuminate\Support\Facades\Route;

Route::view('/people', 'pages.placeholder', ['page' => 'people'])->name('people');
