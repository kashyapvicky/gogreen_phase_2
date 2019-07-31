<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//require(APPPATH.'/libraries/REST_Controller.php');

class Orders_api extends MY_Controller
{

	
	function __construct()
    {
    	//echo"hi";die;

		parent::__construct();
		$this->load->model('orders_api_model');
		//$this->load->model('standard_model');
		//responseconstant
		$this->load->model('responseconstant');


		$crone_url =  base_url(uri_string());
		$this_url =  base_url()."orders_api/today_all_task";
		//echo $this_url; die;
		if($crone_url == $this_url)
		{
			$this->today_all_task();
		}
		else
		{

	
			$postData =  file_get_contents('php://input');
			$postDataArray = json_decode($postData);
	       	if(!empty($postDataArray->method))
	       	{
	            $method = $postDataArray->method;
	            //echo $method; die; 
	            if(!empty($postDataArray->app_key))
	            {
	                //Verify AppKey
	                 $checkAppKey = $this->checkAppKey($postDataArray->app_key);
	                if (!$checkAppKey)
	                {
	                    $Code = ResponseConstant::UNSUCESS;
	                    $rescode = ResponseConstant::HEADER_UNAUTHORIZED;
	                    $Message = ResponseConstant::message('HEADER_UNAUTHORIZED');
	                    $this->sendResponse($Code,$rescode, $Message); // return data                                 
	                }
	            }
	            else
	            {
	                $Code = ResponseConstant::UNSUCCESS;
	                $rescode = ResponseConstant::APPKEY_NOT_FOUND;
	                $Message = ResponseConstant::message('APPKEY_NOT_FOUND');
	                $this->sendResponse($Code,$Message); // return data    
	            }
	        }
	        else
	        { 

	            $Code = ResponseConstant::UNSUCCESS;
	            $rescode = ResponseConstant::METHOD_NOT_FOUND;
	            $Message = ResponseConstant::message('METHOD_NOT_FOUND');
	            $this->sendResponse($Code,$Message); // return data      
	        }
	        switch($method)
	        { 
	            case 'get_orders':
	            $this->get_orders($postDataArray);
	            break;
	            case 'rate_cleaner':
	            $this->rate_cleaner($postDataArray);
	            break;
	            case 'get_order_package_detail':
	            $this->get_order_package_detail($postDataArray);
	            break;
	            case 'get_crew_detail':
	            $this->get_crew_detail($postDataArray);
	            break;
	            case 'send_todays_order_to_cleaner':
	            $this->send_todays_order_to_cleaner($postDataArray);
	            break;
	            case 'cleaner_job_done_detail':
	            $this->cleaner_job_done_detail($postDataArray);
	            break;
	            case 'get_past_task':
	            $this->get_past_task($postDataArray);
	            break;
	            case 'get_collected_payment_detail':
	            $this->get_collected_payment_detail($postDataArray);
	            break;
	            case 'update_payment_status':
	            $this->update_payment_status($postDataArray);
	            break;
	            case 'cleaner_dashboard':
	            $this->cleaner_dashboard($postDataArray);
	            break;
	            case 'get_car_activity':
	            $this->get_car_activity($postDataArray);
	            break;
	            case 'update_job_done_as_attendent':
	            $this->update_job_done_as_attendent($postDataArray);
	            break;
	        }
	    }
    }
    public function get_orders($postDataArray)
    {

    	$user_id = (isset($postDataArray->user_id) && !empty($postDataArray->user_id)) ? $postDataArray->user_id: '';
    	if(empty($user_id))
		{

			$Code = ResponseConstant::UNSUCCESS;
			$rescode = ResponseConstant::UNSUCCESS;
			$Message = ResponseConstant::message('REQUIRED_PARAMETER');
			$this->sendResponse($Code,$rescode,$Message);

		}
		else
		{
			$row = $this->orders_api_model->check_user_id($user_id);
			if($row)
			{
				// tabel included booked_packages,user_payment,car_detail;
				$orders['active_package'] = $this->orders_api_model->get_orders_by_user_id($user_id);
				$orders['expired_package'] = $this->orders_api_model->get_expired_orders_by_user_id($user_id);
				//print_r($orders); die;
				if($orders)
				{
					$Code = ResponseConstant::SUCCESS;
					$rescode = ResponseConstant::SUCCESS;
					$Message = "SUCCESS";
					$this->sendResponse($Code,$rescode,$Message,$orders);
				}
				else
				{
					$Code = ResponseConstant::UNSUCCESS;
					$rescode = ResponseConstant::UNSUCCESS;
					$Message = "ORDER NOT EXIST";
					$this->sendResponse($Code,$rescode,$Message);
				}

			}
			else
			{
				$Code = ResponseConstant::UNSUCCESS;
				$rescode = ResponseConstant::UNSUCCESS;
				$Message = 'USER ID DOES NOT EXIST';
				$this->sendResponse($Code,$rescode,$Message);
			}

			
		}

    }

