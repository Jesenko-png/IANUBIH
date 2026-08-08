<?php

use Illuminate\Support\Facades\Route;

Route::view('/publications', 'pages.placeholder', ['page' => 'publications'])->name('publications');
