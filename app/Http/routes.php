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

Route::get('nuxeotest','NuxeoController@test');

Route::get('nuxeoparse','NuxeoController@parse');

//Liste des imports possibles
Route::get('import/list','NuxeoController@importlist')->name('import.list');

//Importer un dossier
//Route::get('import/go/{import}','NuxeoController@import')->name('import.go');
Route::get('import/go/{import}','NuxeoController@import')->name('import.go');

//montrer le dossier à Importer
Route::get('import/show/{import}','NuxeoController@parse')->name('import.show');

Route::auth();
