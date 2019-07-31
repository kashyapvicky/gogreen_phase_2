<?php

/*
	


*/
defined('BASEPATH') OR exit('No direct script access allowed');
class Pay extends MX_Controller {


	function __construct()
    {
    	
		parent::__construct();
		$this->load->model('pay_model');
	}

	
	public function topaytab()
	{
		 $user_id = $this->input->get('id');
		 $amount = $this->input->get('amount');

		 $row = $this->pay_model->get_user_detail($user_id);
		 //echo $this->db->last_query(); die;
		 if(!empty($row))
		 {
			$name = $row['name'];
			$email = $row['email'];
			$phone_number = $row['phone_number'];

			$name = "vicky";
			$phone_number = "9034195001";
			$url="https://www.paytabs.com/apiv2/create_pay_page";


			$values["merchant_email"] =  "veee.kay258@gmail.com";
			$values['secret_key']        = "lYNdZmmGnixFJbPEsnR26hZQjG6wAtqWsd9rAw8YPGDyRtckQ4nXlnNF4UbEoCBQQLirhqp773FYxSjoWGlh39X748MsLniB9A2r" ;
			$values['site_url']          =    "http://13.126.99.14/gogreen/index.php/push_api/get_data_for_auto_renewal";
			$values['return_url']		="http://13.126.99.14/gogreen/index.php/pay/paytab_response";
			$values['title']             =    "Go Green";
			$values['cc_first_name']     =    $name;
			$values['cc_last_name']      =    "kashyap";
			$values['cc_phone_number']      =    "91";
			//customer phone number
			$values['phone_number']      =    $phone_number; 
			//customer emaial
			$values['email'] = $email;
			$values['products_per_title'] = "car wash package";
			$values['unit_price'] = $amount;
			$values['quantity'] = "1";
			$values['other_charges'] = "0";
			$values['amount'] = $amount;
			$values['discount']="0";
			$values['currency'] = "AED";
			$values['reference_no'] = "user_id-".$user_id."";
			$values['ip_customer'] = "13.126.99.14";
			$values['ip_merchant'] = "13.126.99.14";
			$values['billing_address'] = "Manama Bahrain";
			$values['state'] = "Manama";

			$values['city'] ="Manama";
			$values['postal_code'] = "12345";
			$values['country'] = "BHR";

			$values['shipping_first_name '] = $name;
			$values['shipping_last_name  '] = $name;
			$values['address_shipping']  =    "Flat 3021 Manama Bahrain" ;  
			$values['city_shipping']     =    "Manama"; 
			$values['state_shipping']    =    "Manama";
			$values['postal_code_shipping']=   "12345";
			$values['country_shipping']  =    "BHR";
			$values['msg_lang']  =    " English";
			$values['cms_with_version']  =    " PHP CODEIGNITER";


			$ch = curl_init();

			curl_setopt($ch, CURLOPT_URL,$url);
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS,$values);

			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

			$server_output = curl_exec($ch);

			$output = json_decode($server_output);
	        //$output = (array) $output;
	        curl_close ($ch);
	        $code =  $output->response_code;
	       
	            // echo $code; die;
	            
            if($code==4012)
            {
            	$transaction_id =  $output->p_id;


				$data = array
				(
					'user_id'=>$user_id,
					'write_off_amt'=>$amount,
					'particulars'=>'using payment link',
					'credited_by'=>'payment link',
					'created_at'=>date('Y-m-d'),
					'transaction_id'=>$transaction_id,
					'status'=>1
				);

				$insert_id = $this->pay_model->insert_write_off_entry($data);
            	$paytab_url =  $output->payment_url;
            	// echo"<script>
            	// window.open('".$paytab_url."');
            	// </script>
            	// ";
            	if($insert_id)
            	{
            		redirect($paytab_url);
            		
            	}
            	else
            	{
            		echo "Something Went Wrong. Please try later";
            	}
            	//echo"<a href='".$paytab_url."' target='_blank'>Click here to proceed</a>";
            }
            else
            {
            	print_r($server_output);
            }
		}
		else
		{
			echo "Invalid link";
		}
	}

	public function paytab_response()
	{
		//echo "payment succesfuill";
		if(!empty($_POST))
		{
			$transaction_id = $_POST['payment_reference'];

			$bool = $this->pay_model->update_status($transaction_id);

			if($bool)
			{
				echo "Your payment is completed succesfully";
			}
			else
			{
				echo "Your payment is completes but not updated to go green dashboard.Please  contact to go green admin immidiately";
			}

		}
		//print_r($_POST);
		//$this->input->get('user_id');

	} 
}
