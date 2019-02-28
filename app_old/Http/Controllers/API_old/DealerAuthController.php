<?php
namespace App\Http\Controllers\API;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\DealerAuth;
use App\Retailer;
use App\RetailerOutlet;
use App\MainWarehouseReceiveItem;
use App\Ledger;
use Validator;
use Auth;
use Hash;
use App\DealerNotification;
use DB;
use App\Http\Controllers\API\MessageController;


class DealerAuthController extends Controller
{
	public $successStatus = 200;




    public function __construct() {
        $this->outlet = new RetailerOutlet();
        $this->ledger = new Ledger();
    }

    public function dealer_dashboard(Request $request) {
        $retailer_id = $request->dealer_id;
        $data = $this->outlet->dealer_dashboard($retailer_id);
        return ['status' => 1, 'status code' => 200, 'data' => $data];
    }



	//Find the dealer if the dealer exist then go for the password, else create the dealer account.
    public function dealer_identification(){
    	$check_already_account_exist=DealerAuth::where('dealer_code', request('dealer_code'))->count();

        if($check_already_account_exist>0){
            //$user = Auth::DealerAuth();
            //$success['token'] =  $user->createToken('MyApp')->accessToken;

            $check_password_not_set=DealerAuth::where('dealer_code', request('dealer_code'))->where('password','=',null)->count();
            $dealer_details=DealerAuth::where('dealer_code', request('dealer_code'))->get();
            if($check_password_not_set>0){

            	$response=array(
	        			'status'=>1,
	        			'status_code'=>200,
	        			'message'=>'Now set your account password',
	        			'data'=>[
	        				'auth_id'=>$dealer_details[0]['id'],
	        			],
        			);
            }
            else{
            	$response=array(
	        			'status'=>1,
	        			'status_code'=>200,
	        			'message'=>'Record Found',
	        			'data'=>[
	        				'auth_id'=>$dealer_details[0]['id'],
	        			],
        			);
            }
            

        	return response()->json($response);
        }
        else{ 
        	$check_exist=Retailer::where('retailer_no', request('dealer_code'))->count();
        	if($check_exist>0){

        		$retailer_information=Retailer::where('retailer_no', request('dealer_code'))->get();
        		$recent_record=DealerAuth::create(
        			['retailer_id'=>$retailer_information[0]['id'],
        			 'dealer_code'=> $retailer_information[0]['retailer_no']
        			 ]);
				$recent_id=$recent_record->id;


        			$response=array(
	        			'status'=>1,
	        			'status_code'=>200,
	        			'message'=>'Now set your account password',
	        			'data'=>[
	        				'auth_id'=>$recent_id,
	        			],
        			);

        		return response()->json($response);
        	}
        	else{
        		$response=array(
        			'status'=>0,
        			'status_code'=>404,
        			'message'=>'Invalid Dealer Information',
        			'data'=>array('auth_id'=>0),
        			);
        		return response()->json($response);
        	}
        }
    }


    //Check the password if the password already set then GO FOR LOGIN otherwise set the password.
    public function login(){
    	$auth_id=request('auth_id');
    	$password=request('password');
        $firebase_token=request('token');

		$dealer_Details=DealerAuth::where('id', $auth_id)->get();
    	if($password!=null){
    		if($dealer_Details[0]['password']==null){
    			$update_pass=DealerAuth::where('id', $auth_id)->update(['password'=>bcrypt($password)]);
                //$tokenobj = Auth::DealerAuth()->createToken('name');
		    	$response=array(
		        		'status'=>1,
		        		'status_code'=>200,
		        		'message'=>'Password has been set!',
		        		'data'=>[
		        				'dealer_id'=> $dealer_Details[0]['retailer_id'],
		        				'dealer_code'=> $dealer_Details[0]['dealer_code'],
                                //'token'=>$token = $tokenobj->accessToken,
		        			],
		        		);
		        return response()->json($response);
    		}
    		else{
                //$tokenobj = Auth::DealerAuth()->createToken('name');
               // print_r(bcrypt($password));
                $user_Details=DealerAuth::where('id', $auth_id)->first();
                //print_r($user_Details);
                if(Hash::check($password, $dealer_Details[0]['password'])){
                    $token=$user_Details->createToken('MyApp')->accessToken;
                    $response=array(
                        'status'=>1,
                        'status_code'=>200,
                        'message'=>'Login Succesfully!',
                        'data'=>[
                            'dealer_id'=> $dealer_Details[0]['retailer_id'],
                            'dealer_code'=> $dealer_Details[0]['dealer_code'],
                            'token'=>$token
                        ],
                    );
                    $this->reset_firebaseToken($auth_id, $firebase_token);
                    return response()->json($response);
                }
                else{
                    $response=array(
                        'status'=>0,
                        'status_code'=>403,
                        'message'=>'Incorrect Password!',
                        'data'=>[
                            'dealer_id'=>0,
                        ],
                    );
                    return response()->json($response);
                }

    		}
    		
    	}
    	else{
    		$response=array(
        			'status'=>0,
        			'status_code'=>404,
        			'message'=>'Password cannot be null',
        			'data'=>[
                        'dealer_id'=>0,
                    ],
        			);
        	return response()->json($response);
    	}

    }

