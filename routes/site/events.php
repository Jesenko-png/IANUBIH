<?php

use Illuminate\Support\Facades\Route;

Route::view('/events', 'pages.placeholder', ['page' => 'events'])->name('events');
