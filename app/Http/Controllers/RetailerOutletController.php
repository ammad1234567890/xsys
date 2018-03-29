<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use DB;
use App\Retailer;
use App\City;
use App\Region;
use App\RetailerOutlet;
use Response;



class RetailerOutletController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */


    //Registered a route with the name of '/retailer/outlets'
    public function index()
    {
        return view('retailer_outlets');
    }

    public function make_number($order_id){
        $order_zeros='';
        for($i=0; $i<=strlen($order_id); $i++){
            $order_zeros.=0;
        }
        $current_month=date('m');
        $current_year=date('y');
        $number=$current_month.$current_year.$order_zeros.$order_id;
        return $number;
    }

    //Registered a route with the name of '/add_city'
    public function add_city(Request $request){
        $name= $request->input('name');
        try{
            DB::beginTransaction();
            City::create(array('name'=>$name));
            DB::commit();
            //Use 201 for succesfull work.
            return 201;
        }
        catch(\Exception $exc){
            DB::rollBack();
            return $exc;
        }
    }

    //Registered a route with the name of '/add_region'
    public function add_region(Request $request){
        $name= $request->input('name');
        try{
            DB::beginTransaction();
            Region::create(array('name'=>$name));
            DB::commit();
            //Use 201 for succesfull work.
            return 201;
        }
        catch(\Exception $exc){
            DB::rollBack();
            return $exc;
        }
    }

    public function get_cities(){
        $records=City::get();

        return Response::json($records);
    }

    public function get_regions(){
        $records=Region::get();

        return Response::json($records);
    }

    //Registered a route with the name of /retailer/create_outlet
    public function add_outlet(Request $request){
        //GET THE IMAGE
        $exploded= explode(',', $request->input('copy_image'));

        $decoded= base64_decode($exploded[1]);

        if(str_contains($exploded[0],'jpeg')){
            $extension="jpg";
        }
        else{
            $extension="png";
        }
        //SAVE IT TO retailer_images FOLDER
        $file_name=str_random().'.'.$extension;
        $path=public_path().'/deposit_check_img/'.$file_name;
        file_put_contents($path, $decoded);


        //GET THE RETAILER IMAGE
        $exploded= explode(',', $request->input('uploadImage'));

        $decoded= base64_decode($exploded[1]);

        if(str_contains($exploded[0],'jpeg')){
            $extension="jpg";
        }
        else{
            $extension="png";
        }

        //SAVE IT TO retailer_images FOLDER
        $retailer_file_name=str_random().'.'.$extension;
        $path=public_path().'/retailers_img/'.$retailer_file_name;
        file_put_contents($path, $decoded);

        

        

        //GET ALL OTHER FIELDS
        $fullname= $request->input('fullname');
        $cnic= $request->input('cnic');
        $phone_no= $request->input('phone_no');


        $city_id= $request->input('city_id');
        $region_id= $request->input('region_id');
        $outlet_name= $request->input('outlet_name');
        $outlet_phone= $request->input('outlet_phone');
        $bussiness_person_name= $request->input('bussiness_person_name');
        $bussiness_person_cnic= $request->input('bussiness_person_cnic');
        $bussiness_person_phone= $request->input('bussiness_person_phone');
        $address=$request->input('address');
        $longitude=$request->input('longitude');
        $latitude=$request->input('latitude');
        $security_check_amount=$request->input('security_check_amount');
        $credit_limit=$request->input('credit_limit');
        $credit_duration=$request->input('credit_duration');

        //Getting the logged in user id
        $user=Auth::user()->id;

        //query of getting users with the given phone number or cnic.
        $check_exist=Retailer::where('phone_no','=',$phone_no)->orWhere('cnic',$cnic)->count();

        //Check if the user is already exist or not.
        if($check_exist>0){

            //Use for any type of conflict.
            return 406;
        }
        else{
            //If not exist, consider it as a new retailer also push the details on database.
            try{
                DB::beginTransaction();
                $retailer = Retailer::create(array('name' => $fullname,
                    'cnic' => $cnic,
                    'phone_no'=>$phone_no,
                    'image'=>$retailer_file_name,
                    'created_by'=>$user));
                DB::commit();

                $retailer_id=$retailer->id;
                $retailer_number='DC'.$this->make_number($retailer_id);
                Retailer::where('id', $retailer_id)->update(['retailer_no'=>$retailer_number]);
            }
            catch(\Exception $exc){
                DB::rollBack();
                return $exc;
            }
        }

        $last_retailer_id=$retailer->id;

        try{
            DB::beginTransaction();
            $outlet = RetailerOutlet::create(array(
                'retailer_id' => $last_retailer_id,
                'city_id' => $city_id,
                'region_id'=>$region_id,
                'name'=>$outlet_name,
                'phone_no'=>$outlet_phone,
                'latitude'=>$latitude,
                'longitude'=>$longitude,
                'business_person_name'=>$fullname,
                'mobile_no'=>$phone_no,
                'business_person_cnic'=>$cnic,
                'address'=>$address,
                'security_deposit_amount'=>$security_check_amount,
                'security_deposit_image'=>$file_name,
                'credit_limit'=>$credit_limit,
                'credit_duration'=>$credit_duration,
                'credit_remaining'=>$credit_limit,
                'aging_amount'=>0,
                'created_by'=>$user,

            ));
            DB::commit();
            //Use 201 for succesfull work.
            return 201;
        }
        catch(\Exception $exc){
            DB::rollBack();
            return $exc;
        }
        //echo $bussiness_person_cnic;
    }

    //Registered a route with the name of /retailer/get_all_outlets
    public function get_all_outlets(){
        $records=RetailerOutlet::with('retailer','city','region')->where('is_deleted',0)->get();

        return Response::json($records);
    }

    public function get_all_outlets_dataTable(){
        $records=RetailerOutlet::with('retailer','city','region')->where('is_deleted',0)->limit($_POST['length'])->offset($_POST['start'])->get();
        $data = array();
        $no = 1;
        foreach ($records as $list) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $list->name;
            $row[] = $list->phone_no;
            $row[] = $list->latitude;
            $row[] = $list->longitude;
            $row[] = $list->mobile_no;
            $row[] = $list->business_person_name;
            $row[] = $list->business_person_name;
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => 20,
            "recordsFiltered" => 10,
            "data" => $data,
        );
        return Response::json($output);
    }
    //Registered a route with the name of 'outlet/delete_outlet'
    public function deactivate_outlet(Request $request){
        $id=$request->input('id');

        //Getting the logged in user id
        $user=Auth::user()->id;
        try{
            DB::beginTransaction();
            RetailerOutlet::where('id', $id)->update(array('is_deleted'=>1, 'updated_by'=>$user));
            DB::commit();
            return 201;
        }
        catch(\Exception $exc){
            DB::rollBack();
            return $exc;
        }
    }

    //Registered a route with the name of 'outlet/reactivate_outlet'
    public function activate_outlet(Request $request){
        $id=$request->input('id');

        //Getting the logged in user id
        $user=Auth::user()->id;
        try{
            DB::beginTransaction();
            RetailerOutlet::where('id', $id)->update(array('is_deleted'=>0, 'updated_by'=>$user));
            DB::commit();
            return 201;
        }
        catch(\Exception $exc){
            DB::rollBack();
            return $exc;
        }
    }

    //Registered a route with the name of 'outlet/update_outlet'
    public function edit_outlet(Request $request){
        $id=$request->input('id');
        $retailer_id= $request->input('retailer_id');
        $city_id= $request->input('city_id');
        $region_id= $request->input('region_id');
        $outlet_name= $request->input('outlet_name');
        $outlet_phone= $request->input('outlet_phone');
        $bussiness_person_name= $request->input('bussiness_person_name');
        $bussiness_person_cnic= $request->input('bussiness_person_cnic');
        $bussiness_person_phone= $request->input('bussiness_person_phone');
        $address=$request->input('address');
        $longitude=$request->input('longitude');
        $latitude=$request->input('latitude');
        $security_check_amount=$request->input('security_check_amount');
        $credit_limit=$request->input('credit_limit');
        $credit_duration=$request->input('credit_duration');

        //Getting the logged in user id
        $user=Auth::user()->id;

        try{
            DB::beginTransaction();
            $outlet = RetailerOutlet::where('id', $id)->update(array(
                'retailer_id' => $retailer_id,
                'city_id' => $city_id,
                'region_id'=>$region_id,
                'name'=>$outlet_name,
                'phone_no'=>$outlet_phone,
                'latitude'=>$latitude,
                'longitude'=>$longitude,
                'business_person_name'=>$bussiness_person_name,
                'mobile_no'=>$bussiness_person_phone,
                'business_person_cnic'=>$bussiness_person_cnic,
                'address'=>$address,
                'security_deposit_amount'=>$security_check_amount,
                'credit_limit'=>$credit_limit,
                'credit_duration'=>$credit_duration,
                'credit_remaining'=>$credit_limit,
                'updated_by'=>$user,
            ));
            DB::commit();
            //Use 201 for succesfull work.
            return 201;
        }
        catch(\Exception $exc){
            DB::rollBack();
            return $exc;
        }
    }

    //Registered a route with the name of 'outlet/change_outlet_image'
    public function edit_security_check_image(Request $request)
    {
        //GET THE IMAGE
        $exploded = explode(',', $request->input('copy_image'));

        $decoded = base64_decode($exploded[1]);

        if (str_contains($exploded[0], 'jpeg')) {
            $extension = "jpg";
        } else {
            $extension = "png";
        }

        //SAVE IT TO retailer_images FOLDER
        $file_name = str_random() . '.' . $extension;
        $path = public_path() . '/deposit_check_img/' . $file_name;
        file_put_contents($path, $decoded);

        $id=$request->input('id');
        //Getting the logged in user id
        $user = Auth::user()->id;

        try {
            DB::beginTransaction();
            $outlet = RetailerOutlet::where('id', $id)->update(array(
                'security_deposit_image'=>$file_name,
                'updated_by' => $user,
            ));
            DB::commit();
            //Use 201 for succesfull work.
            return 201;
        } catch (\Exception $exc) {
            DB::rollBack();
            return $exc;
        }
    }

    //Registered a route with the name of 'outlet/retailer_outlets'
    public function get_retailer_outlets(Request $request){
        $retailer_id=$request->input('retailer_id');
        $records= RetailerOutlet::where('retailer_id', $retailer_id)->get();
        return Response::json($records);
    }

    public function get_all_outlets_by_id($outlet_id){
        $records=RetailerOutlet::with('retailer','city','region')->where('is_deleted',0)->where('id', $outlet_id)->get();

        return Response::json($records);
    }

}
