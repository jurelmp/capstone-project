<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', function(){
	// return View::make('home.index');
	if(Auth::check()){
		return View::make('layout.home_user');
	} else{
		return View::make('layout.home_default');
	}
});

Route::get('/login', array('uses' => 'HomeController@getLogin'));
Route::post('/login', array('uses' => 'HomeController@postLogin'));
Route::get('/logout', array('uses' => 'HomeController@postLogout'));

Route::get('/register', array('uses' => 'HomeController@getCreateaccount'));
Route::post('/register', array('uses' => 'HomeController@postCreateaccount'));

Route::get('/login/facebook', 'HomeController@getLoginWithFacebook');


Route::controller('/alumni', 'MainController');
Route::controller('/password', 'RemindersController');



Route::group(array('before' => 'auth'), function(){

	
	Route::controller('/admin', 'AdminController');
	Route::controller('/user', 'UserController');
	
	Route::controller('/analytics', 'AnalyticsController');
});

// Route::get('/email', function(){
// 	Artisan::call('email:parse');
// });