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

Route::get('/testH','HomeController@test');
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/example','HomeController@demo');
//AccessControll
Route::get('/access','AccessControllController@index');//->middleware('accesscontrol:2');//return view for creating role
Route::get('/permissions','AccessControllController@permission');//->middleware('accesscontrol:2'); //return all permissions
Route::get('/role','AccessControllController@RolePermission');//returning all roles with permissions
Route::post('/createrole','AccessControllController@createRole');//->middleware('accesscontrol:2'); //creating role
Route::post('/editRole','AccessControllController@editRole');//->middleware('accesscontrol:2');//editing role and its permissions
Route::get('/deleterole/{id}','AccessControllController@deleteRole');//->middleware('accesscontrol:2');//delete specific role

Route::get('/userrole','AccessControllController@userRole');//->middleware('accesscontrol:2');
Route::get('/users','AccessControllController@users');//->middleware('accesscontrol:2');
Route::get('/roles','AccessControllController@roles');//->middleware('accesscontrol:2');
Route::get('/userroles','AccessControllController@userRoles');//->middleware('accesscontrol:2');
Route::post('/edituserrole','AccessControllController@editUserRole');//->middleware('accesscontrol:2');

//Product Management
Route::get('/product','ProductController@index');

Route::get('/test','ProductController@test');//->middleware('accesscontrol:1');

//Product Management


//Retailers
Route::get('/retailer', 'RetailerController@index')->name('retailer');
Route::get('/retailer_list', 'RetailerController@retailer_list');
Route::post('/retailer/create_retailer','RetailerController@create_retailer');
Route::post('/retailer/edit_retailer','RetailerController@edit_retailer');
Route::post('/retailer/delete_retailer','RetailerController@deactivate_retailer');
Route::post('/retailer/reactivate_retailer','RetailerController@activate_retailer');
Route::get('/retailer/get_retailers','RetailerController@get_all_retailers');
Route::get('/retailer/create_order','RetailerController@create_order');

//Retailers

//RETAILER ORDE
Route::post('/retailer/order/create','RetailerController@create_new_order');
//Route::get('/retailer_order/account_clearance','RetailerOrderController@non_clear_order');
Route::get('/retailer_order/get_all_non_clear_orders','RetailerOrderController@get_all_non_clear_orders');
Route::get('/retailer_order/get_orders','RetailerOrderController@get_all_orders');
Route::get('/retailer_order/orders','RetailerOrderController@orders');
Route::post('/retailer_order/delete','RetailerOrderController@delete_order');
Route::get('/retailer_order/payment','RetailerOrderController@order_payment');
Route::get('/retailer/get_invoices','RetailerOrderController@get_all_invoices');
Route::post('/retailer/order/add_payment','RetailerOrderController@add_order_payment');
//RETAILER ORDER

//Outlets
Route::get('/retailer/outlets', 'RetailerOutletController@index')->name('retailer_outlets');
Route::get('/outlet/get_all_outlets', 'RetailerOutletController@get_all_outlets');
Route::post('/outlet/create_outlet', 'RetailerOutletController@add_outlet');
Route::post('/outlet/delete_outlet', 'RetailerOutletController@deactivate_outlet');
Route::post('/outlet/reactivate_outlet', 'RetailerOutletController@activate_outlet');
Route::post('/outlet/update_outlet', 'RetailerOutletController@edit_outlet');
Route::post('/outlet/change_outlet_image','RetailerOutletController@edit_security_check_image');
Route::post('/outlet/retailer_outlets','RetailerOutletController@get_retailer_outlets');

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
Route::get('/showproduct','ProductController@showProduct');
//Route::get('/test','ProductController@test')->middleware('accesscontrol:1');
Route::post('/createProduct','ProductController@store');
Route::get('/deleteProduct/{id}','ProductController@destroy');
Route::post('/updateProduct','ProductController@update');
Route::post('/get_product_colors','ProductController@get_colors_by_product');
Route::get('/productSearch/{search}','ProductController@search');
Route::get('/productColor/{id}','ProductController@productColor');
Route::get('/getproductColor/{id}','ProductController@get_product_color_by_id');
//PRODUCT

//CATEGORY
Route::get('/category','CategoryController@create');
Route::get('/showCategory','CategoryController@showCategory');
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
Route::get('/order/get_orders','OrderController@get_transaction_closed_orders');
Route::get('/order/all_orders','OrderController@get_orders');
Route::post('/order/create','OrderController@add_new_order');
Route::get('/order/get_all_orders','OrderController@get_all_orders');
Route::post('/order/get_orders_by_id','OrderController@get_orders_by_id');
Route::post('/order/get_products','OrderController@get_products_by_order');
Route::post('/order/received','OrderController@order_received');
Route::get('/order/received_orders','OrderController@received_orders');
Route::get('/order/received_order_details','OrderController@received_order_details');
Route::post('/order/add_payment','OrderController@add_payment');
Route::post('/order/change_order_status','OrderController@change_order_status');
Route::post('/order/delete','OrderController@delete_order');
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
Route::get('/regions/{search}','GeneralController@searchRegion');
//Region

//Department
//middleware('accesscontrol:5')
Route::get('/allDepartments','GeneralController@departments');
Route::post('/createDepartment','GeneralController@createDepartment');
Route::post('/editDepartment','GeneralController@editDepartment');
//Department

