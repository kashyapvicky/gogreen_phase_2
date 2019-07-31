<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//require(APPPATH.'/libraries/REST_Controller.php');

class Cleaner_api extends MY_Controller
{

	
	function __construct()
    {


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
        // $phone_number = (isset($postDataArray->phone_number) && !empty($postDataArray->phone_number)) ? $postDataArray->phone_number: '';
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
}
			