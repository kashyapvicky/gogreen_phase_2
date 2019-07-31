<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//require(APPPATH.'/libraries/REST_Controller.php');

use Twilio\Rest\Client;
 base_url_custom. '/Twilio/autoload.php';
class Api_v2 extends MY_Controller
{

	
	function __construct()
    {
    	//echo base_url(); die;
		parent::__construct();
		$this->load->model('api_model');
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
                $this->sendResponse($Code, $Message); // return data    
            }
        }
        else
        { 
            $Code = ResponseConstant::UNSUCCESS;
            $rescode = ResponseConstant::METHOD_NOT_FOUND;
            $Message = ResponseConstant::message('METHOD_NOT_FOUND');
            $this->sendResponse($Code, $Message); // return data      
        }
        switch($method)
        { 
            case 'login':
            $this->login($postDataArray);
            break;
            case 'sign_up':
            $this->sign_up($postDataArray);
            break;
            case 'update_device_token':
            $this->update_device_token($postDataArray);
            break;
            case 'insert_car_detail':
            $this->insert_car_detail($postDataArray);
            break;
            case 'get_city':
            $this->get_city($postDataArray);
            break;
            case 'get_locality':
            $this->get_locality($postDataArray);
            break;
            case 'get_street':
            $this->get_street($postDataArray);
            break;
            case 'forget_password':
            $this->forget_password($postDataArray);
            break;
            case 'phone_varification':
            $this->phone_varification($postDataArray);
            break;
            case 'update_verification_key':
            $this->update_verification_key($postDataArray);
            break;
            case 'update_phone_number':
            $this->update_phone_number($postDataArray);
            break;
            case 'change_password':
            $this->change_password($postDataArray);
                // created by vinod
            case 'update_profile':
            $this->update_profile($postDataArray);
            break;

            case 'check_app_compatiblity':
            $this->check_app_compatiblity($postDataArray);
            break;
            
        }
    }

	public function update_profile($postDataArray)
	{
           // echo "<pre>"; print_r($postDataArray); die;
            $user_id = (isset($postDataArray->user_id) && !empty($postDataArray->user_id)) ? $postDataArray->user_id: '';
            $email =  (isset($postDataArray->email) && !empty($postDataArray->email)) ? $postDataArray->email: '';
            $name = (isset($postDataArray->name) && !empty($postDataArray->name)) ? $postDataArray->name: '';
            if(empty($user_id))
		{
			$Code = ResponseConstant::UNSUCCESS;
			$rescode = 0; // Common Parameter is missing
			$Message = ResponseConstant::message('REQUIRED_PARAMETER');			
			$this->sendResponse($Code,$rescode, $Message);
		}
		else
		{
                    $column = array('email'=>$email,'name'=>$name);
                    $where = array('id'=>$user_id);
                    $table = 'users';
                    $update_user = $this->api_model->update($where,$column,$table);
			if($update_user)
			{
                            $Code = ResponseConstant::SUCCESS;
                            $rescode = 0; // Common Parameter is missing
                            $Message = 'User Profile Updated Successfully.';
                            $this->sendResponse($Code,$rescode,$Message);
			}
                }
        }
	public function sign_up($postDataArray)
	{
		//getting post data
		//echo base_url(); die;
		$date = date("Y-m-d");
		$name = (isset($postDataArray->name) && !empty($postDataArray->name)) ? $postDataArray->name: '';
		$email =  (isset($postDataArray->email) && !empty($postDataArray->email)) ? $postDataArray->email: '';
		$phone_number = (isset($postDataArray->phone_number) && !empty($postDataArray->phone_number)) ? $postDataArray->phone_number: '';
		//if($postDataArray->phone_number){$phone_number = $postDataArray->phone_number;}
		$password = (isset($postDataArray->password) && !empty($postDataArray->password)) ? $postDataArray->password: '';
		$device_type = (isset($postDataArray->device_type) && !empty($postDataArray->device_type)) ? $postDataArray->device_type: '';
		$device_token = (isset($postDataArray->device_token) && !empty($postDataArray->device_token)) ? $postDataArray->device_token: '';
		$login_type = (isset($postDataArray->login_type) && !empty($postDataArray->login_type)) ? $postDataArray->login_type: '';
		$social_id = (isset($postDataArray->social_id) && !empty($postDataArray->social_id)) ? $postDataArray->social_id: '';
		//echo  $social_id; die;
			// Check For Common Parameters
		if(empty($name) || empty($email) || empty($phone_number)  || empty($device_type) ||empty($login_type))
		{
			$Code = ResponseConstant::UNSUCCESS;
			$rescode = 0; // Common Parameter is missing
			$Message = ResponseConstant::message('REQUIRED_PARAMETER');
			//$Message = "sign up api missing parameter";

			$this->sendResponse($Code,$rescode, $Message);
		}
		else
		{


			$bool = $this->api_model->check_phone_existence($phone_number);
			if($bool)
			{
				// $Code = ResponseConstant::UNSUCCESS;
				// $rescode = 0; // Common Parameter is missing
				// $Message = "Phone Number already linked to another account.";
				// $this->sendResponse($Code,$rescode, $Message);
				$row_data = $this->api_model->phone_email_existence($phone_number,$email);
				if($row_data)
				{
					$bool = $this->api_model->update_soocial_id_on_combo($phone_number,$email,$social_id,$login_type);
					if($bool)
					{	//echo"hello";
						//print_r($bool); die;
						$key =  $bool['is_phone_verified']; 
						$user_id = $bool['id'];
						$is_phone_varified = $key;
						$data['user_id'] = $bool;
						$response = array(

							'id' => strval($user_id),
							'name' => $name,
							'email' => $email,
							'phone_number' => $phone_number,
							'is_phone_verified' => $key,
						);
						$Code = ResponseConstant::SUCCESS;
						$rescode = ResponseConstant::SUCCESS;// Email is already exist
						$Message = "SOCIAL_ID_UPDATED";
						$this->sendResponse($Code,$rescode, $Message,array($response)); // return data   
					}
					else
					{
						$Code = ResponseConstant::UNSUCCESS;
						$rescode = ResponseConstant::UNSUCCESS;// Email is already exist
						$Message = "ERROR IN UPDATING SOCIAL KEY";
						$this->sendResponse($Code,$rescode, $Message);
					}     
				}
				else
				{
					$Code = ResponseConstant::UNSUCCESS;
					$rescode = ResponseConstant::UNSUCCESS;// Email is already exist
					$Message = "Phone Number Linked To Another Account";
					$this->sendResponse($Code,$rescode, $Message);
				}
			}
			

			//  else
			// {	//echo $login_type; die;

				if($login_type == 'FB')
				{

					//echo $login_type; die;
					$email_existed = $this->api_model->check_email_existence($email);	
					if(empty($social_id))
					{
						$Code = ResponseConstant::UNSUCCESS;
						$rescode = ResponseConstant::SOCIAL_ID_NOT_FOUND; // Social ID not Found
						$Message = ResponseConstant::message('REQUIRED_PARAMETER');
						//$Message = "Social id not given";
						$this->sendResponse($Code,$rescode,$Message);
					}
					elseif($email_existed)
					{
						if($email_existed['phone_number'] == $phone_number)
						{
							$phone_number = $email_existed['phone_number'];
							$is_phone_verified = $email_existed['is_phone_verified'];
						}
						else
						{
							$is_phone_verified = '0';
						}
						

						$bool = $this->api_model->update_social_id_fb($email,$social_id,$phone_number,$is_phone_verified);
						if($bool)
						{
							$data['user_id'] = $bool;
							$response = array(

								'id' => strval($bool),
								'name' => $name,
								'email' => $email,
								'phone_number' => $phone_number,
								'is_phone_verified' => $is_phone_verified,
							);
							$Code = ResponseConstant::SUCCESS;
 							$rescode = ResponseConstant::SUCCESS;// Email is already exist
							$Message = "SOCIAL_ID_UPDATED";
							$this->sendResponse($Code,$rescode, $Message,array($response)); // return data   
						}
						else
						{
							$Code = ResponseConstant::UNSUCCESS;
							$rescode = ResponseConstant::UNSUCCESS;// Email is already exist
							$Message = "ERROR IN UPDATING SOCIAL KEY";
							$this->sendResponse($Code,$rescode, $Message);
						}


					}
					else
					{

						$date = date("Y-m-d");
						$data = array(
						'name'=>$name,
						'email'=>$email,
						'phone_number'=>$phone_number,
						'device_type'=>$device_type,
						'device_token'=>$device_token,
						'social_id_fb'=>$social_id,
						'login_type'=>$login_type,
						'created_at'=>$date
						);
				
						$result = $this->api_model->insert_data($data);
						if($result)
						{
							$data['user_id'] = $result;
							$response = array(

								'id' => strval($result),
								'name' => $name,
								'email' => $email,
								'phone_number' => $phone_number,
								'is_phone_verified' => '0',
							);
							$this->send_mail_to_user($email);
							// $response['id'] = strval($result);
							// $response['name'] = $name;
							// $response['email'] = $email;
							// $response['phone_number'] = $phone_number;
							// $response['is_phone_verified'] = '0';
							$Code = ResponseConstant::SUCCESS;
							$rescode = ResponseConstant::SUCCESS;
							$Message = ResponseConstant::message('DA_ADD_SUCCESSFULLY');
							$this->sendResponse($Code,$rescode, $Message,array($response));
							//echo"succesfullt inserted";
						}
						else
						{

							$Code = ResponseConstant::UNSUCCESS;
							$rescode = ResponseConstant::UNSUCCESS;
							$Message = ResponseConstant::message('DATA_NOT_INSERTED');
							$this->sendResponse($Code,$rescode, $Message);
						}	//echo"error in insertions";
					}
				}
			//}	//echo  $social_id; die;
			elseif($login_type =='GL')
			{
				//echo $login_type; die;
				$email_existed = $this->api_model->check_email_existence($email);	
				if(empty($social_id))
				{
					$Code = ResponseConstant::UNSUCCESS;
					$rescode = ResponseConstant::SOCIAL_ID_NOT_FOUND; // Social ID not Found
					$Message = ResponseConstant::message('REQUIRED_PARAMETER');
					//$Message = "Social id not given";
					$this->sendResponse($Code,$rescode,$Message);
				}
				elseif($email_existed)
				{
					if($email_existed['phone_number'] == $phone_number)
					{
						$phone_number = $email_existed['phone_number'];
						$is_phone_verified = $email_existed['is_phone_verified'];
					}
					else
					{
						$is_phone_verified = '0';
					}

					$bool = $this->api_model->update_social_id_gl($email,$social_id,$phone_number,$is_phone_verified);
					if($bool)
					{
						$data['user_id'] = $bool;
						$response = array(

							'id' => strval($bool),
							'name' => $name,
							'email' => $email,
							'phone_number' => $phone_number,
							'is_phone_verified' => $is_phone_verified,
						);
						$Code = ResponseConstant::SUCCESS;
						$rescode = ResponseConstant::SUCCESS;// Email is already exist
						$Message = "SOCIAL_ID_UPDATED";
						$this->sendResponse($Code,$rescode, $Message,array($response)); // return data   
					}
					else
					{
						$Code = ResponseConstant::UNSUCCESS;
						$rescode = ResponseConstant::UNSUCCESS;// Email is already exist
						$Message = "ERROR IN UPDATING SOCIAL KEY";
						$this->sendResponse($Code,$rescode, $Message);
					}     
					//die;
				}
				else
				{
					$date = date("Y-m-d");
					$data = array(
					'name'=>$name,
					'email'=>$email,
					'phone_number'=>$phone_number,
					'device_type'=>$device_type,
					'device_token'=>$device_token,
					'social_id_gl'=>$social_id,
					'login_type'=>$login_type,
					'created_at'=>$date
					);
			
					$result = $this->api_model->insert_data($data);
					//echo $result; die;
					if($result)
					{
						//$data['user_id'] = $result;
						$response = array(

							'id' => strval($result),
							'name' => $name,
							'email' => $email,
							'phone_number' => $phone_number,
							'is_phone_verified' => '0',
						);
						$this->send_mail_to_user($email);
						//$data =array('inserted_user_id' =>$result);
						$Code = ResponseConstant::SUCCESS;
						$rescode = ResponseConstant::SUCCESS;
						$Message = ResponseConstant::message('DA_ADD_SUCCESSFULLY');
						$this->sendResponse($Code,$rescode, $Message,array($response));
						//echo"succesfullt inserted";
					}
					else
					{

						$Code = ResponseConstant::UNSUCCESS;
						$rescode = ResponseConstant::UNSUCCESS;
						$Message = ResponseConstant::message('DATA_NOT_INSERTED');
						$this->sendResponse($Code,$rescode, $Message);
					}	//echo"error in insertions";
				}
			}
			elseif($login_type == 'EM')
			{
					//echo"dfdf";die;

				$email_existed = $this->api_model->check_email_existence($email);
				if($email_existed)
				{
					$Code = ResponseConstant::UNSUCCESS;
					$rescode = ResponseConstant::UNSUCCESS;// Email is already exist
					$Message = ResponseConstant::message('EMAIL_ALREADYEXIST');
					$this->sendResponse($Code, $rescode,$Message); // return data         
					//die;
				}
				else
				{
				// inserting post data to databse
					$data = array(
						'name'=>$name,
						'email'=>$email,
						'password'=>md5($password),
						'phone_number'=>$phone_number,
						'device_type'=>$device_type,
						'device_token' =>$device_token,
						//if(!empty($social_id)){'social_id' =>$social_id}
						'login_type'=>$login_type,
						'created_at'=>$date
					);
					//$this->load->model('user_model');
					$result = $this->api_model->insert_data($data);
					if($result)
					{
						$data['user_id'] = $result; 
						$response = array(

							'id' => strval($result),
							'name' => $name,
							'email' => $email,
							'phone_number' => $phone_number,
							'is_phone_verified' => '0',
						);
						$this->send_mail_to_user($email);

							// $response['id'] = strval($result);
							// $response['name'] = $name;
							// $response['email'] = $email;
							// $response['phone_number'] = $phone_number;
							// $response['is_phone_verified'] = '0';
						

						$Code = ResponseConstant::SUCCESS;
						$rescode = ResponseConstant::SUCCESS;
						$Message = ResponseConstant::message('DA_ADD_SUCCESSFULLY');
						$this->sendResponse($Code,$rescode,$Message,array($response));
						//echo"succesfullt inserted";
					}
					else
					{

						$Code = ResponseConstant::UNSUCCESS;
						$rescode = ResponseConstant::UNSUCCESS;
						$Message = ResponseConstant::message('DATA_NOT_INSERTED');
						$this->sendResponse($Code, $Message);
						//echo"error in insertions";
					}
				}
			}
		}
	}

	public function send_mail_to_user($email)
	{
		if(!empty($email))
		{
			$this->load->library('email');
            $config['protocol']    = 'smtp';
            $config['smtp_host']    = 'smtp.gmail.com';
            $config['smtp_port']    = '567';
            $config['smtp_timeout'] = '7';
            $config['smtp_user']    = 'veee.kay258@gmail.com';
            //$config['smtp_pass']    = 'Heyudude@0';
            $config['charset']    = 'utf-8';
            $config['newline']    = "\r\n";
            $config['mailtype'] = 'html'; // or html
            $config['validation'] = TRUE; // bool whether to validate email or not      
            $this->load->library('email', $config);
            $this->email->from('vicky@ripenapps.com', 'Go Green');
            $this->email->to('info@gogreen-uae.com');
            $this->email->subject('Go Green-Order Confirmation Mail');
            $message = "".$email." Registerd Succesfully With Go Green Team.
            ";
            // $message .="<a href = ".base_url()."admin/confirm_password?id=$id>Link</a>";
            $this->email->message($message);  
            $this->email->send();
		}

	}


	public function login($postDataArray)
	{
		//getting parameters when login with google
		$email = (isset($postDataArray->email) && !empty($postDataArray->email)) ? $postDataArray->email: '';
		$name = (isset($postDataArray->name) && !empty($postDataArray->name)) ? $postDataArray->name: '';
		// $social_id = (isset($postDataArray->social_id) && !empty($postDataArray->social_id)) ? $postDataArray->social_id : '';
		$phone_number = (isset($postDataArray->phone_number) && !empty($postDataArray->phone_number)) ? $postDataArray->phone_number: '';
		$login_type = (isset($postDataArray->login_type) && !empty($postDataArray->login_type)) ? $postDataArray->login_type: '';
		$device_type = (isset($postDataArray->device_type) && !empty($postDataArray->device_type)) ? $postDataArray->device_type: '';
		$social_id = (isset($postDataArray->social_id) && !empty($postDataArray->social_id)) ? $postDataArray->social_id: '';
		$is_phone_varified=false;
			// when login with google email,name,phone number ,login type and device type is mandadotry parameter
			
		if($postDataArray->login_type == 'GL')
		{


			if(empty($social_id))
			{
				$Code = ResponseConstant::UNSUCCESS;
				$rescode = 2;  // Social ID Not Found
				$Message = ResponseConstant::message('REQUIRED_PARAMETER'); 
				//$Message = 'Social Id Not Found';
				$this->sendResponse($Code,$rescode, $Message);
			}
			else
			{

				$data = $this->api_model->check_social_id_gl($social_id);
				if($data)
				{
					//print_r($data); die;
					$Code = ResponseConstant::SUCCESS;
					$rescode = 1;
					//$Message = ResponseConstant::message('REQUIRED_PARAMETER');
					$Message = 'Login Successfull With Google';
					$this->sendResponse($Code,$rescode,$Message,array($data));
				}
				else
				{
					$Code = ResponseConstant::UNSUCCESS;
					$rescode = ResponseConstant::SOCIAL_ID_NOT_BELONG_TO_DATABASE;
					//$Message = ResponseConstant::message('REQUIRED_PARAMETER');
					$Message = 'Social Id Not Belong To Database';
					$this->sendResponse($Code,$rescode,$Message);
				}
			}

		}
		/*-----------------Login for Facebook----------------*/
		elseif($postDataArray->login_type == 'FB')
		{
			//getting parameter when user login with facebook
				if(empty($social_id))
				{
					//$object = new stdClass();
					$Code = ResponseConstant::UNSUCCESS;
					$rescode = 2;  // Social ID Not Found
					$Message = ResponseConstant::message('REQUIRED_PARAMETER'); 
					//$Message = 'Social Id Not Found';
					$this->sendResponse($Code,$rescode, $Message);
				}
				else
				{

					$data = $this->api_model->check_social_id_fb($social_id);
					if($data)
					{
						$Code = ResponseConstant::SUCCESS;
						$rescode = 1;
						//$Message = ResponseConstant::message('REQUIRED_PARAMETER');
						$Message = 'Login Successfull With Facebook';
						$this->sendResponse($Code,$rescode,$Message,array($data));
					}
					else
					{
						$Code = ResponseConstant::UNSUCCESS;
						$rescode = ResponseConstant::SOCIAL_ID_NOT_BELONG_TO_DATABASE;
						//$Message = ResponseConstant::message('REQUIRED_PARAMETER');
						$Message = 'Social Id Not Belong To Database';
						$this->sendResponse($Code,$rescode,$Message);
					}
				}
				
		}
		else
		{
			// login when user login_type is normal
			$password = (isset($postDataArray->password) && !empty($postDataArray->password)) ? $postDataArray->password: '';
			$email = (isset($postDataArray->email) && !empty($postDataArray->email)) ? $postDataArray->email: '';
			//$phone_number = (isset($postDataArray->phone_number) && !empty($postDataArray->phone_number)) ? $postDataArray->phone_number: '';
			if(empty($password) || empty($email))
			{
				//$object = new stdClass();
				$Code = ResponseConstant::UNSUCCESS;
				//$Message = "required paramenter of normal user";
				$rescode = 0; // parameter missing
				$Message = ResponseConstant::message('REQUIRED_PARAMETER');
				//$Message = "Normal login case parameter missing";
				//$Message = "parameter missing in normal case";
				$this->sendResponse($Code,$rescode,$Message);
			}
			else
			{
				
					$data = $this->api_model->login($email,$password);
					
				if($data)
				{	
					//print_r($data); die;
					$Code = ResponseConstant::SUCCESS;
					$rescode =1;
					//$Message = ResponseConstant::message('REQUIRED_PARAMETER');
					$Message = 'Login Successfull'; 
					$this->sendResponse($Code,$rescode,$Message,array($data));
				}
				else
				{
					$Code = ResponseConstant::UNSUCCESS;
					$rescode = ResponseConstant::UNSUCCESS;
					$Message = ResponseConstant::message('INVALID_CREDENTIALS');
					$this->sendResponse($Code,$rescode,$Message);

				}
			}
		}	
		
	}

	public function insert_car_detail($postDataArray)
	{
		
		$user_id = $postDataArray->user_id;
		$brand = $postDataArray->brand;
		$model = $postDataArray->model;
		$reg_no = $postDataArray->reg_no;
		$color = $postDataArray->color;
		$parking_number = $postDataArray->parking_number;
		$apartment_number = $postDataArray->apartment_number;


		if(empty($user_id) || empty($brand) || empty($model) || empty($reg_no) || empty($color) ||empty($parking_number) || empty($apartment_number))
		{

			$Code = ResponseConstant::UNSUCCESS;
			$Message = ResponseConstant::message('REQUIRED_PARAMETER');
			$this->sendResponse($Code, $Message);

		}


		else
		{

			$data = array(
				'user_id' =>$user_id,
				'brand' =>$brand,
				'model' =>$model,
				'color' =>$color,
				'reg_no' =>$reg_no,
				'parking_number' =>$parking_number,
				'apartment_number' =>$apartment_number,
	 		
			);

			$inserted_data = $this->api_model->insert_car_details($data);

			if($inserted_data)
			{
				$Code = ResponseConstant::SUCCESS;
				$Message = ResponseConstant::message('DA_ADD_SUCCESSFULLY');
				$this->sendResponse($Code, $Message,array($data));
			}
			else
			{
				$Code = ResponseConstant::UNSUCCESS;
				$Message = ResponseConstant::message('DATA_NOT_INSERTED');
				$this->sendResponse($Code, $Message);
			}
		}		
	}

	public function update_device_token($postDataArray)
	{

		$user_id = (isset($postDataArray->user_id) && !empty($postDataArray->user_id)) ? $postDataArray->user_id: '';
		$device_token = (isset($postDataArray->device_token) && !empty($postDataArray->device_token)) ? $postDataArray->device_token: '';
		$device_type = (isset($postDataArray->device_type) && !empty($postDataArray->device_type)) ? $postDataArray->device_type: '';
		if(empty($user_id) || empty($device_type))
		{

			$Code = ResponseConstant::UNSUCCESS;
			$Message = ResponseConstant::message('REQUIRED_PARAMETER');
			$this->sendResponse($Code, $Message);

		}
		else
		{
			$bool = $this->api_model->update_token($user_id,$device_token);
			if($bool)
			{
				$Code = ResponseConstant::SUCCESS;
				$Message = 'Device Token Updated Successfully';
				$this->sendResponse($Code, $Message);
			}
		}

	}

	public function get_city()
	{
		//echo "hello";die;
		$result = $this->api_model->get_all_city();
		if($result)
		{
			$Code = ResponseConstant::SUCCESS;
			$rescode=ResponseConstant::SUCCESS;
			$Message = 'Successfully Get Cities';
			//print_r($result); die;
			$this->sendResponse($Code,$rescode,$Message,$result);
		}
		else
		{
			$Code = ResponseConstant::UNSUCCESS;
			$rescode=ResponseConstant::UNSUCCESS;
			$Message = 'No Cities Found';
			$this->sendResponse($Code,$rescode,$Message,$result);
		}
	}

	public function get_locality($postDataArray)
	{
		$city_id = $postDataArray->city_id;
		$localities = $this->api_model->get_locality_api($city_id);

		if($localities)
		{
			$Code = ResponseConstant::SUCCESS;
			$rescode=ResponseConstant::SUCCESS;
			$Message = 'Successfull';
			$this->sendResponse($Code,$rescode,$Message,$localities);
		}
		else
		{
			$Code = ResponseConstant::UNSUCCESS;
			$rescode=ResponseConstant::UNSUCCESS;
			$Message = 'No Localities Found';
			$this->sendResponse($Code,$rescode,$Message);
		}
	}

	public function get_street($postDataArray)
	{
		$locality_id = $postDataArray->locality_id;
		$street = $this->api_model->get_street_api($locality_id);

		if($street)
		{
			$Code = ResponseConstant::SUCCESS;
			$rescode=ResponseConstant::SUCCESS;
			$Message = 'Successfull';
			$this->sendResponse($Code,$rescode,$Message,$street);
		}
		else
		{
			$Code = ResponseConstant::UNSUCCESS;
			$rescode=ResponseConstant::UNSUCCESS;
			$Message = 'No Streets Found';
			$this->sendResponse($Code,$rescode,$Message);
		}
	}
	public function phone_varification($postDataArray)
	{
	
		$phone_number = (isset($postDataArray->phone_number) && !empty($postDataArray->phone_number)) ? $postDataArray->phone_number: '';
		//$phone_number = 9034195001;
		if(empty($phone_number))
		{

			$Code = ResponseConstant::UNSUCCESS;
			$response = ResponseConstant::UNSUCCESS;
			$Message = ResponseConstant::message('REQUIRED_PARAMETER');
			$this->sendResponse($Code,$response,$Message);
		}
		else
		{
			$data = $this->api_model->varify_phone_number($phone_number);
			//print_r($data); die;
			if($data)
			{
				$email = $data['email'];
				$id = $data['id'];
				$phone_number = $data['phone_number'];
				$otp =  rand(1052,9986);			
				// $this->api_model->send_otp_to_phone($phone_number,$otp);
				$account_sid = 'ACb91f71e69b710a801bedd6f2e9fea091';
				$auth_token = '6fd3d4aecff231f1d51c0aaa12b6db5a';
				$twilio_number = "+17049816330";
				$client = new Client($account_sid, $auth_token);
				$client->messages->create(
				// Where to send a text message (your cell phone?)
				$phone_number,
				array(
				'from' => $twilio_number,
				'body' => $otp
				)
				);
				// send otp in response
				$Code = ResponseConstant::SUCCESS;
				$response = ResponseConstant::SUCCESS;
				$Message = "SUCCESFULLY SEND OTP";
				$factor[0]['id'] = $data['id'];
				$factor[0]['otp'] = $otp; 
				$this->sendResponse($Code,$response,$Message,$factor);
			}
			else
			{
				$Code = ResponseConstant::UNSUCCESS;
				$response = ResponseConstant::UNSUCCESS;
				$Message = 'Phone Nuber Does Not Exist';
				$this->sendResponse($Code,$response,$Message);
			}

		}
		
	}
	public function update_verification_key($postDataArray)
	{
		$user_id = (isset($postDataArray->user_id) && !empty($postDataArray->user_id)) ? $postDataArray->user_id: '';
		//$key = (isset($postDataArray->key) && !empty($postDataArray->key)) ? $postDataArray->key: '';
		if(empty($user_id))
		{
			$Code = ResponseConstant::UNSUCCESS;
			$rescode =ResponseConstant::UNSUCCESS;// parameter missing
			$Message = ResponseConstant::message('REQUIRED_PARAMETER');
			$this->sendResponse($Code,$rescode, $Message);
		}
		else
		{
			$bool = $this->api_model->update_phone_verify_key($user_id);
			if($bool)
			{
				$Code = ResponseConstant::SUCCESS;
				$rescode =ResponseConstant::SUCCESS;// parameter missing
				$Message ="PHONE VERIFIED SUCCESSFULLY";
				$this->sendResponse($Code,$rescode, $Message);
			}
			else
			{
				$Code = ResponseConstant::UNSUCCESS;
				$rescode =ResponseConstant::UNSUCCESS;// parameter missing
				$Message = 'Error In Verification';
				$this->sendResponse($Code,$rescode, $Message);
			}
		}

	}


	public function forget_password($postDataArray)
	{
		ini_set('display_errors', 1);
		ini_set('display_startup_errors', 1);
		error_reporting(E_ALL);
		// echo"hello"; die;
		$email = (isset($postDataArray->email) && !empty($postDataArray->email)) ? $postDataArray->email: '';
		//$phone_number = 9034195001;
		if(empty($email))
		{

			$Code = ResponseConstant::UNSUCCESS;
			$response = ResponseConstant::UNSUCCESS;
			$Message = ResponseConstant::message('REQUIRED_PARAMETER');
			$this->sendResponse($Code,$response,$Message);
		}
		else
		{	
			$row_data = $this->api_model->check_email_to_reset_password($email);
			//echo $email; die;
			//print_r($row_data); die;
			if($row_data)
			{
				//print_r($row_data); die;
				$id = $row_data['id'];
				$this->load->library('email');

				$config['protocol']    = 'smtp';

				$config['smtp_host']    = 'smtp.gmail.com';

				$config['smtp_port']    = '567';

				$config['smtp_timeout'] = '7';

				$config['smtp_user']    = 'veee.kay258@gmail.com';

				//$config['smtp_pass']    = 'Heyudude@0';

				$config['charset']    = 'utf-8';

				$config['newline']    = "\r\n";

				$config['mailtype'] = 'html'; // or html

				$config['validation'] = TRUE; // bool whether to validate email or not      
				$this->load->library('email', $config);
				$this->email->from('vicky@ripenapps.com');
				$this->email->to($email); 


				$this->email->subject('Password Verification Link');
				//echo "<a href = ". base_url()."admin/reset_user_password?id=$id>Link</a>"; die;
				//$message = '<html><body>';
				$message = "click on the link below to reset your password";

				$message .=  "<br>";
				$message .="<a href = ".base_url()."admin/reset_user_password?id=$id>Link</a>";
				//$message .= '</body></html>';
				//echo $message;  die;
				$this->email->message($message);

				if($this->email->send())
				{
					$Code = ResponseConstant::SUCCESS;
					$response = ResponseConstant::SUCCESS;
					$Message = "Password Reset Link Send To Your Mail";
					$this->sendResponse($Code,$response,$Message);
				}
				else{
					$Code = ResponseConstant::UNSUCCESS;
					$response = ResponseConstant::UNSUCCESS;
					$Message = "Error In Sending Mail";
					$this->sendResponse($Code,$response,$Message);
				}

				//echo $this->email->print_debugger();die;
	
			}
			else
			{
				
					$Code = ResponseConstant::UNSUCCESS;
					$response = ResponseConstant::UNSUCCESS;
					$Message = "Email Does Not Belong To Any User";
					$this->sendResponse($Code,$response,$Message);
			}
			
		}	
	}


	public function update_phone_number($postDataArray)
	{
		$id = $postDataArray->user_id;
		$phone_number = $postDataArray->phone_number;

		if(empty($id) || empty($phone_number))
		{
			$Code = ResponseConstant::UNSUCCESS;
			$response = ResponseConstant::UNSUCCESS;
			$Message = ResponseConstant::message('REQUIRED_PARAMETER');
			$this->sendResponse($Code,$response,$Message);
		}
		else
		{
			//check if  phone number already existed
			$row = $this->api_model->check_is_exist($phone_number);
			if($row)
			{
				$Code = ResponseConstant::UNSUCCESS;
				$response = ResponseConstant::UNSUCCESS;
				$Message = "Number Already Exist";
				$this->sendResponse($Code,$response,$Message);
			}
			else
			{

			
				$bool = $this->api_model->update_phone_number($id,$phone_number);
				if($bool)
				{

					$Code = ResponseConstant::SUCCESS;
					$response = ResponseConstant::SUCCESS;
					$Message = "MOBILE NUMBER UPDATED";
					$this->sendResponse($Code,$response,$Message);
				}
				else
				{
					$Code = ResponseConstant::UNSUCCESS;
					$response = ResponseConstant::UNSUCCESS;
					$Message = "ERROR IN UPDATION MOBILE NUMBER";
					$this->sendResponse($Code,$response,$Message);
				}
			}
		}
	}
	public function change_password($postDataArray)
    {
        $user_id = (isset($postDataArray->user_id) && !empty($postDataArray->user_id)) ? $postDataArray->user_id: '';
        $old_password = (isset($postDataArray->old_password) && !empty($postDataArray->old_password)) ? $postDataArray->old_password: '';
        $old_password = md5($old_password);
        $new_password = (isset($postDataArray->new_password) && !empty($postDataArray->new_password)) ? $postDataArray->new_password: '';

        if(empty($user_id) || empty($old_password) || empty($new_password) )
        {
            $Code = ResponseConstant::UNSUCCESS;
            $rescode = ResponseConstant::UNSUCCESS;
            $Message = ResponseConstant::message('REQUIRED_PARAMETER');
            $this->sendResponse($Code,$rescode,$Message); 
        }
        else
        {
            $is_exist =  $this->api_model->check_user_id($user_id);
            if($is_exist)
            {
               $row =  $this->api_model->check_old_password($user_id,$old_password);
               if($row)
               {
                 $bool = $this->api_model->change_password($user_id,$new_password);
                 if($bool)
                    {
                        $Code = ResponseConstant::SUCCESS;
                        $rescode = ResponseConstant::SUCCESS;
                        $Message = 'SUCCESSFULL';
                        $this->sendResponse($Code,$rescode,$Message);
                    }
                    else
                    {
                        $Code = ResponseConstant::UNSUCCESS;
                        $rescode = ResponseConstant::UNSUCCESS;
                        $Message = 'Error';
                        $this->sendResponse($Code,$rescode,$Message);
                    }
               }
               else
               {
                    $Code = ResponseConstant::UNSUCCESS;
                    $rescode = ResponseConstant::UNSUCCESS;
                    $Message = 'OLD PASSWORD NOT MATCH';
                    $this->sendResponse($Code,$rescode,$Message);
               }
            }
            else
            {
                $Code = ResponseConstant::UNSUCCESS;
                $rescode = ResponseConstant::UNSUCCESS;
                $Message = 'USER ID NOT EXIST';
                $this->sendResponse($Code,$rescode,$Message);
            }
        }
    }

    public function check_app_compatiblity($postDataArray)
    {
    	$device_type = (isset($postDataArray->device_type) && !empty($postDataArray->device_type)) ? $postDataArray->device_type: '';
        $version = (isset($postDataArray->version) && !empty($postDataArray->version)) ? $postDataArray->version: '';

        $ios_v = "1.0.3";
        $android_v = "1.2";

        if($device_type=="ios")
        {

        	if($version < $ios_v)
        	{
        		$Code = ResponseConstant::UNSUCCESS;
                $rescode = ResponseConstant::UNSUCCESS;
                $Message = 'OLD VERSION';
                $this->sendResponse($Code,$rescode,$Message);
        	}
        	else
        	{
        		$Code = ResponseConstant::SUCCESS;
                $rescode = ResponseConstant::SUCCESS;
                $Message = ' CURRENT VERSION';
                $this->sendResponse($Code,$rescode,$Message);
        	}

        }
        else
        {
        	if($version < $android_v)
        	{
        		$Code = ResponseConstant::UNSUCCESS;
                $rescode = ResponseConstant::UNSUCCESS;
                $Message = 'OLD VERSION';
                $this->sendResponse($Code,$rescode,$Message);
        	}
        	else
        	{
        		$Code = ResponseConstant::SUCCESS;
                $rescode = ResponseConstant::SUCCESS;
                $Message = ' CURRENT VERSION';
                $this->sendResponse($Code,$rescode,$Message);
        	}
        }

    }
	
}  // class api extends ci controller closed here


