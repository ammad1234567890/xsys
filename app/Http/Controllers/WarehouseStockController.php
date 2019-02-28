<?php

namespace App\Http\Controllers;

use App\WarehouseStock;
use App\WarehouseStockItem;
use App\WarehouseStockTypeDetails;
use Illuminate\Http\Request;
use Auth;
use App\warehouseStaff;
use App\MainWarehouseReceiveItem;
use DB;

class WarehouseStockController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
    	return view('warehouseStock');
    }

    public function allStock()
    {
    	$warehouseStock=WarehouseStock::with('warehouse','productColor.product')->get();
    	return $warehouseStock;
    }

    public function warehouseStockSearch($id)
    {
		DB::getPdo()->setAttribute(\PDO::ATTR_EMULATE_PREPARES,true);
        $searchStock=WarehouseStock::where('warehouse_id',$id)->with(
            'warehouse',
            'productColor.product','warehouse_stock_details')->get();
        return $searchStock;
    }

    public function searchStockDetails($id)
    {
        //$searchStock=WarehouseStockItem::all();
        // $searchStock=WarehouseStockItem::where('warehouse_id',5)->get();
		
        $searchStock=WarehouseStockItem::where('warehouse_id',$id)->with('warehouse','item.productColor.product','item.imei')->get();
        return $searchStock;
        //return $id;
    }

    public function stock_item_detail(){
        return View('stock_item_detail');
    }

    public function cons_stock_item_detail(){
        return View('consolidatedWarehouseStock');
    }

    public function stock_item_history(){
        return View('stockItemHistory');
    }
    public function get_specific_warehouse_item(Request $request)
    {
     /*   $warehouse_id=$request->input('warehouse_id');
        $product_id= $request->input('product_id');
        $product_color_id= $request->input('product_color_id');
        return DB::select("
              Select * from 
              tbl_main_warehouse_receive_item warehouse_item 
              inner join tbl_imei imei 
              on imei . item_id = warehouse_item . item_id 
              inner join tbl_item items
              on items.id=warehouse_item.item_id
              where 
              warehouse_item . warehouse_id = '$warehouse_id' 
              AND imei . product_id = '$product_id' AND 
              items.product_color_id='$product_color_id' 
              AND warehouse_item.is_sold=0"); */
		
		$warehouse_id=$request->input('warehouse_id');
        $product_id= $request->input('product_id');
        $product_color_id= $request->input('product_color_id');
        return DB::select("
              Select imei.imei1, imei.imei2, imei.item_id from 
              tbl_main_warehouse_receive_item warehouse_item 
              inner join tbl_imei imei 
              on imei . item_id = warehouse_item . item_id 
              inner join tbl_item items
              on items.id=warehouse_item.item_id
              where 
              warehouse_item . warehouse_id = '$warehouse_id' 
              AND imei . product_id = '$product_id' AND 
              items.product_color_id='$product_color_id' 
              AND warehouse_item.is_sold=0 AND warehouse_item.current_stock_status=1");
    }


    public function get_specific_item_history($warehouse_id, $product_color_id){
        return DB::select("(Select IF(transfer.transfer_qty > 0, 'Issued', '') as status_for, 
        transfer.created_at, 
        transfer.id as transfer_id, 
        transfer.transfer_qty as Transfer_qty, 
        transfer_warehouse.name as transfer_warehouse_name, 
        transfer.product_unit_price as unit_price, 
        issue_note.win_no as resource,
        transfer.created_at as transfer_date 
      from tbl_warehouse_stock warehouse_stock 
      left join tbl__warehouse__transfer transfer on transfer.previous_warehouse_id=warehouse_stock.warehouse_id 
      inner join tbl_warehouse transfer_warehouse on transfer_warehouse.id=transfer.new_warehouse_id 
      inner join warehouse_issue_note issue_note on issue_note.id=transfer.resource_id
      where warehouse_stock.warehouse_id='$warehouse_id' 
      AND warehouse_stock.product_color_id='$product_color_id' 
      AND transfer.product_color_id='$product_color_id' order by transfer.id DESC)
      
      UNION

(Select IF(transfer.transfer_qty > 0, 'Received', '') as status_for, 
transfer.created_at, 
transfer.id as transfer_id,
transfer.transfer_qty as Transfer_qty, 
transfer_warehouse.name as transfer_warehouse_name, 
transfer.product_unit_price as unit_price, 
issue_note.win_no as resource,
transfer.created_at as transfer_date 
from tbl_warehouse_stock warehouse_stock 
left join tbl__warehouse__transfer transfer on transfer.new_warehouse_id=warehouse_stock.warehouse_id 
inner join tbl_warehouse transfer_warehouse on transfer_warehouse.id=transfer.previous_warehouse_id 
inner join warehouse_issue_note issue_note on issue_note.id=transfer.resource_id
where warehouse_stock.warehouse_id='$warehouse_id' AND warehouse_stock.product_color_id='$product_color_id' AND transfer.product_color_id='$product_color_id' 
order by transfer.id DESC)

UNION

(Select IF(receive_products.product_qty > 0, 'Received', '') as status_for,
main_receive.created_at,
main_receive.id as transfer_id,
receive_products.product_qty as Transfer_qty,
IF(receive_products.product_qty > 0, 'Port', '') as transfer_warehouse_name, 
manu_order_prod.unit_cost as unit_price,
receive.receive_no as resource,
main_receive.created_at as transfer_date  
from tbl_main_warehouse_receive main_receive
inner join tbl_main_warehouse_receive_product receive_products on receive_products.main_receive_id=main_receive.id
inner join tbl_receive receive on receive.id=main_receive.receive_id
inner join tbl_manufacturing_order_product manu_order_prod on manu_order_prod.manufacture_order_id=receive.manufacturing_order_id
where main_receive.warehouse_id='$warehouse_id' AND receive_products.product_color_id='$product_color_id' AND manu_order_prod.product_color_id='$product_color_id')

UNION

(SELECT IF(products.product_qty > 0, 'Issued', '') as status_for, 
orders.created_at,
orders.id as transfer_id,
products.product_qty, 
outlet.name as transfer_warehouse_name,

products.unit_price as unit_price, 
invoice.invoice_no as resource,
orders.created_at as transfer_date

FROM `tbl_retailer_order` orders
 inner join tbl_retailer_order_products products on products.retailer_order_id=orders.id
 inner join tbl_retailer_outlet outlet on outlet.id=orders.outlet_id
 inner join tbl_invoice invoice on invoice.order_id=orders.id
 where orders.warehouse_id='$warehouse_id' AND products.product_color_id='$product_color_id' order by orders.created_at DESC)
");

    }

    public function get_specific_item_supply_history($warehouse_id, $product_color_id){
        return DB::select("SELECT products.unit_price, products.product_qty, orders.created_at, outlet.name as outlet_name FROM `tbl_retailer_order` orders
              inner join tbl_retailer_order_products products on products.retailer_order_id=orders.id
              inner join tbl_retailer_outlet outlet on outlet.id=orders.outlet_id
              where orders.warehouse_id='$warehouse_id' AND products.product_color_id='$product_color_id' order by orders.created_at DESC");
    }


    public function get_warehouse_stock_by_warehouse_id($warehouse_id, $product_color_id){
        return WarehouseStock::with('warehouse')->where('warehouse_id', $warehouse_id)->where('product_color_id', $product_color_id)->get();
    }
	
	/*public function get_warehouse_instock_items(Request $request){
        $userId=Auth::user()->staff_id;
        $warehouse_details=warehouseStaff::with('warehouse')->where('staff_id',$userId)->get();
        $warehouse_id= $warehouse_details[0]['warehouse']['id'];


        if ( $request->input('client') ) {
            return MainWarehouseReceiveItem::where('warehouse_id',$warehouse_id)->where('is_sold', 0)->with('item.productColor.product','item.imei')->get();
        }
        $columns = ['warehouse_id', 'current_stock_status', 'item_id'];
        $length = $request->input('length');
        $column = $request->input('column'); //Index
        $dir = $request->input('dir');
        $searchValue = $request->input('search');


        $query = MainWarehouseReceiveItem::where('warehouse_id',$warehouse_id)->where('is_sold', 0)->with('item.productColor.product','item.imei')->orderBy($columns[$column], $dir);
        if ($searchValue) {
            $query->where(function($query) use ($searchValue) {
                $query->orWhereHas('item.imei', function ( $q ) use ($searchValue) {
                        $q->Where('imei1', 'like', '%' . $searchValue . '%');
                    })
                    ->orWhereHas('item.imei', function ( $q ) use ($searchValue) {
                        $q->Where('imei2', 'like', '%' . $searchValue . '%');
                    })->orWhereHas('item.productColor.product', function ( $q ) use ($searchValue) {
                        $q->Where('name', 'like', '%' . $searchValue . '%');
                    })->orWhereHas('item.productColor', function ( $q ) use ($searchValue) {
                        $q->Where('color', 'like', '%' . $searchValue . '%');
                    });

            });
        }
        $projects = $query->paginate($length);
        return ['data' => $projects, 'draw' => $request->input('draw')];
    }*/
	
	public function get_warehouse_instock_items(Request $request){
        $userId=Auth::user()->staff_id;
        $warehouse_details=warehouseStaff::with('warehouse')->where('staff_id',$userId)->get();
        $warehouse_id= $warehouse_details[0]['warehouse']['id'];





        if ( $request->input('client') ) {
            return MainWarehouseReceiveItem::where('warehouse_id',$warehouse_id)->where('is_sold', 0)->with('item.productColor.product','item.imei')->get();
        }
        $columns = ['warehouse_id', 'current_stock_status', 'item_id'];
        $length = $request->input('length');
        $column = $request->input('column'); //Index
        $dir = $request->input('dir');
        $searchValue = $request->input('search');
        $selected_product= $request->input('selected_product');
        $selected_product_color= $request->input('selected_product_color');
        $stock_type= $request->input('stock_type');
        $excel_export= $request->input('excel_export');
        $excel_type= $request->input('excel_type');
        $file_name= $request->input('file_name');


        $query = MainWarehouseReceiveItem::where('warehouse_id',$warehouse_id)->where('is_sold', 0)->with('item.productColor.product','item.imei')->orderBy($columns[$column], $dir);
       if($selected_product!=""){
           $query->where(function($query) use ($selected_product) {
               $query->WhereHas('item.productColor.product', function ( $q ) use ($selected_product) {
                       $q->Where('id',$selected_product);
                   });
           });
       }
       if($selected_product_color!=""){
           $query->where(function($query) use ($selected_product_color) {
               $query->WhereHas('item.productColor', function ( $q ) use ($selected_product_color) {
                   $q->Where('id',$selected_product_color);
               });
           });
       }
       if($stock_type!=""){
            $query->where("current_stock_status",$stock_type);
       }

        if ($searchValue) {
            $query->where(function($query) use ($searchValue) {
                $query->orWhereHas('item.imei', function ( $q ) use ($searchValue) {
                        $q->Where('imei1', 'like', '%' . $searchValue . '%');
                    })
                    ->orWhereHas('item.imei', function ( $q ) use ($searchValue) {
                        $q->Where('imei2', 'like', '%' . $searchValue . '%');
                    })->orWhereHas('item.productColor.product', function ( $q ) use ($searchValue) {
                        $q->Where('name', 'like', '%' . $searchValue . '%');
                    })->orWhereHas('item.productColor', function ( $q ) use ($searchValue) {
                        $q->Where('color', 'like', '%' . $searchValue . '%');
                    });

            });
        }
        $projects = $query->paginate($length);

        if($excel_export==1){
            if($excel_type==1){
                $total_rows=$query->count();
                $projects = $query->paginate($total_rows);
            }

            $data= $query->get();

            $data_final=array();




            for($i=0; $i<count($data); $i++){
                $data_two=$this->object_to_array($data[$i]["item"]);
                $type="";
                if($data[$i]["current_stock_status"]==1){
                    $type="Major";
                }
                else if($data[$i]["current_stock_status"]==2){
                    $type="Mini";
                }
                else if($data[$i]["current_stock_status"]==3){
                    $type="Damage";
                }
                else if($data[$i]["current_stock_status"]==4){
                    $type="Travelling";
                }
                $data_final[]=[
                    "SKU"=>$data_two["product_color"]["sku"],
                    "Model"=>$data_two["product_color"]["product"]["name"],
                    "Color"=>$data_two["product_color"]["color"],
                    "Type"=>$type,
                    "IMEI1"=>$data_two["imei"][0]["imei1"],
                    "IMEI2"=>$data_two["imei"][0]["imei2"],
                ];
            }
            if($file_name==""){
                $file_name="InStockRecords";
            }
			ini_set('memory_limit', '-1');
            $this->export_excel($file_name,$data_final);

        }

        return ['data' => $projects, 'draw' => $request->input('draw')];
    }
    public function object_to_array($data) {
        return collect($data)->map(function($x) {
            return (array) $x;
        })->toArray();
    }
    public function export_excel($name, $data){
		
        return \Excel::create($name, function($excel) use ($name, $data) {


            $excel->sheet($name, function($sheet) use ($data)
            {
				/* $export_rows = array_chunk($data,1000);
				 foreach ($export_rows as $tmp){
						$sheet->rows($tmp);
				  } */
                $sheet->fromArray($data);
            });

        })->download("xlsx");

    }


   /*public function get_warehouse_sold_items(Request $request){
        $userId=Auth::user()->staff_id;
        $warehouse_details=warehouseStaff::with('warehouse')->where('staff_id',$userId)->get();
        $warehouse_id= $warehouse_details[0]['warehouse']['id'];


        if ( $request->input('client') ) {
            return MainWarehouseReceiveItem::where('warehouse_id',$warehouse_id)->where('is_sold', 1)->with('outlet','item.productColor.product','item.imei')->get();
        }
        $columns = ['warehouse_id', 'current_stock_status', 'item_id'];
        $length = $request->input('length');
        $column = $request->input('column'); //Index
        $dir = $request->input('dir');
        $searchValue = $request->input('search');


        $query = MainWarehouseReceiveItem::where('warehouse_id',$warehouse_id)->where('is_sold', 1)->with('outlet','item.productColor.product','item.imei')->orderBy($columns[$column], $dir);
        if ($searchValue) {
            $query->where(function($query) use ($searchValue) {
                $query->orWhereHas('item.imei', function ( $q ) use ($searchValue) {
                    $q->Where('imei1', 'like', '%' . $searchValue . '%');
                })
                    ->orWhereHas('item.imei', function ( $q ) use ($searchValue) {
                        $q->Where('imei2', 'like', '%' . $searchValue . '%');
                    })->orWhereHas('item.productColor.product', function ( $q ) use ($searchValue) {
                        $q->Where('name', 'like', '%' . $searchValue . '%');
                    })->orWhereHas('item.productColor', function ( $q ) use ($searchValue) {
                        $q->Where('color', 'like', '%' . $searchValue . '%');
                    })->orWhereHas('outlet', function ( $q ) use ($searchValue) {
                        $q->Where('name', 'like', '%' . $searchValue . '%');
                    });

            });
        }
        $projects = $query->paginate($length);
        return ['data' => $projects, 'draw' => $request->input('draw')];
    }*/
	
	 public function get_warehouse_sold_items(Request $request){
        $userId=Auth::user()->staff_id;
        $warehouse_details=warehouseStaff::with('warehouse')->where('staff_id',$userId)->get();
        $warehouse_id= $warehouse_details[0]['warehouse']['id'];


        if ( $request->input('client') ) {
            return MainWarehouseReceiveItem::where('warehouse_id',$warehouse_id)->where('is_sold', 1)->with('outlet','outlet.city','item.productColor.product','item.imei')->get();
        }
        $columns = ['warehouse_id', 'current_stock_status', 'item_id'];
        $length = $request->input('length');
        $column = $request->input('column'); //Index
        $dir = $request->input('dir');
        $searchValue = $request->input('search');

       $selected_state=$request->input('selected_state');
       $selected_city=$request->input('selected_city');
       $selected_filter_type= $request->input('selected_filter_type');
       $selected_sales_officer= $request->input('selected_sales_officer');
       $selected_outlet= $request->input('selected_outlet');
       $selected_product= $request->input('selected_product');
       $selected_product_color= $request->input('selected_product_color');
       $activate_status= $request->input('activate_status');


       $excel_export=$request->input("excel_export");
       $excel_type=$request->input("excel_type");
       $file_name=$request->input("excel_filename");


        $query = MainWarehouseReceiveItem::where('warehouse_id',$warehouse_id)->where('is_sold', 1)->with('outlet','outlet.city','item.productColor.product','item.imei')->orderBy($columns[$column], $dir);
       if($selected_state!=""){
           $query->where(function($query) use ($selected_state) {
               $query->orWhereHas('outlet.city', function ( $q ) use ($selected_state) {
                   $q->Where('state_id', $selected_state);
               });
           });
       }
       if($selected_city!=""){
           $query->where(function($query) use ($selected_city) {
               $query->orWhereHas('outlet.city', function ( $q ) use ($selected_city) {
                   $q->Where('id', $selected_city);
               });
           });
       }
       if($selected_filter_type==1){
           $query->where(function($query) use ($selected_sales_officer) {
               $query->orWhereHas('outlet.sales_officer', function ( $q ) use ($selected_sales_officer) {
                   $q->Where('id', $selected_sales_officer);
               });
           });
       }
       else if($selected_filter_type==2){
           if($selected_outlet!=""){
               $query->where("sold_to_outlet_id", $selected_outlet);
           }
       }
       else if($selected_filter_type==3){
           if($selected_product!="" && $selected_product_color!=""){
               $query->where(function($query) use ($selected_product_color) {
                   $query->orWhereHas('item.productColor', function ( $q ) use ($selected_product_color) {
                       $q->Where('id', $selected_product_color);
                   });
               });
           }
           else if($selected_product_color=="" && $selected_product!=""){
               $query->where(function($query) use ($selected_product) {
                   $query->orWhereHas('item.productColor.product', function ( $q ) use ($selected_product) {
                       $q->Where('id', $selected_product);
                   });
               });
           }
       }
       if($activate_status==1){
           $query->where("item_is_activate", 1);
       }
       else if($activate_status==2){
           $query->where("item_is_activate", 0);
       }


        if ($searchValue) {
            $query->where(function($query) use ($searchValue) {
                $query->orWhereHas('item.imei', function ( $q ) use ($searchValue) {
                    $q->Where('imei1', 'like', '%' . $searchValue . '%');
                })
                    ->orWhereHas('item.imei', function ( $q ) use ($searchValue) {
                        $q->Where('imei2', 'like', '%' . $searchValue . '%');
                    })->orWhereHas('item.productColor.product', function ( $q ) use ($searchValue) {
                        $q->Where('name', 'like', '%' . $searchValue . '%');
                    })->orWhereHas('item.productColor', function ( $q ) use ($searchValue) {
                        $q->Where('color', 'like', '%' . $searchValue . '%');
                    })->orWhereHas('outlet', function ( $q ) use ($searchValue) {
                        $q->Where('name', 'like', '%' . $searchValue . '%');
                    });

            });
        }
        $projects = $query->paginate($length);

       if($excel_export==1){
           if($excel_type==1){
               $total_rows=$query->count();
               $projects = $query->paginate($total_rows);
           }

           $data= $query->get();

           $data_final=array();




           for($i=0; $i<count($data); $i++){
               $data_two=$this->object_to_array($data[$i]["item"]);
               $data_outlet=$this->object_to_array($data[$i]["outlet"]);
               $activate_status="Not Activated";

               if($data[$i]["item_is_activate"]==1){
                   $activate_status="Activated";
               }
               $data_final[]=[
                   "SKU"=>$data_two["product_color"]["sku"],
                   "Model"=>$data_two["product_color"]["product"]["name"],
                   "Color"=>$data_two["product_color"]["color"],
                   "City"=>$data_outlet["city"]["name"],
                   "Outlet"=>$data_outlet["name"][0],
                   "Address"=>$data_outlet["address"][0],
                   "IMEI1"=>$data_two["imei"][0]["imei1"],
                   "IMEI2"=>$data_two["imei"][0]["imei2"],
                   "Activation Status"=>$activate_status,
               ];
           }
           if($file_name==""){
               $file_name="SoldStockRecords";
           }
           $this->export_excel($file_name,$data_final);

       }
        return ['data' => $projects, 'draw' => $request->input('draw')];
    }
}
