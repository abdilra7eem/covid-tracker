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
    // return view('welcome');
    return redirect('/incident');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::resource('/directorate', 'DirectorateController')->middleware('throttle:60,1');
Route::resource('/user', 'UserController')->middleware('throttle:60,1');
Route::resource('/incident', 'IncidentController')->middleware('throttle:60,1');
Route::resource('/school', 'SchoolController')->middleware('throttle:60,1');
Route::resource('/schoolClosure', 'SchoolClosureController')->middleware('throttle:60,1');


