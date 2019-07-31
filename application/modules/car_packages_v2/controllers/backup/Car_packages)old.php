<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//require(APPPATH.'/libraries/REST_Controller.php');

class Car_packages extends MY_Controller
{

	
	function __construct()
    {


		parent::__construct();
		$this->load->model('car_packages_model');
		//$this->load->model('standard_model');
		//responseconstant
		$this->load->model('responseconstant');
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
            case 'insert_car_detail':
            $this->insert_car_detail($postDataArray);
            break;
            case 'car_list':
            $this->car_list($postDataArray);
            break;
            case 'get_car_model':
            $this->get_car_model($postDataArray);
            break;
            case 'get_car_brand':
            $this->get_car_brand($postDataArray);
            break; 
            case 'add_brand':
            $this->add_brand($postDataArray);
            break;
            case 'add_model':
            $this->add_model($postDataArray);
            break;
            case 'package':
            $this->package($postDataArray);
            break;
            case 'insert_booked_services':
            $this->insert_booked_services($postDataArray);
            break;
            case 'upcoming_renewals':
            $this->upcoming_renewals($postDataArray);
            break;
        }
    }

	
	public function insert_car_detail($postDataArray)
	{
		//print_r($postDataArray);die;
		$user_id = (isset($postDataArray->user_id) && !empty($postDataArray->user_id)) ? $postDataArray->user_id: '';
		$city_id = (isset($postDataArray->city_id) && !empty($postDataArray->city_id)) ? $postDataArray->city_id: '';
		$locality_id = (isset($postDataArray->locality_id) && !empty($postDataArray->locality_id)) ? $postDataArray->locality_id: '';
		$street_id = (isset($postDataArray->street_id) && !empty($postDataArray->street_id)) ? $postDataArray->street_id: '';
		$brand = (isset($postDataArray->brand) && !empty($postDataArray->brand)) ? $postDataArray->brand: '';
		$model = (isset($postDataArray->model) && !empty($postDataArray->model)) ? $postDataArray->model: '';
		$reg_no = (isset($postDataArray->reg_no) && !empty($postDataArray->reg_no)) ? $postDataArray->reg_no: '';
		$color = (isset($postDataArray->color) && !empty($postDataArray->color)) ? $postDataArray->color: '';
		$parking_number = (isset($postDataArray->parking_number) && !empty($postDataArray->parking_number)) ? $postDataArray->parking_number: '';
		$apartment_number = (isset($postDataArray->apartment_number) && !empty($postDataArray->apartment_number)) ? $postDataArray->apartment_number: '';
		$car_type = (isset($postDataArray->car_type) && !empty($postDataArray->car_type)) ? $postDataArray->car_type: '';


		if(empty($user_id) || empty($brand) || empty($model) || empty($reg_no) || empty($color) ||empty($parking_number) || empty($apartment_number) || empty($city_id) || empty($locality_id) || empty($street_id) || empty($car_type))
		{

			$Code = ResponseConstant::UNSUCCESS;
			$rescode = ResponseConstant::UNSUCCESS;
			$Message = ResponseConstant::message('REQUIRED_PARAMETER');
			$this->sendResponse($Code,$rescode,$Message);

		}
		else
		{

			$bool = $this->car_packages_model->check_reg_no($user_id,$reg_no);
			if($bool)
			{
				//echo $bool; die;
				$Code = ResponseConstant::UNSUCCESS;
				$rescode = ResponseConstant::UNSUCCESS;
				$Message ="CAR ALREADY EXIST";
				$this->sendResponse($Code,$rescode,$Message);
			}
			else
			{


				$data = array(
					'user_id' =>$user_id,
					'city_id' =>$city_id,
					'locality_id' =>$locality_id,
					'street_id' =>$street_id,
					'brand' =>$brand,
					'model' =>$model,
					'type' =>$car_type,
					'color' =>$color,
					'reg_no' =>$reg_no,
					'parking_number' =>$parking_number,
					'apartment_number' =>$apartment_number,
				);

				$inserted_data = $this->car_packages_model->insert_car_details($data);

				if($inserted_data)
				{
					$Code = ResponseConstant::SUCCESS;
					$rescode = ResponseConstant::SUCCESS;
					$Message = ResponseConstant::message('DA_ADD_SUCCESSFULLY');
					$this->sendResponse($Code,$rescode,$Message,array($data));
				}
				else
				{
					$Code = ResponseConstant::UNSUCCESS;
					$rescode = ResponseConstant::UNSUCCESS;
					$Message = ResponseConstant::message('DATA_NOT_INSERTED');
				}	$this->sendResponse($Code,$rescode,$Message);
			}	
		}		
	}


	public function car_list($postDataArray)
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
			$car_array = $this->car_packages_model->get_cars($user_id);


			
			if($car_array)
			{
				foreach($car_array as $car)
				{
					$expiry_date = $car['expiry_date'];
					//echo $expiry_date; die;
					$today = date("Y-m-d");
					 $difference = strtotime($expiry_date) - strtotime($today);
					//echo $difference; die;
					 if($difference <=0)
					 {
					 	//echo $difference;die;
					 	// echo "<br>";
					 	//echo $car['id'];die;
					 	$bool = $this->car_packages_model->update_is_package_as_expire($car['id']);
					 }
					 //die('nothing');
				}
				
				
				

				$car_array_updated = $this->car_packages_model->get_cars_updated($user_id);
				if($car_array_updated)
				{
					$Code = ResponseConstant::SUCCESS;
					$rescode = ResponseConstant::SUCCESS;
					$Message = 'SUCCESS';
					$this->sendResponse($Code,$rescode,$Message,$car_array_updated);
				}
				else
				{
					$Code = ResponseConstant::UNSUCCESS;
					$rescode = ResponseConstant::UNSUCCESS;
					$Message = 'NO CAR FOUND';
					$this->sendResponse($Code,$rescode,$Message);
				}	
			}
			else
			{
				$Code = ResponseConstant::UNSUCCESS;
				$rescode = ResponseConstant::UNSUCCESS;
				$Message = 'NO CAR FOUND';
				$this->sendResponse($Code,$rescode,$Message);
			}
		}
		
	}

	public function get_car_model($postDataArray)
	{
		$brand_id = (isset($postDataArray->brand_id) && !empty($postDataArray->brand_id)) ? $postDataArray->brand_id: '';
		if(empty($brand_id))
		{
			$Code = ResponseConstant::UNSUCCESS;
			$rescode = ResponseConstant::UNSUCCESS;
			$Message = ResponseConstant::message('REQUIRED_PARAMETER');
			$this->sendResponse($Code,$rescode,$Message);
		}
		$model_array = $this->car_packages_model->get_models($brand_id);
		if($model_array)
		{
			$Code = ResponseConstant::SUCCESS;
			$rescode = ResponseConstant::SUCCESS;
			$Message = 'SUCCESS';
			$this->sendResponse($Code,$rescode,$Message,$model_array);
		}
		else
		{
			$Code = ResponseConstant::UNSUCCESS;
			$rescode = ResponseConstant::UNSUCCESS;
			$Message = 'UNSUCCESS';
			$this->sendResponse($Code,$rescode,$Message);
		}
	}
	public function get_car_brand($postDataArray)
	{
		$brand_array = $this->car_packages_model->get_brand();
		if($brand_array)
		{
			$Code = ResponseConstant::SUCCESS;
			$rescode = ResponseConstant::SUCCESS;
			$Message = 'SUCCESS';
			$this->sendResponse($Code,$rescode,$Message,$brand_array);
		}
		else
		{
			$Code = ResponseConstant::UNSUCCESS;
			$rescode = ResponseConstant::UNSUCCESS;
			$Message = 'UNSUCCESS';
			$this->sendResponse($Code,$rescode,$Message);
		}
	}

	public function add_brand($postDataArray)
	{
		
		$brand_name = (isset($postDataArray->brand_name) && !empty($postDataArray->brand_name)) ? $postDataArray->brand_name: '';
		$type = (isset($postDataArray->type) && !empty($postDataArray->type)) ? $postDataArray->type: '';
		$model_name = (isset($postDataArray->model_name) && !empty($postDataArray->model_name)) ? $postDataArray->model_name: '';
		if(empty($brand_name) || empty($type) || empty($model_name))
		{
			$Code = ResponseConstant::UNSUCCESS;
			$rescode = ResponseConstant::UNSUCCESS;
			$Message = ResponseConstant::message('REQUIRED_PARAMETER');
			$this->sendResponse($Code,$rescode,$Message);

		}
		else
		{
			$bool = $this->car_packages_model->check_brand_name($brand_name);
			$bool_model = $this->car_packages_model->check_model_name($model_name);
			if(!empty($bool) || !empty($bool_model))
			{
				$Code = ResponseConstant::UNSUCCESS;
				$rescode = ResponseConstant::UNSUCCESS;
				$Message = 'Alrady Exist';
				$this->sendResponse($Code,$rescode,$Message);
			}
			else
			{
				$data = array(
					'name'=>$brand_name,
					'type'=>$type
				);
				$insert_id = $this->car_packages_model->insert_brand($data);
				if($insert_id)
				{
					$data = array(
					'name'=>$model_name,
					'type'=>$type,
					'brand_id'=>$insert_id,
					);
					$bool = $this->car_packages_model->insert_model($data);
					if($bool)
					{
						$Code = ResponseConstant::SUCCESS;
						$rescode = ResponseConstant::SUCCESS;
						$Message = ResponseConstant::message('DA_ADD_SUCCESSFULLY');
						$this->sendResponse($Code,$rescode,$Message);
					}
					else
					{
						$Code = ResponseConstant::UNSUCCESS;
						$rescode = ResponseConstant::UNSUCCESS;
						$Message = 'Error In Insertion';
						$this->sendResponse($Code,$rescode,$Message);
					}
				}
				else
				{
					$Code = ResponseConstant::UNSUCCESS;
					$rescode = ResponseConstant::UNSUCCESS;
					$Message = 'Error In Insertion';
					$this->sendResponse($Code,$rescode,$Message);
				}
			}
		}
	}

	public function add_model($postDataArray)
	{

		$name = (isset($postDataArray->name) && !empty($postDataArray->name)) ? $postDataArray->name: '';
		$type = (isset($postDataArray->type) && !empty($postDataArray->type)) ? $postDataArray->type: '';
		$brand_id = (isset($postDataArray->brand_id) && !empty($postDataArray->brand_id)) ? $postDataArray->brand_id: '';
		if(empty($name) || empty($type) || empty($brand_id) )
		{
			$Code = ResponseConstant::UNSUCCESS;
			$rescode = ResponseConstant::UNSUCCESS;
			$Message = ResponseConstant::message('REQUIRED_PARAMETER');
			$this->sendResponse($Code,$rescode,$Message);

		}
		else
		{
			$bool = $this->car_packages_model->check_model_name($name);
			if($bool)
			{
				$Code = ResponseConstant::UNSUCCESS;
				$rescode = ResponseConstant::UNSUCCESS;
				$Message = 'Model Name Alrady Exist';
				$this->sendResponse($Code,$rescode,$Message);
			}
			else
			{
				$data = array(
					'name'=>$name,
					'type'=>$type,
					'brand_id'=>$brand_id,
				);
				$bool = $this->car_packages_model->insert_model($data);
				if($bool)
				{
					$Code = ResponseConstant::SUCCESS;
					$rescode = ResponseConstant::SUCCESS;
					$Message = ResponseConstant::message('DA_ADD_SUCCESSFULLY');
					$this->sendResponse($Code,$rescode,$Message);
				}
				else
				{
					$Code = ResponseConstant::UNSUCCESS;
					$rescode = ResponseConstant::UNSUCCESS;
					$Message = 'Error In Insertion';
					$this->sendResponse($Code,$rescode,$Message);
				}
			}
		}
	}
	public function package($postDataArray)
	{
		$locality_id = (isset($postDataArray->locality_id) && !empty($postDataArray->locality_id)) ? $postDataArray->locality_id: '';

		$car_type = (isset($postDataArray->car_type) && !empty($postDataArray->car_type)) ? $postDataArray->car_type: '';


		if(empty($locality_id) || empty($car_type) )
		{
			$Code = ResponseConstant::UNSUCCESS;
			$rescode = ResponseConstant::UNSUCCESS;
			$Message = ResponseConstant::message('REQUIRED_PARAMETER');
			$this->sendResponse($Code,$rescode,$Message);
		}
		{
			$package_row = $this->car_packages_model->get_package($locality_id,$car_type);
			if($package_row)
			{
				//print_r($package_row);die;
				
				$responce['monthly']['id'] =$package_row[0]['id'];
				$responce['monthly']['interior_once'] =$package_row[0]['interior_once'];
				$responce['monthly']['exterior_once'] =$package_row[0]['exterior_once'];
				$responce['monthly']['interior_thrice'] =$package_row[0]['interior_thrice'];
				$responce['monthly']['exterior_thrice'] =$package_row[0]['exterior_thrice'];
				$responce['monthly']['interior_five'] =$package_row[0]['interior_five'];
				$responce['monthly']['exterior_five'] =$package_row[0]['exterior_five'];
				$responce['once']['id']=$package_row[0]['id'];
				$responce['once']['price_interior']=$package_row[0]['price_interior'];
				$responce['once']['price_exterior']=$package_row[0]['price_exterior'];
				//print_r($responce); die;
				$Code = ResponseConstant::SUCCESS;
				$rescode = ResponseConstant::SUCCESS;
				$Message = "SUCCESFULLY GET PACKAGE";
				$this->sendResponse($Code,$rescode,$Message,array($responce));
			}
			else
			{
				$Code = ResponseConstant::UNSUCCESS;
				$rescode = ResponseConstant::UNSUCCESS;
				$Message = 'Package Not Exist';
				$this->sendResponse($Code,$rescode,$Message);
			}
			
		}

	}
	public function insert_booked_services($postDataArray)
	{
		//echo"<pre>";print_r($postDataArray); die;

		$user_id = (isset($postDataArray->user_id) && !empty($postDataArray->user_id)) ? $postDataArray->user_id: '';
		$transaction_id = (isset($postDataArray->transaction_id) && !empty($postDataArray->transaction_id)) ? $postDataArray->transaction_id: '';
		$net_paid = (isset($postDataArray->net_paid) && !empty($postDataArray->net_paid)) ? $postDataArray->net_paid: '';
		if(empty($user_id) || empty($transaction_id) || empty($net_paid) )
		{
			$Code = ResponseConstant::UNSUCCESS;
			$rescode = ResponseConstant::UNSUCCESS;
			$Message = ResponseConstant::message('REQUIRED_PARAMETER');
			$this->sendResponse($Code,$rescode,$Message);

		}
		else
		{
			
			
				$user_payment_data = array(
					'user_id'=>$user_id,
					'transaction_id'=>$transaction_id,
					'net_paid'=>$net_paid
				);
				$book_package_insertion = 0;
				foreach ($postDataArray->cars as $key => $value)
				{
					$car_id = $value->car_id;
					$package_type = $value->package_type;
					$purchase_date = $value->purchase_date;

					if($package_type == 'monthly')
					{
						$expiry_date = date('Y-m-d', strtotime($purchase_date .'+1 month'));
					}
					else
					{
						$expiry_date = date('Y-m-d', strtotime($purchase_date .'+1 day'));
					}
					$services = $value->services;
					$days = $value->days;
					$frequency = $value->frequency;
					$amount = $value->amount;
					$coupan_applied = $value->coupan_applied;
					$data = array(
						'user_id'=>$user_id,
						'car_id'=>$car_id,
						'transaction_id'=>$transaction_id,
						'package_type'=>$package_type,
						'purchase_date'=>$purchase_date,
						'expiry_date'=>$expiry_date,
						'services'=>$services,
						'days'=>$days,
						'frequency'=>$frequency,
						'amount'=>$amount,
						'coupan_applied'=>$coupan_applied
					);
					$row = $this->car_packages_model->check_car_id_existence($car_id);
					if($row)
					{
						$data_to_update = array(
						'user_id'=>$user_id,
						'transaction_id'=>$transaction_id,
						'package_type'=>$package_type,
						'purchase_date'=>$purchase_date,
						'expiry_date'=>$expiry_date,
						'services'=>$services,
						'days'=>$days,
						'frequency'=>$frequency,
						'amount'=>$amount,
						'coupan_applied'=>$coupan_applied
						);
						$bool = $this->car_packages_model->update_car_package($car_id,$data_to_update);
						if($bool)
						{
							$package_activated = $this->car_packages_model->update_is_packege_car_key($car_id);
							$book_package_insertion=1;
						}
					}
					else
					{
						$bool = $this->car_packages_model->insert_book_package($data);
						if($bool)
						{
							$package_activated = $this->car_packages_model->update_is_packege_car_key($car_id);
							$book_package_insertion=1;
						}
					}
					
				}
				if($book_package_insertion ==1)
				{
					$is_payment_bool = $this->car_packages_model->update_is_payment($user_id);
					$bool = $this->car_packages_model->insert_user_payment_data($user_payment_data);
					if($bool)
					{
						//print_r($responce); die;
						$Code = ResponseConstant::SUCCESS;
						$rescode = ResponseConstant::SUCCESS;
						$Message = "DATA INSERTED SUCCESSFULLY";
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
				else
				{
					$Code = ResponseConstant::UNSUCCESS;
					$rescode = ResponseConstant::UNSUCCESS;
					$Message = "SOMETHING WENT WRONG";
					$this->sendResponse($Code,$rescode,$Message);
				}
			
		}
		
		
		// foreach ($post_array as $key => $value) {
		// 	echo"<pre>";print_r($value);
		// 	# code...
		// }
	// 	$user_id = (isset($postDataArray->user_id) && !empty($postDataArray->user_id)) ? $postDataArray->user_id: '';
	// 	$car_id = (isset($postDataArray->car_id) && !empty($postDataArray->car_id)) ? $postDataArray->car_id: '';
	// 	$package_type = (isset($postDataArray->package_type) && !empty($postDataArray->package_type)) ? $postDataArray->package_type: '';
	// 	$purchase_date = (isset($postDataArray->purchase_date) && !empty($postDataArray->purchase_date)) ? $postDataArray->purchase_date: '';
	// 	$expiry_date = (isset($postDataArray->expiry_date) && !empty($postDataArray->expiry_date)) ? $postDataArray->expiry_date: '';
	// 	$services  = (isset($postDataArray->services ) && !empty($postDataArray->services )) ? $postDataArray->services : '';

	// 	$days  = (isset($postDataArray->days ) && !empty($postDataArray->days )) ? $postDataArray->days : '';
	// 	$frequency  = (isset($postDataArray->frequency ) && !empty($postDataArray->frequency )) ? $postDataArray->frequency : '';
	// 	$amount  = (isset($postDataArray->amount ) && !empty($postDataArray->amount )) ? $postDataArray->amount : '';
	// 	$coupan_applied  = (isset($postDataArray->coupan_applied ) && !empty($postDataArray->coupan_applied )) ? $postDataArray->coupan_applied : 'N/A';
	// 	$net_paid  = (isset($postDataArray->net_paid ) && !empty($postDataArray->net_paid )) ? $postDataArray->net_paid : '';
	// 	if(empty($user_id) || empty($package_type) ||empty($purchase_date) ||empty($expiry_date) ||empty($services) ||empty($days) || empty($frequency) ||empty($amount) ||empty($coupan_applied) ||empty($net_paid) || empty($car_id))
	// 	{

	// 		$Code = ResponseConstant::UNSUCCESS;
	// 		$rescode = ResponseConstant::UNSUCCESS;
	// 		$Message = ResponseConstant::message('REQUIRED_PARAMETER');
	// 		$this->sendResponse($Code,$rescode,$Message);

	// 	}
	// 	else
	// 	{	

	// 		$bool = $this->car_packages_model->check_car_existence($car_id);
	// 		if($bool)
	// 		{
	// 			$Code = ResponseConstant::UNSUCCESS;
	// 			$rescode = ResponseConstant::UNSUCCESS;
	// 			$Message = "PACKAGE ALREADY ACTIVATED";
	// 			$this->sendResponse($Code,$rescode,$Message);
	// 		}
	// 		else
	// 		{
	// 			$data = array(
	// 				'user_id'=>$user_id,
	// 				'package_type'=>$package_type,
	// 				'car_id'=>$car_id,
	// 				'purchase_date'=>$purchase_date,
	// 				'expiry_date'=>$expiry_date,
	// 				'services'=>$services,
	// 				'days'=>$days,
	// 				'frequency'=>$frequency,
	// 				'amount'=>$amount,
	// 				'coupan_applied'=>$coupan_applied,
	// 				'net_paid'=>$net_paid,

	// 			);
	// 			$bool = $this->car_packages_model->insert_book_package($data);
	// 			if($bool)
	// 			{
	// 				$Code = ResponseConstant::SUCCESS;
	// 				$rescode = ResponseConstant::SUCCESS;
	// 				$Message = "DATA ADDED SUCCESSFULLY";
	// 				$this->sendResponse($Code,$rescode,$Message);
	// 			}
	// 			else
	// 			{
	// 				$Code = ResponseConstant::UNSUCCESS;
	// 				$rescode = ResponseConstant::UNSUCCESS;
	// 				$Message = 'Error In Insertion';
	// 				$this->sendResponse($Code,$rescode,$Message);
	// 			}
	// 		}
	// 	}
		

	}
	public function upcoming_renewals($postDataArray)
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
			$today = date('Y-m-d');
			$next_week = date('Y-m-d',strtotime("+7 days"));
			$upcoming_details = $this->car_packages_model->get_week_before_data($user_id,$today,$next_week);
			//print_r($upcoming_details); die;
			if(!empty($upcoming_details))
			{
				 foreach ($upcoming_details as $key => $value) {

				 	if($value['package_type']=='monthly')
				 	{
						$up['upcoming'][] = $value;
						$up['services'][] = $value;
				 	}
				 	else
				 	{
						$up['services'][] = $value;
				 	}
				 }
				// print_r($upcoming_details); die;
				$Code = ResponseConstant::SUCCESS;
				$rescode = ResponseConstant::SUCCESS;
				$Message = "SUCCESFULL";
				$this->sendResponse($Code,$rescode,$Message,$up);
			}
			else
			{
				$Code = ResponseConstant::SUCCESS;
				$rescode = ResponseConstant::SUCCESS;
				$Message = "CARS NOT FOUND";
				$this->sendResponse($Code,$rescode,$Message);
			}
		}
	}
}
			