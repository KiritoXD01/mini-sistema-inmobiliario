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

Route::group(['prefix' => 'city'], function(){
    //GET: Get all users
    Route::get('/', 'CityController@index')->middleware('auth')->name('city.index');
    //GET: Create a new user view
    Route::get('/create', 'CityController@create')->middleware('auth')->name('city.create');
    //GET: Edit an user view
    Route::get('/{city}/edit', 'CityController@edit')->middleware('auth')->name('city.edit');
    //GET: Show an user view
    Route::get('/{city}/show', 'CityController@show')->middleware('auth')->name('city.show');
    //GET: Import users to Excel
    Route::get('/export', 'CityController@export')->middleware('auth')->name('city.export');
    //GET: Check if email exists
    Route::get('/checkName', 'CityController@checkName')->middleware('auth')->name('city.checkName');
    //POST: Create a new user
    Route::post('/', 'CityController@store')->middleware('auth')->name('city.store');
    //POST: Import users from CSV/Excel
    Route::post('/import', 'CityController@import')->middleware('auth')->name('city.import');
    //POST: Change the user status
    Route::post('/changeStatus/{city}', 'CityController@changeStatus')->middleware('auth')->name('city.changeStatus');
    //PATCH: Update an existing user
    Route::patch('/{city}', 'CityController@update')->middleware('auth')->name('city.update');
    //DELETE: Deletes and user
    Route::delete('/{city}', 'CityController@destroy')->middleware('auth')->name('city.destroy');
});

Route::group(['prefix' => 'propertyType'], function(){
    //GET: Get all users
    Route::get('/', 'PropertyTypeController@index')->middleware('auth')->name('propertyType.index');
    //GET: Create a new user view
    Route::get('/create', 'PropertyTypeController@create')->middleware('auth')->name('propertyType.create');
    //GET: Edit an user view
    Route::get('/{propertyType}/edit', 'PropertyTypeController@edit')->middleware('auth')->name('propertyType.edit');
    //GET: Show an user view
    Route::get('/{propertyType}/show', 'PropertyTypeController@show')->middleware('auth')->name('propertyType.show');
    //POST: Create a new user
    Route::post('/', 'PropertyTypeController@store')->middleware('auth')->name('propertyType.store');
    //POST: Change the user status
    Route::post('/changeStatus/{propertyType}', 'PropertyTypeController@changeStatus')->middleware('auth')->name('propertyType.changeStatus');
    //PATCH: Update an existing user
    Route::patch('/{propertyType}', 'PropertyTypeController@update')->middleware('auth')->name('propertyType.update');
    //DELETE: Deletes and user
    Route::delete('/{propertyType}', 'PropertyTypeController@destroy')->middleware('auth')->name('propertyType.destroy');
});

Route::group(['prefix' => 'propertyStatus'], function(){
    //GET: Get all users
    Route::get('/', 'PropertyStatusController@index')->middleware('auth')->name('propertyStatus.index');
    //GET: Create a new user view
    Route::get('/create', 'PropertyStatusController@create')->middleware('auth')->name('propertyStatus.create');
    //GET: Edit an user view
    Route::get('/{propertyStatus}/edit', 'PropertyStatusController@edit')->middleware('auth')->name('propertyStatus.edit');
    //GET: Show an user view
    Route::get('/{propertyStatus}/show', 'PropertyStatusController@show')->middleware('auth')->name('propertyStatus.show');
    //POST: Create a new user
    Route::post('/', 'PropertyStatusController@store')->middleware('auth')->name('propertyStatus.store');
    //POST: Change the user status
    Route::post('/changeStatus/{propertyStatus}', 'PropertyStatusController@changeStatus')->middleware('auth')->name('propertyStatus.changeStatus');
    //PATCH: Update an existing user
    Route::patch('/{propertyStatus}', 'PropertyStatusController@update')->middleware('auth')->name('propertyStatus.update');
    //DELETE: Deletes and user
    Route::delete('/{propertyStatus}', 'PropertyStatusController@destroy')->middleware('auth')->name('propertyStatus.destroy');
});

