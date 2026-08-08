<?php

use Illuminate\Support\Facades\Route;

Route::redirect('/', '/bs');

Route::prefix('{locale}')
    ->where(['locale' => 'bs|en'])
    ->middleware('locale')
    ->group(function () {
        require __DIR__.'/site.php';
    });