//Staff type
//middleware('accesscontrol:6')
Route::get('/allStaffType','GeneralController@staffType');
Route::post('/createStaffType','GeneralController@createStaffType');
Route::post('/editStaffType','GeneralController@editStaffType');
//Staff type
//Warehouse type
Route::get('/allWarehouseType','GeneralController@warehouseType');//->middleware('accesscontrol:7');
Route::post('/createWarehouseType','GeneralController@createWarehouseType');//->middleware('accesscontrol:7');
Route::post('/editWarehouseType','GeneralController@editWarehouseType');//->middleware('accesscontrol:7');
//Warehouse type
//Designation
// Route::get('/allDesignations','GeneralController@designations')->middleware('accesscontrol:8');
// Route::post('/createDesignation','GeneralController@createDesignation')->middleware('accesscontrol:8');
// Route::post('/editDesignation','GeneralController@editDesignation')->middleware('accesscontrol:8');
//Designation
//middleware('accesscontrol:7')
Route::get('/allDesignations','GeneralController@designations');
Route::post('/createDesignation','GeneralController@createDesignation');
Route::post('/editDesignation','GeneralController@editDesignation');
//Designation


//Staff Management
Route::get('/manager','StaffController@manager');
Route::get('/accountant','StaffController@accountant');
Route::get('/staff','StaffController@index');
Route::get('/viewStaff','StaffController@viewStaff');
Route::get('/allStaff','StaffController@showAll');
Route::post('/createStaff','StaffController@store');
Route::post('/editStaff','StaffController@update');
Route::get('/deleteStaff/{id}','StaffController@destory');
//Staff Management


//Currency
Route::get('/get_currencies','GeneralController@get_all_currencies');
Route::post('/add_currency','GeneralController@get_add_currency');

//Payment_types
Route::get('/get_payment_types','GeneralController@get_all_payment_types');
Route::post('/add_payment','GeneralController@add_payment');

//RecieveStatus
Route::get('/order/get_status','GeneralController@get_order_status');
Route::post('/order/add_status','GeneralController@add_order_status');

//IMEI Upload
Route::get('/importIMEI', 'IMEIController@importExport');
Route::get('/downloadExcel/{type}', 'IMEIController@downloadExcel');
Route::post('/importExcel', 'IMEIController@importExcel');
//IMEI Upload
//Warehouse
//Warehouse Management
Route::get('/warehouse','WarehouseController@index');
Route::get('/createNewWarehouse','WarehouseController@create');
Route::get('/allWarehouse','WarehouseController@allWarehouses');
Route::post('/createWarehouse','WarehouseController@store');
Route::post('/editWarehouse','WarehouseController@update');
Route::get('/deleteWarehouse/{id}','WarehouseController@destroy');
Route::get('/warehouse_by_manager','WarehouseController@get_warehouse_by_manager');
Route::post('/warehouse_salesofficer','WarehouseController@warehouse_salesofficer');
Route::post('/warehouse_products','WarehouseController@warehouse_products');
//Warehouse Management
//WarehouseStaff
Route::get('/warehouseStaff','WarehouseStaffController@index');
Route::get('/warehouseStaffView','WarehouseStaffController@viewStaff');
Route::get('/searchStaff/{colum}/{search}','WarehouseStaffController@search');
Route::post('/createWarehouseStaff','WarehouseStaffController@store');
Route::get('/warehouseSearchStaff/{id}','WarehouseStaffController@searchStaff');
Route::get('/removeStaff/{id}','WarehouseStaffController@remove');
//WarehouseStaff
//Main Warehouse
//MainWarehouseReceive
Route::get('/mainWarehouseReceive','MainWarehouseReceiveController@index');
Route::get('/currentWarehouse','MainWarehouseReceiveController@currentWarehouse');
Route::get('/receivSearch/{search}','MainWarehouseReceiveController@receive');
Route::post('/createMainWarehouseReceive','MainWarehouseReceiveController@store');
Route::get('/lastWarehouseReceive','MainWarehouseReceiveController@lastWarehouseReceive');
Route::post('/createReceiveItems','MainWarehouseReceiveController@createReceiveItems');
//MainWarehouseReceive
//Main Warehouse
//Warehouse Issue
Route::get('/warehouseIssue','WarehouseIssueController@index');
Route::get('/warehouseIssueRequest','WarehouseIssueController@warehouseIssueRequest');
Route::get('/getProducts/{id}','WarehouseIssueController@getProducts');
Route::post('/createIssue','WarehouseIssueController@createIssue');
//Warehouse Issue
//Warehouse Stock
Route::get('/warehouseStock','WarehouseStockController@index');
Route::get('/allStock','WarehouseStockController@allStock');
Route::get('/warehouseStockSearch/{id}','WarehouseStockController@warehouseStockSearch');
Route::get('/searchStockDetails/{id}','WarehouseStockController@searchStockDetails');
//Warehouse Stock
//Warehouse

//Finance
Route::get('/finance/orders_approval','FinanceController@non_approved_order');
Route::post('/finance/approve_order','FinanceController@approve_retailer_order');
Route::post('/retailer_order/edit_products','RetailerOrderController@edit_order_products');
//Financee

//BANK
Route::get('/bank/get_all_banks','BankController@get_all_banks');


//Finance
Route::get('/ledger','RetailerLedgersController@index');
Route::post('/ledgerData','RetailerLedgersController@get_all_ledger');
Route::post('/RetailerTotalOutstanding','RetailerLedgersController@retailer_ledger_balance');
Route::get('/bank','BankController@index');
Route::get('/allBanks','BankController@banks');
Route::post('/createBank','BankController@createBank');
Route::get('/retailer_order/get_order/{id}','RetailerOrderController@get_all_order');
Route::get('/invoice/create/{id}','RetailerInvoiceController@invoiceCreate');
Route::post('/invoice/store/','RetailerInvoiceController@store');
Route::get('/invoice/list/','RetailerInvoiceController@index');
Route::get('/invoice/get_invoice/','RetailerInvoiceController@get_invoice');
Route::post('/get_invoice_by_retailer','RetailerInvoiceController@get_invoice_by_retailer');