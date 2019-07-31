<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//require(APPPATH.'/libraries/REST_Controller.php');

class Api extends MY_Controller
{

	
	function __construct()
    {
		parent::__construct();
		$this->load->model('category_model');
		//$this->load->model('standard_model');
		$this->load->model('responseconstant');
		$postData =  file_get_contents('php://input');
		$postDataArray = json_decode($postData);
       	if(!empty($postDataArray->method))
       	{
            $method = $postDataArray->method; 
            if(!empty($postDataArray->app_key))
            {
                //Verify AppKey
                 $checkAppKey = $this->checkAppKey($postDataArray->app_key);
                if (!$checkAppKey)
                {
                    $Code = ResponseConstant::HEADER_UNAUTHORIZED;
                    $Message = ResponseConstant::message('HEADER_UNAUTHORIZED');
                    $this->sendResponse($Code, $Message); // return data                                 
                }
            }
            else
            {
                $Code = ResponseConstant::UNSUCCESS;
                $Message = ResponseConstant::message('APPKEY_NOT_FOUND');
                $this->sendResponse($Code, $Message); // return data    
            }
        }
        else
        { 
            $Code = ResponseConstant::UNSUCCESS;
            $Message = ResponseConstant::message('METHOD_NOT_FOUND');
            $this->sendResponse($Code, $Message); // return data      
        }

        switch($method)
        {            
            case 'login':
            $this->login($postDataArray);
            break;
            case 'signUp':
            $this->signUp($postDataArray);
            break;
            case 'locationRestaurant':
            $this->locationRestaurant($postDataArray);
            break;
            case 'restaurant_list':
            $this->restaurant_list($postDataArray);
            break;
            case 'restaurantDetail':
            $this->restaurantDetail($postDataArray);
            break;
        }
    }

	// function category_get()
	// {

	// 	//$data = array("name" => "vicky", "class" => "b.tech");
	// 	//$data = $this->category_model->get_all_categories();
	// 	//$data =   $data['name'] = 'vikas';
	// 	//$jsn = json_encode($data);
	// 	//$this->response($data);
	// 	$testarray = array('fkey' => 'fvalue', 'skey'=>'svalue');
	// 	$Code = ResponseConstant::UNSUCCESS;
	// 	$Message = ResponseConstant::message('HEADER_UNAUTHORIZED');
	// 	$this->sendResponse($Code, $Message,$testarray);
	// 	// $res = array();
	// 	// $res['resturant']['key']['resturant_id']=1;
	// 	// print_r($res);
	// }

	// public function demo_post()
	// {
	// 	 $postData =  file_get_contents('php://input');
	// 	 //print_r($postData);    //give json format
	// 		$data = json_decode($postData);
	// 		$data->color ="green";
	// 		$data->food="indian";
	// 		print_r($data);

	// 		//to insert post data into tabel
	// 	  // $data = $this->category_model->insert_data(json_decode($postData));
	// 	  // if($data)
	// 	  // {
	// 	  // 	$this->response($data);
	// 	  // }
	// 	  // else{
	// 	  // 	echo"error encountered";
	// 	  // }
	// }

