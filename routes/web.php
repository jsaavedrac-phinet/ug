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
Route::post('deploy', 'DeployController@deploy');
Route::get('/', function(){

    return redirect(route('login'));
});

Auth::routes(['register' => false]);


Route::middleware(['auth','access'])->group(function(){
    Route::get('/home','DashboardController@home')->name('home');
    Route::get('/profile','DashboardController@profile')->name('profile');
    Route::post('/profile','DashboardController@update_profile')->name('update_profile');


    Route::middleware('superadmin')->group(function(){
        Route::resource('group', 'GroupController');
        Route::resource('colorSetting','ColorSettingController');
        Route::get('/user/{user}/edit','UserController@edit')->name('user.edit');
        Route::put('/user/{user}','UserController@update')->name('user.update');
        Route::delete('/user/{user}','UserController@destroy')->name('user.destroy');

    });

    Route::group(['middleware' => ['user.add']], function () {
        Route::get('/user/create','UserController@create')->name('user.create');
        Route::post('/user','UserController@store')->name('user.store');
    });
    Route::resource('user', 'UserController')->except(['create','store','edit','update','destroy']);

    Route::get('repayment','DashboardController@repayment')->name('repayment');
    Route::post('payment/{user}','DashboardController@payment')->name('payment');

    Route::group(['middleware' => ['debug']], function () {
        Route::get('changeDay','DashboardController@changeDay')->name('changeDay');
        Route::post('changeDay','DashboardController@updateDay')->name('updateDay');
    });

    Route::group(['middleware' => ['collect']], function () {
        Route::get('/collect','DashboardController@collect')->name('collect');
    });

    Route::get('/monitor','DashboardController@monitor')->name('monitor');

    Route::get('/branch/{user}','DashboardController@branch')->name('branch');
    Route::post('/branch/{user}','DashboardController@branchFilter');
    Route::get('/calendar','DashboardController@calendar')->name('calendar');

    Route::group(['middleware' => ['return']], function () {
        Route::get('/return','DashboardController@return')->name('return');
        Route::post('/return/{user}','DashboardController@update_return')->name('update_return');
    });



});
