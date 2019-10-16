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

//use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('landing');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('landing');

// Route group
Route::group(['middleware' => ['auth', 'admin']], function() {
    Route::get('/dashboard', function () {
        return view('dashboard.index');
    })->name('dashboard');
});

Route::resource('cities', 'CityController');
Route::resource('roles', 'RoleController');

Route::prefix('jobs')->group(function(){
    Route::get('', 'JobController@index')->name('jobs.index');
    Route::get('create', 'JobController@create')->name('jobs.create');
    Route::get('{job}', 'JobController@show')->name('jobs.show');
    Route::post('', 'JobController@store')->name('jobs.store');
    Route::get('{job}/edit', 'JobController@edit')->middleware('WriterAndReporter')->name('jobs.edit');
    Route::patch('{job}', 'JobController@update')->name('jobs.update');
    Route::delete('{job}', 'JobController@destroy')->middleware('WriterAndReporter')->name('jobs.destroy');
});

Route::resource('staffs', 'StaffController');
Route::resource('visitors', 'VisitorController');
Route::resource('news', 'NewsController');

Route::put('toggleStaffStatus/{staff}', 'StaffController@toggleActivity')->name('staffToggleStatus');
Route::put('toggleVisitorStatus/{visitor}', 'VisitorController@toggleActivity')->name('visitorToggleStatus');
Route::put('togglePublishNews/{news}', 'NewsController@togglePublishing')->name('togglePublishNews');

Route::prefix('files')->group(function() {
    Route::post('store', 'FileUploadController@fileStore');
    Route::post('delete', 'FileUploadController@fileDestroy');
    Route::get('getById/{id}', 'FileUploadController@getById');
});

Route::get('/getCities/{id}','CityController@getCities');
Route::get('/getRelated','NewsController@getRelated');
Route::get('/getAuthorsByJob/{id}','StaffController@getAuthorsByJob');