	public function locationRestaurant_post($postDataArray)
	{
		$lat = (isset($postDataArr->lat) && !empty($postDataArr->lat)) ? $postDataArr->lat : '';
		$lang = (isset($postDataArr->lang) && !empty($postDataArr->lang)) ? $postDataArr->lang : '';
		if (empty($lat) AND empty($lang))
		{
			$Code = ResponseConstant::UNSUCCESS;
			$Message = ResponseConstant::message('REQUIRED_PARAMETER');
			$this->sendResponse($Code, $Message); // return data
		}
		$this->load->model('user');
		$table = 'resturant';
		$column = array(
		            'lat'=>$lat,
		            'lang'=>$lang
		            );
		$flag = 'l_r';
		/*model function to find near by 5km resturants*/
		$result = $this->user->locationRestaurant($table,$column,$flag);
		if(count($result)>0)
		{

			$res = array();      
			foreach($result as $key=>$value)
			{     
			    $res['resturant'][$key]['resturant_id']=$value['id'];
			    $res['resturant'][$key]['resturant_name']= $value['resturant_name'] ;
			    $res['resturant'][$key]['resturant_image']= SITE_PATH.'upload/resturants_image/'.$value['image'];
			    $res['resturant'][$key]['resturant_address']=  $value['resturant_adds'];
			}
			/*--------Offer(Coupon) images----------------*/
			$flag = 'offer';
			$table = 'offer';
			$result = $this->user->locationRestaurant($table,$column,$flag);
			//  echo "<pre>"; print_r($result);die();
			foreach($result as $key=>$value)
			{
			   $res['coupon_image'][$key]['image'] = SITE_PATH.'upload/offer_coupon_image/'.$value['image'];
			}
			$Code = ResponseConstant::SUCCESS;
			$Message = ResponseConstant::message('SUCCESS');	
			/*$res = $this->model_name->getData($array);*/
			$this->sendResponse($Code, $Message,$res); // return data  
		}
		/*else block to find near by 100km resturants*/
		else
		{
			$table = 'resturant';
			$column = array(
			            'lat'=>$lat,
			            'lang'=>$lang
			            );
			$flag = 'f_r';
			$result = $this->user->locationRestaurant($table,$column,$flag);
			$res = array();            
			foreach($result as $key=>$value)
			{
			    $res['resturant'][$key]['resturant_id']=$value['id'];
			    $res['resturant'][$key]['resturant_name']= $value['resturant_name'] ;
			    $res['resturant'][$key]['resturant_image']= SITE_PATH.'upload/resturants_image'.$value['image'];
			    $res['resturant'][$key]['resturant_address']=  $value['resturant_adds'];
			}
			/*--------Offer(Coupon) images----------------*/
			$flag = 'offer';
			$table = 'offer';
			$result = $this->user->locationRestaurant($table,$column,$flag);
			//  echo "<pre>"; print_r($result);die();
			foreach($result as $key=>$value)
			{
			   $res['coupon_image'][$key]['image'] = SITE_PATH.'upload/offer_coupon_image/'.$value['image'];
			}

			$Code = ResponseConstant::SUCCESS;
			$Message = ResponseConstant::message('SUCCESS');
			/*$res = $this->model_name->getData($array);*/
			$this->sendResponse($Code, $Message,$res); // return data  
		}
	} // function location restaurent post closed here

