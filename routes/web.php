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

Route::get('/', function () {
    return view('front.home.page');
});

$this->get('admin/login', 'Auth\LoginController@showLoginForm')->name('login');
$this->post('admin/login', 'Auth\LoginController@login');
$this->post('admin/logout', 'Auth\LoginController@logout')->name('logout');

// Password Reset Routes...
$this->post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
$this->get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
$this->post('password/reset', 'Auth\ResetPasswordController@reset');



Route::group(['prefix' => 'admin', 'namespace' => 'Admin'], function() {

    Route::group(['middleware' => 'auth'], function() {
        Route::get('/', function() {
            return view('welcome');
        });

        Route::get('map', function() {
            return view('admin.maptest');
        });

        Route::get('users', 'UsersController@index');
        Route::post('users', 'UsersController@store');
        Route::post('users/{user}', 'UsersController@update');
        Route::delete('users/{user}', 'UsersController@delete');

        Route::post('super-admins', 'SuperAdminsController@store');
        Route::delete('super-admins/{user}', 'SuperAdminsController@delete');

        Route::post('me/password', 'UserPasswordController@update');

        Route::get('slideshow/slides', 'SlidesController@index');
        Route::get('slideshow/slides/{slide}', 'SlidesController@show');

        Route::get('locations', 'LocationsController@index');
        Route::get('locations/create', 'LocationsController@create');
        Route::post('locations', 'LocationsController@store');
        Route::post('locations/{location}', 'LocationsController@update');
        Route::delete('locations/{location}', 'LocationsController@delete');
    });

    Route::group(['middleware' => 'auth', 'prefix' => 'services', 'namespace' => 'Services'], function() {
       Route::get('users', 'UsersController@index');
    });
});

