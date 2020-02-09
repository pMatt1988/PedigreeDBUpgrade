<?php

use App\Dog;
use App\Http\Controllers\DogController;
use App\Http\Controllers\PedigreeController;
use Illuminate\Database\Query\Builder;

Route::get('/', [DogController::class, 'index'])->name('dogindex');
Route::get('create', [DogController::class, 'create'])->name('dogcreate')->middleware(['auth', 'permission:Create Dog']);

Route::get('{id}', [DogController::class, 'show'])->name('dogshow');
Route::post('/', [DogController::class, 'store'])->name('dogstore')->middleware(['auth', 'permission:Create Dog']);
Route::get('{id}/edit', [DogController::class, 'edit'])->name('dogedit')->middleware(['auth', 'permission:Edit Dog']);
Route::patch('{id}', [DogController::class, 'update'])->name('dogupdate')->middleware(['auth', 'permission:Edit Dog']);
//Route::delete('{id}', [DogController::class, 'destroy'])->name('dogdestroy')->middleware(['auth', 'permission:Edit Dog']);
Route::get('{id}/delete', 'DogController@destroy')->middleware(['auth', 'permission:Edit Dog']);



Route::get('{id}/pedigree/{nGens}', [PedigreeController::class, 'show']);

Route::get('testmate', [PedigreeController::class, 'testmate']);
Route::get('testmate/show', [PedigreeController::class, 'showtestmate']);

Route::get('test', function () {
    $query = (new Dog)->newQuery()
        ->leftJoin('dog_relationship', function (Builder $join) {
            $join->on('dog_relationship.dog_id', '=', 'dogs.id')
                ->where('dog_relationship.relation', 'male')->orWhereNull('dog_');
        })
        ->first();

    dd($query);
    return 'test';
});


//Route::get('search', [AdvancedSearchController::class, 'index'])->name('advsearch');
