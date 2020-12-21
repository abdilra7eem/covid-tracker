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

Route::redirect('/register', '/', 301);

// Route::get('/register', 'HomeController@register');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::resource('/directorate', 'DirectorateController')->middleware('throttle:60,1');
Route::resource('/user', 'UserController')->middleware('throttle:60,1');
Route::resource('/incident', 'IncidentController')->middleware('throttle:60,1');
Route::resource('/school', 'SchoolController')->middleware('throttle:60,1');
Route::resource('/schoolClosure', 'SchoolClosureController')->middleware('throttle:60,1');
Route::get('/inactive', 'HomeController@inactive');

// Route::prefix('test')->group(function () {

//     Route::get('1', function () {
//         $incidents = App\Incident::with('user')
//             ->inRandomOrder()->paginate(25);

//         return view('incident.index')->withIncidents($incidents);
//     });

//     Route::get('2', function () {
//         $schools = App\SchoolClosure::where('grade', '>', 12)
//             ->where('reopening_date', null)
//             ->orderBy('grade', 'DESC')
//             ->with('user')->with('user.school')
//             ->get()->unique('user_id');

//             return view('schoolClosure.index')->withSchools($schools)->withType('');
//     });

//     Route::get('3', function () {
//         $school = App\School::where('id', 5)->with('user')->get();
//         return view('school.show')->withSchool($school);
//     });

//     Route::get('4', function () {
//         $schools = SchoolClosure::where('deleted', false)
//             ->where("grade", ">", 12)
//             ->where("school_closures.reopening_date", null)
//             ->orderBy("school_closures.grade", "DESC")
//             ->distinct('user_id')
//             ->join("users", "school_closures.user_id", "users.id")
//             ->where("users.directorate_id", 2)
//             ->select("users.id as user_id", "users.*", "school_closures.id as closure_id", "school_closures.*")
//             ->with("user")->with("user.school")
//             ->paginate(25);
//     });
//     Route::get('5', function () {
//         $schools = SchoolClosure::where('deleted', false)
//             ->where("grade", ">", 12)
//             ->where("reopening_date", null)
//             // ->orderBy('closure_date', 'DESC')
//             ->orderBy("grade", "DESC")
//             ->distinct('user_id')
//             ->orderBy('closure_date', 'DESC')
//             ->with("user")->with("user.school")
//             ->simplePaginate(25);
//             // ->get()
//     });
// });