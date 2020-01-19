<?php

use App\Http\Controllers\DogController;
use App\Http\Controllers\PedigreeController;

Route::get('/', [DogController::class, 'index'])->name('dogindex');
Route::get('create', [DogController::class, 'create'])->name('dogcreate')->middleware(['auth', 'permission:Create Dog']);

Route::get('{id}', [DogController::class, 'show'])->name('dogshow');
Route::post('/', [DogController::class, 'store'])->name('dogstore');
Route::get('{id}/edit', [DogController::class, 'edit'])->name('dogedit');
Route::patch('{id}', [DogController::class, 'update'])->name('dogupdate');
Route::delete('{id}', [DogController::class, 'destroy'])->name('dogdestroy');

Route::get('{id}/pedigree/{nGens}', [PedigreeController::class, 'show']);

Route::get('testmate', [PedigreeController::class, 'testmate']);
Route::get('testmate/show', [PedigreeController::class, 'showtestmate']);


//Route::get('search', [AdvancedSearchController::class, 'index'])->name('advsearch');
