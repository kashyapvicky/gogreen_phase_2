<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require_once(APPPATH.'libraries/REST_Controller.php');

class MY_Controller extends REST_Controller {
	function __construct()
	{
		parent::__construct();
		
	}

	 function checkAppKey($AppKey){
		if ($AppKey != '123456') {
            return FALSE;           
        }
        //return TRUE;
		return $AppKey;
	}

	/**
     * send Json Response format
     * @param string $errorCode, $errorMsgCode, array $result, string $resultKey
     * @return json Response Message
     */
    public function sendResponse($errorCode = null,$rescode =null, $errorMsgCode = null, $result = array(), $resultKey = null, $extraData = array()) {

		if(count($result)){
			$respose = array(
				"status" => $errorCode,
				"resCode"=>$rescode,
				"message" => $errorMsgCode,
				"result" => array(),
			);
		}
		else{
			$respose = array(
				"status" => $errorCode,
				"resCode"=>$rescode,
				"message" => $errorMsgCode,
				"result" => array(),
			);
		}

        if (count($result)) {
            if (!empty($resultKey)) {
                $respose['result'] = array($resultKey => $result);
            } else {
                $respose['result'] = $result;
            }
        }
		

        if (count($extraData)) {
            $respose['extra_data'] = $extraData;
        }
		$arr = array();
 		$arr['data'] = $respose;
        die(json_encode($arr));
    }
}
