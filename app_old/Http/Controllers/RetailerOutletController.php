<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use DB;
use App\Retailer;
use App\City;
use App\Region;
use App\RetailerOutlet;
use App\Staff;
use App\RetailerOrder;
use App\SoTask;
use App\SoAuth;
use App\OnShelfImei;
use App\SoTaskSoldItems;
use Response;
use App\Http\Controllers\NotificationController;

class RetailerOutletController extends Controller {

    public function __construct() {
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
    public function index() {
        return view('retailer_outlets');
    }

    public function make_number($order_id) {

        $id_length = strlen($order_id);

        if ($id_length == 1) {
            $order_zeros = '0000';
        }
        if ($id_length == 2) {
            $order_zeros = '000';
        }
        if ($id_length == 3) {
            $order_zeros = '00';
        }
        if ($id_length == 4) {
            $order_zeros = '0';
        }
        if ($id_length == 5) {
            $order_zeros = '';
        }

        /* $order_zeros='';
          for($i=0; $i<=strlen($order_id); $i++){
          $order_zeros.=0;
          } */
        $current_month = date('m');
        $current_year = date('y');
        $number = $current_month . $current_year . $order_zeros . $order_id;
        return $number;
    }

    //Registered a route with the name of '/add_city'
    public function add_city(Request $request) {
        $name = $request->input('name');
        try {
            DB::beginTransaction();
            City::create(array('name' => $name));
            DB::commit();
            //Use 201 for succesfull work.
            return 201;
        } catch (\Exception $exc) {
            DB::rollBack();
            return $exc;
        }
    }

    //Registered a route with the name of '/add_region'
    public function add_region(Request $request) {
        $name = $request->input('name');
        try {
            DB::beginTransaction();
            Region::create(array('name' => $name));
            DB::commit();
            //Use 201 for succesfull work.
            return 201;
        } catch (\Exception $exc) {
            DB::rollBack();
            return $exc;
        }
    }

    public function get_cities() {
        $records = City::get();

        return Response::json($records);
    }

    public function get_cities_by_state($state_id) {
        return $records = City::where("state_id", $state_id)->get();

         //Response::json($records);
    }

    public function get_regions() {
        $records = Region::get();

        return Response::json($records);
    }

    //Registered a route with the name of /retailer/create_outlet
    public function add_outlet(Request $request) {
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


        //GET THE RETAILER IMAGE

        $retailer_file_name = null;
        if ($request->input('uploadImage')) {
            $exploded = explode(',', $request->input('uploadImage'));

            $decoded = base64_decode($exploded[1]);

            if (str_contains($exploded[0], 'jpeg')) {
                $extension = "jpg";
            } else {
                $extension = "png";
            }

            //SAVE IT TO retailer_images FOLDER
            $retailer_file_name = str_random() . '.' . $extension;
            $path = public_path() . '/retailers_img/' . $retailer_file_name;
            file_put_contents($path, $decoded);
        }






        //GET ALL OTHER FIELDS
        $fullname = $request->input('fullname');
        $cnic = $request->input('cnic');
        $phone_no = $request->input('phone_no');


        $city_id = $request->input('city_id');
        $region_id = $request->input('region_id');
        $outlet_name = $request->input('outlet_name');
        $outlet_phone = $request->input('outlet_phone');
        $bussiness_person_name = $request->input('bussiness_person_name');
        $bussiness_person_cnic = $request->input('bussiness_person_cnic');
        $bussiness_person_phone = $request->input('bussiness_person_phone');
        $address = $request->input('address');
        $longitude = $request->input('longitude');
        $latitude = $request->input('latitude');
        $security_check_amount = $request->input('security_check_amount');
        $credit_limit = $request->input('credit_limit');
        $credit_duration = $request->input('credit_duration');
        $sales_officer = $request->input('sales_officer_id');

        //Getting the logged in user id
        $user = Auth::user()->id;

        //query of getting users with the given phone number or cnic.
        $check_exist = Retailer::where('phone_no', '=', $phone_no)->orWhere('cnic', $cnic)->count();

        $check_exist = 0;

        //Check if the user is already exist or not.
        if ($check_exist > 0) {

            //Use for any type of conflict.
            return 406;
        } else {
            //If not exist, consider it as a new retailer also push the details on database.
            try {
                DB::beginTransaction();
                $retailer = Retailer::create(array('name' => $fullname,
                            'cnic' => $cnic,
                            'phone_no' => $phone_no,
                            'image' => $retailer_file_name,
                            'created_by' => $user));
                DB::commit();

                $retailer_id = $retailer->id;
                $retailer_number = 'DC' . $this->make_number($retailer_id);
                Retailer::where('id', $retailer_id)->update(['retailer_no' => $retailer_number]);
            } catch (\Exception $exc) {
                DB::rollBack();
                return $exc;
            }
        }

        $last_retailer_id = $retailer->id;

        try {
            DB::beginTransaction();
            $outlet = RetailerOutlet::insert(array(
                        'retailer_id' => $last_retailer_id,
                        'city_id' => $city_id,
                        'region_id' => $region_id,
                        'name' => $outlet_name,
                        'phone_no' => $outlet_phone,
                        'latitude' => $latitude,
                        'longitude' => $longitude,
                        'business_person_name' => $fullname,
                        'mobile_no' => $phone_no,
                        'business_person_cnic' => $cnic,
                        'address' => $address,
                        'security_deposit_amount' => $security_check_amount,
                        'security_deposit_image' => $file_name,
                        'credit_limit' => $credit_limit,
                        'credit_duration' => $credit_duration,
                        'credit_remaining' => $credit_limit,
                        'aging_amount' => 0,
                        'created_by' => $user,
                        'sales_officer_id' => $sales_officer
            ));

            /* $value_arr=array(
              'retailer_id' => $last_retailer_id,
              'city_id' => $city_id,
              'region_id' => $region_id,
              'name' => $outlet_name,
              'phone_no' => $outlet_phone,
              'latitude' => $latitude,
              'longitude' => $longitude,
              'business_person_name' => $fullname,
              'mobile_no' => $phone_no,
              'business_person_cnic' => $cnic,
              'address' => $address,
              'security_deposit_amount' => $security_check_amount,
              'security_deposit_image' => $file_name,
              'credit_limit' => $credit_limit,
              'credit_duration' => $credit_duration,
              'credit_remaining' => $credit_limit,
              'aging_amount' => 0,
              'created_by' => $user,
              );

              DB::table('tbl_retailer_outlet')->insert($value_arr); */
            DB::commit();
            //Use 201 for succesfull work.
            return 201;
        } catch (\Exception $exc) {
            DB::rollBack();
            return $exc;
        }
        //echo $bussiness_person_cnic;
    }

    //Registered a route with the name of /retailer/get_all_outlets
    public function get_all_outlets() {
        $records = RetailerOutlet::with('retailer', 'city', 'region')->where('is_deleted', 0)->get();

        return Response::json($records);
    }

    public function get_outlet_by_city_state($state_id, $city_id=""){
        $query=RetailerOutlet::with('retailer', 'city', 'region')->where('is_deleted', 0);
        if($city_id==""){
            $query->where(function($query) use ($state_id) {
                $query->orWhereHas('city', function ( $q ) use ($state_id) {
                    $q->Where('state_id', $state_id);
                });
            });
        }
        else{
            $query->where("city_id", $city_id);
        }

        return $query->get();
    }

    public function get_all_outlets_dataTable(Request $request) {

        if ($request->input('client')) {
            return RetailerOutlet::with('retailer', 'city', 'region', 'sales_officer')->where('is_deleted', 0)->get();
        }
        $columns = ['retailer_id', 'name', 'address', 'phone_no', 'mobile_no'];
        $length = $request->input('length');
        $column = $request->input('column'); //Index
        $dir = $request->input('dir');
        $searchValue = $request->input('search');
        //$selected_filters= $request->input('selected_filters');
        $selected_sales_officer= $request->input("selected_sales_officer");
        $selected_city= $request->input("selected_city");
        $selected_state= $request->input("selected_state");

        $excel_export=$request->input("excel_export");
        $excel_type=$request->input("excel_type");
        $file_name=$request->input("file_name");

        $query = RetailerOutlet::with('retailer', 'city', 'region', 'sales_officer')->orderBy($columns[$column], $dir);

        if($selected_sales_officer!=""){
            $query->where("sales_officer_id", $selected_sales_officer);
        }
        if($selected_city!=""){
            $query->where("city_id", $selected_city);
        }
        if($selected_state!=""){
            $query->where(function($query) use ($selected_state) {
                $query->orWhereHas('city', function ( $q ) use ($selected_state) {
                        $q->Where('state_id', $selected_state);
                    });
                });
        }
        if ($searchValue) {
            $query->where(function($query) use ($searchValue) {
                $query->where('name', 'like', '%' . $searchValue . '%')
                        ->orWhere('address', 'like', '%' . $searchValue . '%')
                        ->orWhereHas('retailer', function ( $q ) use ($searchValue) {
                            $q->Where('retailer_no', 'like', '%' . $searchValue . '%');
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
                $data_final[]=[
                    "Dealer Code"=>$data[$i]['retailer']['retailer_no'],
                    "Dealer Name"=>$data[$i]['retailer']['name'],
                    "Dealer Cnic"=>$data[$i]['retailer']['cnic'],
                    "Outlet Name"=>$data[$i]['name'],
                    "Phone No"=>$data[$i]['phone_no'],
                    "City"=>$data[$i]["city"]['name'],
                    "Locality"=>$data[$i]['region']["name"],
                    "SalesOfficer"=>$data[$i]['sales_officer']["name"],
                    "Security Deposit Amount"=>$data[$i]['security_deposit_amount'],
                    "Credit Limit"=>$data[$i]['credit_limit'],
                    "Credit Duration"=>$data[$i]['credit_duration'],
                    "Opening Date"=> date("d/M/y", strtotime($data[$i]['retailer']['created_at'])),
                ];
            }
            if($file_name==""){
                $file_name="OutletRecords";
            }
            $this->export_excel($file_name,$data_final);
        }


        return ['data' => $projects, 'draw' => $request->input('draw')];
    }

    public function export_excel($name, $data){
        return \Excel::create($name, function($excel) use ($name, $data) {

            $excel->sheet($name, function($sheet) use ($data)
            {
                $sheet->fromArray($data);

            });

        })->download("xlsx");

    }

    //Registered a route with the name of 'outlet/reactivate_outlet'
    public function activate_outlet(Request $request) {
        $id = $request->input('id');

        //Getting the logged in user id
        $user = Auth::user()->id;
        try {
            DB::beginTransaction();
            RetailerOutlet::where('id', $id)->update(array('is_deleted' => 0, 'updated_by' => $user));
            DB::commit();
            return 201;
        } catch (\Exception $exc) {
            DB::rollBack();
            return $exc;
        }
    }

    //Registered a route with the name of 'outlet/update_outlet'
    public function edit_outlet(Request $request) {
        $id = $request->input('id');
        $retailer_id = $request->input('retailer_id');
        $city_id = $request->input('city_id');
        $region_id = $request->input('region_id');
        $outlet_name = $request->input('outlet_name');
        $outlet_phone = $request->input('outlet_phone');
        $bussiness_person_name = $request->input('bussiness_person_name');
        $bussiness_person_cnic = $request->input('bussiness_person_cnic');
        $bussiness_person_phone = $request->input('bussiness_person_phone');
        $address = $request->input('address');
        $longitude = $request->input('longitude');
        $latitude = $request->input('latitude');
        $security_check_amount = $request->input('security_check_amount');
        $credit_limit = $request->input('credit_limit');
        $credit_duration = $request->input('credit_duration');


        $retailer_name = $request->input('fullname');
        $retailer_phone = $request->input('phone_no');
        $retailer_cnic = $request->input('cnic');
        $sales_officer = $request->input('sales_officer_id');
        //Getting the logged in user id
        $user = Auth::user()->id;

        try {
            DB::beginTransaction();
            $outlet = RetailerOutlet::where('id', $id)->update(array(
                'retailer_id' => $retailer_id,
                'city_id' => $city_id,
                'region_id' => $region_id,
                'name' => $outlet_name,
                'phone_no' => $outlet_phone,
                'latitude' => $latitude,
                'longitude' => $longitude,
                'business_person_name' => $bussiness_person_name,
                'mobile_no' => $bussiness_person_phone,
                'business_person_cnic' => $bussiness_person_cnic,
                'address' => $address,
                'security_deposit_amount' => $security_check_amount,
                'credit_limit' => $credit_limit,
                'credit_duration' => $credit_duration,
                'credit_remaining' => $credit_limit,
                'updated_by' => $user,
                'business_person_name' => $retailer_name,
                'mobile_no' => $retailer_cnic,
                'business_person_cnic' => $retailer_phone,
                'sales_officer_id' => $sales_officer
            ));


            $retailer = Retailer::where('id', $retailer_id)->update([
                'name' => $retailer_name,
                'cnic' => $retailer_cnic,
                'phone_no' => $retailer_phone
            ]);


            DB::commit();
            //Use 201 for succesfull work.
            return 201;
        } catch (\Exception $exc) {
            DB::rollBack();
            return $exc;
        }
    }

    public function edit_retailer_image(Request $request) {
        //GET THE RETAILER IMAGE
        $exploded = explode(',', $request->input('uploadImage'));

        $decoded = base64_decode($exploded[1]);

        if (str_contains($exploded[0], 'jpeg')) {
            $extension = "jpg";
        } else {
            $extension = "png";
        }

        //SAVE IT TO retailer_images FOLDER
        $retailer_file_name = str_random() . '.' . $extension;
        $path = public_path() . '/retailers_img/' . $retailer_file_name;
        file_put_contents($path, $decoded);

        $id = $request->input('retailer_id');
        //Getting the logged in user id
        $user = Auth::user()->id;

        try {
            DB::beginTransaction();
            $outlet = Retailer::where('id', $id)->update(array(
                'image' => $retailer_file_name,
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

    public function delete_retailer_image(Request $request) {

        $id = $request->input('retailer_id');
        Retailer::where('id', $id)->update(['image' => null]);

        return 201;
    }

    //Registered a route with the name of 'outlet/change_outlet_image'
    public function edit_security_check_image(Request $request) {
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

        $id = $request->input('id');
        //Getting the logged in user id
        $user = Auth::user()->id;

        try {
            DB::beginTransaction();
            $outlet = RetailerOutlet::where('id', $id)->update(array(
                'security_deposit_image' => $file_name,
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
    public function get_retailer_outlets(Request $request) {
        $retailer_id = $request->input('retailer_id');
        $records = RetailerOutlet::where('retailer_id', $retailer_id)->get();
        return Response::json($records);
    }

    public function get_all_outlets_by_id($outlet_id) {
        $records = RetailerOutlet::with('retailer', 'city', 'region')->where('is_deleted', 0)->where('id', $outlet_id)->get();

        return Response::json($records);
    }

    public function get_all_outlets_order_of_warehouse($warehouse_id) {
        return DB::Select("Select outlet.id as id, outlet.name as name from tbl_retailer_outlet outlet inner join tbl_retailer_order r_order on r_order.outlet_id=outlet.id where r_order.warehouse_id=$warehouse_id order by outlet.id ASC");
    }

    public function get_outlet_advance_amount($outlet_id) {
        return RetailerOutlet::select('advance_amount')->where('id', $outlet_id)->get();
    }

    public function get_sales_officers_outlets(Request $request) {

        if ($request->input('client')) {
            return Staff::where('staff_type_id', 5)->get();
        }
        $columns = ['id', 'name', 'address', 'cnic', 'email', 'phoneNumber'];
        $length = $request->input('length');
        $column = $request->input('column'); //Index
        $dir = $request->input('dir');
        $searchValue = $request->input('search');

        $query = Staff::where('staff_type_id', 5)->orderBy($columns[$column], $dir);
        if ($searchValue) {
            $query->where(function($query) use ($searchValue) {
                $query->where('name', 'like', '%' . $searchValue . '%')
                        ->orWhere('phoneNumber', 'like', '%' . $searchValue . '%')
                        ->orWhere('email', 'like', '%' . $searchValue . '%')
                        ->orWhere('cnic', 'like', '%' . $searchValue . '%');
            });
        }
        $projects = $query->paginate($length);
        return ['data' => $projects, 'draw' => $request->input('draw')];
    }

    public function get_outlet_of_salesOfficers($so_id) {
        return RetailerOrder::Select('outlet_id')->with('retailer_outlet', 'retailer_outlet.city', 'retailer_outlet.region')->distinct()->where('sales_officer_id', $so_id)->get();

        // return DB::table('tbl_retailer_order')->distinct()->select('outlet_id', 'name', '')->where('sales_officer_id', $so_id)
        //->get();
    }

    public function create_survey_task(Request $request) {
        $outlets = $request->input('outlets');
        $so_id = $request->input('so_id');
        $user = Auth::user()->id;
        foreach ($outlets as $outlet) {
            $task_id = SoTask::create(['so_id' => $so_id, 'outlet_id' => $outlet, 'status_id' => 1, 'comment' => '', 'created_by' => $user]);
            $task_no = 'TS' . $this->make_number($task_id->id);
            SoTask::where('id', $task_id->id)->update(['task_no' => $task_no]);
        }

        $so_data = SoAuth::where('so_id', $so_id)->first();
        $token = $so_data['firebase_token'];
        $notification = new NotificationController;
        $notification->send($token, "New Shelf Task", "Check your dashboard to see tasks", 'null', 1, []);


        return 201;
    }

    public function get_all_so_tasks(Request $request) {



        if ($request->input('client')) {
            return SoTask::with('sales_officer', 'retailer_outlet', 'retailer_outlet.city', 'retailer_outlet.region', 'task_status')->get();
        }
        $columns = ['id', 'task_no', 'created_at'];
        $length = $request->input('length');
        $column = $request->input('column'); //Index
        $dir = $request->input('dir');
        $searchValue = $request->input('search');

        $query = SoTask::with('sales_officer', 'retailer_outlet', 'retailer_outlet.city', 'retailer_outlet.region', 'task_status')->orderBy($columns[$column], $dir);
        if ($searchValue) {
            $query->where(function($query) use ($searchValue) {
                $query->where('task_no', 'like', '%' . $searchValue . '%')
                        ->orWhereHas('sales_officer', function ( $q ) use ($searchValue) {
                            $q->Where('name', 'like', '%' . $searchValue . '%');
                        })->orWhereHas('retailer_outlet', function ( $q ) use ($searchValue) {
                            $q->Where('name', 'like', '%' . $searchValue . '%');
                        })
                        ->orWhereHas('retailer_outlet.city', function ( $q ) use ($searchValue) {
                            $q->Where('name', 'like', '%' . $searchValue . '%');
                        })
                        ->orWhereHas('retailer_outlet.region', function ( $q ) use ($searchValue) {
                            $q->Where('name', 'like', '%' . $searchValue . '%');
                        });
            });
        }
        $projects = $query->paginate($length);
        return ['data' => $projects, 'draw' => $request->input('draw')];
    }

    public function get_so_task($task_id) {
        return SoTask::with('sales_officer', 'retailer_outlet', 'retailer_outlet.city', 'retailer_outlet.region', 'task_status')->where('id', $task_id)->get();
    }

    public function changeToCompleteTask(Request $request) {
        $task_id = $request->input('task_id');
        SoTask::where('id', $task_id)->update(['status_id' => 3]);

        return 201;
    }

    public function get_shelf_imeis_by_task($task_id) {

        return OnShelfImei::with('item', 'item.productColor', 'item.productColor.product', 'item.imei')->where('task_id', $task_id)->get();
    }

    public function get_for_activate_imeis_by_task($task_id) {
        return SoTaskSoldItems::with('item', 'item.productColor', 'item.productColor.product', 'item.imei')->where('task_id', $task_id)->get();
    }

}
