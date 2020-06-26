<?php

use Illuminate\Support\Facades\Auth;
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
    return view('welcome');
});

Auth::routes([
    'register' => false
]);

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/changeLanguage/{language}', 'HomeController@changeLanguage')->name('changeLanguage');

Route::group(['prefix' => 'user'], function () {
    //GET: Get all users
    Route::get('/', 'UserController@index')->middleware('auth')->name('user.index');
    //GET: Create a new user view
    Route::get('/create', 'UserController@create')->middleware('auth')->name('user.create');
    //GET: Edit an user view
    Route::get('/{user}/edit', 'UserController@edit')->middleware('auth')->name('user.edit');
    //GET: Show an user view
    Route::get('/{user}/show', 'UserController@show')->middleware('auth')->name('user.show');
    //GET: Import users to Excel
    Route::get('/export', 'UserController@export')->middleware('auth')->name('user.export');
    //GET: Check if email exists
    Route::get('/checkEmail', 'UserController@checkEmail')->middleware('auth')->name('user.checkEmail');
    //POST: Create a new user
    Route::post('/', 'UserController@store')->middleware('auth')->name('user.store');
    //POST: Import users from CSV/Excel
    Route::post('/import', 'UserController@import')->middleware('auth')->name('user.import');
    //POST: Change the user status
    Route::post('/changeStatus/{user}', 'UserController@changeStatus')->middleware('auth')->name('user.changeStatus');
    //PATCH: Update an existing user
    Route::patch('/{user}', 'UserController@update')->middleware('auth')->name('user.update');
    //DELETE: Deletes and user
    Route::delete('/{user}', 'UserController@destroy')->middleware('auth')->name('user.destroy');
});

Route::group(['prefix' => 'userRole'], function() {
    //GET: Get all user roles
    Route::get('/', 'UserRoleController@index')->middleware('auth')->name('userRole.index');
    //GET: Create a new role view
    Route::get('/create', 'UserRoleController@create')->middleware('auth')->name('userRole.create');
    //GET: Edit an role view
    Route::get('/{role}/edit', 'UserRoleController@edit')->middleware('auth')->name('userRole.edit');
    //GET: Show an role view
    Route::get('/{role}/show', 'UserRoleController@show')->middleware('auth')->name('userRole.show');
    //POST: Create a new role
    Route::post('/', 'UserRoleController@store')->middleware('auth')->name('userRole.store');
    //POST: Change the role status
    Route::post('/changeStatus/{role}', 'UserRoleController@changeStatus')->middleware('auth')->name('userRole.changeStatus');
    //PATCH: Update an existing role
    Route::patch('/{role}', 'UserRoleController@update')->middleware('auth')->name('userRole.update');
    //DELETE: Deletes and role
    Route::delete('/{role}', 'UserRoleController@destroy')->middleware('auth')->name('userRole.destroy');
});

Route::group(['prefix' => 'country'], function(){
    //GET: Get all users
    Route::get('/', 'CountryController@index')->middleware('auth')->name('country.index');
    //GET: Create a new user view
    Route::get('/create', 'CountryController@create')->middleware('auth')->name('country.create');
    //GET: Edit an user view
    Route::get('/{country}/edit', 'CountryController@edit')->middleware('auth')->name('country.edit');
    //GET: Show an user view
    Route::get('/{country}/show', 'CountryController@show')->middleware('auth')->name('country.show');
    //GET: Import users to Excel
    Route::get('/export', 'CountryController@export')->middleware('auth')->name('country.export');
    //GET: Check if email exists
    Route::get('/checkName', 'CountryController@checkName')->middleware('auth')->name('country.checkName');
    //GET: Check if iso exists
    Route::get('/checkISO', 'CountryController@checkISO')->middleware('auth')->name('country.checkISO');
    //POST: Create a new user
    Route::post('/', 'CountryController@store')->middleware('auth')->name('country.store');
    //POST: Import users from CSV/Excel
    Route::post('/import', 'CountryController@import')->middleware('auth')->name('country.import');
    //POST: Change the user status
    Route::post('/changeStatus/{country}', 'CountryController@changeStatus')->middleware('auth')->name('country.changeStatus');
    //PATCH: Update an existing user
    Route::patch('/{country}', 'CountryController@update')->middleware('auth')->name('country.update');
    //DELETE: Deletes and user
    Route::delete('/{country}', 'CountryController@destroy')->middleware('auth')->name('country.destroy');
});