	public function rate_cleaner($postDataArray)
	{
		$activity_id = (isset($postDataArray->activity_id) && !empty($postDataArray->activity_id)) ? $postDataArray->activity_id: '';
		$user_id = (isset($postDataArray->user_id) && !empty($postDataArray->user_id)) ? $postDataArray->user_id: '';
		$cleaner_id = (isset($postDataArray->cleaner_id) && !empty($postDataArray->cleaner_id)) ? $postDataArray->cleaner_id: '';
		$rating = (isset($postDataArray->rating) && !empty($postDataArray->rating)) ? $postDataArray->rating: '';
		$car_id = (isset($postDataArray->car_id) && !empty($postDataArray->car_id)) ? $postDataArray->car_id: '';
		$feedback = (isset($postDataArray->feedback) && !empty($postDataArray->feedback)) ? $postDataArray->feedback: '';
		$order_id = (isset($postDataArray->order_id) && !empty($postDataArray->order_id)) ? $postDataArray->order_id: '';
		if(empty($user_id) || empty($cleaner_id) || empty($rating) || empty($car_id) || empty($order_id) || empty($activity_id))
		{

			$Code = ResponseConstant::UNSUCCESS;
			$rescode = ResponseConstant::UNSUCCESS;
			$Message = ResponseConstant::message('REQUIRED_PARAMETER');
			$this->sendResponse($Code,$rescode,$Message);

		}
		else
		{
			$row = $this->orders_api_model->check_cleaner_existence($cleaner_id);
			if($row)
			{
				$already_rated = $this->orders_api_model->check_if_user_already_rated($activity_id);
				if($already_rated)
				{	
					$Code = ResponseConstant::SUCCESS;
					$rescode = 0;
					$Message = "CLEANER ALREADY RATED";
					$this->sendResponse($Code,$rescode,$Message);
				}
				else
				{					
					// $data = array(
					// 'rate_by_user'=>$user_id,
					// //'rating'=>'rating+'.$rating.'',
					// 'car_id'=>$car_id,
					// 'feedback'=>$feedback,
					// 'order_id'=>$order_id,
					// );
					$bool = $this->orders_api_model->update_cleaners_rating_info($feedback,$activity_id);
							$this->orders_api_model->increment_to_rating_and_count_column($cleaner_id,$rating);
							//$this->orders_api_model->update_status_as_activity_rated($activity_id);
							// echo $this->db->last_query(); die;
					if($bool)
					{
						$Code = ResponseConstant::SUCCESS;
						$rescode = ResponseConstant::SUCCESS;
						$Message = "SUCCESS";
						$this->sendResponse($Code,$rescode,$Message);
					}
					else
					{
						$Code = ResponseConstant::UNSUCCESS;
						$rescode = ResponseConstant::UNSUCCESS;
						$Message = "ERROR IN UPDATION";
						$this->sendResponse($Code,$rescode,$Message);
					}
				}
			}
			else
			{
				$Code = ResponseConstant::UNSUCCESS;
				$rescode = ResponseConstant::UNSUCCESS;
				$Message = "CLEANER NOT EXIST";
				$this->sendResponse($Code,$rescode,$Message);
			}

			
		}

	}
	public function get_order_package_detail($postDataArray)
	{
		$user_id = (isset($postDataArray->user_id) && !empty($postDataArray->user_id)) ? $postDataArray->user_id: '';
		$order_id = (isset($postDataArray->order_id) && !empty($postDataArray->order_id)) ? $postDataArray->order_id: '';
		$car_id = (isset($postDataArray->car_id) && !empty($postDataArray->car_id)) ? $postDataArray->car_id: '';
		if(empty($user_id) || empty($order_id) || empty($car_id) )
		{

			$Code = ResponseConstant::UNSUCCESS;
			$rescode = ResponseConstant::UNSUCCESS;
			$Message = ResponseConstant::message('REQUIRED_PARAMETER');
			$this->sendResponse($Code,$rescode,$Message);
		}
		else
		{
			//$this->orders_api_model->check_user_packege($user_id)
			$row = $this->orders_api_model->get_package_detail($user_id,$car_id,$order_id);
			// echo $this->db->last_query(); die;
			if($row)
			{
				$Code = ResponseConstant::SUCCESS;
				$rescode = ResponseConstant::SUCCESS;
				$Message = "SUCCESS";
				$this->sendResponse($Code,$rescode,$Message,array($row));
			}
			else
			{
				$Code = ResponseConstant::UNSUCCESS;
				$rescode = ResponseConstant::UNSUCCESS;
				$Message = "USER ID NOT EXIST";
				$this->sendResponse($Code,$rescode,$Message);
			}
		}
	}

