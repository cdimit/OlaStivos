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

Auth::routes();
//Redirect to closed view
Route::middleware(['closed'])->group(function () {
	/*
	|--------------------------------------------------------------------------
	| HOME route
	|--------------------------------------------------------------------------
	|
	*/

	Route::get('/', 'HomeController@index')->name('home');


	Route::post('/search/show', 'HomeController@searchShow')->name('search.show');
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
	Route::get('/records/nationals/history', 'RecordController@showNRsHistory')->name('record.showNRsHistory')->middleware('role:admin');
	Route::post('/records/nationals/history', 'RecordController@searchNRsHistory')->name('record.searchNRsHistory')->middleware('role:admin');
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
	| Score-List Routes
	|--------------------------------------------------------------------------
	|
	*/
	Route::get('/scorelist', 'ScoreListController@show')->name('scorelist.show');
	Route::post('/scorelist', 'ScoreListController@search')->name('scorelist.search');


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
	| Contact us Routes
	|--------------------------------------------------------------------------
	|
	*/
	Route::get('/contact-us', 'ContactController@show')->name('contact.show');
	Route::post('/contact-us', 'ContactController@send')->name('contact.send');


	/*
	|--------------------------------------------------------------------------
	| ADMIN DASHBOARD Routes
	|--------------------------------------------------------------------------
	|	resource routes for CRUD
	|	all the controllers are in App/Dashboard
	*/

	//For admins and moderators
	Route::middleware(['auth','role:admin,moderator'])->group(function () {
		Route::get('dashboard', function () {
		    return view('dashboard/home');
		});
		Route::resource('dashboard/club', 'Dashboard\ClubCrudController', ['except' => ['show', 'destroy']]);
		Route::resource('dashboard/athlete', 'Dashboard\AthleteCrudController', ['except' => ['show', 'destroy']]);
		Route::resource('dashboard/series', 'Dashboard\SeriesCrudController', ['except' => ['show', 'destroy']]);
		Route::resource('dashboard/competition', 'Dashboard\CompetitionCrudController', ['except' => ['show', 'destroy']]);
		Route::resource('dashboard/result', 'Dashboard\ResultCrudController', ['except' => ['show']]);
		Route::resource('dashboard/image', 'Dashboard\ImageCrudController', ['except' => ['show', 'destroy']]);
		Route::resource('dashboard/video', 'Dashboard\VideoCrudController', ['except' => ['show', 'destroy']]);

		Route::post('/dashboard/result/events', 'Dashboard\ResultCrudController@getEvents')->name('results.getEvents');
		Route::post('/dashboard/result/dates', 'Dashboard\ResultCrudController@getDates')->name('results.getDates');

		Route::get('/dashboard/result/createRace', 'Dashboard\ResultCrudController@createRace')->name('result.createRace');
		Route::post('/dashboard/result/createRace', 'Dashboard\ResultCrudController@storeRace')->name('result.storeRace');

	});
	//For admins only
	Route::middleware(['auth','role:admin'])->group(function () {
		Route::resource('dashboard/events', 'Dashboard\EventCrudController', ['except' => ['show','destroy']]);
		Route::resource('dashboard/users', 'Dashboard\UserCrudController', ['except' => ['create','store','show']]);
		//PENDING AND PUBLISHING
		Route::get('dashboard/pending', 'Dashboard\PendingController@index')->name('pending.index');
		Route::post('dashboard/pending', 'Dashboard\PendingController@publish')->name('pending.publish');

		//COMMANDS
		Route::get('dashboard/commands', 'Dashboard\CommandController@index')->name('commands.index');
		Route::get('dashboard/commands/fixyearinathletes', 'Dashboard\CommandController@fixYearInAthletes')->name('commands.fixYearInAthletes');
		Route::get('dashboard/commands/fixageinresults', 'Dashboard\CommandController@fixAgeInResults')->name('commands.fixAgeInResults');
		Route::post('dashboard/commands/refreshrecordbyevent', 'Dashboard\CommandController@refreshRecordByEvent')->name('commands.refreshRecordByEvent');

	});
});
