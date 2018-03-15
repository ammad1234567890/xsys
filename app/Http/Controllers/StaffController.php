<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Staff;
use App\StaffType;

class StaffController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('staff');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
        $email=$request->input('email');
        $cnic=$request->input('CNIC');
        $address=$request->input('address');
        $phoneNumber=$request->input('phoneNumber');
        $city=$request->input('city');
        $region=$request->input('region');
        $departmentId=$request->input('department_id');
        $staffTypeId=$request->input('staff_type_id');
        $designationId=$request->input('designation_id');
        $userId=Auth::User()->id;
        //return array(['name'=>$name,'email'=>$email,'CNIC'=>$cnic,'address'=>$address,'city_id'=>$cityId,'region_id'=>$regionId,'staff_type_id'=>$staffTypeId,'designation_id'=>$designationId,'department_id'=>$departmentId,'created_by'=>$userId]);
        try{
        $createdStaff=Staff::create(['name'=>$name,'email'=>$email,'CNIC'=>$cnic,'address'=>$address,'phoneNumber'=>$phoneNumber,'city_id'=>$city['id'],'region_id'=>$region['id'],'staff_type_id'=>$staffTypeId,'designation_id'=>$designationId,'department_id'=>$departmentId,'created_by'=>$userId]);
        }
        catch(\Exception $e){
          $return=array('replay'=>1,'data'=>$e);
          return $return;
        }
        $staff=Staff::where('id',$createdStaff->id)->with('city')->with('region')->with('department')->with('staffType')->with('designation')->with('user')->where('is_deleted',0)->first();
        $return=array('replay'=>0,'data'=>$staff);
        return $return;

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showAll()
    {
        $staff=Staff::with('city')->with('region')->with('department')->with('staffType')->with('designation')->with('user')->where('is_deleted',0)->get();
        return $staff;
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
      $email=$request->input('email');
      $cnic=$request->input('CNIC');
      $address=$request->input('address');
      $phoneNumber=$request->input('phoneNumber');
      $city=$request->input('city');
      $region=$request->input('region');
      $departmentId=$request->input('department_id');
      $staffTypeId=$request->input('staff_type_id');
      $designationId=$request->input('designation_id');
      $userId=Auth::User()->id;
      try{
        $updatedStaff=Staff::where('id',$id)->update(['name'=>$name,'email'=>$email,'CNIC'=>$cnic,'address'=>$address,'phoneNumber'=>$phoneNumber,'city_id'=>$city['id'],'region_id'=>$region['id'],'staff_type_id'=>$staffTypeId,'designation_id'=>$designationId,'department_id'=>$departmentId,'created_by'=>$userId]);
      }
      catch(\Exception $e){
        $return=array('replay'=>1,'data'=>$e);
        return $return;
      }
      $staff=Staff::where('id',$id)->with('city')->with('region')->with('department')->with('staffType')->with('designation')->with('user')->where('is_deleted',0)->first();
      $return=array('replay'=>0,'data'=>$staff);
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
          Staff::where('id',$id)->update(['is_deleted'=>1]);
        }catch(\Exception $e){
          $return=array('replay'=>1,'data',$e);
          return $return;
        }
        $return=array('replay'=>0);
        return $return;
    }

    public function manager()
    {
      $type=StaffType::where('type','Manageing')->first();
      $manager=Staff::where('staff_type_id',$type->id)->with('city')->with('region')->with('department')->with('staffType')->with('designation')->with('user')->where('is_deleted',0)->get();
      return $manager;
    }

    public function accountant()
    {
      $type=StaffType::where('type','Accounts')->first();
      $accoutnant=Staff::where('staff_type_id',$type->id)->with('city')->with('region')->with('department')->with('staffType')->with('designation')->with('user')->where('is_deleted',0)->get();
      return $accoutnant;
    }

}
