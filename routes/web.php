<?php

use Illuminate\Support\Facades\Auth;
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

	if(Auth::user())
	{
		if(Auth::user()->isAdmin())
	    {
	        return redirect('home');
	    }
	    if (Auth::user()->isBulk())
	    {
	    	return redirect('bulk');
	    }
	}
    else
    {
    	return view('welcome');
    }
});

Auth::routes();

Route::group(['middleware' => 'auth'], function () {

	//Route::resource('user', 'UserController', ['except' => ['show']]);
	Route::get('profile', ['as' => 'profile.edit', 'uses' => 'ProfileController@edit']);
	Route::put('profile', ['as' => 'profile.update', 'uses' => 'ProfileController@update']);
	Route::put('profile/password', ['as' => 'profile.password', 'uses' => 'ProfileController@password']);
	
	Route::group(['middleware' => 'App\Http\Middleware\BulkAdminMiddleware'], function()
	{
			Route::get('bulk', 'AdKernalController@index')->name('bulk');
			Route::get('bulk/campaigns', 'AdKernalController@Campaigns')->name('bulk-campaigns');
			Route::get('bulk/upload', 'AdKernalController@Upload')->name('bulk-upload');
			Route::post('bulk/store', 'AdKernalController@Store')->name('bulk-store');
	});

	Route::group(['middleware' => 'App\Http\Middleware\SuperAdminMiddleware'], function()
	{
		Route::get('/home', 'HomeController@index')->name('home');
		Route::get('{page}/{id}', ['as' => 'page.index', 'uses' => 'PageController@index']);
		Route::get('ajax/campaigns', 'ApiController@getUserCampaigns');
		Route::get('ajax/report', 'ApiController@getCampaignReport');
		Route::get('ajax/company/insertionorder', 'ApiController@getCompanyInsertionOrders');

		Route::get('campaign', 'CampaignController@index')->name('campaigns');
		Route::get('campaign/create', 'CampaignController@create')->name('campaign-create');
		Route::post('campaign/create', 'CampaignController@store')->name('campaign-store');
		Route::get('campaign/view/{id}', 'CampaignController@view')->name('campaign-view');
		Route::get('campaign/edit/{id}', 'CampaignController@edit')->name('campaign-edit');
		Route::post('campaign/update', 'CampaignController@update')->name('campaign-update');
		Route::get('creative/edit/{id}', 'CampaignController@editCreative')->name('creative-edit');
		Route::post('creative/edit/{id}', 'CampaignController@updateCreative')->name('creative-update');

		Route::get('campaign/links/{id}', 'CampaignLinkController@index')->name('campaign-link');
		Route::post('campaign/links/update', 'CampaignLinkController@update')->name('campaign-link-update');

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