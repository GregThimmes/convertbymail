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


Route::group(['middleware' => 'auth'], function () {
	//Route::resource('user', 'UserController', ['except' => ['show']]);
	Route::get('profile', ['as' => 'profile.edit', 'uses' => 'ProfileController@edit']);
	Route::put('profile', ['as' => 'profile.update', 'uses' => 'ProfileController@update']);
	Route::put('profile/password', ['as' => 'profile.password', 'uses' => 'ProfileController@password']);
	Route::get('{page}/{id}', ['as' => 'page.index', 'uses' => 'PageController@index']);
	Route::get('ajax/campaigns', 'ApiController@getUserCampaigns');
	Route::get('ajax/report', 'ApiController@getCampaignReport');
	Route::get('ajax/company/insertionorder', 'ApiController@getCompanyInsertionOrders');

	Route::group(['middleware' => 'admin'], function () 
	{
		Route::group(['prefix' => 'admin'], function()
		{
				Route::get('campaign', 'CampaignController@index')->name('campaign');
				Route::get('campaign/create', 'CampaignController@create')->name('campaign-create');
				Route::post('campaign/create', 'CampaignController@store')->name('campaign-store');
				Route::get('campaign/view/{id}', 'CampaignController@view')->name('campaign-view');
				Route::get('campaign/links/{id}', 'CampaignLinkController@index')->name('campaign-link');

        });
    });

});