	public function get_crew_detail($postDataArray)
	{
		$user_id = (isset($postDataArray->user_id) && !empty($postDataArray->user_id)) ? $postDataArray->user_id: '';
		$order_id = (isset($postDataArray->order_id) && !empty($postDataArray->order_id)) ? $postDataArray->order_id: '';
		$car_id = (isset($postDataArray->car_id) && !empty($postDataArray->car_id)) ? $postDataArray->car_id: '';


		if(empty($user_id) || empty($order_id) || empty($car_id) )
		{

			$Code = ResponseConstant::UNSUCCESS;
			$rescode = ResponseConstant::UNSUCCESS;
			$Message = ResponseConstant::message('REQUIRED_PARAMETER');
			$this->sendResponse($Code,$rescode,$Message);

		}
		else
		{
			$all_crew = $this->orders_api_model->get_cleaners_detail_of_assiagned_team($user_id,$order_id,$car_id);
			if($all_crew)
			{
				$Code = ResponseConstant::SUCCESS;
				$rescode = ResponseConstant::SUCCESS;
				$Message = "SUCCESS";
				$this->sendResponse($Code,$rescode,$Message,$all_crew);
			}
			else
			{
				$Code = ResponseConstant::UNSUCCESS;
				$rescode = ResponseConstant::UNSUCCESS;
				$Message = "ERROR IN GETTING CREW DETAIL";
				$this->sendResponse($Code,$rescode,$Message,$all_crew);
			}
		}


	}
	public function send_todays_order_to_cleaner($postDataArray)
	{
		$cleaner_id = (isset($postDataArray->cleaner_id) && !empty($postDataArray->cleaner_id)) ? $postDataArray->cleaner_id: '';
		if(empty($cleaner_id))
		{
			$Code = ResponseConstant::UNSUCCESS;
			$rescode = ResponseConstant::UNSUCCESS;
			$Message = ResponseConstant::message('REQUIRED_PARAMETER');
			$this->sendResponse($Code,$rescode,$Message);
		}

		$car_details = $this->orders_api_model->get_order_id_by_cleaner_id($cleaner_id);
		//echo "<pre>";print_r($car_details); die;
		$current_day =  date('D');
		$current_date = date('Y-m-d');
		$todays_data = array();
		foreach ($car_details as $key => $value)
		{
			$car_id =$value['car_id'];

			if($value['package_type'] == 'monthly')
			{
				//echo"current_days";die;
				$days_array = explode(',',$value['days']);
				//print_r($days_array); die;
				if(in_array($current_day, $days_array))
				{
					$row = $this->orders_api_model->check_car_already_cleaned($car_id);

					//if $row is found means car is cleaned by atleast one cleane on current date

					if(empty($row))
					{
						// respondent row is found when this cleaner already responed for the same
						$respondent_row = $this->orders_api_model->check_is_car_respondent_by_this_cleaner($car_id,$cleaner_id);
						if(empty($respondent_row))
						{
							$todays_data[] =$value;
						}
						//$todays_data[]=$value;
					}
					// $attend_status = (int)$row['attendent'];
					// $tbl_cleaner_id = $row['tbl_cleaner_id'];
					// echo $attend_status;
					// echo"<br>";
					// echo $tbl_cleaner_id;
					// echo"<br>";
					// echo $cleaner_id;
					// echo"<br>";					
				}
			}
			else
			{
				if($current_date ==$value['one_time_service_date'])
				{
					$row = $this->orders_api_model->check_car_already_cleaned($car_id);

					//if $row is found means car is cleaned by atleast one cleane on current date

					if(empty($row))
					{
						// respondent row is found when this cleaner already responed for the same
						$respondent_row = $this->orders_api_model->check_is_car_respondent_by_this_cleaner($car_id,$cleaner_id);
						if(empty($respondent_row))
						{
							$todays_data[] =$value;
						}
						//$todays_data[]=$value;
					}
					// $attend_status = (int)$row['attendent'];
					// $tbl_cleaner_id = $row['tbl_cleaner_id'];
					// if(!empty($row))
					// {
					// 	foreach ($row as $key => $values)
					// 	{
					// 		if($values['attendent']==2 && $values['tbl_cleaner_id']!==$cleaner_id)
					// 		{
					// 			// echo $values['tbl_cleaner_id'];
					// 			// echo"<br>";
					// 			// echo $cleaner_id;
					// 			// echo"<br>";

					// 			// print_r($row); die;
					// 			echo $values['tbl_cleaner_id'];
					// 			echo"<br>";
					// 			echo $cleaner_id;die;
					// 			$todays_data[] =$value;
					// 		}
					// 	}

					// }
					// else
					// {
					// 	$todays_data[] =$value;
					// }
				} 
			}						
		} 

			$Code = ResponseConstant::SUCCESS;
			$rescode = ResponseConstant::SUCCESS;
			$Message = "SUCCESS";
			$this->sendResponse($Code,$rescode,$Message,$todays_data);
	}
	public function cleaner_job_done_detail($postDataArray)
	{
		$cleaner_id = (isset($postDataArray->cleaner_id) && !empty($postDataArray->cleaner_id)) ? $postDataArray->cleaner_id: '';
		$team_id = (isset($postDataArray->team_id) && !empty($postDataArray->team_id)) ? $postDataArray->team_id: '';
		$payment_key = (isset($postDataArray->payment_key) && !empty($postDataArray->payment_key)) ? $postDataArray->payment_key: '';
		$package_type = (isset($postDataArray->package_type) && !empty($postDataArray->package_type)) ? $postDataArray->package_type: '';
		$user_id = (isset($postDataArray->user_id) && !empty($postDataArray->user_id)) ? $postDataArray->user_id: '';
		$car_id = (isset($postDataArray->car_id) && !empty($postDataArray->car_id)) ? $postDataArray->car_id: '';
		$attendent = (isset($postDataArray->attendent) && !empty($postDataArray->attendent)) ? $postDataArray->attendent: '';
		$reason = (isset($postDataArray->reason) && !empty($postDataArray->reason)) ? $postDataArray->reason: '';
		$service_type = (isset($postDataArray->service_type) && !empty($postDataArray->service_type)) ? $postDataArray->service_type: '';


		//$car_id = (isset($postDataArray->car_id) && !empty($postDataArray->car_id)) ? $postDataArray->car_id: '';	
		if(empty($cleaner_id) || empty($team_id) || empty($payment_key) || empty($package_type) || empty($user_id)  || empty($car_id) || empty($attendent) || empty($service_type) )
		{

			$Code = ResponseConstant::UNSUCCESS;
			$rescode = ResponseConstant::UNSUCCESS;
			$Message = ResponseConstant::message('REQUIRED_PARAMETER');
			$this->sendResponse($Code,$rescode,$Message);

		}
		else
		{
			$date = date('Y-m-d');
			//echo $date; die;
			$data = array(
				'cleaner_id'=>$cleaner_id,
				'user_id'=>$user_id,
				'payment_key'=>$payment_key,
				'package_type'=>$package_type,
				'week_day'=>date('D'),
				'job_done_date'=>$date,
				'team_id'=>$team_id,
				'car_id'=>$car_id,
				'attendent'=>$attendent,
				'reason'=>$reason,
				'services'=>$service_type
			);
			$insert_id = $this->orders_api_model->insert_done_job_data($data);
			//$insert_id = $this->orders_api_model->update_done_job_data($data,$car_id);
			if ($insert_id)
			{
				$Code = ResponseConstant::SUCCESS;
				$rescode = ResponseConstant::SUCCESS;
				$Message = "SUCCESS";
				$this->sendResponse($Code,$rescode,$Message);
				
			}
			else
			{
				$Code = ResponseConstant::UNSUCCESS;
				$rescode = ResponseConstant::UNSUCCESS;
				$Message = "ERROR IN INSERTION";
				$this->sendResponse($Code,$rescode,$Message);
			}
		}
	}
	public function get_past_task($postDataArray)
	{

		$cleaner_id = (isset($postDataArray->cleaner_id) && !empty($postDataArray->cleaner_id)) ? $postDataArray->cleaner_id: '';
		'';	
		if(empty($cleaner_id) )
		{

			$Code = ResponseConstant::UNSUCCESS;
			$rescode = ResponseConstant::UNSUCCESS;
			$Message = ResponseConstant::message('REQUIRED_PARAMETER');
			$this->sendResponse($Code,$rescode,$Message);

		}
		else
		{
			$past_detail = $this->orders_api_model->get_cleaner_job_done_detail($cleaner_id);
			if($past_detail)
			{
				$Code = ResponseConstant::SUCCESS;
				$rescode = ResponseConstant::SUCCESS;
				$Message ="SUCCESFULL";
				$this->sendResponse($Code,$rescode,$Message,$past_detail);
			}
			else
			{
				$Code = ResponseConstant::UNSUCCESS;
				$rescode = ResponseConstant::UNSUCCESS;
				$Message = "PAST DETAIL DOES NOT EXIT";
				$this->sendResponse($Code,$rescode,$Message);
			}

		}
	}

