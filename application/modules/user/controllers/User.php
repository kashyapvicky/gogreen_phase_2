<?php
defined('BASEPATH') OR exit('No direct script access allowed');




class User extends MX_Controller {

	function __construct()
    {
		parent::__construct();
		$this->load->model('user_model');
		$bool = $this->session->userdata('authorized');
		if($bool != 1)
		{
			//echo $bool; die;
			redirect('admin');
		}
	}
	public function index()
	{
    $users = $this->user_model->get_all_users();
	//echo "<pre>";print_r($users);die;
    $data['users'] =$users;
    $data['page'] ='user_view';
		//$this->template->load('template', 'user_view',$data);
		_layout($data);
	}

	public function get_user_car_details()
	{
		$id = $this->input->get('id');;
		$car_detail = $this->user_model->get_car_details($id);

		$user_personal_detail = $this->user_model->get_user_detai($id);
		$data['personal_detail'] = $user_personal_detail;

		//echo "<pre>";print_r($car_detail);die;
		$data['user_id'] = $id;
		$data['user_detail'] = $car_detail;
		 $data['page'] ='user_car_view';
		//$this->template->load('template', 'user_view',$data);
		_layout($data);
		//$this->template->load('template', 'user_car_view',$data);
		//echo "<pre>";print_r($car_detail); die;
	}

	public function get_user_balance_details()
	{
		$id = $this->input->get('id');
		$user_personal_detail = $this->user_model->get_user_detai($id);
		$data['personal_detail'] = $user_personal_detail;

		//echo "<pre>";print_r($car_detail);die;

		$orders_ledger = $this->user_model->get_orders_ledger($id);
		//echo $this->db->last_query(); die;
		$data['ledger'] = $orders_ledger;

		$data['user_id'] = $id;
		 $data['page'] ='account_detail';
		//$this->template->load('template', 'user_view',$data);
		_layout($data);
		//$this->template->load('template', 'user_car_view',$data);
		//echo "<pre>";print_r($car_detail); die;
	}
	public function purchase_history()
	{
		$id= $this->input->get('id');
		$user_id= $this->input->get('u_id');
		$row = $this->user_model->get_purchase_history($id,$user_id);
		$data['purchase_history'] = $row;
		$data['page'] ='purchase_history';
		_layout($data);

		//$this->template->load('template', 'purchase_history',$data);
	}
	public function delete_user()
	{
		$user_id = $this->input->get('id');
		if($user_id)
		{
			$bool = $this->user_model->update_status_as_inactive($user_id);
			if($bool)
			{
				$this->session->set_flashdata('user_deleted','User Deleted Succesfully');
				redirect('user');
			}
			else
			{
				$this->session->set_flashdata('user_deleted','Error In Deletion');
				redirect('user');

			}
		}
		else
		{
			$this->session->set_flashdata('get_error','Id Not Found');
			redirect('user');
		}
	}
	public function excel_export()
	{

		$users = $this->user_model->get_all_users_for_excel();
		//echo $this->db->last_query(); die;
		// echo"<pre>";print_r($users); 
		// // $data[] = array('x'=> 1, 'y'=> 2, 'z'=> 2, 'a'=> 4);
		// header("Content-type: application/csv");
		// header("Content-Disposition: attachment; filename=\"test".".csv\"");
		// header("Pragma: no-cache");
		// header("Expires: 0");

		// $handle = fopen('php://output', 'w');

		// foreach ($users as $data) {
		// fputcsv($handle, $data);
		// }
		// fclose($handle);
		// exit;
		$heading = 'User Report';
		$count = 1;
      header('Content-Type: text/csv; charset=utf-8');
      header('Content-Disposition: attachment; filename=' . $heading . '.csv');
      $output = fopen('php://output', 'w');
      fputcsv($output, array('Sr.no','Date','Name','Phone Number','Email','City','locality','Street','Appt_no','Car Brand','Car Model','Plate No','Color','Package','Status','Amount','Comment'));
		foreach ($users as $key => $value)
		{
			if($value['status']==2)
			{
				$status = "Collected";
			}
			elseif($value['status']==1)
			{
				$status = "Pending";
			}
			else
			{
				$status == "";
			}
		$arr['Sr.no'] = $count;
		$arr['Date'] = $value['created_at'];
		$arr['Name'] = $value['name'];
		$arr['Phone_Number'] = $value['phone_number'];
		$arr['Email'] = $value['email'];
		$arr['City'] = $value['city'];
		$arr['Locality'] = $value['locality'];
		$arr['Street'] = $value['street'];
		$arr['appt_no'] = $value['apartment_number'];
		$arr['Brand'] = $value['brand'];
		$arr['Model'] = $value['model'];
		$arr['Plate_no'] = $value['reg_no'];
		$arr['Color'] = $value['color'];
		$arr['Package'] = $value['package_name'];
		$arr['Payment_Status'] = $status;
		$arr['Amount'] = $value['amount'];
		$arr['Coment'] = "";

		fputcsv($output, $arr);
		$count++;
		}
		fclose($output);
		exit;
	}



