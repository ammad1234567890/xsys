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
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

//AccessControll
Route::get('/access','AccessControllController@index')->middleware('accesscontrol:2');//return view for creating role
Route::get('/permissions','AccessControllController@permission')->middleware('accesscontrol:2'); //return all permissions
Route::get('/role','AccessControllController@RolePermission');//returning all roles with permissions
Route::post('/createrole','AccessControllController@createRole')->middleware('accesscontrol:2'); //creating role
Route::post('/editRole','AccessControllController@editRole')->middleware('accesscontrol:2');//editing role and its permissions
Route::get('/deleterole/{id}','AccessControllController@deleteRole')->middleware('accesscontrol:2');//delete specific role

Route::get('/userrole','AccessControllController@userRole')->middleware('accesscontrol:2');
Route::get('/users','AccessControllController@users')->middleware('accesscontrol:2');
Route::get('/roles','AccessControllController@roles')->middleware('accesscontrol:2');
Route::get('/userroles','AccessControllController@userRoles')->middleware('accesscontrol:2');
Route::post('/edituserrole','AccessControllController@editUserRole')->middleware('accesscontrol:2');

//Product Management
Route::get('/product','ProductController@index');

Route::get('/test','ProductController@test')->middleware('accesscontrol:1');

//Product Management


//Retailers
Route::get('/retailer', 'RetailerController@index')->name('retailer');
Route::post('/retailer/create_retailer','RetailerController@create_retailer');
Route::post('/retailer/edit_retailer','RetailerController@edit_retailer');
Route::post('/retailer/delete_retailer','RetailerController@deactivate_retailer');
Route::post('/retailer/reactivate_retailer','RetailerController@activate_retailer');
Route::get('/retailer/get_retailers','RetailerController@get_all_retailers');
//Retailers

//Outlets
Route::get('/retailer/outlets', 'RetailerOutletController@index')->name('retailer_outlets');
Route::get('/outlet/get_all_outlets', 'RetailerOutletController@get_all_outlets');
Route::post('/outlet/create_outlet', 'RetailerOutletController@add_outlet');
Route::post('/outlet/delete_outlet', 'RetailerOutletController@deactivate_outlet');
Route::post('/outlet/reactivate_outlet', 'RetailerOutletController@activate_outlet');
Route::post('/outlet/update_outlet', 'RetailerOutletController@edit_outlet');
Route::post('/outlet/change_outlet_image','RetailerOutletController@edit_security_check_image');
//Outlets

//City
Route::post('/add_city','RetailerOutletController@add_city');
Route::get('/get_cities','RetailerOutletController@get_cities');
//City

//Region
Route::post('/add_region','RetailerOutletController@add_region');
Route::get('/get_regions','RetailerOutletController@get_regions');
//Region



//PRODUCT
Route::get('/product','ProductController@index'); //return products view
Route::get('/allProducts','ProductController@products');
//Route::get('/test','ProductController@test')->middleware('accesscontrol:1');
Route::post('/createProduct','ProductController@store');
Route::get('/deleteProduct/{id}','ProductController@destroy');
Route::post('/updateProduct','ProductController@update');
Route::post('/get_product_colors','ProductController@get_colors_by_product');
//PRODUCT

//CATEGORY
Route::get('/category','CategoryController@create');
Route::get('/categories','CategoryController@index');
Route::post('/editCategory','CategoryController@update');
Route::get('/path','CategoryController@path');
Route::get('/deleteCategory/{id}','CategoryController@destroy');
Route::post('/createCategory','CategoryController@store');//->middleware('accesscontrol:1');
//CATEGORY


//ORDER
Route::get('/order/create','OrderController@create_order');
Route::get('/order/receive','OrderController@receive_order');
Route::get('/order/payment','OrderController@order_payment');
Route::post('/order/create','OrderController@add_new_order');
Route::get('/order/get_orders','OrderController@get_orders');
Route::get('/order/get_status','OrderController@get_orders_status');
Route::post('/order/get_products','OrderController@get_products_by_order');
Route::post('/order/received','OrderController@order_received');
//ORDER


//General Management
Route::get('general','GeneralController@index');
Route::get('generalData','GeneralController@returnAll');

//City
//middleware('accesscontrol:3');
Route::get('/allCities','GeneralController@cities');
Route::post('/createCity','GeneralController@createCity');
Route::post('/editCity','GeneralController@editCity');
//City

//Region
//middleware('accesscontrol:4');
Route::get('/allRegions','GeneralController@regions');
Route::post('/createRegion','GeneralController@createRegion');
Route::post('/editRegion','GeneralController@editRegion');
//Region

//Department
Route::get('/allDepartments','GeneralController@departments')->middleware('accesscontrol:5');
Route::post('/createDepartment','GeneralController@createDepartment')->middleware('accesscontrol:5');
Route::post('/editDepartment','GeneralController@editDepartment')->middleware('accesscontrol:5');
//Department

//Staff type
Route::get('/allStaffType','GeneralController@staffType')->middleware('accesscontrol:6');
Route::post('/createStaffType','GeneralController@createStaffType')->middleware('accesscontrol:6');
Route::post('/editStaffType','GeneralController@editStaffType')->middleware('accesscontrol:6');
//Staff type

//Designation
Route::get('/allDesignations','GeneralController@designations')->middleware('accesscontrol:7');
Route::post('/createDesignation','GeneralController@createDesignation')->middleware('accesscontrol:7');
Route::post('/editDesignation','GeneralController@editDesignation')->middleware('accesscontrol:7');
//Designation


//Staff Management
Route::get('/staff','StaffController@index');
Route::get('/allStaff','StaffController@showAll');
Route::post('/createStaff','StaffController@store');
Route::post('/editStaff','StaffController@update');
Route::get('/deleteStaff/{id}','StaffController@destory');
//Staff Management