	public function get_collected_payment_detail($postDataArray)
	{
		$cleaner_id = (isset($postDataArray->cleaner_id) && !empty($postDataArray->cleaner_id)) ? $postDataArray->cleaner_id: '';

		if(empty($cleaner_id) )
		{

			$Code = ResponseConstant::UNSUCCESS;
			$rescode = ResponseConstant::UNSUCCESS;
			$Message = ResponseConstant::message('REQUIRED_PARAMETER');
			$this->sendResponse($Code,$rescode,$Message);

		}
		else
		{
			$orders_array = $this->orders_api_model->get_assiagned_order_payment($cleaner_id);
			//print_r($orders_array); die;
			if($orders_array)
			{
				$Code = ResponseConstant::SUCCESS;
				$rescode = ResponseConstant::SUCCESS;
				$Message ="SUCCESFULL";
				$this->sendResponse($Code,$rescode,$Message,$orders_array);
			}
			else
			{
				$Code = ResponseConstant::UNSUCCESS;
				$rescode = ResponseConstant::UNSUCCESS;
				$Message ="NO COD ORDER AVALIABLE";
				$this->sendResponse($Code,$rescode,$Message,$orders_array);
			}
		}
	}

	public function update_payment_status($postDataArray)
	{
		$cleaner_id = (isset($postDataArray->cleaner_id) && !empty($postDataArray->cleaner_id)) ? $postDataArray->cleaner_id: '';
		$id = (isset($postDataArray->id) && !empty($postDataArray->id)) ? $postDataArray->id: '';
		$partial_cash = (isset($postDataArray->partial_cash) && !empty($postDataArray->partial_cash)) ? $postDataArray->partial_cash: '';
		// this id is primary id of user_payment_tabel and its foriegn name is payment_key 
		if(empty($cleaner_id) || empty($id) || empty($partial_cash))
		{
			$Code = ResponseConstant::UNSUCCESS;
			$rescode = ResponseConstant::UNSUCCESS;
			$Message = ResponseConstant::message('REQUIRED_PARAMETER');
			$this->sendResponse($Code,$rescode,$Message);
		}
		else
		{
			$row = $this->orders_api_model->check_payment_status($id);
			$status = $row['status'];
			if($status == 2)
			{
				$Code = ResponseConstant::SUCCESS;
				$rescode = ResponseConstant::SUCCESS;
				$Message = "PAYMENT ALREADY COLLECTED";
				$this->sendResponse($Code,$rescode,$Message);
			}
			else
			{
				$data=array(
					'cleaner_id'=>$cleaner_id,
					'payment_key'=>$id,
					'amount_collected'=>$partial_cash
				);
				$insert_id = $this->orders_api_model->insert_to_payment_collected($data);
				if($insert_id)
				{
					$bool = $this->orders_api_model->insert_collected_amount($id,$partial_cash);
					if($bool)
					{
						$row = $this->orders_api_model->get_net_paid_and_partial_paid_amount($id);
						if($row['partial_payment']>=$row['net_paid'])
						{
							$this->orders_api_model->update_status_of_order_payment($id);
							$Code = ResponseConstant::SUCCESS;
							$rescode = ResponseConstant::SUCCESS;
							$Message = "STATUS UPDATED";
							$this->sendResponse($Code,$rescode,$Message);
						}
						else
						{
							// status not changed but partial payment is insertd because complete payment is not recieved yet
							$Code = ResponseConstant::SUCCESS;
							$rescode = ResponseConstant::SUCCESS;
							$Message = "STATUS NOT CHANGED";
							$this->sendResponse($Code,$rescode,$Message);
						}
					}
					else
					{
						//when partial collected payment is not increment in user_payment tabel
						$Code = ResponseConstant::UNSUCCESS;
						$rescode = ResponseConstant::UNSUCCESS;
						$Message = "PAYMENT NOT INSERTED";
						$this->sendResponse($Code,$rescode,$Message);
					}
					

				}
				else
				{
					$Code = ResponseConstant::UNSUCCESS;
					$rescode = ResponseConstant::UNSUCCESS;
					$Message = "STATUS NOT CHANGED";
					$this->sendResponse($Code,$rescode,$Message);
				}
			}
		}
	}
	public function cleaner_dashboard($postDataArray)
	{

		$cleaner_id = (isset($postDataArray->cleaner_id) && !empty($postDataArray->cleaner_id)) ? $postDataArray->cleaner_id: '';
		if(empty($cleaner_id))
		{
			$Code = ResponseConstant::UNSUCCESS;
			$rescode = ResponseConstant::UNSUCCESS;
			$Message = ResponseConstant::message('REQUIRED_PARAMETER');
			$this->sendResponse($Code,$rescode,$Message);
		}
		$car_details = $this->orders_api_model->get_order_id_by_cleaner_id($cleaner_id);
		//echo "<pre>";print_r($car_details); die;
		$current_day =  date('D');
		$current_date = date('Y-m-d');
		$todays_data = array();
		$count = 0;
		foreach ($car_details as $key => $value)
		{
			$car_id =$value['car_id'];

			if($value['package_type'] == 'monthly')
			{
				$days_array = explode(',',$value['days']);
				if(in_array($current_day, $days_array))
				{
					// $row = $this->orders_api_model->check_car_already_cleaned($car_id,$cleaner_id);
					// if(!$row)
					// {

						$todays_data[] =$value;
						$count++;
					//}						
				}

			}
			else
			{
				if($current_date ==$value['one_time_service_date'])
				{
					// $row = $this->orders_api_model->check_car_already_cleaned($car_id,$cleaner_id);
					// if(!$row)
					// {
						$todays_data[] =$value;
						$count++;
					//}	
				} 
			}
		}
		$dashboard['today']=$count;
		$completed_job=$this->orders_api_model->get_completed_job_count($cleaner_id);
		$dashboard['completed'] = $completed_job;
		// $today_completed = $this->orders_api_model->get_today_completed_job($cleaner_id);
		// $today_completed_count = count($today_completed);
		// foreach ($today_completed as $key => $comp)
		// {
		// 	//print_r($comp); die;

		// 	if($comp['attendent']==2)
		// 	{
		// 		$done_car_row = $this->orders_api_model->check_this_car_done_by_others($comp['car_id'],$cleaner_id);
		// 		//print_r($done_car_row); die;
		// 		if($done_car_row)
		// 		{
		// 			//echo"here";die;
		// 			$today_completed_count++;
		// 		}
		// 	}

		// }
		//die;
		//echo $today_completed_count; die;
		$dashboard['remaining']=$count-$completed_job;
		$basick_info = $this->orders_api_model->get_basick_info($cleaner_id);
		$dashboard['basick_info'] = $basick_info;

		$Code = ResponseConstant::SUCCESS;
		$rescode = ResponseConstant::SUCCESS;
		$Message = "SUCCESS";
		$this->sendResponse($Code,$rescode,$Message,$dashboard);

		//print_r($dashboard); die;
	}

