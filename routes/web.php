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

/*
|--------------------------------------------------------------------------
| HOME route
|--------------------------------------------------------------------------
|
*/
Route::get('/', 'HomeController@index')->name('home');

Auth::routes();

Route::post('/search', 'HomeController@search')->name('search');
/*
|--------------------------------------------------------------------------
| Athletes Routes
|--------------------------------------------------------------------------
|
*/
Route::get('/athlete/{athlete}', 'AthleteController@show')->name('athlete.show');

/*
|--------------------------------------------------------------------------
| Competitions Routes
|--------------------------------------------------------------------------
|
*/
Route::get('/competition/{competition}', 'CompetitionController@show')->name('competition.show');
Route::get('/calendar', 'CompetitionController@showCalendar')->name('competition.calendar');

/*
|--------------------------------------------------------------------------
| Clubs Routes
|--------------------------------------------------------------------------
|
*/
Route::get('/club/{club}', 'ClubController@show')->name('club.show');


/*
|--------------------------------------------------------------------------
| Records Routes
|--------------------------------------------------------------------------
|
*/
/* GET events for national record form */
Route::post('/records/nationals/history/events', 'RecordController@getEvents')->name('record.getEvents');
Route::get('/records/nationals/history', 'RecordController@showNRsHistory')->name('record.showNRsHistory');
Route::post('/records/nationals/history', 'RecordController@searchNRsHistory')->name('record.searchNRsHistory');
Route::get('/records/nationals', 'RecordController@showNRs')->name('record.showNRs');
Route::post('/records/nationals', 'RecordController@searchNRs')->name('record.searchNRs');


/*
|--------------------------------------------------------------------------
| Top-List Routes
|--------------------------------------------------------------------------
|
*/
Route::get('/toplist', 'TopListController@show')->name('toplist.show');
Route::post('/toplist', 'TopListController@search')->name('toplist.search');
Route::post('/toplist/events', 'TopListController@getEvents')->name('toplist.getEvents');


/*
|--------------------------------------------------------------------------
| All-Time Performance Routes
|--------------------------------------------------------------------------
|
*/
Route::get('/alltime', 'AllTimeController@show')->name('alltime.show');
Route::post('/alltime', 'AllTimeController@search')->name('alltime.search');
Route::post('/alltime/events', 'AllTimeController@getEvents')->name('alltime.getEvents');

/*
|--------------------------------------------------------------------------
| ADMIN DASHBOARD Routes
|--------------------------------------------------------------------------
|	resource routes for CRUD
|	all the controllers are in App/Dashboard
*/
Route::get('dashboard', function () {
    return view('dashboard/home');
});
Route::resource('dashboard/club', 'Dashboard\ClubCrudController', ['except' => ['show', 'destroy']]);
Route::resource('dashboard/athlete', 'Dashboard\AthleteCrudController', ['except' => ['show', 'destroy']]);
Route::resource('dashboard/series', 'Dashboard\SeriesCrudController', ['except' => ['show', 'destroy']]);
Route::resource('dashboard/competition', 'Dashboard\CompetitionCrudController', ['except' => ['show', 'destroy']]);
Route::resource('dashboard/result', 'Dashboard\ResultCrudController', ['except' => ['show', 'destroy']]);
Route::get('/dashboard/result/createRace', 'Dashboard\ResultCrudController@createRace')->name('result.createRace');
Route::post('/dashboard/result/createRace', 'Dashboard\ResultCrudController@storeRace')->name('result.storeRace');