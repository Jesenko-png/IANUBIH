<?php

use Illuminate\Support\Facades\Route;

Route::view('/projects', 'pages.placeholder', ['page' => 'projects'])->name('projects');