	public function get_car_activity($postDataArray)
	{
		$id = (isset($postDataArray->id) && !empty($postDataArray->id)) ? $postDataArray->id: '';
		$car_id = (isset($postDataArray->car_id) && !empty($postDataArray->car_id)) ? $postDataArray->car_id: '';
		if(empty($id) || empty($car_id))
		{
			$Code = ResponseConstant::UNSUCCESS;
			$rescode = ResponseConstant::UNSUCCESS;
			$Message = ResponseConstant::message('REQUIRED_PARAMETER');
			$this->sendResponse($Code,$rescode,$Message);
		}
		else
		{

			$cleaners_count_row=$this->orders_api_model->get_number_of_cleaners_by_order_id($id);
			//print_r($cleaners_count_row); die;
			if(!empty($cleaners_count_row))
			{
				// total cleaner count  on given order 
				$total_cleaner_on_assiagned_team = $cleaners_count_row['cleaner_count'];
				//echo $total_cleaner_on_assiagned_team; die;

				$response_1 = $this->orders_api_model->get_car_detail($id,$car_id);
				$date=array();

				if(!empty($response_1))
				{
					foreach ($response_1 as $key => $value)
					{
						$date[]=$value['job_done_date'];
					}
				}
				//print_r($date); die;
				$response_2 = $this->orders_api_model->get_car_detail_2($id,$car_id,$date);
				$not_attendent_array= array();
				if(!empty($response_2))
				{
					foreach ($response_2 as $keys => $val)
					{
						if($val['not_attendent_count']>=$total_cleaner_on_assiagned_team)
						{
							$not_attendent_array[]=$response_2[$keys];
						}
					}
				}
				$response = array_merge($response_1,$not_attendent_array);

				if($response)
				{
					$Code = ResponseConstant::SUCCESS;
					$rescode = ResponseConstant::SUCCESS;
					$Message = "SUCCESS";
					$this->sendResponse($Code,$rescode,$Message,$response);
				}
				else
				{
					$Code = ResponseConstant::UNSUCCESS;
					$rescode = ResponseConstant::UNSUCCESS;
					$Message = "DATA DOES NOT EXIST";
					$this->sendResponse($Code,$rescode,$Message,$response);
				}
			}//here
			else
			{
				$Code = ResponseConstant::SUCCESS;
				$rescode = ResponseConstant::SUCCESS;
				$Message = "NO CLEANER EXIST ON TEAM";
				$this->sendResponse($Code,$rescode,$Message,$response);
			}
			
		}
	}

