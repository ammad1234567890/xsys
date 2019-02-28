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
Auth::routes();
Route::get('/luhn', function () {
    return view('luhn_alog');
});
Route::get('/verfiy_sheets', function () {
    return view('verify_imei_sheets');
});

Route::post("/verify_imeis", "MainWarehouseReceiveController@verify_imeis");

//Route::get('/', function () {
    //return redirect('/login');
//});



Route::middleware(['auth'])->group(function () {
    //Report
        Route::get("/get_all_sales_officers","StaffController@get_all_sales_officer");
        Route::get("/get_cities_by_state/{state_id}", "RetailerOutletController@get_cities_by_state");
        Route::get("/get_outlet_by_city_state/{state}/{city?}", "RetailerOutletController@get_outlet_by_city_state");
        Route::get("/export_excel_all_outlets/{name}/{data}","RetailerOutletController@export_excel_all_outlets");

    //REPRT


        //New Updates 14-Decemeber-2018
            Route::post("/transaction_closed", "RetailerOrderController@transaction_closed_ds");

        //

    //Deactivate

    Route::get('/deactivate_imei', function () {
        return view('imei_deactivate');
    });


    Route::post("/deactivate", "MainWarehouseReceiveController@deactivate_imei");
    //Deactivate

Route::get("/export_excel_all_outlets","RetailerOutletController@export_excel_all_outlets");
Route::get('/TaskReport/{task_id}',function(){
    return View('TaskShelfReport');
});

Route::get("/get_all_advance_payments", "RetailerOrderController@get_all_advance_payment");
Route::get("/get_all_credit_notes_payments", "RetailerOrderController@get_all_credit_notes");



Route::get('/get_shelf_imeis_by_task/{task_id}', 'RetailerOutletController@get_shelf_imeis_by_task');

Route::post('/changeToCompleteTask','RetailerOutletController@changeToCompleteTask');

Route::post('/create_survey_task', 'RetailerOutletController@create_survey_task');


Route::get('/get_for_activate_imeis_by_task/{task_id}', 'RetailerOutletController@get_for_activate_imeis_by_task');
Route::get('/get_so_task/{task_id}', 'RetailerOutletController@get_so_task');
Route::get('/get_all_so_tasks', 'RetailerOutletController@get_all_so_tasks');
    Route::post('/get_past_closing_balance', 'RetailerLedgersController@past_closing_balance');
    Route::get("so_tasks", function(){
        return view('survey_tasks');
    });

    Route::get("get_sales_officer_outlet/{so_id}", "RetailerOutletController@get_outlet_of_salesOfficers");

    Route::get("/get_sales_officers_outlet", "RetailerOutletController@get_sales_officers_outlets");

Route::get("/get_outlet_advance_amount/{outlet_id}","RetailerOutletController@get_outlet_advance_amount");
Route::get('get_cr_types', 'RetailerOrderController@get_cr_types');
Route::post('/retailer/order/create_credit_note','RetailerOrderController@create_credit_note');
Route::post('/retailer/order/add_advance_payment','RetailerOrderController@add_advance_payment');
	
	Route::get('/deposit_slip_details/{ds_id}','RetailerOrderController@deposit_slip_details');
Route::get('/get_warehouse_instock_items', 'WarehouseStockController@get_warehouse_instock_items');
Route::get('/get_warehouse_sold_items', 'WarehouseStockController@get_warehouse_sold_items');

Route::get('/get_all_outlets_dataTable', 'RetailerOutletController@get_all_outlets_dataTable');
Route::get('/get_all_orders_warehouse_datatable/{id}', 'RetailerOrderController@get_all_orders_warehouse_datatable');
Route::get('/receive_TransferStock', function(){
    return View('receive_TransferStock');
});

Route::get('/get_transfer_receiving', 'WarehouseTransferController@get_transfer_receiving');
Route::post('/receive_stock_to_warehouse', 'WarehouseTransferController@receive_stock_to_warehouse');
Route::get('/transferinvoice_print/{win_id}', function(){
    return View('TransferInvoice');
});
	
	Route::get('/transferinvoiceimei_print/{win_id}', function(){
        return View('TransferImeiInvoice');
    });

    Route::get('/transfer_imei_print/{win_id}','WarehouseTransferController@transfer_imei_print');
Route::get('/change_pass', function(){
    return View('change_password');
});
Route::post('update_user_password','AccessControllController@update_user_password');

Route::get('/testH','HomeController@test');
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/example','HomeController@demo');
//AccessControll ->middleware('accesscontrol:2')

Route::get('/access','AccessControllController@index')->middleware('accesscontrol:/access');//return view for creating role
Route::get('/permissions','AccessControllController@permission')->middleware('accesscontrol:/permissions');    //return all permissions

Route::post('/delete_permission','AccessControllController@delete_permission');
Route::post('/edit_permission','AccessControllController@edit_permission');

Route::get('/role','AccessControllController@RolePermission')->middleware('accesscontrol:/role');       //returning all roles with permissions
Route::post('/createrole','AccessControllController@createRole')->middleware('accesscontrol:/createrole');    //creating role
Route::post('/editRole','AccessControllController@editRole')->middleware('accesscontrol:/editRole');       //editing role and its permissions
Route::get('/deleterole/{id}','AccessControllController@deleteRole')->middleware('accesscontrol:/deleterole/{id}');//delete specific role
Route::get('/deleterole/{id}','AccessControllController@deleteRole')->middleware('accesscontrol:/deleterole/{id}');
Route::get('/permission_manage','AccessControllController@permission_view')->middleware('accesscontrol:/permission_manage');
Route::post('/create_permission','AccessControllController@create_permission')->middleware('accesscontrol:/create_permission');

Route::get('/userrole','AccessControllController@userRole')->middleware('accesscontrol:/userrole');
Route::get('/users','AccessControllController@users')->middleware('accesscontrol:/users');
Route::get('/roles','AccessControllController@roles')->middleware('accesscontrol:/roles');
Route::get('/userroles','AccessControllController@userRoles')->middleware('accesscontrol:/userroles');
Route::post('/edituserrole','AccessControllController@editUserRole')->middleware('accesscontrol:/edituserrole');

//Product Management
Route::get('/product','ProductController@index')->middleware('accesscontrol:/product');

Route::get('/test','ProductController@test');//->middleware('accesscontrol:1');

//Product Management


//Retailers
Route::get('/retailer', 'RetailerController@index')->name('retailer')->middleware('accesscontrol:/retailer');
Route::get('/retailer_list', 'RetailerController@retailer_list')->middleware('accesscontrol:/retailer_list');
Route::post('/retailer/create_retailer','RetailerController@create_retailer')->middleware('accesscontrol:/retailer/create_retailer');
Route::post('/retailer/edit_retailer','RetailerController@edit_retailer')->middleware('accesscontrol:/retailer/edit_retailer');
Route::post('/retailer/delete_retailer','RetailerController@deactivate_retailer')->middleware('accesscontrol:/retailer/delete_retailer');
Route::post('/retailer/reactivate_retailer','RetailerController@activate_retailer')->middleware('accesscontrol:/retailer/reactivate_retailer');
Route::get('/retailer/get_retailers','RetailerController@get_all_retailers')->middleware('accesscontrol:/retailer/get_retailers');
Route::get('/retailer/create_order','RetailerController@create_order')->middleware('accesscontrol:/retailer/create_order');

Route::post('/retailer/edit_retailer_image','RetailerOutletController@edit_retailer_image');
Route::post('/retailer/delete_retailer_image','RetailerOutletController@delete_retailer_image');




//Retailers

//RETAILER ORDE
Route::post('/retailer/order/create','RetailerController@create_new_order')->middleware('accesscontrol:/retailer/order/create');
//Route::get('/retailer_order/account_clearance','RetailerOrderController@non_clear_order');
Route::get('/retailer_order/get_all_non_clear_orders','RetailerOrderController@get_all_non_clear_orders')->middleware('accesscontrol:/retailer_order/get_all_non_clear_orders');
Route::get('/retailer_order/get_orders','RetailerOrderController@get_all_orders')->middleware('accesscontrol:/retailer_order/get_orders');
Route::get('/retailer_order/get_warehouse_orders/{warehouse_id}','RetailerOrderController@get_all_orders_warehouse');
Route::get('/retailer_order/orders','RetailerOrderController@orders')->middleware('accesscontrol:/retailer_order/orders');
Route::post('/retailer_order/delete','RetailerOrderController@delete_order')->middleware('accesscontrol:/retailer_order/delete');
Route::get('/retailer_order/payment','RetailerOrderController@order_payment')->middleware('accesscontrol:/retailer_order/payment');
Route::get('/retailer/get_invoices','RetailerOrderController@get_all_invoices')->middleware('accesscontrol:/retailer/get_invoices');
Route::post('/retailer/order/add_payment','RetailerOrderController@add_order_payment')->middleware('accesscontrol:/retailer/order/add_payment');
//Route::post('/retailer/order/add_advance_payment','RetailerOrderController@add_advance_payment')->middleware('accesscontrol:/retailer/order/add_advance_payment');
//RETAILER ORDER

//Outlets
Route::get('/retailer/outlets', 'RetailerOutletController@index')->name('retailer_outlets')->middleware('accesscontrol:/retailer/outlets');
Route::get('/outlet/get_all_outlets', 'RetailerOutletController@get_all_outlets')->middleware('accesscontrol:/outlet/get_all_outlets');
Route::get('/outlet/get_all_outlets_by_id/{id}', 'RetailerOutletController@get_all_outlets_by_id')->middleware('accesscontrol:/outlet/get_all_outlets_by_id/{id}');
Route::post('/outlet/create_outlet', 'RetailerOutletController@add_outlet')->middleware('accesscontrol:/outlet/create_outlet');
Route::post('/outlet/delete_outlet', 'RetailerOutletController@deactivate_outlet')->middleware('accesscontrol:/outlet//outlet/delete_outlet');
Route::post('/outlet/reactivate_outlet', 'RetailerOutletController@activate_outlet')->middleware('accesscontrol:/outlet/reactivate_outlet');
Route::post('/outlet/update_outlet', 'RetailerOutletController@edit_outlet')->middleware('accesscontrol:/outlet/update_outlet');
Route::post('/outlet/change_outlet_image','RetailerOutletController@edit_security_check_image')->middleware('accesscontrol:/outlet/change_outlet_image');
Route::post('/outlet/retailer_outlets','RetailerOutletController@get_retailer_outlets')->middleware('accesscontrol:/outlet/retailer_outlets');

//Outlets

//City
Route::post('/add_city','RetailerOutletController@add_city')->middleware('accesscontrol:/add_city');
Route::get('/get_cities','RetailerOutletController@get_cities')->middleware('accesscontrol:/get_cities');
//City

//Region
Route::post('/add_region','RetailerOutletController@add_region')->middleware('accesscontrol:/add_region');
Route::get('/get_regions','RetailerOutletController@get_regions')->middleware('accesscontrol:/get_regions');
//Region



//PRODUCT
Route::get('/product','ProductController@index')->middleware('accesscontrol:/product'); //return products view
Route::get('/allProducts','ProductController@products')->middleware('accesscontrol:/allProducts');
Route::get('/showproduct','ProductController@showProduct')->middleware('accesscontrol:/showproduct');
//Route::get('/test','ProductController@test')->middleware('accesscontrol:1');
Route::post('/createProduct','ProductController@store')->middleware('accesscontrol:/createProduct');
Route::get('/deleteProduct/{id}','ProductController@destroy')->middleware('accesscontrol:/deleteProduct/{id}');
Route::post('/updateProduct','ProductController@update')->middleware('accesscontrol:/updateProduct');
Route::post('/get_product_colors','ProductController@get_colors_by_product')->middleware('accesscontrol:/get_product_colors');
Route::get('/productSearch/{search}','ProductController@search')->middleware('accesscontrol:/productSearch/{search}');
Route::get('/productColor/{id}','ProductController@productColor')->middleware('accesscontrol:/productColor/{id}');
Route::get('/getproductColor/{id}','ProductController@get_product_color_by_id')->middleware('accesscontrol:/getproductColor/{id}');
//PRODUCT

//CATEGORY
Route::get('/category','CategoryController@create')->middleware('accesscontrol:/category');
Route::get('/showCategory','CategoryController@showCategory')->middleware('accesscontrol:/showCategory');
Route::get('/categories','CategoryController@index')->middleware('accesscontrol:/categories');
Route::post('/editCategory','CategoryController@update')->middleware('accesscontrol:/editCategory');
Route::get('/path','CategoryController@path')->middleware('accesscontrol:/path');
Route::get('/deleteCategory/{id}','CategoryController@destroy')->middleware('accesscontrol:/deleteCategory/{id}');
Route::post('/createCategory','CategoryController@store')->middleware('accesscontrol:/createCategory');//->middleware('accesscontrol:1');
//CATEGORY


//ORDER
Route::get('/order/create','OrderController@create_order')->middleware('accesscontrol:/order/create');
Route::get('/order/receive','OrderController@receive_order')->middleware('accesscontrol:/order/receive');
Route::get('/order/payment','OrderController@order_payment')->middleware('accesscontrol:/order/payment');
Route::get('/order/get_orders','OrderController@get_transaction_closed_orders')->middleware('accesscontrol:/order/get_orders');
Route::get('/order/all_orders','OrderController@get_orders')->middleware('accesscontrol:/order/all_orders');
Route::post('/order/create','OrderController@add_new_order')->middleware('accesscontrol:/order/create');
Route::get('/order/get_all_orders','OrderController@get_all_orders')->middleware('accesscontrol:/order/get_all_orders');
Route::post('/order/get_orders_by_id','OrderController@get_orders_by_id')->middleware('accesscontrol:/order/get_orders_by_id');
Route::post('/order/get_products','OrderController@get_products_by_order')->middleware('accesscontrol:/order/get_products');
Route::post('/order/received','OrderController@order_received')->middleware('accesscontrol:/order/received');
Route::get('/order/received_orders','OrderController@received_orders')->middleware('accesscontrol:/order/received_orders');
Route::get('/order/received_order_details','OrderController@received_order_details')->middleware('accesscontrol:/order/received_order_details');
Route::get('/order/received_order_status','OrderController@received_order_status')->middleware('accesscontrol:/order/received_order_status');
Route::post('/order/add_payment','OrderController@add_payment')->middleware('accesscontrol:/order/add_payment');
Route::post('/order/change_order_status','OrderController@change_order_status')->middleware('accesscontrol:/order/change_order_status');
Route::post('/order/delete','OrderController@delete_order')->middleware('accesscontrol:/order/delete');
//ORDER


//General Management
Route::get('general','GeneralController@index')->middleware('accesscontrol:/general');
Route::get('generalData','GeneralController@returnAll')->middleware('accesscontrol:/generalData');

//City
//middleware('accesscontrol:3');
Route::get('/allCities','GeneralController@cities')->middleware('accesscontrol:/allCities');
Route::post('/createCity','GeneralController@createCity')->middleware('accesscontrol:/createCity');
Route::post('/editCity','GeneralController@editCity')->middleware('accesscontrol:/editCity');
//City

//Region
//middleware('accesscontrol:4');
Route::get('/allRegions','GeneralController@regions')->middleware('accesscontrol:/allRegions');
Route::post('/createRegion','GeneralController@createRegion')->middleware('accesscontrol:/createRegion');
Route::post('/editRegion','GeneralController@editRegion')->middleware('accesscontrol:/editRegion');
Route::get('/regions/{search}','GeneralController@searchRegion')->middleware('accesscontrol:/regions/{search}');
//Region

//Department
//middleware('accesscontrol:5')
Route::get('/allDepartments','GeneralController@departments')->middleware('accesscontrol:/allDepartments');
Route::post('/createDepartment','GeneralController@createDepartment')->middleware('accesscontrol:/createDepartment');
Route::post('/editDepartment','GeneralController@editDepartment')->middleware('accesscontrol:/editDepartment');
//Department

//Staff type
//middleware('accesscontrol:6')
Route::get('/allStaffType','GeneralController@staffType')->middleware('accesscontrol:/allStaffType');
Route::post('/createStaffType','GeneralController@createStaffType')->middleware('accesscontrol:/createStaffType');
Route::post('/editStaffType','GeneralController@editStaffType')->middleware('accesscontrol:/editStaffType');
//Staff type
//Warehouse type
Route::get('/allWarehouseType','GeneralController@warehouseType')->middleware('accesscontrol:/allWarehouseType');//->middleware('accesscontrol:7');
Route::get('/allWarehouses_details','WarehouseController@allWarehouses_details');
Route::post('/createWarehouseType','GeneralController@createWarehouseType')->middleware('accesscontrol:/createWarehouseType');//->middleware('accesscontrol:7');
Route::post('/editWarehouseType','GeneralController@editWarehouseType')->middleware('accesscontrol:/editWarehouseType');//->middleware('accesscontrol:7');
//Warehouse type
//Designation
// Route::get('/allDesignations','GeneralController@designations')->middleware('accesscontrol:8');
// Route::post('/createDesignation','GeneralController@createDesignation')->middleware('accesscontrol:8');
// Route::post('/editDesignation','GeneralController@editDesignation')->middleware('accesscontrol:8');
//Designation
//middleware('accesscontrol:7')
Route::get('/allDesignations','GeneralController@designations')->middleware('accesscontrol:/allDesignations');
Route::post('/createDesignation','GeneralController@createDesignation')->middleware('accesscontrol:/createDesignation');
Route::post('/editDesignation','GeneralController@editDesignation')->middleware('accesscontrol:/editDesignation');
//Designation


//Staff Management
Route::get('/manager','StaffController@manager')->middleware('accesscontrol:/manager');
Route::get('/accountant','StaffController@accountant')->middleware('accesscontrol:/accountant');
Route::get('/staff','StaffController@index')->middleware('accesscontrol:/staff');
Route::get('/viewStaff','StaffController@viewStaff')->middleware('accesscontrol:/viewStaff');
Route::get('/allStaff','StaffController@showAll')->middleware('accesscontrol:/allStaff');
Route::post('/createStaff','StaffController@store')->middleware('accesscontrol:/createStaff');
Route::post('/editStaff','StaffController@update')->middleware('accesscontrol:/editStaff');
Route::get('/deleteStaff/{id}','StaffController@destory')->middleware('accesscontrol:/deleteStaff/{id}');
//Staff Management


//Currency
Route::get('/get_currencies','GeneralController@get_all_currencies')->middleware('accesscontrol:/get_currencies');
Route::post('/add_currency','GeneralController@get_add_currency')->middleware('accesscontrol:/add_currency');

//Payment_types
Route::get('/get_payment_types','GeneralController@get_all_payment_types')->middleware('accesscontrol:/get_payment_types');
Route::post('/add_payment','GeneralController@add_payment')->middleware('accesscontrol:/add_payment');

//RecieveStatus
Route::get('/order/get_status','GeneralController@get_order_status')->middleware('accesscontrol:/order/get_status');
Route::post('/order/add_status','GeneralController@add_order_status')->middleware('accesscontrol:/order/add_statust');

//IMEI Upload
Route::get('/importIMEI', 'IMEIController@importExport')->middleware('accesscontrol:/importIMEI');
Route::get('/downloadExcel/{type}', 'IMEIController@downloadExcel')->middleware('accesscontrol:/downloadExcel/{type}');
Route::post('/importExcel', 'IMEIController@importExcel')->middleware('accesscontrol:/importExcel');
//IMEI Upload
//Warehouse
//Warehouse Management
Route::get('/warehouse','WarehouseController@index')->middleware('accesscontrol:/warehouse');
Route::get('/createNewWarehouse','WarehouseController@create')->middleware('accesscontrol:/createNewWarehouse');
Route::get('/allWarehouse','WarehouseController@allWarehouses')->middleware('accesscontrol:/allWarehouse');
Route::post('/createWarehouse','WarehouseController@store')->middleware('accesscontrol:/createWarehouse');
Route::post('/editWarehouse','WarehouseController@update')->middleware('accesscontrol:/editWarehouse');
Route::get('/deleteWarehouse/{id}','WarehouseController@destroy')->middleware('accesscontrol:/deleteWarehouse/{id}');
Route::get('/warehouse_by_manager','WarehouseController@get_warehouse_by_manager')->middleware('accesscontrol:/warehouse_by_manager');
Route::post('/warehouse_salesofficer','WarehouseController@warehouse_salesofficer')->middleware('accesscontrol:/warehouse_salesofficer');
Route::post('/warehouse_products','WarehouseController@warehouse_products')->middleware('accesscontrol:/warehouse_products');
Route::post('/get_warehouse_by_city','WarehouseController@warehouse_by_city')->middleware('accesscontrol:/get_warehouse_by_city');
//Warehouse Management
//WarehouseStaff
Route::get('/warehouseStaff','WarehouseStaffController@index')->middleware('accesscontrol:/warehouseStaff');
Route::get('/warehouseStaffView','WarehouseStaffController@viewStaff')->middleware('accesscontrol:/warehouseStaffView');
Route::get('/searchStaff/{colum}/{search}','WarehouseStaffController@search')->middleware('accesscontrol:/searchStaff/{colum}/{search}');
Route::post('/createWarehouseStaff','WarehouseStaffController@store')->middleware('accesscontrol:/createWarehouseStaff');
Route::get('/warehouseSearchStaff/{id}','WarehouseStaffController@searchStaff')->middleware('accesscontrol:/warehouseSearchStaff/{id}');
Route::get('/removeStaff/{id}','WarehouseStaffController@remove')->middleware('accesscontrol:/removeStaff/{id}');
//WarehouseStaff
//Main Warehouse
//MainWarehouseReceive
Route::get('/mainWarehouseReceive','MainWarehouseReceiveController@index')->middleware('accesscontrol:/mainWarehouseReceive');
Route::get('/currentWarehouse','MainWarehouseReceiveController@currentWarehouse')->middleware('accesscontrol:/currentWarehouse');
Route::get('/receivSearch/{search}','MainWarehouseReceiveController@receive')->middleware('accesscontrol://receivSearch/{search}');
Route::post('/createMainWarehouseReceive','MainWarehouseReceiveController@store')->middleware('accesscontrol:/createMainWarehouseReceive');
Route::get('/getMainWarehouseReceive/{id}','MainWarehouseReceiveController@getReceive')->middleware('accesscontrol:/getMainWarehouseReceive/{id}');
Route::get('/getRemainingQuantity/{receiveId}/{productColorId}','MainWarehouseReceiveController@getRemainingQuantity')->middleware('accesscontrol:/getRemainingQuantity/{receiveId}/{productColorId}');
Route::get('/lastWarehouseReceive','MainWarehouseReceiveController@lastWarehouseReceive')->middleware('accesscontrol:/lastWarehouseReceive');
Route::post('/createReceiveItems','MainWarehouseReceiveController@createReceiveItems')->middleware('accesscontrol:/createReceiveItems');
Route::post('/receive_consignment_items','MainWarehouseReceiveController@receive_consignment_items')->middleware('accesscontrol:/receive_consignment_items');
//MainWarehouseReceive
//Main Warehouse
//Warehouse Issue
Route::get('/warehouseIssue','WarehouseIssueController@index')->middleware('accesscontrol:/warehouseIssue');
Route::get('/warehouseIssueRequest','WarehouseIssueController@warehouseIssueRequest')->middleware('accesscontrol:/warehouseIssueRequest');
Route::get('/itemReversal/{invoiceId}','WarehouseIssueController@inverseIssue')->middleware('accesscontrol:/itemReversal/{invoiceId}');
Route::get('/getProducts/{id}','WarehouseIssueController@getProducts')->middleware('accesscontrol:/getProducts/{id}');
Route::post('/createIssue','WarehouseIssueController@createIssue')->middleware('accesscontrol:/createIssue');
//Warehouse Issue
//Warehouse Stock
Route::get('/warehouseStock','WarehouseStockController@index')->middleware('accesscontrol:/warehouseStock');
Route::get('/allStock','WarehouseStockController@allStock')->middleware('accesscontrol:/allStock');
Route::get('/warehouseStockSearch/{id}','WarehouseStockController@warehouseStockSearch')->middleware('accesscontrol:/warehouseStockSearch/{id}');
Route::get('/searchStockDetails/{id}','WarehouseStockController@searchStockDetails')->middleware('accesscontrol:/searchStockDetails/{id}');
//Warehouse Stock
//Warehouse

//Finance
Route::get('/finance/orders_approval','FinanceController@non_approved_order')->middleware('accesscontrol:/finance/orders_approval');
Route::post('/finance/approve_order','FinanceController@approve_retailer_order')->middleware('accesscontrol:/finance/approve_order');
Route::post('/retailer_order/edit_products','RetailerOrderController@edit_order_products')->middleware('accesscontrol:/retailer_order/edit_products');
//Financee

//BANK
Route::get('/bank/get_all_banks','BankController@get_all_banks')->middleware('accesscontrol:/bank/get_all_banks');


//Finance
Route::get('/ledger','RetailerLedgersController@index')->middleware('accesscontrol:/ledger');
Route::post('/ledgerData','RetailerLedgersController@get_all_ledger')->middleware('accesscontrol:/ledgerData');
Route::post('/RetailerTotalOutstanding','RetailerLedgersController@retailer_ledger_balance')->middleware('accesscontrol:/RetailerTotalOutstanding');
Route::get('/bank','BankController@index')->middleware('accesscontrol:/bank');
Route::get('/allBanks','BankController@banks')->middleware('accesscontrol:/allBanks');
Route::post('/createBank','BankController@createBank')->middleware('accesscontrol:/createBank');
Route::get('/retailer_order/get_order/{id}','RetailerOrderController@get_all_order')->middleware('accesscontrol:/retailer_order/get_order/{id}');
Route::get('/invoice/create/{id}','RetailerInvoiceController@invoiceCreate')->middleware('accesscontrol:/invoice/create/{id}');
Route::post('/invoice/store/','RetailerInvoiceController@store')->middleware('accesscontrol:/invoice/store/');
Route::get('/invoice/list/','RetailerInvoiceController@index')->middleware('accesscontrol:/invoice/list/');
Route::get('/invoice/get_invoice/','RetailerInvoiceController@get_invoice')->middleware('accesscontrol:/invoice/get_invoice/');
Route::post('/get_invoice_by_retailer','RetailerInvoiceController@get_invoice_by_retailer')->middleware('accesscontrol:/get_invoice_by_retailer');
Route::get('/invoice/details/{id}','RetailerInvoiceController@invoice_details')->middleware('accesscontrol:/invoice/details/{id}');
Route::get('/invoice/print/{id}','RetailerInvoiceController@print_invoice')->middleware('accesscontrol:/invoice/print/{id}');
Route::get('/invoice/generate_invoice/{id}','RetailerInvoiceController@generate_invoice')->middleware('accesscontrol:/invoice/generate_invoice/{id}');
Route::get('/invoice/invoice_reverse/{id}','RetailerInvoiceController@invoice_reverse')->middleware('accesscontrol:/invoice/invoice_reverse/{id}');
Route::get('/invoice/reversal/{id}','RetailerInvoiceController@reversal')->middleware('accesscontrol:/invoice/reversal/{id}');
Route::post('/invoice/add_reversal','RetailerInvoiceController@invoice_reversal')->middleware('accesscontrol:/invoice/add_reversal');
Route::get('/order/imei/print/{id}','RetailerInvoiceController@print_invoice_imei')->middleware('accesscontrol:/order/imei/print/{id}');
Route::get('/order/imei/return/print/{id}','RetailerInvoiceController@print_invoice_imei_return');
Route::get('/order/imei/details/{id}','RetailerInvoiceController@order_imei_details')->middleware('accesscontrol:/order/imei/details/{id}');
Route::get('/order/imei/return/details/{id}','RetailerInvoiceController@order_imei_return_details');
Route::get('/get_aging_outstanding/{id}','RetailerInvoiceController@get_aging_outstanding')->middleware('accesscontrol:/get_aging_outstanding/{id}');
Route::get('/sale_find/{id}','SaleController@sale_find')->middleware('accesscontrol:/sale_find/{id}');
Route::post('/sale_return_verification','SaleController@sale_return_verification')->middleware('accesscontrol:/sale_return_verification');
Route::post('/sale_return','SaleController@sale_return')->middleware('accesscontrol:/sale_return');
Route::get('/retailer_info/{id}','RetailerLedgersController@retailer_info')->middleware('accesscontrol:/retailer_info/{id}');


//After
Route::get('/retailer/order/get_all_collection','RetailerOrderController@get_all_order_payment')->middleware('accesscontrol:/retailer/order/get_all_collection');
Route::post('/retailer/order/check_edit_order','RetailerOrderController@check_order_can_edit')->middleware('accesscontrol:/retailer/order/check_edit_order');
Route::get('/retailer/master_details/{id}','RetailerController@retailer_master_info')->middleware('accesscontrol:/retailer/master_details/{id}');
Route::get('/retailer/get_orders_by_outlet/{id}','RetailerOrderController@get_order_by_id')->middleware('accesscontrol:/retailer/get_orders_by_outlet/{id}');
Route::get('/retailer/get_all_ledger_by_outlet/{id}','RetailerLedgersController@get_all_ledger_by_outlet')->middleware('accesscontrol:/retailer/get_all_ledger_by_outlet/{id}');
Route::post('/get_collection','RetailerOrderController@get_all_collections')->middleware('accesscontrol:/get_collection');
Route::post('/retailer_order/get_orders_with_warehouse_stock','RetailerOrderController@get_all_orders_with_warehouse_stock')->middleware('accesscontrol:/retailer_order/get_orders_with_warehouse_stock');
//item Details
Route::get('/itemDetails/{imei}','ItemController@itemDetails')->middleware('accesscontrol:/itemDetails/{imei}');
Route::get('/itemDetail','ItemController@detail')->middleware('accesscontrol:/itemDetail');
//item Details

// Porduct Detils
Route::get('/productDetails/{id}','ProductController@productDetails')->middleware('accesscontrol:/productDetails/{id}');
Route::get('/productDetailsView','ProductController@productDetailView')->middleware('accesscontrol:/productDetailsView');
// Porduct Detils

//warehouseTransfer
Route::get('/warehouseTransfer/{issue_note_id}','WarehouseTransferController@index')->middleware('accesscontrol:/warehouseTransfer/{issue_note_id}');
Route::get('/currentWarehouseData/{id}','WarehouseTransferController@warehouseProductDetails')->middleware('accesscontrol:/currentWarehouseData/{id}');
Route::post('/transferReq','WarehouseTransferController@transferReq')->middleware('accesscontrol:/transferReq');
Route::get('/warehouseStockDetail','WarehouseTransferController@allStock')->middleware('accesscontrol:/warehouseStockDetail');
Route::get('/get_all_stock_type_history/{item_id}','ItemController@get_all_stock_type_history')->middleware('accesscontrol:/get_all_stock_type_history/{item_id}');
Route::get('report', function () {
    return view('report_view');
});
//warehouseTransfer


//ProductSpecs
Route::get('/our_products','ProductController@our_products')->middleware('accesscontrol:/our_products');
Route::get('/specification/{id}','ProductController@product_specification')->middleware('accesscontrol:/specification/{id}');
Route::get('/get_product_specification/{id}','ProductController@get_product_specification')->middleware('accesscontrol:/get_product_specification/{id}');
//ProductSpecs
Route::get('/stock_item_detail/','WarehouseStockController@stock_item_detail')->middleware('accesscontrol:/stock_item_detail/');
Route::get('/cons_stock_item_detail/','WarehouseStockController@cons_stock_item_detail')->middleware('accesscontrol:/cons_stock_item_detail/');
Route::get('/stock_item_history/{warehouse_id}/{product_color_id}','WarehouseStockController@stock_item_history')->middleware('accesscontrol:/stock_item_history/{warehouse_id}/{product_color_id}');
Route::post('/get_specific_warehouse_items/','WarehouseStockController@get_specific_warehouse_item')->middleware('accesscontrol:/get_specific_warehouse_items/');
Route::get('/get_specific_item_history/{warehouse_id}/{product_color_id}','WarehouseStockController@get_specific_item_history')->middleware('accesscontrol:/get_specific_item_history/{warehouse_id}/{product_color_id}');
Route::get('/get_specific_item_supply_history/{warehouse_id}/{product_color_id}','WarehouseStockController@get_specific_item_supply_history')->middleware('accesscontrol:/get_specific_item_supply_history/{warehouse_id}/{product_color_id}');
Route::get('/get_products_by_color_id/{product_color_id}','ProductController@get_products_by_color_id')->middleware('accesscontrol:/get_products_by_color_id/{product_color_id}');
Route::get('/get_warehouse_stock_by_warehouse_id/{warehouse_id}/{product_color_id}','WarehouseStockController@get_warehouse_stock_by_warehouse_id')->middleware('accesscontrol:/get_warehouse_stock_by_warehouse_id/{warehouse_id}/{product_color_id}');
Route::get('/issue_note/','WarehouseIssueController@issue_note_create')->middleware('accesscontrol:/issue_note/');
Route::post('/create_issue_note/','WarehouseIssueController@create_issue_note')->middleware('accesscontrol:/create_issue_note/');
Route::get('/display_issue_note/','WarehouseIssueController@display_issue_note')->middleware('accesscontrol:/display_issue_note/');
Route::get('/get_issue_notes/','WarehouseIssueController@get_all_issue_notes')->middleware('accesscontrol:/get_issue_notes/');
Route::get('/get_non_approved_issue_notes/{warehouse_id}','WarehouseIssueController@get_all_non_approved_issue_notes_of_warehouse')->middleware('accesscontrol:/get_non_approved_issue_notes/{warehouse_id}');

Route::get('/non_approved_issue_note/','WarehouseIssueController@non_approved_issue_page')->middleware('accesscontrol:/non_approved_issue_note/');
Route::post('/approved_issue_note/','WarehouseIssueController@approve_issue_note')->middleware('accesscontrol:/approved_issue_note/');
Route::get('/transfer_requests/','WarehouseTransferController@transfer_requests_page')->middleware('accesscontrol:/transfer_requests/');
Route::get('/get_warehouse_requests/{warehouse_id}','WarehouseIssueController@get_all_request_by_warehouse')->middleware('accesscontrol:/get_warehouse_requests/{warehouse_id}');
Route::get('/get_issue_note_details/{issue_note_id}','WarehouseTransferController@get_issue_note_details')->middleware('accesscontrol:/get_issue_note_details/{issue_note_id}');


//reports
Route::get('/report/outstanding','ReportsController@outstandingReport')->middleware('accesscontrol:/report/outstanding');

Route::post('/report/get_outstanding','ReportsController@get_outstanding')->middleware('accesscontrol:/report/get_outstanding');
Route::post('/report/get_outstanding_ledger','ReportsController@get_outstanding_ledger');
Route::post('/report/get_outstanding_invoice_wise','ReportsController@get_outstanding_invoice_wise')->middleware('accesscontrol:/report/get_outstanding_invoice_wise');

Route::get('/get_cities/{state_id}','ReportsController@get_cities')->middleware('accesscontrol:/get_cities/{state_id}');

Route::get('/get_states','ReportsController@get_states')->middleware('accesscontrol:/get_states');

Route::get('/region/{id}','ReportsController@get_region')->middleware('accesscontrol:/region/{id}');

Route::get('/get_sales_officer/{city_id}/{state_id}','ReportsController@get_sales_officer')->middleware('accesscontrol:/get_sales_officer/{city_id}/{state_id}');

Route::get('/get_customer/{id}/{column}/{state}','ReportsController@get_customer')->middleware('accesscontrol:/get_customer/{id}/{column}/{state}');
Route::post('/report/get_sales','ReportsController@get_sales')->middleware('accesscontrol:/report/get_sales');
Route::post('/report/get_sales_qty','ReportsController@get_sales_qty')->middleware('accesscontrol:/report/get_sales_qty');
Route::post('/report/get_sales_qty_product','ReportsController@get_sales_qty_product')->middleware('accesscontrol:/report/get_sales_qty_product');

Route::post('/report/collection','ReportsController@get_collection')->middleware('accesscontrol:/report/collection');
Route::post('/report/activate','ReportsController@get_activate');
Route::post('/report/get_sale_return','ReportsController@get_sale_return');
Route::post('/sale_return_details','ReportsController@sale_return_details');
Route::get('/sale_return_imeis_details','ReportsController@get_sale_return_imeis_details');
Route::post('/sale_return_imeis_details','ReportsController@sale_return_imeis_details');
Route::get('/get_all_products','ProductController@get_all_products');
Route::get('/get_all_product_colors/{id}','ProductController@get_all_product_colors');
Route::post('/report/activation_outlet','ReportsController@activation_outlet');
Route::post('/report/activation_outlet_products','ReportsController@activation_outlet_products');
Route::get('/get_main_warehouse_receive_data/{receive_id}','MainWarehouseReceiveController@get_main_warehouse_receive_by_id')->middleware('accesscontrol:/get_main_warehouse_receive_data/{receive_id}');

Route::get('/consignment_item_scanning/{receive_id}','MainWarehouseReceiveController@consignment_receive_products_page')->middleware('accesscontrol:/consignment_item_scanning/{receive_id}');

Route::post('/get_all_avaiable_imeis/','IMEIController@get_all_avaiable_imeis')->middleware('accesscontrol:/get_all_avaiable_imeis/');
Route::get("/get_ageing_amount/{outlet_id}","RetailerInvoiceController@outlet_aging")->middleware('accesscontrol:/get_ageing_amount/{outlet_id}');
Route::post('/get_warehouse_products_with_pending/','WarehouseController@get_warehouse_products_with_pending')->middleware('accesscontrol:/get_warehouse_products_with_pending/');
Route::get('/get_sales_officer_outlet_orders/{outlet_id}','RetailerOrderController@get_orders_of_sales_officers_by_outlet_id')->middleware('accesscontrol:/get_sales_officer_outlet_orders/{outlet_id}');
Route::get('/outlet/get_all_outlets_order_of_warehouse/{warehouse_id}','RetailerOutletController@get_all_outlets_order_of_warehouse')->middleware('accesscontrol:/outlet/get_all_outlets_order_of_warehouse/{warehouse_id}');
Route::get('/get_outstanding_invoices/{deposit_slip_no}/{outlet_id}/{sales_officer}','RetailerInvoiceController@get_outlet_outstanding_invoices')->middleware('accesscontrol:/get_outstanding_invoices/{deposit_slip_no}/{outlet_id}/{sales_officer}');
Route::get('/retailer_order/order_payment_reversal/{ds_id}','RetailerOrderController@order_payment_reversal')->middleware('accesscontrol:/retailer_order/order_payment_reversal/{ds_id}');
Route::get('/retailer/deposit_slips','RetailerOrderController@get_all_ds')->middleware('accesscontrol:/retailer/deposit_slips');
Route::get('/retailer/payment_slips','RetailerOrderController@order_payment_slips')->middleware('accesscontrol:/retailer/payment_slips');
Route::get('/retailer/get_ds_details/{ds_id}','RetailerOrderController@get_ds_details')->middleware('accesscontrol:/retailer/get_ds_details/{ds_id}');

Route::post('/retailer/check_bounce/','RetailerOrderController@check_bounce')->middleware('accesscontrol:/retailer/check_bounce/');

Route::get('/warehouse/change_stock_type','ChangeStockTypeController@change_stock_view')->middleware('accesscontrol:/warehouse/change_stock_type');

Route::post('/warehouse/update_stock_type','ChangeStockTypeController@change_stock_type')->middleware('accesscontrol:/warehouse/update_stock_type');

Route::get('temporary', function () {
    return "true";
});
Route::get('reports', function () {
    return view('report_view');
});

Route::get('markAsRead', function () {
    auth()->user()->unreadNotifications->markAsRead();
});

Route::get('get_all_unread_notification', function () {
   return auth()->user()->unreadNotifications;
});


Route::get('/upload_items','MainWarehouseReceiveController@product_uploading_with_imies_view');
Route::post('/upload_items_in_excel','MainWarehouseReceiveController@upload_items_in_excel');
Route::get('/receive_stock', 'MainWarehouseReceiveController@receive_stock_view');
Route::post('/submit_consignment_imeis', 'MainWarehouseReceiveController@submit_consignment_imeis');



Route::get('/make_number/{number}','RetailerController@make_number');
//web orders
Route::get('/onlineorders','OnlineOrderController@orders');
Route::get('/order_list','OnlineOrderController@order_list');
Route::get('/order_details/{id}','OnlineOrderController@order_details');
Route::post('/status_update', 'OnlineOrderController@status_update');

Route::get('/get_outlet_details/{id}', 'RetailerController@get_outlet_details');

});



