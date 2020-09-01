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

Route::resource('/directorate', 'DirectorateController');
Route::resource('/user', 'UserController');
Route::resource('/incident', 'IncidentController');
Route::resource('/school', 'SchoolController');
Route::resource('/schoolClosure', 'SchoolClosureController');


