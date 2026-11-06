<?php

use App\Http\Controllers\SectionPageController;
use Illuminate\Support\Facades\Route;

Route::get('/academy/{topic}', [SectionPageController::class, 'academy'])->name('academy.topic');
Route::get('/members/{topic}', [SectionPageController::class, 'members'])->name('members.topic');
Route::get('/organization', [SectionPageController::class, 'organizationIndex'])->name('organization');
Route::get('/organization/{topic}/{item?}', [SectionPageController::class, 'organization'])->name('organization.topic');
Route::get('/publications/{topic}', [SectionPageController::class, 'publications'])->name('publications.topic');
Route::get('/cooperation/{topic}', [SectionPageController::class, 'cooperation'])->name('cooperation.topic');
Route::get('/awards', [SectionPageController::class, 'awards'])->name('awards');
