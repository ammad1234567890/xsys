<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use DB;
use App\Retailer;
use Response;



class RetailerController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    //Registered a route with the name of 'retailer'
    public function index()
    {
        return view('retailer');
    }

    public function create_retailer(Request $request){

        //GET THE IMAGE
        $exploded= explode(',', $request->input('uploadImage'));

        $decoded= base64_decode($exploded[1]);

        if(str_contains($exploded[0],'jpeg')){
            $extension="jpg";
        }
        else{
            $extension="png";
        }

        //SAVE IT TO retailer_images FOLDER
        $file_name=str_random().'.'.$extension;
        $path=public_path().'/retailers_img/'.$file_name;
        file_put_contents($path, $decoded);

        //GET ALL OTHER FIELDS
        $fullname= $request->input('fullname');
        $cnic= $request->input('cnic');
        $phone_no= $request->input('phone_no');

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
                    'image'=>$file_name,
                    'created_by'=>$user,
                    'updated_by'=>null));
                DB::commit();
                //Use 201 for succesfull work.
                return 201;
            }
            catch(\Exception $exc){
                DB::rollBack();
                return $exc;
            }
        }

    }

    //Registered a route with the name of 'retailer/edit_retailer'
    public function edit_retailer(Request $request){
        //GET THE IMAGE
        $exploded= explode(',', $request->input('uploadImage'));

        $decoded= base64_decode($exploded[1]);

        if(str_contains($exploded[0],'jpeg')){
            $extension="jpg";
        }
        else{
            $extension="png";
        }

        //SAVE IT TO retailer_images FOLDER
        $file_name=str_random().'.'.$extension;
        $path=public_path().'/retailers_img/'.$file_name;
        file_put_contents($path, $decoded);
        //GET ALL OTHER FIELDS

        $id=$request->input('id');
        $fullname= $request->input('fullname');
        $cnic= $request->input('cnic');
        $phone_no= $request->input('phone_no');

        //Getting the logged in user id
        $user=Auth::user()->id;

        //query of getting users with the given phone number or cnic.
        $check_exist=Retailer::where('id','!=',$id)->where('phone_no','=',$phone_no)->count();

        //Check if the user is already exist or not.
        if($check_exist>0){

            //Use for any type of conflict.
            return 406;
        }
        else{
            //If not exist, consider it as a new retailer also push the details on database.
            try{
                DB::beginTransaction();
                $retailer = Retailer::where('id', $id)->update(array('name' => $fullname,
                    'cnic' => $cnic,
                    'phone_no'=>$phone_no,
                    'image'=>$file_name,
                    'updated_by'=>$user));
                DB::commit();
                //Use 201 for succesfull work.
                return 201;
            }
            catch(\Exception $exc){
                DB::rollBack();
                return $exc;
            }
        }
    }


    //Registered a route with the name of 'retailer/delete_retailer'
    public function deactivate_retailer(Request $request){
        $id=$request->input('id');

        //Getting the logged in user id
        $user=Auth::user()->id;
        try{
            DB::beginTransaction();
            Retailer::where('id', $id)->update(array('is_deleted'=>1, 'updated_by'=>$user));
            DB::commit();
            return 201;
        }
        catch(\Exception $exc){
            DB::rollBack();
            return $exc;
        }
    }

    //Registered a route with the name of 'retailer/reactivate_retailer'
    public function activate_retailer(Request $request){
        $id=$request->input('id');

        //Getting the logged in user id
        $user=Auth::user()->id;
        try{
            DB::beginTransaction();
            Retailer::where('id', $id)->update(array('is_deleted'=>0, 'updated_by'=>$user));
            DB::commit();
            return 201;
        }
        catch(\Exception $exc){
            DB::rollBack();
            return $exc;
        }
    }

    //Registered a route with the name of 'retailer/get_retailers'
    public function get_all_retailers(){
        $records=Retailer::where('is_deleted',0)->get();

        return Response::json($records);
    }
}
