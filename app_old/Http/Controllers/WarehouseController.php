<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Warehouse;
use App\WarehouseStaff;
use Auth;
use Response;
use DB;
class WarehouseController extends Controller
{

  public function __construct()
    {
        $this->middleware('auth');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('warehouse');
    }

    public function allWarehouses()
    {
      return Warehouse::where('is_deleted',0)->with('warehouseType')->with('city')->with('region')->with('manager')->with('accountant')->get();
    }
	public function allWarehouses_details() {
        return Warehouse::where('is_deleted', 0)->select('id', 'name')->get();
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       $name=$request->input('name');
       $typeId=$request->input('warehouse_type_id');
       $city=$request->input('city');
       $region=$request->input('region');
       $lat=$request->input('latitude');
       $log=$request->input('longitude');
       $address=$request->input('address');
       $warehouseManager=$request->input('warehouse_manager');
       $warehouseAccountant=$request->input('warehouse_accountant');
       $userId=Auth::user()->id;
      try{
        $createdWarehouse=Warehouse::create(['name'=>$name,'warehouse_type_id'=>$typeId,'city_id'=>$city['id'],'region_id'=>$region['id'],'latitude'=>$lat,'longitude'=>$log,'address'=>$address,'warehouse_manager'=>$warehouseManager['id'],'warehouse_accountant'=>$warehouseAccountant['id'],'created_by'=>$userId]);
      }
      catch(\Exception $e){
        $return=array('replay'=>1,'data'=>$e);
        return $return;
      }
      $allWarehouses=Warehouse::where('id',$createdWarehouse->id)->where('is_deleted',0)->with('warehouseType')->with('city')->with('region')->with('manager')->with('accountant')->first();
      $return=array('replay'=>0,'data'=>$allWarehouses);
      return $return;
    }

    public function create()
    {
      return view('createWarehouse');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $id=$request->input('id');
        $name=$request->input('name');
        $typeId=$request->input('warehouse_type_id');
        $city=$request->input('city');
        $region=$request->input('region');
        $lat=$request->input('latitude');
        $log=$request->input('longitude');
        $address=$request->input('address');
        $warehouseManager=$request->input('warehouse_manager');
        $warehouseAccountant=$request->input('warehouse_accountant');
        $userId=Auth::user()->id;
       try{
         $updatedWarehouse=Warehouse::where('id',$id)->update(['name'=>$name,'warehouse_type_id'=>$typeId,'city_id'=>$city['id'],'region_id'=>$region['id'],'latitude'=>$lat,'longitude'=>$log,'address'=>$address,'warehouse_manager'=>$warehouseManager['id'],'warehouse_accountant'=>$warehouseAccountant['id'],'created_by'=>$userId]);
       }
       catch(\Exception $e){
         $return=array('replay'=>1,'data'=>$e);
         return $return;
       }
       $allWarehouses=Warehouse::where('id',$id)->with('warehouseType')->with('city')->with('region')->with('manager')->with('accountant')->first();
       $return=array('replay'=>0,'data'=>$allWarehouses);
       return $return;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{
          Warehouse::where('id',$id)->update(['is_deleted'=>1]);
        }catch(\Exception $e){
          return 1;
        }
        return 0;
    }


    //Route /warehouse_by_manager
    public function get_warehouse_by_manager(){
        $userId=Auth::user()->staff_id;

        $allWarehouses=warehouseStaff::with('warehouse')->where('staff_id',$userId)->get();

        return Response::json($allWarehouses);
    }

    //Route /warehouse_salesofficer
    public function warehouse_salesofficer(Request $request){
        $warehouse_id= $request->input('warehouse_id');

        $allWarehouses=warehouseStaff::with(['staff'=>function($q){ $q->where('staff_type_id',5); }])->where('warehouse_id',$warehouse_id)->get();

        return Response::json($allWarehouses);
    }

    //Route /warehouse_products
    public function warehouse_products(Request $request)
    {
        $warehouse_id= $request->input('warehouse_id');
        $records=warehouse::with('warehouseStock','warehouseStock.productColor','warehouseStock.productColor.product')->where('id',$warehouse_id)->get();

        /*$query="Select order_prod.product_qty from tbl_warehouse_stock stock inner join tbl_retailer_order r_order on r_order.warehouse_id=stock.warehouse_id inner join tbl_retailer_order_products order_prod on order_prod.retailer_order_id=r_order.id where stock.product_color_id=order_prod.product_color_id AND r_order.is_delivered=0 AND stock.warehouse_id='"$warehouse_id"'";

        DB::select($query);*/
        return Response::json($records);
    }


    public function get_warehouse_products_with_pending(Request $request){
      $warehouse_id= $request->input('warehouse_id');
        $records=warehouse::with('warehouseStock','warehouseStock.warehouse_stock_details','warehouseStock.productColor','warehouseStock.productColor.product')->where('id',$warehouse_id)->get()->toArray();

        //$query="Select stock.product_color_id, SUM(order_prod.product_qty) as pending_qty from tbl_warehouse_stock stock inner join tbl_retailer_order r_order on r_order.warehouse_id=stock.warehouse_id inner join tbl_retailer_order_products order_prod on order_prod.retailer_order_id=r_order.id where stock.product_color_id=order_prod.product_color_id AND r_order.is_delivered=0 AND stock.warehouse_id='".$warehouse_id."' AND r_order.is_deleted=0 group by stock.product_color_id order by stock.product_color_id ASC";


        
       // $pending_Record=DB::select($query);

        $pending_Record=[];

        $final_Record=array_merge($records, $pending_Record);
        return Response::json($final_Record);
    }

    function array_push_assoc($array, $key, $value){
      $array[$key] = $value;
      return $array;
    }

    public function warehouse_by_city(Request $request)
    {
        $city_id= $request->input('city_id');
        $records=warehouse::where('city_id',$city_id)->get();
        return Response::json($records);
    }


}