	public function today_all_task()
	{
		//echo "dfs"; die;
		$tasks = $this->orders_api_model->get_all_todays_task();
		 //echo"<pre>";print_r($tasks); die;
		$todays_task = array();
		foreach ($tasks as $key => $value)
		{
			if($value['package_type']=='monthly')
			{
				$days_array = explode(',', $value['days']);
				//print_r( $days_array);
				$current_day = date('D');
				if(in_array($current_day,$days_array))
				{
					//echo"exist";die;
					//echo $current_day;die;
					$todays_task[] = $value;
				}	
			 //echo"<pre>";print_r($todays_task); die;
			}
			else
			{
				//print_r($tasks); die;
				$current_date = date('Y-m-d');
				if($current_date == $value['one_time_service_date'])
				{
					$todays_task[] = $value;
				}
			}	//
			
		}
		//echo"<pre>";print_r($todays_task);die;
		if(!empty($todays_task))
		{
			$current_date = date('Y-m-d');
			foreach ($todays_task as $key => $value)
			{
				$current_day = date('D');
				$data = array
				(
					'car_id'=>$value['car_id'],
					'week_day'=>$current_day,
					'team_id'=>$value['team_id'],
					'attendent'=>0,
					'package_type'=>$value['package_type'],
					'services '=>$value['services'],
					'payment_key'=>$value['payment_key'],
					'user_id'=>$value['user_id']
				);
				$row = $this->orders_api_model->check_this_car_cleaned_or_not($value['car_id']);
				if($row)
				{
					//return false;
					echo "1";
				}
				else
				{
					// get all cleaner of the team
					$cleaners_array = $this->orders_api_model->get_all_cleaner_of_the_team($value['team_id']);
					foreach ($cleaners_array as $arrays_key => $arrays_value)
					{

						$cleaner_id = $arrays_value['cleaner_id'];
						$responded_row = $this->orders_api_model->check_this_cleaner_responded_or_not($cleaner_id,$value['car_id']);
						//echo $this->db->last_query(); die;
                                               // echo"<pre>";print_r($responded_row);//die;
						if($responded_row)
						{
							echo "1";
						}
						else
						{
                                                  //  echo "csd";
							$ignored_car_data= array
							(
								'car_id'=>$value['car_id'],
								'cleaner_id'=>$cleaner_id,
								'week_day'=>$current_day,
								'team_id'=>$value['team_id'],
								'attendent'=>2,
								'job_done_date'=>$current_date,
								'package_type'=>$value['package_type'],
								'services '=>$value['services'],
								'payment_key'=>$value['payment_key'],
								'reason'=> 'car ignored by cleaner',
								'user_id'=>$value['user_id']

							);
							$insert_id = $this->orders_api_model->car_ignored_by_this_cleaner_data_insert($ignored_car_data);
						}
					}
//die;
					//$bool = $this->orders_api_model->insert_ignored_car($data);
					//echo $this->db->last_query(); die;
				}
				
			}
                     //   echo $insert_id; die;
			if(!empty($insert_id) && isset($insert_id))
			{
				echo "todays task succesfully inserted to database";
			}
		}

		else
		{
			echo "NO task found for today";
		}	
	}

