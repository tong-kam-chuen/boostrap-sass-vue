<?php

use Illuminate\Support\Facades\Route;

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
    return redirect('login');
});

Auth::routes();

Route::resource('Replies','ReplyController');
Route::resource('Options','OptionController');
Route::resource('Questions','QuestionController');
Route::resource('Questionnaires','QuestionnaireController');
Route::post('Questionnaires/changeStatus', array('as' => 'changeStatus', 'uses' => 'QuestionnaireController@changeStatus'));
