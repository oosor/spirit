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

Route::get('/', 'DashboardController@index');

Route::get('/view', 'GreekRuController@index');
Route::get('/bible', 'BibleController@index');
Route::get('/simphony-greek', 'SimphonyController@index');
Route::get('/simphony-ru', 'SimphonyController@ruSimphony');
Route::get('/simphony-greek-word', 'SimphonyController@greekSimphonyWord');
Route::get('/comment', 'CommentController@index');
Route::get('/about', 'DashboardController@about');


// get datas

Route::post('/word-greek', 'GreekRuController@wordGreek');
Route::post('/word-ru', 'GreekRuController@wordRu');
Route::post('/chapter-greek', 'GreekRuController@chapterGreek');
Route::post('/symphony-greek-word', 'GreekRuController@symphonyGWord');
Route::post('/ru-bible', 'GreekRuController@ruBible');
Route::post('/ru-simphony', 'GreekRuController@ruSimphony');
Route::post('/greek-template', 'GreekRuController@chapterGreek');
Route::post('/ru-template', 'BibleController@chapterRu');


Route::post('/abr-word', 'GreekRuController@abrWord');

Route::post('/simphony-_greek', 'SimphonyController@greekViewRender');
Route::post('/simphony-_ru', 'SimphonyController@ruViewRender');
Route::post('/simphony-_greek-word', 'SimphonyController@greekWordViewRender');

Route::post('/comment-book', 'CommentController@commentBook');
Route::post('/comment-data', 'CommentController@commentData');
