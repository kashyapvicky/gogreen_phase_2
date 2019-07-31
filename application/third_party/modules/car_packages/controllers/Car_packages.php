<?php

defined('BASEPATH') OR exit('No direct script access allowed');

//require(APPPATH.'/libraries/REST_Controller.php');

class Car_packages extends MY_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('car_packages_model');
        //$this->load->model('standard_model');
        //responseconstant
        $this->load->model('responseconstant');
        $postData = file_get_contents('php://input');
        $postDataArray = json_decode($postData); //print_r($postDataArray); die;
        if (!empty($postDataArray->method)) {
            $method = $postDataArray->method;
            //echo $method; die; 
            if (!empty($postDataArray->app_key)) {
                //Verify AppKey
                $checkAppKey = $this->checkAppKey($postDataArray->app_key);
                if (!$checkAppKey) {
                    $Code = ResponseConstant::UNSUCESS;
                    $rescode = ResponseConstant::HEADER_UNAUTHORIZED;
                    $Message = ResponseConstant::message('HEADER_UNAUTHORIZED');
                    $this->sendResponse($Code, $rescode, $Message); // return data                                 
                }
            } else {
                $Code = ResponseConstant::UNSUCCESS;
                $rescode = ResponseConstant::APPKEY_NOT_FOUND;
                $Message = ResponseConstant::message('APPKEY_NOT_FOUND');
                $this->sendResponse($Code, $Message); // return data    
            }
        } else {


            $Code = ResponseConstant::UNSUCCESS;
            $rescode = ResponseConstant::METHOD_NOT_FOUND;
            $Message = ResponseConstant::message('METHOD_NOT_FOUND');
            $this->sendResponse($Code, $Message); // return data      
        }
        switch ($method) {

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
            case 'edit_car_detail':
                $this->edit_car_detail($postDataArray);
                break;
            case 'remove_car':
                $this->remove_car($postDataArray);
                break;
            case 'get_coupans':
                $this->get_coupans($postDataArray);
                break;
            case 'is_valid_coupan':
                $this->is_valid_coupan($postDataArray);
                break;
        }
    }

    public function insert_car_detail($postDataArray) {
        //print_r($postDataArray);die;
        $user_id = (isset($postDataArray->user_id) && !empty($postDataArray->user_id)) ? $postDataArray->user_id : '';
        $city_id = (isset($postDataArray->city_id) && !empty($postDataArray->city_id)) ? $postDataArray->city_id : '';
        $locality_id = (isset($postDataArray->locality_id) && !empty($postDataArray->locality_id)) ? $postDataArray->locality_id : '';
        $street_id = (isset($postDataArray->street_id) && !empty($postDataArray->street_id)) ? $postDataArray->street_id : '';
        $brand = (isset($postDataArray->brand) && !empty($postDataArray->brand)) ? $postDataArray->brand : '';
        $model = (isset($postDataArray->model) && !empty($postDataArray->model)) ? $postDataArray->model : '';
        $reg_no = (isset($postDataArray->reg_no) && !empty($postDataArray->reg_no)) ? $postDataArray->reg_no : '';
        $color = (isset($postDataArray->color) && !empty($postDataArray->color)) ? $postDataArray->color : '';
        $parking_number = (isset($postDataArray->parking_number) && !empty($postDataArray->parking_number)) ? $postDataArray->parking_number : '';
        $apartment_number = (isset($postDataArray->apartment_number) && !empty($postDataArray->apartment_number)) ? $postDataArray->apartment_number : '';
        $car_type = (isset($postDataArray->car_type) && !empty($postDataArray->car_type)) ? $postDataArray->car_type : '';


        if (empty($user_id) || empty($brand) || empty($model) || empty($reg_no) || empty($color)  || empty($apartment_number) || empty($city_id) || empty($locality_id) || empty($street_id) || empty($car_type)) {

            $Code = ResponseConstant::UNSUCCESS;
            $rescode = ResponseConstant::UNSUCCESS;
            $Message = ResponseConstant::message('REQUIRED_PARAMETER');
            $this->sendResponse($Code, $rescode, $Message);
        } else {

            $bool = $this->car_packages_model->check_reg_no($user_id, $reg_no);
            if ($bool) {
                //echo $bool; die;
                $Code = ResponseConstant::UNSUCCESS;
                $rescode = ResponseConstant::UNSUCCESS;
                $Message = "CAR ALREADY EXIST";
                $this->sendResponse($Code, $rescode, $Message);
            } else {


                $data = array(
                    'user_id' => $user_id,
                    'city_id' => $city_id,
                    'locality_id' => $locality_id,
                    'street_id' => $street_id,
                    'brand' => $brand,
                    'model' => $model,
                    'type' => $car_type,
                    'color' => $color,
                    'reg_no' => $reg_no,
                    'parking_number' => $parking_number,
                    'apartment_number' => $apartment_number,
                );

                $inserted_data = $this->car_packages_model->insert_car_details($data);

                if ($inserted_data) {
                    $Code = ResponseConstant::SUCCESS;
                    $rescode = ResponseConstant::SUCCESS;
                    $Message = ResponseConstant::message('DA_ADD_SUCCESSFULLY');
                    $this->sendResponse($Code, $rescode, $Message, array($data));
                } else {
                    $Code = ResponseConstant::UNSUCCESS;
                    $rescode = ResponseConstant::UNSUCCESS;
                    $Message = ResponseConstant::message('DATA_NOT_INSERTED');
                } $this->sendResponse($Code, $rescode, $Message);
            }
        }
    }

    public function car_list($postDataArray) {
        //echo"test";die;
        $user_id = (isset($postDataArray->user_id) && !empty($postDataArray->user_id)) ? $postDataArray->user_id : '';

        if (empty($user_id)) {
            $Code = ResponseConstant::UNSUCCESS;
            $rescode = ResponseConstant::UNSUCCESS;
            $Message = ResponseConstant::message('REQUIRED_PARAMETER');
            $this->sendResponse($Code, $rescode, $Message);
        } else {
            $car_array = $this->car_packages_model->get_cars($user_id);



            if ($car_array) {
                foreach ($car_array as $car) {
                    $expiry_date = $car['expiry_date'];
                    //echo $expiry_date; die;
                    $today = date("Y-m-d");
                    $difference = strtotime($expiry_date) - strtotime($today);
                    //echo $difference; die;
                    if ($difference <= 0) {
                        //echo $difference;die;
                        // echo "<br>";
                        //echo $car['id'];die;
                        $bool = $this->car_packages_model->update_is_package_as_expire($car['id']);
                    }
                    //die('nothing');
                }




                $car_array_updated = $this->car_packages_model->get_cars_updated($user_id);
                if ($car_array_updated) {
                    $Code = ResponseConstant::SUCCESS;
                    $rescode = ResponseConstant::SUCCESS;
                    $Message = 'SUCCESS';
                    $this->sendResponse($Code, $rescode, $Message, $car_array_updated);
                } else {
                    $Code = ResponseConstant::UNSUCCESS;
                    $rescode = ResponseConstant::UNSUCCESS;
                    $Message = 'NO CAR FOUND';
                    $this->sendResponse($Code, $rescode, $Message);
                }
            } else {
                $Code = ResponseConstant::UNSUCCESS;
                $rescode = ResponseConstant::UNSUCCESS;
                $Message = 'NO CAR FOUND';
                $this->sendResponse($Code, $rescode, $Message);
            }
        }
    }

    public function get_car_model($postDataArray) {
        $brand_id = (isset($postDataArray->brand_id) && !empty($postDataArray->brand_id)) ? $postDataArray->brand_id : '';
        if (empty($brand_id)) {
            $Code = ResponseConstant::UNSUCCESS;
            $rescode = ResponseConstant::UNSUCCESS;
            $Message = ResponseConstant::message('REQUIRED_PARAMETER');
            $this->sendResponse($Code, $rescode, $Message);
        }
        $model_array = $this->car_packages_model->get_models($brand_id);
        if ($model_array) {
            $Code = ResponseConstant::SUCCESS;
            $rescode = ResponseConstant::SUCCESS;
            $Message = 'SUCCESS';
            $this->sendResponse($Code, $rescode, $Message, $model_array);
        } else {
            $Code = ResponseConstant::UNSUCCESS;
            $rescode = ResponseConstant::UNSUCCESS;
            $Message = 'UNSUCCESS';
            $this->sendResponse($Code, $rescode, $Message);
        }
    }

    public function get_car_brand($postDataArray) {
        $brand_array = $this->car_packages_model->get_brand();
        if ($brand_array) {
            $Code = ResponseConstant::SUCCESS;
            $rescode = ResponseConstant::SUCCESS;
            $Message = 'SUCCESS';
            $this->sendResponse($Code, $rescode, $Message, $brand_array);
        } else {
            $Code = ResponseConstant::UNSUCCESS;
            $rescode = ResponseConstant::UNSUCCESS;
            $Message = 'UNSUCCESS';
            $this->sendResponse($Code, $rescode, $Message);
        }
    }

    public function add_brand($postDataArray) {

        $brand_name = (isset($postDataArray->brand_name) && !empty($postDataArray->brand_name)) ? $postDataArray->brand_name : '';
        $type = (isset($postDataArray->type) && !empty($postDataArray->type)) ? $postDataArray->type : '';
        $model_name = (isset($postDataArray->model_name) && !empty($postDataArray->model_name)) ? $postDataArray->model_name : '';
        if (empty($brand_name) || empty($type) || empty($model_name)) {
            $Code = ResponseConstant::UNSUCCESS;
            $rescode = ResponseConstant::UNSUCCESS;
            $Message = ResponseConstant::message('REQUIRED_PARAMETER');
            $this->sendResponse($Code, $rescode, $Message);
        } else {
            $bool = $this->car_packages_model->check_brand_name($brand_name);
            $bool_model = $this->car_packages_model->check_model_name($model_name);
            if (!empty($bool) || !empty($bool_model)) {
                $Code = ResponseConstant::UNSUCCESS;
                $rescode = ResponseConstant::UNSUCCESS;
                $Message = 'Alrady Exist';
                $this->sendResponse($Code, $rescode, $Message);
            } else {
                $data = array(
                    'name' => $brand_name,
                    'type' => $type
                );
                $insert_id = $this->car_packages_model->insert_brand($data);
                if ($insert_id) {
                    $data = array(
                        'name' => $model_name,
                        'type' => $type,
                        'brand_id' => $insert_id,
                    );
                    $bool = $this->car_packages_model->insert_model($data);
                    if ($bool) {
                        $Code = ResponseConstant::SUCCESS;
                        $rescode = ResponseConstant::SUCCESS;
                        $Message = ResponseConstant::message('DA_ADD_SUCCESSFULLY');
                        $this->sendResponse($Code, $rescode, $Message);
                    } else {
                        $Code = ResponseConstant::UNSUCCESS;
                        $rescode = ResponseConstant::UNSUCCESS;
                        $Message = 'Error In Insertion';
                        $this->sendResponse($Code, $rescode, $Message);
                    }
                } else {
                    $Code = ResponseConstant::UNSUCCESS;
                    $rescode = ResponseConstant::UNSUCCESS;
                    $Message = 'Error In Insertion';
                    $this->sendResponse($Code, $rescode, $Message);
                }
            }
        }
    }

    public function add_model($postDataArray) {

        $name = (isset($postDataArray->name) && !empty($postDataArray->name)) ? $postDataArray->name : '';
        $type = (isset($postDataArray->type) && !empty($postDataArray->type)) ? $postDataArray->type : '';
        $brand_id = (isset($postDataArray->brand_id) && !empty($postDataArray->brand_id)) ? $postDataArray->brand_id : '';
        if (empty($name) || empty($type) || empty($brand_id)) {
            $Code = ResponseConstant::UNSUCCESS;
            $rescode = ResponseConstant::UNSUCCESS;
            $Message = ResponseConstant::message('REQUIRED_PARAMETER');
            $this->sendResponse($Code, $rescode, $Message);
        } else {
            $bool = $this->car_packages_model->check_model_name($name);
            if ($bool) {
                $Code = ResponseConstant::UNSUCCESS;
                $rescode = ResponseConstant::UNSUCCESS;
                $Message = 'Model Name Alrady Exist';
                $this->sendResponse($Code, $rescode, $Message);
            } else {
                $data = array(
                    'name' => $name,
                    'type' => $type,
                    'brand_id' => $brand_id,
                );
                $bool = $this->car_packages_model->insert_model($data);
                if ($bool) {
                    $Code = ResponseConstant::SUCCESS;
                    $rescode = ResponseConstant::SUCCESS;
                    $Message = ResponseConstant::message('DA_ADD_SUCCESSFULLY');
                    $this->sendResponse($Code, $rescode, $Message);
                } else {
                    $Code = ResponseConstant::UNSUCCESS;
                    $rescode = ResponseConstant::UNSUCCESS;
                    $Message = 'Error In Insertion';
                    $this->sendResponse($Code, $rescode, $Message);
                }
            }
        }
    }

    public function package($postDataArray) {
        $locality_id = (isset($postDataArray->locality_id) && !empty($postDataArray->locality_id)) ? $postDataArray->locality_id : '';

        $car_type = (isset($postDataArray->car_type) && !empty($postDataArray->car_type)) ? $postDataArray->car_type : '';


        if (empty($locality_id) || empty($car_type)) {
            $Code = ResponseConstant::UNSUCCESS;
            $rescode = ResponseConstant::UNSUCCESS;
            $Message = ResponseConstant::message('REQUIRED_PARAMETER');
            $this->sendResponse($Code, $rescode, $Message);
        } {
            $package_row = $this->car_packages_model->get_package($locality_id, $car_type);
            if ($package_row) {
                //print_r($package_row);die;

                $responce['monthly']['id'] = $package_row[0]['id'];
                $responce['monthly']['interior_once'] = $package_row[0]['interior_once'];
                $responce['monthly']['exterior_once'] = $package_row[0]['exterior_once'];
                $responce['monthly']['interior_thrice'] = $package_row[0]['interior_thrice'];
                $responce['monthly']['exterior_thrice'] = $package_row[0]['exterior_thrice'];
                $responce['monthly']['interior_five'] = $package_row[0]['interior_five'];
                $responce['monthly']['exterior_five'] = $package_row[0]['exterior_five'];
                $responce['once']['id'] = $package_row[0]['id'];
                $responce['once']['price_interior'] = $package_row[0]['price_interior'];
                $responce['once']['price_exterior'] = $package_row[0]['price_exterior'];
                //print_r($responce); die;
                $Code = ResponseConstant::SUCCESS;
                $rescode = ResponseConstant::SUCCESS;
                $Message = "SUCCESFULLY GET PACKAGE";
                $this->sendResponse($Code, $rescode, $Message, array($responce));
            } else {
                $Code = ResponseConstant::UNSUCCESS;
                $rescode = ResponseConstant::UNSUCCESS;
                $Message = 'Package Not Exist';
                $this->sendResponse($Code, $rescode, $Message);
            }
        }
    }

    public function insert_booked_services($postDataArray)
    {
        //echo"<pre>";print_r($postDataArray); die;

        $user_id = (isset($postDataArray->user_id) && !empty($postDataArray->user_id)) ? $postDataArray->user_id : '';
        $transaction_id = (isset($postDataArray->transaction_id) && !empty($postDataArray->transaction_id)) ? $postDataArray->transaction_id : '';
        $net_paid = (isset($postDataArray->net_paid) && !empty($postDataArray->net_paid)) ? $postDataArray->net_paid : '';
        $actual_payment = (isset($postDataArray->actual_payment) && !empty($postDataArray->actual_payment)) ? $postDataArray->actual_payment : '';
        $payment_type = (isset($postDataArray->payment_type) && !empty($postDataArray->payment_type)) ? $postDataArray->payment_type : '';
        $coupan_applied = (isset($postDataArray->coupan_applied) && !empty($postDataArray->coupan_applied)) ? $postDataArray->coupan_applied : '';

        $city_id = (isset($postDataArray->city_id) && !empty($postDataArray->city_id)) ? $postDataArray->city_id : '';
        $locality_id = (isset($postDataArray->locality_id) && !empty($postDataArray->locality_id)) ? $postDataArray->user_id : '';
        $street_id = (isset($postDataArray->street_id) && !empty($postDataArray->street_id)) ? $postDataArray->street_id : '';
        if (empty($user_id) || empty($transaction_id) || empty($net_paid) || empty($actual_payment) || empty($payment_type) || empty($coupan_applied)) {
            $Code = ResponseConstant::UNSUCCESS;
            $rescode = ResponseConstant::UNSUCCESS;
            $Message = ResponseConstant::message('REQUIRED_PARAMETER');
            $this->sendResponse($Code, $rescode, $Message);
        } else {


            $user_payment_data = array(
                'user_id' => $user_id,
                'transaction_id' => $transaction_id,
                'orders_id' => '',
                'net_paid' => $net_paid,
                'actual_payment' => $actual_payment,
                'coupan_applied' => $coupan_applied,
                'payment_type' => $payment_type
            );

            $insert_id = $this->car_packages_model->insert_user_payment_data($user_payment_data);
            if ($insert_id) {

                // update is payment on users tabel
                $this->car_packages_model->update_is_payment($user_id);


                //update  order id on user_payment tabel
                $order_id = 100000 + $insert_id;
                $this->car_packages_model->update_order_id($insert_id, $order_id);


                // foreach loop to insert details in booked_package tabel start from here 
                $this->assiagn_team($postDataArray, $insert_id);

                $book_package_insertion = 0;
                foreach ($postDataArray->cars as $key => $value)
                {
                    $car_id = $value->car_id;
                    $package_type = $value->package_type;
                    $purchase_date = $value->purchase_date;

                    // $city_id = $value->city_id;
                    // $locality_id = $value->locality_id;
                    // $street_id = $value->street_id;

                    if ($package_type == 'monthly') {
                        $expiry_date = date('Y-m-d', strtotime($purchase_date . '+1 month'));
                        $one_time_service_date = Null;
                    } else {
                        $one_time_service_date = $value->one_time_service_date;
                        $expiry_date = date('Y-m-d', strtotime($one_time_service_date . '+1 day'));
                        //echo $one_time_service_date; die;
                    }
                    $services = $value->services;
                    $days = $value->days;
                    $frequency = $value->frequency;
                    $amount = $value->amount;
                    $data = array(
                        'user_id' => $user_id,
                        'payment_key' => $insert_id,
                        'car_id' => $car_id,
                        'transaction_id' => $transaction_id,
                        'package_type' => $package_type,
                        'purchase_date' => $purchase_date,
                        'expiry_date' => $expiry_date,
                        'one_time_service_date' => $one_time_service_date,
                        'services' => $services,
                        'days' => $days,
                        'frequency' => $frequency,
                        'amount' => $amount,
                        'city_id'=>$city_id,
                        'locality_id'=>$locality_id,
                        'street_id'=>$street_id
                    );
                    $row = $this->car_packages_model->check_car_id_existence($car_id);
                    // //echo $this->db->last_query(); die;
                    if ($row) {
                        //echo"hello";die;
                        // if user_renew the package the new entry will go to tabel but the previous car packaege status change to 2
                        $this->car_packages_model->update_package_status($car_id);
                    }
                    //{
                    // 	$data_to_update = array(
                    // 		'user_id'=>$user_id,
                    // 		'payment_key'=>$insert_id,
                    // 		'transaction_id'=>$transaction_id,
                    // 		'package_type'=>$package_type,
                    // 		'purchase_date'=>$purchase_date,
                    // 		'expiry_date'=>$expiry_date,
                    // 		'services'=>$services,
                    // 		'one_time_service_date'=>$one_time_service_date,
                    // 		'days'=>$days,
                    // 		'frequency'=>$frequency,
                    // 		'amount'=>$amount
                    // 	);
                    // 	$bool = $this->car_packages_model->update_car_package($car_id,$data_to_update);
                    // 	if($bool)
                    // 	{
                    // 		$package_activated = $this->car_packages_model->update_is_packege_car_key($car_id);
                    // 		$book_package_insertion=1;
                    // 	}
                    // }
                    // else
                    // {
                    $package_activated = $this->car_packages_model->update_is_packege_car_key($car_id);
                    $insert_id_of_booked_package = $this->car_packages_model->insert_book_package($data);
                    if ($insert_id_of_booked_package) {
                        $book_package_insertion = 1;
                    }
                    //}
                }//foreach loop ends here
                // to check weather the data in booked_package is inserted properly or not we take $book_package_insertion

                if ($book_package_insertion == 1) {

                    $Code = ResponseConstant::SUCCESS;
                    $rescode = ResponseConstant::SUCCESS;
                    $Message = "DATA INSERTED SUCCESSFULLY";
                    $this->sendResponse($Code, $rescode, $Message);
                } else {
                    $Code = ResponseConstant::UNSUCCESS;
                    $rescode = ResponseConstant::UNSUCCESS;
                    $Message = "ERROR IN INSERTION PACKAGE";
                    $this->sendResponse($Code, $rescode, $Message);
                }
            } else {
                $Code = ResponseConstant::UNSUCCESS;
                $rescode = ResponseConstant::UNSUCCESS;
                $Message = "ERROR IN GETING PAYMENT";
                $this->sendResponse($Code, $rescode, $Message);
            }
        }
    }

    public function assiagn_team($postDataArray, $insert_id) {
        $user_id = $postDataArray->user_id;
        $street_id_to_assiagn_team = $postDataArray->street_id;
        // foreach ($postDataArray->cars as $key => $value)
        // {
        //     $car_id = $value->car_id;

        //     $row = $this->car_packages_model->get_street_id_by_car_id($car_id);
        //     $street_id_to_assiagn_team = $row['street_id'];
        // }
        // either team id found or not on that street
        //echo $row['street_id']; die;
        $team = $this->car_packages_model->get_team_id_by_street_id($street_id_to_assiagn_team);
        $team_id = $team['id'];
        //echo $team_id; die;
        if (!empty($team_id)) {

            $data = array(
                'team_id' => $team_id,
                'user_id' => $user_id,
                'payment_key' => $insert_id,
            );
            $insert_id = $this->car_packages_model->insert_data_to_assiagned_team($data);

            //update increment job by one
            $this->car_packages_model->increment_job_by_one_in_teams_tabel($team_id);
        } else {
            $data = array(
                'team_id' => 0,
                'user_id' => $user_id,
                'payment_key' => $insert_id,
            );
            $insert_id = $this->car_packages_model->insert_data_to_assiagned_team($data);
        }
    }

    public function upcoming_renewals($postDataArray) {
        $user_id = (isset($postDataArray->user_id) && !empty($postDataArray->user_id)) ? $postDataArray->user_id : '';
        if (empty($user_id)) {
            $Code = ResponseConstant::UNSUCCESS;
            $rescode = ResponseConstant::UNSUCCESS;
            $Message = ResponseConstant::message('REQUIRED_PARAMETER');
            $this->sendResponse($Code, $rescode, $Message);
        } else {
            $row = $this->car_packages_model->check_user_id($user_id);
            if ($row) {
                $today = date('Y-m-d');
                $next_week = date('Y-m-d', strtotime("+7 days"));
                $expired_packages_detail['upcoming_renewals'] = $this->car_packages_model->get_expired_packages_detail($user_id);
                //print_r($expired_packages_detail); die;	
                $expired_packages_detail['services'] = $this->car_packages_model->get_week_before_data($user_id, $today, $next_week);

                //print_r($expired_packages_detail['services']); die;
                // foreach ($expired_packages_detail['services'] as $key => $value)
                // {
                // 		if($value['package_type'] == 'monthly')
                // 		{
                // 			$days = $value['days'];
                // 			$days_array = explode(',',$days);
                // 			//print_r($days_array);die;
                // 					//print_r($days_array);die;
                // 					//$aa = array('Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday');
                // 					//echo "<pre>"; print_r($days_array); //die;
                // 					$current_day =  date('D');									
                // 					$k=array(); //die;
                // 					foreach ($days_array as $keys=>$val)
                // 					{
                // 						if($val == $current_day)
                // 						{
                // 							$k[] = $keys;
                // 						}else{
                // 							//echo "fxvx"; die;
                // 							$next_date = date('Y-m-d', strtotime($current_day .' +1 day'));
                // 							$nextDay = date('D', strtotime($next_date));
                // 							if($val == $nextDay)
                // 							{
                // 								$k[] = $keys;
                // 							}
                // 							//echo $day; die;
                // 						}
                // 					}
                // 					//echo $key; die;
                // 					//echo "<pre>kk"; print_r($k); die;
                // 					if(!empty($k)){
                // 						for($i=0; $i<count($days_array); $i++)
                // 						{
                // 							if($k[0]<=$i)
                // 							{
                // 								$b[] = $days_array[$i];
                // 							}
                // 						}
                // 					}
                // 					//echo "<pre>"; print_r($b); die;
                // 					 $new = implode(',',$b);
                // 					 //print_r($new); die;
                // 					// 
                // 					$expired_packages_detail['services'][$key]['days']=$new;
                // 					//
                // 		}
                // }
//echo "<pre>"; print_r($expired_packages_detail['services']); die;

                $coupans = $this->car_packages_model->get_all_coupans();
                //print_r($coupans); die;
                foreach ($coupans as $key => $value) {
                    //echo "hello";die;
                  //  $coupans[$key]['img_path'] = base_url() . 'uploads/' . $value['img_name'];
                    $coupans[$key]['img_path'] = 'http://13.126.99.14/gogreen/'. 'uploads/' . $value['img_name'];
                    //print_r($coupans); die;
                }
                $expired_packages_detail['coupans'] = $coupans;

                $Code = ResponseConstant::SUCCESS;
                $rescode = ResponseConstant::SUCCESS;
                $Message = 'SUCCESS';
                $this->sendResponse($Code, $rescode, $Message, $expired_packages_detail);
                //print_r($expired_packages_detail); die;
            } else {
                $Code = ResponseConstant::UNSUCCESS;
                $rescode = ResponseConstant::UNSUCCESS;
                $Message = 'USER ID DOES NOT EXIST ';
                $this->sendResponse($Code, $rescode, $Message);
            }
            // $today = date('Y-m-d');
            // $next_week = date('Y-m-d',strtotime("+7 days"));
            // $upcoming_details = $this->car_packages_model->get_week_before_data($user_id,$today,$next_week);
            // //print_r($upcoming_details); die;
            // if(!empty($upcoming_details))
            // {
            // 	$up = array();
            // 	 foreach ($upcoming_details as $key => $value) {
            // 	 	if($value['package_type']=='monthly')
            // 	 	{
            // 			$up['upcoming'][] = $value;
            // 			$up['services'][] = $value;
            // 	 	}
            // 	 	else
            // 	 	{
            // 			$up['services'][] = $value;
            // 	 	}
            // 	 }
            // 	// if(empty($up)){
            // 	 	if (array_key_exists("upcoming",$up)){
            // 	 }else{
            // 	 	$up['upcoming'] = array();
            // 	 }
            // 	//echo"<pre>"; print_r($up); die;
            // 	$Code = ResponseConstant::SUCCESS;
            // 	$rescode = ResponseConstant::SUCCESS;
            // 	$Message = "SUCCESFULL";
            // 	$this->sendResponse($Code,$rescode,$Message,$up);
            // }
            // else
            // {
            // 	$res = array('upcoming'=>array(),'services'=>array());
            // 	$Code = ResponseConstant::SUCCESS;
            // 	$rescode = ResponseConstant::SUCCESS;
            // 	$Message = "CARS NOT FOUND";
            // 	$this->sendResponse($Code,$rescode,$Message,$res);
            // }
        }
    }

    public function edit_car_detail($postDataArray) {
        //print_r($postDataArray);die;
        $user_id = (isset($postDataArray->user_id) && !empty($postDataArray->user_id)) ? $postDataArray->user_id : '';
        $car_id = (isset($postDataArray->car_id) && !empty($postDataArray->car_id)) ? $postDataArray->car_id : '';
        $city_id = (isset($postDataArray->city_id) && !empty($postDataArray->city_id)) ? $postDataArray->city_id : '';
        $locality_id = (isset($postDataArray->locality_id) && !empty($postDataArray->locality_id)) ? $postDataArray->locality_id : '';
        $street_id = (isset($postDataArray->street_id) && !empty($postDataArray->street_id)) ? $postDataArray->street_id : '';
        $brand = (isset($postDataArray->brand) && !empty($postDataArray->brand)) ? $postDataArray->brand : '';
        $model = (isset($postDataArray->model) && !empty($postDataArray->model)) ? $postDataArray->model : '';
        $reg_no = (isset($postDataArray->reg_no) && !empty($postDataArray->reg_no)) ? $postDataArray->reg_no : '';
        $color = (isset($postDataArray->color) && !empty($postDataArray->color)) ? $postDataArray->color : '';
        $parking_number = (isset($postDataArray->parking_number) && !empty($postDataArray->parking_number)) ? $postDataArray->parking_number : '';
        $apartment_number = (isset($postDataArray->apartment_number) && !empty($postDataArray->apartment_number)) ? $postDataArray->apartment_number : '';
        //$car_type = (isset($postDataArray->car_type) && !empty($postDataArray->car_type)) ? $postDataArray->car_type: '';


        if (empty($user_id) || empty($car_id) || empty($brand) || empty($model) || empty($reg_no) || empty($color) || empty($apartment_number) || empty($city_id) || empty($locality_id) || empty($street_id)) {

            $Code = ResponseConstant::UNSUCCESS;
            $rescode = ResponseConstant::UNSUCCESS;
            $Message = ResponseConstant::message('REQUIRED_PARAMETER');
            $this->sendResponse($Code, $rescode, $Message);
        } else {

            $row = $this->car_packages_model->check_user_id_and_car_id($user_id, $car_id);
            if ($row) {
                //echo $bool; die;
                $data = array(
                    'city_id' => $city_id,
                    'locality_id' => $locality_id,
                    'street_id' => $street_id,
                    'brand' => $brand,
                    'model' => $model,
                    'color' => $color,
                    'reg_no' => $reg_no,
                    'parking_number' => $parking_number,
                    'apartment_number' => $apartment_number,
                );

                $bool = $this->car_packages_model->update_car_detail($data, $car_id);
                if ($bool) {
                    $Code = ResponseConstant::SUCCESS;
                    $rescode = ResponseConstant::SUCCESS;
                    $Message = "DATA UPDATED SUCCESFULLY";
                    $this->sendResponse($Code, $rescode, $Message);
                } else {
                    $Code = ResponseConstant::UNSUCCESS;
                    $rescode = ResponseConstant::UNSUCCESS;
                    $Message = "ERROR IN UPDATION";
                    $this->sendResponse($Code, $rescode, $Message);
                }
            } else {

                $Code = ResponseConstant::UNSUCCESS;
                $rescode = ResponseConstant::UNSUCCESS;
                $Message = "CAR OR USER ID DOES NOT EXIST";
                $this->sendResponse($Code, $rescode, $Message);
            }
        }
    }

    public function remove_car($postDataArray) {
        $user_id = (isset($postDataArray->user_id) && !empty($postDataArray->user_id)) ? $postDataArray->user_id : '';
        $car_id = (isset($postDataArray->car_id) && !empty($postDataArray->car_id)) ? $postDataArray->car_id : '';
        if (empty($user_id) || empty($car_id)) {

            $Code = ResponseConstant::UNSUCCESS;
            $rescode = ResponseConstant::UNSUCCESS;
            $Message = ResponseConstant::message('REQUIRED_PARAMETER');
            $this->sendResponse($Code, $rescode, $Message);
        } else {

            $row = $this->car_packages_model->check_user_id_and_car_id($user_id, $car_id);
            if ($row) {
                $bool = $this->car_packages_model->delete_car($user_id, $car_id);
                if ($bool) {
                    $Code = ResponseConstant::SUCCESS;
                    $rescode = ResponseConstant::SUCCESS;
                    $Message = "DELETED SUCCESSFULLY";
                    $this->sendResponse($Code, $rescode, $Message);
                } else {
                    $Code = ResponseConstant::UNSUCCESS;
                    $rescode = ResponseConstant::UNSUCCESS;
                    $Message = "ERROR IN DELETION";
                    $this->sendResponse($Code, $rescode, $Message);
                }
            } else {
                $Code = ResponseConstant::UNSUCCESS;
                $rescode = ResponseConstant::UNSUCCESS;
                $Message = "CAR OR USER ID DOES NOT EXIST";
                $this->sendResponse($Code, $rescode, $Message);
            }
        }
    }

    public function get_coupans($postDataArray) {
        $coupans = $this->car_packages_model->get_all_coupans();
        //print_r($coupans); die;
        foreach ($coupans as $key => $value) {
            //echo "hello";die;
            $coupans[$key]['img_path'] = base_url() . 'uploads/' . $value['img_name'];
            //print_r($coupans); die;
        }
        if ($coupans) {
            $Code = ResponseConstant::SUCCESS;
            $rescode = ResponseConstant::SUCCESS;
            $Message = "SUCCESS";
            $this->sendResponse($Code, $rescode, $Message, $coupans);
        } else {
            $Code = ResponseConstant::UNSUCCESS;
            $rescode = ResponseConstant::UNSUCCESS;
            $Message = "COUPAN DOES NOT EXIST";
            $this->sendResponse($Code, $rescode, $Message);
        }
    }

    public function is_valid_coupan($postDataArray) {
        $user_id = (isset($postDataArray->user_id) && !empty($postDataArray->user_id)) ? $postDataArray->user_id : '';
        $coupan_code = (isset($postDataArray->coupan_code) && !empty($postDataArray->coupan_code)) ? $postDataArray->coupan_code : '';
        $amount = (isset($postDataArray->amount) && !empty($postDataArray->amount)) ? $postDataArray->amount : '';

        //$this->car_packages_model->is_new_or_existed_user($user_id)
        if (empty($user_id) || empty($coupan_code)) {

            $Code = ResponseConstant::UNSUCCESS;
            $rescode = ResponseConstant::UNSUCCESS;
            $Message = ResponseConstant::message('REQUIRED_PARAMETER');
            $this->sendResponse($Code, $rescode, $Message);
        } else {
            $row = $this->car_packages_model->check_user_id($user_id);
            if ($row) {
                $active_user_row = $this->car_packages_model->is_user_active($user_id);
                if ($active_user_row) {
                    //echo"user is active";die;
                    $data = array('coupan_code' => $coupan_code, 'user_type' => 2);
                    $coupan_row = $this->car_packages_model->get_coupan_code_detail($data);
                    if ($coupan_row) {
                        //print_r($coupan_row); die;
                        if ($amount < $coupan_row['minimum_order']) {
                            $Code = ResponseConstant::UNSUCCESS;
                            $rescode = ResponseConstant::UNSUCCESS;
                            $Message = 'AMOUNT IS LESS THAN THE MINIMUM ORDER';
                            $this->sendResponse($Code, $rescode, $Message);
                        } else {
                            $discount_amount = ($amount * $coupan_row['discount']) / 100;
                            //echo $discount_amount; die;
                            if ($discount_amount > $coupan_row['max_discount']) {
                                $Code = ResponseConstant::UNSUCCESS;
                                $rescode = ResponseConstant::UNSUCCESS;
                                $Message = 'MAX DISCOUNT LIMIT EXCEEDS';
                                $this->sendResponse($Code, $rescode, $Message);
                            } else {
                                $Code = ResponseConstant::SUCCESS;
                                $rescode = ResponseConstant::SUCCESS;
                                $Message = 'SUCCESS';
                                $this->sendResponse($Code, $rescode, $Message, array($coupan_row));
                            }
                        }
                        // $Code = ResponseConstant::SUCCESS;
                        // $rescode = ResponseConstant::SUCCESS;
                        // $Message = 'SUCCESS';
                        // $this->sendResponse($Code,$rescode,$Message,array($coupan_row));
                    } else {
                        $Code = ResponseConstant::UNSUCCESS;
                        $rescode = ResponseConstant::UNSUCCESS;
                        $Message = 'INVALID CODE';
                        $this->sendResponse($Code, $rescode, $Message);
                    }
                } else {
                    $data = array('coupan_code' => $coupan_code, 'user_type' => 1);
                    $coupan_row = $this->car_packages_model->get_coupan_code_detail($data);
                    if ($coupan_row) {
                        if ($amount < $coupan_row['minimum_order']) {
                            $Code = ResponseConstant::UNSUCCESS;
                            $rescode = ResponseConstant::UNSUCCESS;
                            $Message = 'AMOUNT IS LESS THAN THE MINIMUM ORDER';
                            $this->sendResponse($Code, $rescode, $Message);
                        } else {
                            $discount_amount = ($amount * $coupan_row['discount']) / 100;
                            if ($discount_amount > $coupan_row['max_discount']) {
                                $Code = ResponseConstant::UNSUCCESS;
                                $rescode = ResponseConstant::UNSUCCESS;
                                $Message = 'MAX DISCOUNT LIMIT EXCEEDS';
                                $this->sendResponse($Code, $rescode, $Message);
                            } else {
                                $Code = ResponseConstant::SUCCESS;
                                $rescode = ResponseConstant::SUCCESS;
                                $Message = 'SUCCESS';
                                $this->sendResponse($Code, $rescode, $Message, array($coupan_row));
                            }
                        }
                    } else {
                        $Code = ResponseConstant::UNSUCCESS;
                        $rescode = ResponseConstant::UNSUCCESS;
                        $Message = 'INVALID CODE';
                        $this->sendResponse($Code, $rescode, $Message);
                    }
                }
            } else {
                $Code = ResponseConstant::UNSUCCESS;
                $rescode = ResponseConstant::UNSUCCESS;
                $Message = "USER ID DOES NOT EXIST";
                $this->sendResponse($Code, $rescode, $Message);
            }

            // $row = $this->car_package_model->is_user_active($user_id);
            // if($row)
        }
    }

}
