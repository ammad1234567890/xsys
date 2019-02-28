<?php 
use Illuminate\Http\Request;
	Route::post('login','PassportController@login');
Route::post('register','PassportController@register');
Route::group(['middleware' => 'auth:api'], function(){
	Route::post('get-details', 'PassportController@getDetails');
});

//Route::post('dealer_identification','API\DealerAuthController@dealer_identification');
//Route::post('dealer_login','API\DealerAuthController@login');

    Route::get('get_imei_details/{imei}/{dealer_id}', 'API\DealerAuthController@imei_details')->middleware('client');
Route::post('item_activation','API\DealerAuthController@activate_item')->middleware('client');

Route::post('logout','API\DealerAuthController@logout');//->middleware('client');


?>