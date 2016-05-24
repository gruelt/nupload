<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/home',function () {
  return view('welcome');
}

);


//routes de la ressource formulaire_list
Route::resource('formulaire','FormulaireController');

//routes de la ressource service
Route::resource('service','ServiceController');

//Route vers tous les formulaires
Route::get('formulaires', [
    'middleware' => ['auth','admin'],
    'uses' => 'FormulaireController@indexall'
]);


Route::get('profile', [
    'middleware' => ['auth','admin'],
    'uses' => 'FormulaireController@indexall'
]);


Route::auth();
