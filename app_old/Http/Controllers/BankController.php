<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use DB;
use App\Retailer;
use App\City;
use App\Bank;
use Response;

class BankController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    
    public function index()
    {
        return view("bank");
    }


    public function banks()
    {
       // return Bank::all();
        return  DB::table('tbl_bank')
            ->leftJoin('tbl_city', 'tbl_bank.city_id', '=', 'tbl_city.id')
            ->get();
    }

    public function createBank(Request $request)
    {

        $bank_name=$request->input('bank_name');
        $bank_city_id=$request->input('city_id');
        $bank_phone_no=$request->input('bank_phone_no');
        try{
            $createdBank=Bank::create([ 'bank_name'=>$bank_name,
                                        'city_id'=>$bank_city_id,
                                        'bank_uan'=>$bank_phone_no
            ]);

        }catch(\Exception $e){
            $return=array('return'=>1,'data'=>$e);
            return $return;
        }
        $return=array('return'=>0,'data'=>$createdBank);
        return $return;
    }


    public function editBank(Request $request)
    {
        $id=$request->input('id');
        $bank_name=$request->input('bank_name');
        //$bank_city_id=$request->input('bank_city_id');
        $bank_phone_no=$request->input('bank_phone_no');
        $bank_city_id = 1;
        try{
            Bank::where('id',$id)->update([ 'bank_name'=>$bank_name,
                'city_id'=>$bank_city_id,
                'bank_phone_no'=>$bank_phone_no
            ]);
        }catch(\Exception $e){
            $return=array('return'=>1,'data'=>$e);
            return $return;
        }
        $return=array('return'=>0);
        return $return;
    }

    //          /bank/get_all_banks
    public function get_all_banks(){
        $record=Bank::get();
        return Response::json($record);
    }


}
