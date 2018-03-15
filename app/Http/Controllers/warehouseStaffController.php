<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Staff;
use App\WarehouseStaff;
use DB;
class WarehouseStaffController extends Controller
{
    public function index()
    {
      return view('WarehouseStaff');
    }
    public function search($colum,$search)
    {
      $searchedStaff=Staff::where($colum,'Like','%'.$search.'%')->get();
      return $searchedStaff;
    }

    public function store(Request $request)
    {
      $staff=$request->input('staff');
      $warehouse=$request->input('warehouse');
      $userId=Auth::user()->id;
      try{
        DB::beginTransaction();
        if(WarehouseStaff::where('staff_id',$staff['id'])->exists()){
          warehouseStaff::where('staff_id',$staff['id'])->update(['warehouse_id'=>$warehouse['id'],'updated_by'=>$userId]);
          //return 2;
        }else{
          $createdWarehouseStaff=warehouseStaff::create(['warehouse_id'=>$warehouse['id'],'staff_id'=>$staff['id'],'created_by'=>$userId]);
          //return 3;
        }
      }catch(\Exception $e){
        DB::rollBack();
        return 1;

      }
      DB::commit();
      return 0;
    }

    public function searchStaff($id)
    {
      $warehouseStaff=warehouseStaff::where('warehouse_id',$id)->where('is_deleted',0)->with(['staff.city','staff.region','staff.designation','staff.staffType','staff.department'])->get();
      return $warehouseStaff;
    }

    public function remove($id)
    {
      try{
        warehouseStaff::where('id',$id)->update(['is_deleted'=>1]);
      }catch(\Exception $e){
        return 1;
      }
      return 0;
    }
}
