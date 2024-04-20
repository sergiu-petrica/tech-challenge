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
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['middleware' => 'auth', 'prefix' => 'clients'], function () {
    Route::get('/', 'ClientsController@index')->name('clients.index');
    Route::get('/create', 'ClientsController@create');
    Route::post('/', 'ClientsController@store');
    Route::get('/{client_id}', 'ClientsController@show');
    Route::delete('/{client_id}', 'ClientsController@destroy');

    Route::get('/{client_id}/journals/create', 'JournalsController@create');
    Route::get('/{client_id}/journals/{journal_id}', 'JournalsController@show');
    Route::post('/{client_id}/journals', 'JournalsController@store');
    Route::delete('/{client_id}/journals/{journal_id}', 'JournalsController@destroy');

    Route::delete('/{client_id}/bookings/{booking_id}', 'BookingsController@destroy');
});
