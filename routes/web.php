<?php

use Illuminate\Support\Facades\Route;
use App\ShortLink;
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
    
     $shortLinks = ShortLink::select("short_links.*",

             DB::raw("(select count(id) from url_redirect_history where url_id = short_links.id ) as url_open_count"))

             ->groupby("short_links.id")
             ->get();

     return view('home', compact('shortLinks'));
});

Route::get('generate-shorten-link', 'HomeController@index');
Route::post('generate-shorten-link', 'HomeController@store')->name('generate.shorten.link.post');

Route::get('{code}', 'HomeController@shortenLink')->name('shorten.link');
Route::post('save-user-redirect', 'HomeController@save_user_redirect');