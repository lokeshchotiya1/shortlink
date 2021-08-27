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

Route::get('generate-shorten-link', 'HomeController@index');
Route::post('generate-shorten-link', 'HomeController@store')->name('generate.shorten.link.post');

Route::get('{code}', 'HomeController@shortenLink')->name('shorten.link');