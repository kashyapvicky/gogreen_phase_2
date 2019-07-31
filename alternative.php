<?php 
//echo"testing";die;   
$key = "7fb80757-7b24-4355-8955-7e6cfea3344c";    
$secret = "2kIJ9HiXUE63ytSY/09fog=="; 
$phone_number = "+919034195001";
	 
$user = "application\\" . $key . ":" . $secret;    
$message = array("message"=>"Test");    
$data = json_encode($message);    
$ch = curl_init('https://messagingapi.sinch.com/v1/sms/' . $phone_number);    
curl_setopt($ch, CURLOPT_POST, true);    
curl_setopt($ch, CURLOPT_USERPWD,$user);    
curl_setopt($ch, CURLOPT_POSTFIELDS, $data);    
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);    
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);    
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));    
	
$result = curl_exec($ch);    
	
if(curl_errno($ch)) {    
    echo 'Curl error: ' . curl_error($ch);    
} else {    
    echo $result;    
}   
	 
curl_close($ch);    
	
//text local api



?> 