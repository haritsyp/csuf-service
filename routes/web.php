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
Route::group(['middleware' => 'usersession'], function () {
	Route::get('/', function () {
		return view('app');
	});
});

Route::get('login', function () {
		return view('login');
	});

Route::post('auth','LoginController@login');
Route::get('logout','LoginController@destroy');
Route::get('excel','PollController@getExcel');
Route::get('excelresult','PollController@getExcelResult');

Route::resource('service','ServiceController');
Route::delete('poll','PollController@destroy');
Route::get('api/service','ServiceController@getAPI');
Route::get('api/resultpoll','PollController@getResult');
Route::get('api/polls','PollController@paginate');
Route::get('api/resultpollfilter','PollController@getResultFilter');
Route::get('api/resulttablefilter','PollController@getResultTableFilter');
Route::get('api/resulttable','PollController@getResultTable');
Route::get('api/excel','PollController@getExcel');
Route::post('api/poll', [
	'uses' => 'PollController@store',
	'nocsrf' => true,
]);