Route::group(['prefix' => 'propertyLegalCondition'], function(){
    //GET: Get all users
    Route::get('/', 'PropertyLegalConditionController@index')->middleware('auth')->name('propertyLegalCondition.index');
    //GET: Create a new user view
    Route::get('/create', 'PropertyLegalConditionController@create')->middleware('auth')->name('propertyLegalCondition.create');
    //GET: Edit an user view
    Route::get('/{propertyLegalCondition}/edit', 'PropertyLegalConditionController@edit')->middleware('auth')->name('propertyLegalCondition.edit');
    //GET: Show an user view
    Route::get('/{propertyLegalCondition}/show', 'PropertyLegalConditionController@show')->middleware('auth')->name('propertyLegalCondition.show');
    //POST: Create a new user
    Route::post('/', 'PropertyLegalConditionController@store')->middleware('auth')->name('propertyLegalCondition.store');
    //POST: Change the user status
    Route::post('/changeStatus/{propertyLegalCondition}', 'PropertyLegalConditionController@changeStatus')->middleware('auth')->name('propertyLegalCondition.changeStatus');
    //PATCH: Update an existing user
    Route::patch('/{propertyLegalCondition}', 'PropertyLegalConditionController@update')->middleware('auth')->name('propertyLegalCondition.update');
    //DELETE: Deletes and user
    Route::delete('/{propertyLegalCondition}', 'PropertyLegalConditionController@destroy')->middleware('auth')->name('propertyLegalCondition.destroy');
});

Route::group(['prefix' => 'property'], function(){
    //GET: Get all users
    Route::get('/', 'PropertyController@index')->middleware('auth')->name('property.index');
    //GET: Create a new user view
    Route::get('/create', 'PropertyController@create')->middleware('auth')->name('property.create');
    //GET: Edit an user view
    Route::get('/{property}/edit', 'PropertyController@edit')->middleware('auth')->name('property.edit');
    //GET: Show an user view
    Route::get('/{property}/show', 'PropertyController@show')->middleware('auth')->name('property.show');
    //GET: Get all the cities by the country_id
    Route::get('/getCitiesByCountry', 'PropertyController@getCitiesByCountry')->middleware('auth')->name('property.getCitiesByCountry');
    // GET: Get all images from property
    Route::get('/getImages', 'PropertyController@getImages')->name('property.getImages');
    //POST: Create a new user
    Route::post('/', 'PropertyController@store')->middleware('auth')->name('property.store');
    //POST: Change the user status
    Route::post('/changeStatus/{property}', 'PropertyController@changeStatus')->middleware('auth')->name('property.changeStatus');
    //POST: Assign properties to user
    Route::post('/assignProperties/{user}', 'PropertyController@assignPropertiesToSeller')->middleware('auth')->name('property.assignPropertiesToSeller');
    //PATCH: Update an existing user
    Route::patch('/{property}', 'PropertyController@update')->middleware('auth')->name('property.update');
    //DELETE: Deletes and user
    Route::delete('/{property}', 'PropertyController@destroy')->middleware('auth')->name('property.destroy');
});

Route::group(['prefix' => 'currency'], function(){
    //GET: Get all users
    Route::get('/', 'CurrencyController@index')->middleware('auth')->name('currency.index');
    //GET: Create a new user view
    Route::get('/create', 'CurrencyController@create')->middleware('auth')->name('currency.create');
    //GET: Edit an user view
    Route::get('/{currency}/edit', 'CurrencyController@edit')->middleware('auth')->name('currency.edit');
    //GET: Show an user view
    Route::get('/{currency}/show', 'CurrencyController@show')->middleware('auth')->name('currency.show');
    //POST: Create a new user
    Route::post('/', 'CurrencyController@store')->middleware('auth')->name('currency.store');
    //POST: Change the user status
    Route::post('/changeStatus/{currency}', 'CurrencyController@changeStatus')->middleware('auth')->name('currency.changeStatus');
    //PATCH: Update an existing user
    Route::patch('/{currency}', 'CurrencyController@update')->middleware('auth')->name('currency.update');
    //DELETE: Deletes and user
    Route::delete('/{currency}', 'CurrencyController@destroy')->middleware('auth')->name('currency.destroy');
});

Route::group(['prefix' => 'activity'], function() {
    //GET: Get all logs
    Route::get('/', 'ActivityController@index')->middleware('auth')->name('activity.index');
});