	public function update_job_done_as_attendent($postDataArray)
	{
		$id = (isset($postDataArray->id) && !empty($postDataArray->id)) ? $postDataArray->id: '';
		$job_done_date = (isset($postDataArray->job_done_date) && !empty($postDataArray->job_done_date)) ? $postDataArray->job_done_date: '';
		$feedback = (isset($postDataArray->feedback) && !empty($postDataArray->feedback)) ? $postDataArray->feedback: '';
		$attendent = (isset($postDataArray->attendent) && !empty($postDataArray->attendent)) ? $postDataArray->attendent: '';

		if(empty($id) || empty($job_done_date) || empty($attendent))
		{
			$Code = ResponseConstant::UNSUCCESS;
			$rescode = ResponseConstant::UNSUCCESS;
			$Message = ResponseConstant::message('REQUIRED_PARAMETER');
			$this->sendResponse($Code,$rescode,$Message);
		}
		else

		{
			$data =array('job_done_date'=>$job_done_date,'feedback'=>$feedback,'attendent'=>$attendent);
			$bool = $this->orders_api_model->update_attendent_status($id,$data);
			if($bool)
			{
				$Code = ResponseConstant::SUCCESS;
				$rescode = ResponseConstant::SUCCESS;
				$Message = "SUCCESS";
				$this->sendResponse($Code,$rescode,$Message);
			}
			else
			{
				$Code = ResponseConstant::UNSUCCESS;
				$rescode = ResponseConstant::UNSUCCESS;
				$Message = "ERROR IN UPDATION";
				$this->sendResponse($Code,$rescode,$Message);
			}
		}

	}

}
			