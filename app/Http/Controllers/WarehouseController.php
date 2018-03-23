<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Warehouse;
use App\WarehouseStaff;
use Auth;
use Response;
class WarehouseController extends Controller
{
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
        return Response::json($records);
    }

}