	function restaurantDetail($postDataArr)
	{

		 //$this->sendResponse('500', 'testing response',array('a'=>'5'));die;
    	$restaurant_id = (isset($postDataArr->restaurant_id) && !empty($postDataArr->restaurant_id)) ? $postDataArr->restaurant_id : '';
       //echo "test";die();
        if (empty($restaurant_id))
        {
            $Code = ResponseConstant::UNSUCCESS;
            $Message = ResponseConstant::message('REQUIRED_PARAMETER');
            $this->sendResponse($Code, $Message); // return data
        }
        $this->load->model('user');
        $table = 'resturant';
        $flag = 'r_detail';
        $columns = array('id','resturant_name','image','resturant_adds','phone','owner_phone','lat','lang','resturant_type');
        $where = array('id'=>$restaurant_id);
        $result = $this->user->getRowData($where,$columns,$table,$flag);
        //echo "<pre>";print_r($result);die();
        if(count($result)>0)
        {
       
            $res = array();            
            /*foreach($result as $key=>$value){*/
                $res['id'] = $result->id;
                $res['restaurant_name'] = $result->resturant_name;
                $res['image'] =site_url().'upload/resturants_image/'.$result->image;
                $res['restaurant_address'] = $result->resturant_adds;
                $res['restaurant_Phone_No'] = $result->phone;
                $res['owner_Phone_No'] = $result->owner_phone;
                $res['latitude'] = $result->lat;
                $res['longitude'] = $result->lang;
                $res['resturant_type'] = $result->resturant_type;
                $res['delivery_time'] = '45 min';
                $res['rating'] = '4.6';
                $res['reviews'] = 'good';
            /*}*/
            /*--------code to fetch restaurant timing ----------------*/
            $table = 'resturant_timing';
            $flag = 'timing';
            $columns = array('open_time','close_time','day');
            $where = array('resturant_id'=>$restaurant_id);
            $timing = $this->user->getArrayData($where,$columns,$table,$flag);
           // echo "test";die;
            /*echo "<pre>"; print_r($timing);die();*/
            $selected_day = '' ;
            //$selected_day_key = '';
            foreach($timing as $key=>$value)
            {
    
               $selected_day = $res['open_day'][$key]['day'] = $value['day'];
               $res['open_day'][$key]['open_time'] = $value['open_time'];
               $res['open_day'][$key]['close_time'] = $value['close_time']; 
               // $res['open_day']['rest_days']['open_time'] = '00:00';
               // $res['open_day']['rest_days']['close_time'] = '00:00';
            }
            //echo $selected_day_key; 
            $res['open_day'][1]['day'] = '';
            // $res['open_day'][2]['close_time'] = 'test';
			$weekdays = array('Sunday','Monday','Tuesday','Wednesday','thursday','Friday', 'Saturday');
			$to_delete = in_array($selected_day, $weekdays);
			unset($weekdays[$to_delete]);
			$weekdays[1] = $weekdays[0];
			unset($weekdays[0]);
			foreach ($weekdays as $key => $value)
			{
				$res['open_day'][$key]['day'] = $value;
				$res['open_day'][$key]['open_time'] = '00:00';
				$res['open_day'][$key]['close_time'] = '00:00';	
			}


            $table = 'resturant_cusine';
            $columns = array('cusine_id');
            $where = array('resturant_id'=>$restaurant_id);
            $flag = 'multiJoin';
            $cusineId = $this->user->getArrayData($where,$columns,$table,$flag,$restaurant_id);
            
			
			if(!empty($cusineId))
	        {
	            $result = array();
	            foreach ($cusineId as $element=>$value) 
	            {
	               $result[$element['cu_id']][] = $value;
	            }
	            $grouped = $this->array_group_by($cusineId, "cusinename");

	           foreach ($grouped as $key => $value)
	            {
	                 $itemgrouped = $this->array_group_by($value, "item_name");
	                 $grouped[$key] = $itemgrouped;
	            }
	            $index = 0;
	           // echo "<pre>"; print_r($grouped); die;
	            foreach($grouped as $key=>$value)
	            {
	              //  echo "<pre>"; print_r($value); die;
	              //  $res['cuisines'][$index]['cusine_id'] = $value[0]['cu_id'];
	                $res['cuisines'][$index]['cusine_name'] = $key;
	                $res['cuisines'][$index]['items'] = [];
	                $indexofitem = 0;
	                foreach ($value as $key_item => $value_item)
	                {                    
	                    $res['cuisines'][$index]['items'][$indexofitem]['name'] = $key_item;
	                    $res['cuisines'][$index]['items'][$indexofitem]['type'] = $value_item[$index]['item_type'];
	                    $res['cuisines'][$index]['items'][$indexofitem]['cuisine_id'] = $value_item[$index]['cu_id'];
	                    $res['cuisines'][$index]['items'][$indexofitem]['resturant_menue_id'] = $value_item[$index]['id'];
	                    $indexofitemcust = 0;
	                   // echo "<pre>"; print_r($value_item); die;
	                    foreach ($value_item as $keycust_item => $valuecust_item)
	                    {
	                         $res['cuisines'][$index]['items'][$indexofitem]['customization'][$indexofitemcust]['resturant_menue_item_id'] = $valuecust_item['resturant_menue_item_id'];
	                         $res['cuisines'][$index]['items'][$indexofitem]['customization'][$indexofitemcust]['type'] = $valuecust_item['varient_menue'];
	                         $res['cuisines'][$index]['items'][$indexofitem]['customization'][$indexofitemcust]['price'] = $valuecust_item['price'];
	                         $indexofitemcust++;
	                    } 
	                    $indexofitem++;
	                }
	                 $index++;
	            }
	        }
	        else
	        {
	            $res['cuisines'] = array();
	        }
           //  echo "<pre>";print_r($res); die;
            
            $Code = ResponseConstant::SUCCESS;
            $Message = ResponseConstant::message('SUCCESS');
            /*$res = $this->model_name->getData($array);*/
            $this->sendResponse($Code, $Message,$res); // return data  
        }
        else
        {
            $object = new stdClass();
            $Code = ResponseConstant::UNSUCCESS;
            $Message = ResponseConstant::message('RESTURANT_NOT_FOUND');
            $this->sendResponse($Code, $Message,$object); // return data   
        }
   }


   function array_group_by(array $array, $key)
   {
        //print_r($key);die();
       // echo "in";
        if (!is_string($key) && !is_int($key) && !is_float($key) && !is_callable($key) )
        {
            trigger_error('array_group_by(): The key should be a string, an integer, or a callback', E_USER_ERROR);
            return null;
        }
        $func = (!is_string($key) && is_callable($key) ? $key : null);
        $_key = $key;
       /// echo "in5";
        // Load the new array, splitting by the target key
        $grouped = [];
        foreach ($array as $value) 
        {
            $key = null;
            if (is_callable($func)) {
                $key = call_user_func($func, $value);
            } elseif (is_object($value) && isset($value->{$_key})) {
                $key = $value->{$_key};
            } elseif (isset($value[$_key])) {
                $key = $value[$_key];
            }
            if ($key === null) {
                continue;
            }
            $grouped[$key][] = $value;
        }

        // Recursively build a nested grouping if more parameters are supplied
        // Each grouped array value is grouped according to the next sequential key
        if (func_num_args() > 2)
        {
            $args = func_get_args();
            foreach ($grouped as $key => $value)
            {
                $params = array_merge([ $value ], array_slice($args, 2, func_num_args()));
                $grouped[$key] = call_user_func_array('array_group_by', $params);
            }
        }
        return $grouped;
    }


    

}  // class api extends ci controller closed here


