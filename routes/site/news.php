<?php

use Illuminate\Support\Facades\Route;

Route::view('/news', 'pages.placeholder', ['page' => 'news'])->name('news');
