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
use Illuminate\Database\Query\Builder;
use Nayjest\Grids\Components\ColumnHeadersRow;
use Nayjest\Grids\Components\FiltersRow;
use Nayjest\Grids\Components\THead;
use Nayjest\Grids\DataRow;
use Nayjest\Grids\EloquentDataProvider;
use Nayjest\Grids\FieldConfig;
use Nayjest\Grids\FilterConfig;
use Nayjest\Grids\Grid;
use Nayjest\Grids\GridConfig;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

Route::get('/', function () {
    return redirect('dogs');
});


/**
 * Dog Routes
 */
Route::prefix('dogs')->group(base_path('routes/dogs.php'));
Route::group(['prefix' => 'backend', 'middleware' => ['auth', 'permission:Access Backend']], base_path('routes/backend.php'));

Route::group(['prefix' => 'api'], function () {
    Route::get('autocomplete/{query}', 'SearchController@result');
    Route::get('autocomplete/{query}/{sex}', 'SearchController@resultsex');
});


Route::get('/home', function () {
    return redirect('dogs');
})->name('home');

Route::get('test', function () {
    dd(json_encode(Auth::user()));
});
Auth::routes(['verify' => true]);


