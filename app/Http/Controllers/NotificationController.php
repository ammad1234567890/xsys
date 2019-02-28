<?php
namespace App\Http\Controllers;
class NotificationController extends Controller
{

	// sending push message to single user by firebase reg id
	public function send($to,$title,$message,$image,$type,$payload_arr) {
		$fields = array(
			'to' => $to,
			'data' => array('title'=>$title,'message'=>$message,'image'=>$image,'type'=>$type),
			'payload'=>$payload_arr
		);
		
		return $this->send_notification($fields);
	}
	
	// Sending message to a topic by topic name
	public function sendToTopic($to,$title, $message,$image,$payload_arr) {
		$fields = array(
			'to' => '/topics/' . $to,
			'data' => array('title'=>$title,'message'=>$message,'image'=>$image),
			'payload'=>$payload_arr
		);
		return $this->send_topic_notification($fields);
	}
	
	// sending push message to multiple users by firebase registration ids
	public function sendMultiple($registration_ids, $message) {
		$fields = array(
			'to' => $registration_ids,
			'data' => $message,
		);
		
		return $this->sendPushNotification($fields);
	}
	
	public function key(){
		define('FIREBASE_API_KEY', 'AAAA9joGPBA:APA91bEvyBh9163s2DH8r7MH4pZQvj59wHze5Cml8MW6bC1MFRUg6dfoB6nRn7iPkjDCh3AC7KlYg7ourJPrgfPKwc-ZYHFD1NrufP9Peq8VAcBT3MTtAfYkQTcL-6cQyJW7Vgn4XbZxUUk6eECO34y3UN0rpmpmaw');
	}
	
	// function makes curl request to firebase servers
	
	
	public function send_notification($fields){
		$this->key();
		//print_r($fields);
		//echo FIREBASE_API_KEY;
		
		$url = 'https://fcm.googleapis.com/fcm/send';
		$priority="high";
		$notification= array(
			'type'=> $fields['data']['type'],
			'title' => $fields['data']['title'],
			'message' => $fields['data']['message'],
			'timestamp'=> date('Y-m-d H:i:s'),
			'image'=> $fields['data']['image'],
			'payload'=> $fields['payload'],
		);
		
		$fields = array(
			'to' => $fields['to'],
			'data' =>array(
				'data'=>$notification
			)
		);
		
		$headers = array(
			'Authorization:key='.FIREBASE_API_KEY,
			'Content-Type: application/json'
		);
		
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt ($ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
		// echo json_encode($fields);
		$result = curl_exec($ch);
		echo curl_error($ch);
		if ($result === FALSE) {
			die('Curl failed: ' . curl_error($ch));
		}
		curl_close($ch);
		return $result;
		
		$tokens = array('RECEIVER-TOKEN-1'
		,'RECEIVER_TOKEN-2');
	}
	
	
	
	
	
	public function send_topic_notification($fields){
		$this->key();
		//print_r($fields);
		
		
		$url = 'https://fcm.googleapis.com/fcm/send';
		$priority="high";
		$notification= array(
			'title' => $fields['data']['title'],
			'message' => $fields['data']['message'],
			'timestamp'=> date('Y-m-d H:i:s'),
			'image'=> $fields['data']['image'],
			'payload'=> $fields['payload'],
		);
		
		$fields = array(
			'to' => $fields['to'],
			'data' =>array(
				'data'=>$notification
			)
		);
		
		$headers = array(
			'Authorization:key='.FIREBASE_API_KEY,
			'Content-Type: application/json'
		);
		
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt ($ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
		// echo json_encode($fields);
		$result = curl_exec($ch);
		echo curl_error($ch);
		if ($result === FALSE) {
			die('Curl failed: ' . curl_error($ch));
		}
		curl_close($ch);
		return $result;
		
		$tokens = array('RECEIVER-TOKEN-1'
		,'RECEIVER_TOKEN-2');
	}
}
?>