<?php
Route::get('/', function() {
   return view('backend.index');
});


/**
 * Edit USERS
 */
Route::get('users', 'EditUsersController@index');
//Route::get('users/{id}', 'EditUsersController@show');
Route::get('users/{id}/edit', 'EditUsersController@edit');
