<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//BY DEFAULT ROUTES
Route::post('login','PassportController@login');
Route::post('register','PassportController@register');
Route::group(['middleware' => 'auth:api'], function(){
	Route::post('get-details', 'PassportController@getDetails');
});
//BY DEFAULT ROUTES END

//BEFORE LOGIN ROUTES
Route::post('dealer_identification','API\DealerAuthController@dealer_identification');
Route::post('dealer_login','API\DealerAuthController@login');	

Route::post('/update_token','API\DealerAuthController@set_token');
Route::post('/activation_response', 'API\ImeiActivationController@activate_imei');
//BEFORE LOGIN ROUTES END

//AFTER LOGIN ROUTES
Route::group(['middleware' => 'client_credentials'], function() {
	Route::post('get_dealer_dashboard', 'API\outletController@dealer_dashboard');
	//Route::post('get_dealer_ledger','API\outletController@get_dealer_ledger');
	Route::get('get_imei_details/{imei}/{dealer_id}', 'API\DealerAuthController@imei_details');
	Route::post('item_activation','API\DealerAuthController@activate_item');
	Route::post('logout','API\DealerAuthController@logout');
	Route::get('get_notifications/{dealer_id}', 'API\DealerAuthController@get_all_notification');
	Route::post('get_dealer_activations', 'API\ImeiActivationController@get_dealer_activations');
	Route::post('get_dealer_shelf', 'API\ImeiActivationController@get_dealer_shelf');
	
	// after login so routes
	Route::post('get_so_tasks', 'API\SoTaskController@get_so_tasks');
	Route::post('submit_shelf_report', 'API\SoTaskController@submit_shelf_report');
	Route::post('get_outlet_imeis', 'API\SoTaskController@outlet_imeis');

});
//AFTER LOGIN ROUTES END

Route::post("/so_identification","API\SoAuthController@so_identification");
Route::post("/so_login","API\SoAuthController@login");


