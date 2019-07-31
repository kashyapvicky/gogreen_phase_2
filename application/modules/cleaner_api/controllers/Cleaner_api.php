<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//require(APPPATH.'/libraries/REST_Controller.php');

class Cleaner_api extends MY_Controller
{

	
	function __construct()
    {
        //echo"helllo";die;

		parent::__construct();
		$this->load->model('cleaner_api_model');
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
            case 'cleaner_login':
            $this->cleaner_login($postDataArray);
            break;
            case 'get_id_by_number':
            $this->get_id_by_number($postDataArray);
            break;
            case 'update_password':
            $this->update_password($postDataArray);
            break;
            case 'update_info':
            $this->update_info($postDataArray);
            break;
            case 'change_password':
            $this->change_password($postDataArray);
            break;
            
             
        }
    }
    public function cleaner_login($postDataArray)
    {
    	$phone_number = (isset($postDataArray->phone_number) && !empty($postDataArray->phone_number)) ? $postDataArray->phone_number: '';
		$password = (isset($postDataArray->password) && !empty($postDataArray->password)) ? $postDataArray->password: '';

		if(empty($phone_number) || empty($password))
		{

			$Code = ResponseConstant::UNSUCCESS;
			$rescode = ResponseConstant::UNSUCCESS;
			$Message = ResponseConstant::message('REQUIRED_PARAMETER');
			$this->sendResponse($Code,$rescode,$Message);

		}
		else
		{
			$row_array = $this->cleaner_api_model->validate_login_cleaner($phone_number,$password);
			if($row_array)
			{
				$Code = ResponseConstant::SUCCESS;
				$rescode = ResponseConstant::SUCCESS;
				$Message ='Login Successfully';
				$this->sendResponse($Code,$rescode,$Message,array($row_array));	
			}
			else
			{
				$Code = ResponseConstant::UNSUCCESS;
				$rescode = ResponseConstant::UNSUCCESS;
				$Message ='INVALID CREDENTIALS';
				$this->sendResponse($Code,$rescode,$Message);
			}
		}
    }
    public function get_id_by_number($postDataArray)
    {
        $phone_number = (isset($postDataArray->phone_number) && !empty($postDataArray->phone_number)) ? $postDataArray->phone_number: '';
        if(empty($phone_number))
        {
            $Code = ResponseConstant::UNSUCCESS;
            $rescode = ResponseConstant::UNSUCCESS;
            $Message = ResponseConstant::message('REQUIRED_PARAMETER');
            $this->sendResponse($Code,$rescode,$Message);
        }
        else
        {
            $row = $this->cleaner_api_model->get_user_id($phone_number);
            if($row)
            {
                $Code = ResponseConstant::SUCCESS;
                $rescode = ResponseConstant::SUCCESS;
                $Message ='SUCCESS';
                $this->sendResponse($Code,$rescode,$Message,array($row));

            }
            else
            {
                $Code = ResponseConstant::UNSUCCESS;
                $rescode = ResponseConstant::UNSUCCESS;
                $Message = 'PHONE NUMBER DOES NOT EXIST';
                $this->sendResponse($Code,$rescode,$Message);
            }
        }
    }
    public function update_password($postDataArray)
    {

        $user_id = (isset($postDataArray->user_id) && !empty($postDataArray->user_id)) ? $postDataArray->user_id: '';
        $confirm_password = (isset($postDataArray->confirm_password) && !empty($postDataArray->confirm_password)) ? $postDataArray->confirm_password: '';
        if(empty($user_id) || empty($confirm_password))
        {
            $Code = ResponseConstant::UNSUCCESS;
            $rescode = ResponseConstant::UNSUCCESS;
            $Message = ResponseConstant::message('REQUIRED_PARAMETER');
            $this->sendResponse($Code,$rescode,$Message); 
        }
        else
        {
            $row = $this->cleaner_api_model->check_user_id($user_id);
            if($row)
            {
                $bool = $this->cleaner_api_model->update_password($user_id,$confirm_password);
                if($bool)
                {
                    $Code = ResponseConstant::SUCCESS;
                    $rescode = ResponseConstant::SUCCESS;
                    $Message ='SUCCESS';
                    $this->sendResponse($Code,$rescode,$Message);
                }
                else
                {
                    $Code = ResponseConstant::UNSUCCESS;
                    $rescode = ResponseConstant::UNSUCCESS;
                    $Message = 'ERROR IN UPDATION';
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
    public function update_info($postDataArray)
    {
       // echo"hello";die;
        $user_id = (isset($postDataArray->user_id) && !empty($postDataArray->user_id)) ? $postDataArray->user_id: '';
        $phone_number = (isset($postDataArray->phone_number) && !empty($postDataArray->phone_number)) ? $postDataArray->phone_number: '';
        $first_name = (isset($postDataArray->first_name) && !empty($postDataArray->first_name)) ? $postDataArray->first_name: '';
        $last_name = (isset($postDataArray->last_name) && !empty($postDataArray->last_name)) ? $postDataArray->last_name: '';
        $email = (isset($postDataArray->email) && !empty($postDataArray->email)) ? $postDataArray->email: '';
        $image_string =(isset($postDataArray->image_string) && !empty($postDataArray->image_string)) ? $postDataArray->image_string: '';
        if(empty($user_id) || empty($phone_number) || empty($first_name) || empty($last_name) || empty($email) )
        {
            $Code = ResponseConstant::UNSUCCESS;
            $rescode = ResponseConstant::UNSUCCESS;
            $Message = ResponseConstant::message('REQUIRED_PARAMETER');
            $this->sendResponse($Code,$rescode,$Message); 
        }
        else
        {
           $row =  $this->cleaner_api_model->check_user_id($user_id);
           if($row)
           {

                $data = array(

                    'phone_number'=>$phone_number,
                    'first_name'=>$first_name,
                    'last_name'=>$last_name,
                    'email'=>$email,
                    'image_string'=>$image_string

                );
                $bool = $this->cleaner_api_model->update_user_info($data,$user_id);
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
                $Message = 'USER ID NOT EXIST';
                $this->sendResponse($Code,$rescode,$Message);
           }

        }
    }


    public function change_password($postDataArray)
    {
        $user_id = (isset($postDataArray->user_id) && !empty($postDataArray->user_id)) ? $postDataArray->user_id: '';
        $old_password = (isset($postDataArray->old_password) && !empty($postDataArray->old_password)) ? $postDataArray->old_password: '';
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
            $is_exist =  $this->cleaner_api_model->check_user_id($user_id);
            if($is_exist)
            {
               $row =  $this->cleaner_api_model->check_old_password($user_id,$old_password);
               if($row)
               {
                 $bool = $this->cleaner_api_model->change_password($user_id,$new_password);
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
}
			