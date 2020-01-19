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
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

Route::get('/', function () {
    return redirect('dogs');
});


/**
 * Dog Routes
 */
Route::prefix('dogs')->group(base_path('routes/dogs.php'));




Route::get('autocomplete/{query}', 'SearchController@result');
Route::get('autocomplete/{query}/{sex}', 'SearchController@resultsex');





Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/admin/test', function () {
    return ('You are a Super Admin');
})->middleware('role:Super Admin');


Route::group(['prefix' =>'backend','middleware' => ['permission:Access Backend']], base_path('routes/backend.php'));
