<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use App\Http\Controllers\DogController;
use App\Http\Controllers\PedigreeController;

Route::get('/', function () {
    return redirect('dogs');
});


/**
 * Dog Routes
 */

Route::get('dogs', [DogController::class, 'index'])->name('dogindex');
Route::get('dogs/create', [DogController::class, 'create'])->name('dogcreate');

Route::get('dogs/{id}', [DogController::class, 'show'])->name('dogshow');
Route::post('dogs', [DogController::class, 'store'])->name('dogstore');
Route::get('dogs/{id}/edit', [DogController::class, 'edit'])->name('dogedit');
Route::patch('dogs/{id}', [DogController::class, 'update'])->name('dogupdate');
Route::delete('dogs/{id}', [DogController::class, 'destroy'])->name('dogdestroy');

Route::get('autocomplete/{query}', 'SearchController@result');
Route::get('autocomplete/{query}/{sex}', 'SearchController@resultsex');


Route::get('dogs/{id}/pedigree/{nGens}', [PedigreeController::class, 'show']);

Route::get('testmate', [PedigreeController::class, 'testmate']);
Route::get('testmate/show', [PedigreeController::class, 'showtestmate']);


Route::get('search', [AdvancedSearchController::class, 'index'])->name('advsearch');


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
