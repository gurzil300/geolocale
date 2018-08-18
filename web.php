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
//GET
Route::get('/', function () { return view('welcome');  })->name('index');

//CHANGE LANGUAGE
Route::get('/language/{lang}','LanguageController@change')->name('lang');