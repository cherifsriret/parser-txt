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

Auth::routes(['register'=>false]);

Route::get('user/login','IndexationTextController@login')->name('login.form');
Route::post('user/login','IndexationTextController@loginSubmit')->name('login.submit');
Route::get('user/logout','IndexationTextController@logout')->name('user.logout');

Route::get('user/register','IndexationTextController@register')->name('register.form');
Route::post('user/register','IndexationTextController@registerSubmit')->name('register.submit');
// Reset password
Route::get('/','IndexationTextController@home')->name('home');
// Frontend Routes
Route::get('/home', 'IndexationTextController@index');
Route::post('/indexationTEXTE', 'IndexationTextController@indexationTEXTE')->name('search');
Route::get('/indexationTEXTE/{document:id}', 'IndexationTextController@indexationTEXTEShow')->name('indexation.show');


// Backend section start

Route::group(['prefix'=>'/admin','middleware'=>['auth','admin']],function(){
    Route::get('/','AdminController@index')->name('admin');
    // user route
    Route::resource('users','UsersController');

    Route::group(['prefix'=>'/documents'],function(){
        Route::get('/','LireCorpusController@index')->name('documents.index');
        Route::get('/LireCorpus','LireCorpusController@LireCorpusGet')->name('documents.create');
        Route::post('/LireCorpus/store','LireCorpusController@LireCorpus')->name('documents.store');


    });

    // Profile
    Route::get('/profile','AdminController@profile')->name('admin-profile');
    Route::post('/profile/{id}','AdminController@profileUpdate')->name('profile-update');
    // Password Change
    Route::get('change-password', 'AdminController@changePassword')->name('change.password.form');
    Route::post('change-password', 'AdminController@changPasswordStore')->name('change.password');
});