	public function filter_function()
	{
		$flag = $this->input->get('flag');
		if($flag==1)
		{
			redirect('user');
		}
		else
		{
			$users = $this->user_model->get_filtered_user($flag);
			$data['users'] =$users;
			$data['page'] ='user_view';
			//$this->template->load('template', 'user_view',$data);
			_layout($data);
		}
	}
	public function insert_write_off()
	{
		$user_id = $this->input->post('user_id_hidden');
		$write_off_amount = $this->input->post('write_off_amount');
		$reason = $this->input->post('reason');
		$data = array
		(
			'user_id'=>$user_id,
			'write_off_amt'=>$write_off_amount,
			'particulars'=>$reason,
			'credited_by'=>'admin',
			'created_at'=>date('Y-m-d'),
			'status'=>2
		);
		$insert_id = $this->user_model->insert_write_off($data);
		if($insert_id)
		{
			$this->session->set_flashdata('write_off_inserted','Data Inserted Succesfully');
		}
		else
		{
			$this->session->set_flashdata('write_off_inserted','Error In Insertion');
		}

			redirect(base_url('user/get_user_balance_details?id='.$user_id.''));
	}

	public function send_payment_link()
	{
		$user_id =$this->input->post('user_id_hidden');
		$link_amount =$this->input->post('link_amount');

		//echo $link_amount; die;

		$row = $this->user_model->get_user_detail($user_id);
		//$phone_number = +919034195001;
		$phone_number = $row['phone_number'];

		// sinch doc
		// $user_id=1;
		// $link_amount=550;
			$app_link = "http://13.126.99.14/gogreen/index.php/pay/topaytab?id=".$user_id."&amount=".$link_amount."";
			//$app_link = "https://gogreen.com/url/?id=".$user_id."&amount=".$link_amount."";

			$key = "43b7c518-5060-4118-9348-f8316f9be5e0";
			$secret = "K1zMMGiPG0WiA55nNd3xeA==";
			$phone_number = $phone_number;
			$user = "application\\" . $key . ":" . $secret;
			$message = array("message"=>"Dear Customer,
				please click on given link to make a payment against your order with go green in order to enjoy your services continously.
				".$app_link."");
			// gogreenpay.com?id=".$user_id."&amount=".$link_amount);
			//print_r($message); die;
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
			//echo $result;
			//echo "success";
				$this->session->set_flashdata('link_send','Payment link Succesfully Send to cusomers registerd mobile number');
				redirect(base_url('user/get_user_balance_details?id='.$user_id.''));
			}

			curl_close($ch);

		// sinch doc ends here
	} 

	public function stop_package()
	{

		$flag  = $this->input->get('flagg');
		$user_id = $this->input->get('id');
		$row = $this->user_model->get_device_token($user_id);
		$device_token = $row['device_token'];

		//echo $device_token; die;
		if($flag==2)
		{
			$bool  = $this->user_model->stop_user_service($user_id,$status=1);

			if($bool)
			{
				// send push to user
				
				if(!empty($device_token))
				{
					$message = "Dear Customer, Your Subscription Has been Renewed.";
					$user_name = 'Go Green';
					$title = 'Subscription renewed';
					$body = $message;  
					$notification = array('title' =>$title , 'body' => $body, 'sound' => 'default', 'badge' => '1');
					$arrayToSend = array('to' => $device_token, 'notification' => $notification,'priority'=>'high');
					$json = json_encode($arrayToSend);
					if(!empty($device_token))
					{ 
						$next_level=  $this->user_model->sendPush($json);
						print_r($next_level);
						// echo "hellllo";die;
					}
					else
					{
						echo "not working"; //die;
					}
				}

				$this->session->set_flashdata('stop_succs','Service Renew Succesfully');
				redirect('user');

			}
			else
			{
				$this->session->set_flashdata('stop_succs','Error In Renew Service');
				redirect('user');
			}
		}
		else
		{

			$bool  = $this->user_model->stop_user_service($user_id,$status=2);
			if($bool)
			{

				if(!empty($device_token))
				{
					$message = "Dear Customer, Your Subscription Has been cancelled.";
					$user_name = 'Go Green';
					$title = 'Subscription cancelled';
					$body = $message;  
					$notification = array('title' =>$title , 'body' => $body, 'sound' => 'default', 'badge' => '1');
					$arrayToSend = array('to' => $device_token, 'notification' => $notification,'priority'=>'high');
					$json = json_encode($arrayToSend);
					if(!empty($device_token))
					{ 
						$next_level=  $this->user_model->sendPush($json);
						print_r($next_level);
						// echo "hellllo";die;
					}
					else
					{
						//echo "not working"; die;
					}
				}
				$this->session->set_flashdata('stop_succs','Service Stopped Succesfully');
				redirect('user');

			}
			else
			{
				$this->session->set_flashdata('stop_succs','Error In Stop Service');
				redirect('user');
			}
		}
	} 

	function activate_user()
	{
		$id = $this->input->get('id');

		$bool = $this->user_model->activate_user_status($id);
		if($bool)
		{
			$this->session->set_flashdata('user_active','User activated');
		}
		else
		{
			$this->session->set_flashdata('user_active','Error in user activation');
		}

		redirect('user');
	}
}   
  

	

