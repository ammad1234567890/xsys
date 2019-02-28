<?php
namespace App\Http\Controllers\API;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\DealerAuth;
use App\Retailer;
use App\RetailerOutlet;
use App\MainWarehouseReceiveItem;
use Validator;
use Auth;
use Hash;
use DB;



class MessageController extends Controller
{
	public $successStatus = 200;


	public function send($phone,$msg){
		$phone=ltrim($phone, '0');
		$phone= "92".$phone;

		$username = "923330325223";
		$password = "4285";
		$sender = "8584";
		$message = $msg;
		$url = "http://sendpk.com/api/sms.php";

		$ch = curl_init();
		$timeout = 30;
		curl_setopt($ch,CURLOPT_URL,$url);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
		curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS,"username=".$username."&password=".$password."&sender=".urlencode($sender)."&mobile=".$phone."&message=".urlencode($message)."");
		curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,$timeout);
		$responce = curl_exec($ch);
		curl_close($ch);
		/*Print Responce*/
		return $responce;
	}
}