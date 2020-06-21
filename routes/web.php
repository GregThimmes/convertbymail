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
				Route::get('campaign', 'CampaignController@index')->name('campaigns');
				Route::get('campaign/create', 'CampaignController@create')->name('campaign-create');
				Route::post('campaign/create', 'CampaignController@store')->name('campaign-store');
				Route::get('campaign/view/{id}', 'CampaignController@view')->name('campaign-view');
				Route::get('campaign/edit/{id}', 'CampaignController@edit')->name('campaign-edit');
				Route::post('campaign/update', 'CampaignController@update')->name('campaign-update');

				Route::get('campaign/links/{id}', 'CampaignLinkController@index')->name('campaign-link');
				Route::post('campaign/links/store', 'CampaignLinkController@store')->name('campaign-link-store');

				Route::get('orders', 'InsertionOrderController@index')->name('orders');
				Route::get('orders/create', 'InsertionOrderController@create')->name('order-create');
				Route::post('orders/create', 'InsertionOrderController@store')->name('order-store');
				Route::post('orders/update', 'InsertionOrderController@update')->name('order-store');
				Route::get('orders/edit/{id}', 'InsertionOrderController@edit')->name('order-edit');

				Route::get('companies', 'CompanyController@index')->name('companies');
				Route::get('companies/create', 'CompanyController@create')->name('company-create');
				Route::post('companies/create', 'CompanyController@store')->name('company-store');
				Route::get('companies/edit/{id}', 'CompanyController@edit')->name('company-edit');
				Route::post('companies/update', 'CompanyController@update')->name('company-update');


				Route::get('reps', 'UserController@reps')->name('reps');
				Route::get('reps/create', 'UserController@repsCreate')->name('reps-create');
				Route::post('reps/create', 'UserController@repsStore')->name('reps-store');
				Route::get('reps/edit/{id}', 'UserController@repsEdit')->name('reps-edit');
				Route::post('reps/update', 'UserController@repsUpdate')->name('reps-update');
        });
    });

});

