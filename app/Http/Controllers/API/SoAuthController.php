<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\OnShelfImei;
use App\SoAuth;
use App\SoTask;
use App\SoTaskStatus;
use DB;
use App\IMEI;
use App\Staff;
use App\Http\Controllers\RetailerInvoiceController;
use App\MainWarehouseReceiveItem;
use Auth;
use Hash;

class SoAuthController extends Controller {

    public function so_identification() {
        //str_replace('-', '', request('phone_no'));
        //substr_replace(request('phone_no'),"-",4);
        $phone_no=substr_replace(request('phone'),'-', 4, 0);
        $check_staff_exist=Staff::where('phoneNumber', $phone_no)->where('staff_type_id', 5)->count();
        if($check_staff_exist==1){
            $so_data=Staff::where('phoneNumber', $phone_no)->where('staff_type_id', 5)->get();

            $so_id=$so_data[0]->id;

            $check_already_account_exist=SoAuth::where('so_id', $so_id)->count();

            if($check_already_account_exist>0){
                $check_password_not_set=SoAuth::where('so_id', $so_id)->where('password','=',null)->count();
            $so_auth_details=SoAuth::where('so_id', $so_id)->get();
                if($check_password_not_set>0){

                    $response=array(
                            'status'=>1,
                            'status_code'=>200,
                            'message'=>'Now set your account password',
                            'data'=>[
                                'auth_id'=>$so_auth_details[0]['id'],
                            ],
                        );
                }
                else{
                    $response=array(
                            'status'=>1,
                            'status_code'=>200,
                            'message'=>'Record Found',
                            'data'=>[
                                'auth_id'=>$so_auth_details[0]['id'],
                            ],
                        );
                }
            

                return response()->json($response);
            }
            else{
                $staff_information=Staff::where('id', $so_id)->get();
                $recent_record=SoAuth::create(
                    ['so_id'=>$staff_information[0]['id']
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
        }
        else{
                $response=array(
                    'status'=>0,
                    'status_code'=>404,
                    'message'=>'Invalid Sales Officer Information',
                    'data'=>array('auth_id'=>0),
                    );
                return response()->json($response);
        } 
    }

    public function login(){
        $auth_id=request('auth_id');
        $password=request('password');
        $firebase_token=request('token');

        $so_Details=SoAuth::where('id', $auth_id)->get();
        if($password!=null){
            if($so_Details[0]['password']==null){
                $update_pass=SoAuth::where('id', $auth_id)->update(['password'=>bcrypt($password)]);
                $user_Details=SoAuth::where('id', $auth_id)->first();
				$token=$user_Details->createToken('MyApp')->accessToken;
                $response=array(
                        'status'=>1,
                        'status_code'=>200,
                        'message'=>'Password has been set!',
                        'data'=>[
                                'so_id'=> $so_Details[0]['so_id'],
                                'token'=>$token
                            ],
                        );
				$this->reset_firebaseToken($auth_id, $firebase_token);
                return response()->json($response);
            }
            else{
                //$tokenobj = Auth::DealerAuth()->createToken('name');
               // print_r(bcrypt($password));
                $user_Details=SoAuth::where('id', $auth_id)->first();
                //print_r($user_Details);
                if(Hash::check($password, $so_Details[0]['password'])){
                    $token=$user_Details->createToken('MyApp')->accessToken;
                    $response=array(
                        'status'=>1,
                        'status_code'=>200,
                        'message'=>'Login Succesfully!',
                        'data'=>[
                            'so_id'=> $so_Details[0]['so_id'],
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
                            'so_id'=>0,
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
                        'so_id'=>0,
                    ],
                    );
            return response()->json($response);
        }

    }

    public function reset_firebaseToken($so_id,$token){
        SoAuth::where('id', $so_id)->update(['firebase_token'=> $token]);
    }

}
