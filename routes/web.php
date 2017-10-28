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

Route::get('/', function () {
    return view('dashboard');
});


Route::get('/view', 'GreekRuController@index');






// get datas

Route::post('/word-greek', 'GreekRuController@wordGreek');
Route::post('/word-ru', 'GreekRuController@wordRu');
Route::post('/chapter-greek', 'GreekRuController@chapterGreek');
Route::post('/symphony-greek-word', 'GreekRuController@symphonyGWord');
Route::post('/ru-bible', 'GreekRuController@ruBible');
Route::post('/ru-simphony', 'GreekRuController@ruSimphony');



Route::post('/abr-word', 'GreekRuController@abrWord');
