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

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['middleware' => ['auth']], function() {

  Route::get('/', function () {
      return redirect('dashboard');
  });

  Route::get('invoice', function(){
      return view('invoice');
  });

  Route::resource('Replies','ReplyController');
  Route::resource('Options','OptionController');
  Route::resource('Questions','QuestionController');
  Route::resource('Questionnaires','QuestionnaireController');
  Route::post('Questionnaires/changeStatus', array('as' => 'changeStatus', 'uses' => 'QuestionnaireController@changeStatus'));

});

Route::get('{path}', "HomeController@index")->where('path', '([A-z\d/-\/_.]+)?');
