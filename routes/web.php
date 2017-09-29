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
    return view('welcome');
});

Auth::routes();


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

Route::get('/home', 'HomeController@index')->name('home');