    public function imei_details(){
         $imei=request('imei');
         $dealer_id=request('dealer_id');
        if($imei!="" && $dealer_id!=""){
            $dealer_outlet_data=RetailerOutlet::where('retailer_id', $dealer_id)->get();

            $dealer_outlet_id=$dealer_outlet_data[0]['id'];

            //DB::select("Select * from tbl_main_warehouse_receive_item receive_item inner join tbl_imei imei on imei.item_id=receive_item.item_id");

            $imei_data=DB::select("Select * from tbl_imei imei 
            inner join tbl_item item on imei.item_id=item.id 
            inner join tbl_product_color pro_color_tbl on pro_color_tbl.id=item.product_color_id 
            inner join tbl_product pro_tbl on pro_tbl.id=pro_color_tbl.product_id 
            inner join tbl_main_warehouse_receive_item receive_item on receive_item.item_id=item.id 
            inner join tbl_specs_product specs on specs.product_id=pro_color_tbl.product_id 
            where 
            receive_item.sold_to_outlet_id=$dealer_outlet_id AND 
            (imei.imei1=$imei OR imei.imei2=$imei) AND 
            (specs.specs_sub_category_id=16 OR specs.specs_sub_category_id=21)");



           // return $imei_data;
            if($imei_data!=null){
				 $activation_date_final="";
            $expired_warranty_date_final="";
            if($imei_data[0]->item_is_activate==1){
              /*  $activation_date=date('d/m/Y', strtotime($imei_data[0]->activated_date));
                //$expired_warranty_date=strtotime("+1 year", $activation_date);
				$expired=date('Y-m-d', strtotime('-1 day', strtotime($imei_data[0]->activated_date)));
				
				
                $act_date=date('d', strtotime($expired));
                $act_month=date('m', strtotime($imei_data[0]->activated_date));
                $increament_year = date('Y', strtotime($imei_data[0]->activated_date))+1;

                $expired_warranty_date=$act_date.'/'.$act_month.'/'.$increament_year;  */
				
				
				$activation_date=date('Y-m-d', strtotime($imei_data[0]->activated_date));
                //$expired_warranty_date=strtotime("+1 year", $activation_date);
                $expired=date('Y-m-d', strtotime('+1 year', strtotime($imei_data[0]->activated_date)));
                $expired_warranty= date('Y-m-d', strtotime('-1 day', strtotime($expired)));


                $expired_warranty_date=date('Y-m-d', strtotime($expired_warranty));




                $activation_date_final=date('d/m/Y', strtotime($activation_date));
                $expired_warranty_date_final=date('d/m/Y', strtotime($expired_warranty));
				
				
				
				
            }
            else{
                $activation_date="";
            }
                $imei_detail=array(
                    'imei'=>[
                        'imei1'=>$imei_data[0]->imei1,
                        'imei2'=>$imei_data[0]->imei2,
                        'item_id'=>$imei_data[0]->item_id,
                        'activation_status'=>$imei_data[0]->item_is_activate,
                        'activated_date'=>$activation_date_final,
                        'warranty_expiry'=>$expired_warranty_date_final
						//'warranty_expiry'=>$expired
                    ],
                    'product_details'=>[
                        'product_id'=>$imei_data[0]->product_id,
                        'product_name'=>$imei_data[0]->name,
                        'product_color'=>$imei_data[0]->color,
                        'memory'=>$imei_data[1]->detail_name,
                        'os'=>$imei_data[0]->detail_name,
                    ],
                );

                $response=array(
                    'status'=>1,
                    'status_code'=>200,
                    'message'=>'Imei Details',
                    'data'=>$imei_detail,
                );

                return response()->json($response);

            }
            else{
                $response=array(
                    'status'=>0,
                    'status_code'=>404,
                    'message'=>'Invalid Imei',
                    'data'=>[],
                );
                return response()->json($response);
            }

            //print_r($imei_detail);
        }
        else{
            $response=array(
                'status'=>0,
                'status_code'=>403,
                'message'=>'Invalid Information',
                'data'=>[],
            );
            return response()->json($response);
        }
    }

    public function activate_item(){
        $item_id= request('item_id');
        $customer_name= request('customer_name');
        $customer_phone= request('customer_phone');

        $dealer_Response= request('dealer_response');
        if($item_id!=''){
            if($dealer_Response==1){
                if(MainWarehouseReceiveItem::where('item_id', $item_id)->exists()){
                    $item_details=MainWarehouseReceiveItem::where('item_id', $item_id)->get();
                    if($item_details[0]['item_is_activate']==0){
                        MainWarehouseReceiveItem::where('item_id', $item_id)->update(['item_is_activate'=>1, 'activated_date'=>date('Y-m-d H:i:s')]);

                        if($customer_name!="" || $customer_phone!=""){
                            $date=date('Y-m-d H:i:s');
                            DB::select("Insert into customer_details(name, phone, item_id, created_date) values('$customer_name', '$customer_phone', '$item_id', '".$date."')");
                        }

                        if($customer_phone!=""){
                            $alert_msgs = new MessageController;
                            $alert_msgs->send($customer_phone, "Your device has successfully been activated. Thank you for buying Xcell");
                        }


                        $response=array(
                            'status'=>1,
                            'status_code'=>200,
                            'message'=>'Imei has been Activated!',
                            'data'=>[],
                        );
                        return response()->json($response);
                    }
                    else{
                        $response=array(
                            'status'=>0,
                            'status_code'=>409,
                            'message'=>'Already Activated!',
                            'data'=>[],
                        );
                        return response()->json($response);
                    }
                }
                else{
                    $response=array(
                        'status'=>0,
                        'status_code'=>404,
                        'message'=>'Invalid Item',
                        'data'=>[],
                    );
                    return response()->json($response);
                }
            }
            else{
                $data=MainWarehouseReceiveItem::with('outlet')->where('item_id', $item_id)->first();
                $alert_msgs = new MessageController;
                $alert_msgs->send($customer_phone, "IMEI Activation rejected,Please contact with your dealer ".$data['outlet']['phone_no']);
                $response=array(
                    'status'=>1,
                    'status_code'=>406,
                    'message'=>'Cancel Request',
                    'data'=>[],
                );
                return response()->json($response);
            }
        }
        else{
            $response=array(
                'status'=>0,
                'status_code'=>403,
                'message'=>'Invalid Information',
                'data'=>[],
            );
            return response()->json($response);
        }

    }

    public function logout(){
        $id= request('id');
        $user_Details=DealerAuth::where('id', $id)->first();
        $userTokens = $user_Details->tokens;
        foreach($userTokens as $token) {
            $token->revoke();
        }

        $response=array(
            'status'=>1,
            'status_code'=>200,
            'message'=>'Logout!',
            'data'=>[],
        );
        return response()->json($response);
    }

    public function set_token(Request $request){
        $token=$request->input('token');
        $dealer_code= $request->input('dealer_id');


        DealerAuth::where('id', $dealer_code)->update(['firebase_token'=> $token]);
        $response=array(
            'status'=>1,
            'status_code'=>200,
            'message'=>'Token Updated!',
            'data'=>[],
        );
        return response()->json($response);
    }

    public function reset_firebaseToken($dealer_id,$token){
        DealerAuth::where('id', $dealer_id)->update(['firebase_token'=> $token]);
    }

    public function get_all_notification($dealer_auth_id){
        return DealerNotification::where('dealer_auth_id', $dealer_auth_id)->orderBy('id','DESC')->get();
    }
}
