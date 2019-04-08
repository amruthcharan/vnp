<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

/*Route::get('/', function () {
    return view('welcome');
});*/

Route::auth();

//Route Group with Auth Middleware
Route::group(['middleware'=>'auth'], function (){

    //Dashboard Route
    Route::get('/', 'HomeController@index');

    //Users Route
    Route::resource('/users', 'UserController');

    //owners Routes
    Route::resource('/owners', 'OwnerController');

    //Patients Routes
    Route::resource('/patients', 'PatientController');


});


