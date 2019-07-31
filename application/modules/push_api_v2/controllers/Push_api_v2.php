<?php
defined('BASEPATH') OR exit('No direct script access allowed');




class Push_api_v2 extends MX_Controller 
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('push_api_model');
    }

    public function get_7_days_ahead_renewals()
    {
        
        
        $add7days = date('Y-m-d', strtotime('+7 days'));
        $add2days = date('Y-m-d', strtotime('+2 days'));

        $all_data = $this->push_api_model->get_7_2_days_ahead_package($add7days,$add2days);
        //echo $this->db->last_query(); die;
        //echo"<pre>";print_r($all_data); die;

        if(!empty($all_data))
        {
            foreach ($all_data as $key => $value)
            {
                //echo "hello"; die;
                $expiry_date = $value['expiry_date'];
                $amount = $value['amount'];

                $strtotime = strtotime($expiry_date);
                $month =  date('F', $strtotime);

                if($value['payment_type'] == 2)
                {
                    // online case

                    if($expiry_date == $add2days)
                    {
                        $message = "Dear Customer, your package of AED ".$amount."  for the month of".$month." is due for renewal is due in 2 days. Kindly make the payment on or before the due date or pay here. Ignore if already paid or if auto renewal mode is on.";
                    }
                    else
                    {
                        $message = "Dear Customer, your package of AED ".$amount."  for the month of ".$month." is due for renewal in 7 days. Kindly make the payment on or before the due date or pay here. Ignore if already paid or if auto renewal mode is on. ";

                    }
                }
                else
                {
                    //cod cause
                     if($expiry_date == $add2days )
                    {
                        $message = "Dear Customer, your package of AED ".$amount."  for the month of".$month." is due for renewal is due in 2 days. Kindly make the payment on or before the due date or pay here. Ignore if already paid.";
                    }
                    else
                    {
                        $message = "Dear Customer, your package of AED ".$amount."  for the month of ".$month." is due for renewal in 7 days. Kindly make the payment on or before the due date or pay here. Ignore if already paid. ";

                    }


                }

               // echo $message; die;
                $device_type = $value['device_type'];
                $order_id=$value['order_id'];
                $title = 'Go Green Amount Due..';//order_id
               $device_token = $value['device_token'];
                //$device_token = 'cLCpW58wMF0:APA91bEGSLmYRQZq-X4XU4DAYUFivDBQjl5xKBhal1s61D47aYmQyIJJZ6nIyt9gmtT4EEmeey4qY3yGXZyIJjJLNuOLlrTsFhEmzcxAK7NVi2tJXxvE-DtiizdwOB-JG652CqxA8K3O';
               
                //$device_type="ios";
                $body = $message;

                $api_code = 1;
                $notification = array('title' =>$title , 'body' => $body, 'sound' => 'default', 'badge' => '1','order_id'=>$order_id,'api_code'=>$api_code);
                $arrayToSend = array('to' => $device_token, 'notification' => $notification,'priority'=>'high');
                $json = json_encode($arrayToSend);
                 if(!empty($device_token))
                { 
                    $next_level = $this->push_api_model->sendPush($json,$device_token,$device_type,$body,$title,$api_code,$order_id);
                   // echo $device_token;
                    print_r($next_level);
                   // echo "hellllo";die;
                }
                else
                {
                    echo "not working";
                }

                //die;// just for testing only for one person     
            
               
            }
        }
        else
        {
            echo "No user To Send Push";
        }
       // echo $this->db->last_query(); die;
    }


    // send push to those who are not paid more than 5 years in COD cash

    public function get_5_days_fraudster()
    {
        $all_data = $this->push_api_model->get_fraudster();
        // echo $this->db->last_query();
         //echo "<pre>";print_r($all_data);die;

        if(!empty($all_data))
        {
            foreach ($all_data as $key => $value)
            {
                $amount = $value['net_paid'];
                $message = "Dear Customer, your amount of AED". $amount." is now overdue, kindly make immediate payment to avoid disconnection of services. Pay here. We recommend to switch on the auto renewal mode for easier payments in future.";
                $title = 'Go Green Amount Due..';//order_id
                $device_token = $value['device_token'];
                //$device_token = 'cLCpW58wMF0:APA91bEGSLmYRQZq-X4XU4DAYUFivDBQjl5xKBhal1s61D47aYmQyIJJZ6nIyt9gmtT4EEmeey4qY3yGXZyIJjJLNuOLlrTsFhEmzcxAK7NVi2tJXxvE-DtiizdwOB-JG652CqxA8K3O';
                $device_type = $value['device_type'];
                //$device_type="ios";
                $api_code=2;
                $order_id = $value['user_payment_id'];
               // $device_token = 'cObSbVvMXu8:APA91bFXD9O6eGywTXUiCa_z8LTBQ-TywJUOTIBTUX1n5IE-VZkaiuiNI9N6NatrKlwq82VQYGpKKyrsgAq84oh97Xe56Zl6-cn63SJQT-CmrPMRirWX1CkiryZmpFUJbFdQ4YKlOFJo';
                $body = $message;
                $notification = array('title' =>$title , 'body' => $body, 'sound' => 'default', 'badge' => '1','order_id'=>$value['user_payment_id'],'api_code'=>$api_code);
                $arrayToSend = array('to' => $device_token, 'notification' => $notification,'priority'=>'high');
                $json = json_encode($arrayToSend);
                 if(!empty($device_token))
                { 
                    $next_level = $this->push_api_model->sendPush($json,$device_token,$device_type,$body,$title,$api_code,$order_id);
                    print_r($next_level);
                   // echo "hellllo";die;
                }
                else
                {
                    echo "not working"; 
                }
             }
        }
        else
        {
            echo "No user To Send Push";
        }

    }
    // get  expired packages with auto renewal

        //crone function
    public function get_data_for_auto_renewal()
    {

        // get package who is expired today awith auto renewl mode on
        $result = $this->push_api_model->get_expired_packages();
        // echo "hello"; die;
       // echo $this->db->last_query(); die;
         echo"<pre>";print_r($result); die;
        $url="https://www.paytabs.com/apiv3/tokenized_transaction_prepare";
        $values=array();
        if(!empty($result))
        {




            foreach ($result as $key => $value)
            {

                if($value['payment_type'] == 1)//cod cause
                {

                   // echo "<pre>";print_r($value); die;



                    $value['purchase_date'] = date('Y-m-d');
                    $no_of_months = $value['no_of_months'];
                    $expiry_date = date('Y-m-d', strtotime($value['purchase_date'] . '+'.$no_of_months.' month'));
                    $value['expiry_date'] = $expiry_date;
                     $user_payment_data = array(
                    'user_id' => $value['user_id'],
                    'transaction_id' => 'COD',
                    'orders_id' => '',
                    'net_paid' => $value['amount'],
                    'actual_payment' => $value['amount'],
                    'coupan_applied' => $value['cpn'],
                    'created_at'=>date('Y-m-d'),
                    'payment_type' => 1//online cause
                    );
                    $insert_id = $this->push_api_model->insert_user_payment_data($user_payment_data);
                    if ($insert_id)
                    {

                        //update order id
                        $order_id = 100000 + $insert_id;
                        $this->push_api_model->update_order_id($insert_id,$order_id);
                        $this->assiagn_team($value['user_id'],$value['street_id'],$insert_id);

                         $data = array(
                            'user_id' => $value['user_id'],
                            'payment_key' => $insert_id,
                            'car_id' => $value['car_id'],
                            'transaction_id' => '12345',//payment gateway id
                            'package_type' => $value['package_type'],
                            'purchase_date' => date('Y-m-d'),
                            'expiry_date' => $expiry_date,
                            'created_at' => date('Y-m-d'),
                            'package_name'=>$value['package_name'],
                            'one_time_service_date' => $value['one_time_service_date'],
                            'services' => $value['services'],
                            'days' => $value['days'],
                            'frequency' => $value['frequency'],
                            'amount' => $value['amount'],
                            'city_id'=>$value['city_id'],
                            'locality_id'=>$value['locality_id'],
                            'street_id'=>$value['street_id'],
                            'no_of_months'=>$value['no_of_months'],
                            'auto_renewal'=>$value['auto_renewal']
                            );
                    }
                    //set package status as 2;
                    $this->push_api_model->update_package_status_as_renew($value['id']);
                    $insert_id_of_booked_package = $this->push_api_model->insert_book_package($data);
                    if($insert_id_of_booked_package)
                    {
                        echo "Success For user id";
                        echo $value['user_id'];

                    }
                    else
                    {
                        echo "Something Went Wrong For User Id";
                        echo $value['user_id'];
                    }
                }
                else
                {

                   // $amount = $value['amount'];
                    $pt_token=$value['pt_token'];

                    $amount =$value['amount'];
                    //$name = $value['name'];
                    $name=$value['name'];
                    //$order_id = $value['order_id'];
                    $order_id=$value['order_id'];
                    //$email = $value['email'];
                    $email = "coolkashyap.com@gmail.com";
                    $pt_email = $value['pt_email'];
                    $pt_password=$value['pt_password'];
                    //$phone_number = $value['phone_number'];
                    $phone_number=$value['phone_number'];

                    $values["merchant_email"] =  $email;
                    $values['secret_key']        = "WuMPoZ7qMdeWYvwm5JMuX06aRlXHgTicn42M3acQoqMmWjJ12vwZwD9nZ64fZmsnruauFmk3N7qKq9MtFisbVCzVJEaJ1D6s8hXN";
                    $values['title']             ="Go Green Package Renew";
                    $values['cc_first_name']     =$name;
                    $values['cc_last_name']      =$name; 
                    $values['order_id']          =$order_id;
                    $values['product_name']      ="GO Green Renew";
                    $values['customer_email']    =$pt_email;
                    $values['phone_number']      =$phone_number;
                    $values['amount']            =$amount;
                    $values['currency']          ="AED";
                    $values['address_billing']   ="Dubai JLT";
                    $values['state_billing']     ="Dubai JLT";
                    $values['city_billing']      ="Dubai";
                    $values['postal_code_billing']="110025";  
                    $values['country_billing']    ="ARE";   
                    $values['address_shipping']   ="Dubai JLT" ;  
                    $values['city_shipping']      = "Dubai JLT"; 
                    $values['state_shipping']     = "Dubai JLT";   
                    $values['postal_code_shipping']="110025";
                    $values['country_shipping']    ="ARE"; 
                    $values['pt_token']  =    $pt_token; 
                    $values['pt_customer_email']  = $pt_email; 
                    $values['pt_customer_password']  =$pt_password;
                  // echo"<pre>"; print_r($values); die;
                    //$post_data = json_encode($values); 

                    $ch = curl_init();

                    curl_setopt($ch, CURLOPT_URL,$url);
                    curl_setopt($ch, CURLOPT_POST, 1);
                    curl_setopt($ch, CURLOPT_POSTFIELDS,$values);

                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

                    $server_output = curl_exec($ch);
                    print_r($server_output); 
                    $output = json_decode($server_output);
                    //$output = (array) $output;
                    curl_close ($ch);
                    $code =  $output->response_code;
                    $transaction_id =  $output->transaction_id;

                    //print_r($output); die;

                    // echo $code; die;
                    //when i get successfull response 
                    if($code==100)
                    {   
                        // payment is succesfully registered;
                        //status=2  in booked_packges model
                        $value['purchase_date'] = date('Y-m-d');
                        $no_of_months = $value['no_of_months'];
                        $expiry_date = date('Y-m-d', strtotime($value['purchase_date'] . '+'.$no_of_months.' month'));
                        $value['expiry_date'] = $expiry_date;

                         $user_payment_data = array(
                        'user_id' => $value['user_id'],
                        'transaction_id' => $transaction_id,
                        'orders_id' => '',
                        'net_paid' => $amount,
                        'actual_payment' => $amount,
                        'coupan_applied' => $value['cpn'],
                        'created_at'=>date('Y-m-d'),
                        'payment_type' => 2,//online cause
                        'pt_token'=>$value['pt_token'],
                        'pt_email'=>$value['pt_email'],
                        'pt_password'=>$value['pt_password']
                        );
                        $insert_id = $this->push_api_model->insert_user_payment_data($user_payment_data);
                        if ($insert_id)
                        {

                            //update order id
                            $order_id = 100000 + $insert_id;
                            $this->push_api_model->update_order_id($insert_id,$order_id);
                            $this->assiagn_team($value['user_id'],$value['street_id'],$insert_id);

                             $data = array(
                                'user_id' => $value['user_id'],
                                'payment_key' => $insert_id,
                                'car_id' => $value['car_id'],
                                'transaction_id' => '12345',//payment gateway id
                                'package_type' => $value['package_type'],
                                'purchase_date' => date('Y-m-d'),
                                'expiry_date' => $expiry_date,
                                'created_at' => date('Y-m-d'),
                                'package_name'=>$value['package_name'],
                                'one_time_service_date' => $value['one_time_service_date'],
                                'services' => $value['services'],
                                'days' => $value['days'],
                                'frequency' => $value['frequency'],
                                'amount' => $value['amount'],
                                'city_id'=>$value['city_id'],
                                'locality_id'=>$value['locality_id'],
                                'street_id'=>$value['street_id'],
                                'no_of_months'=>$value['no_of_months'],
                                'auto_renewal'=>$value['auto_renewal']
                                );
                        }

                        //set package status as 2;
                        $this->push_api_model->update_package_status_as_renew($value['id']);
                        $insert_id_of_booked_package = $this->push_api_model->insert_book_package($data);
                        if($insert_id_of_booked_package)
                        {
                            echo "Success For user id";
                            echo $value['user_id'];

                        }
                        else
                        {
                            echo "Something Went Wrong For User Id";
                            echo $value['user_id'];
                        }
                        // echo"<pre>";print_r($value); die;  
                    }
                    else
                    {
                        echo "payment gaateway error occured";
                        
                    }
                }
            }
        }
        else
        {
            echo"No User To Send Renew";
        }

    }

    public function assiagn_team($user_id,$street_id,$insert_id)
    {
        $user_id = $user_id;
        $street_id_to_assiagn_team = $street_id;

        $team = $this->push_api_model->get_team_id_by_street_id($street_id_to_assiagn_team);
        $team_id = $team['id'];
        //echo $team_id; die;
        if (!empty($team_id)) {

            $data = array(
                'team_id' => $team_id,
                'user_id' => $user_id,
                'payment_key' => $insert_id,
            );
            $inserrt_id = $this->push_api_model->insert_data_to_assiagned_team($data);

            //update increment job by one
            $this->push_api_model->increment_job_by_one_in_teams_tabel($team_id);
        } else {
            $data = array(
                'team_id' => 0,
                'user_id' => $user_id,
                'payment_key' => $insert_id,
            );
            $insert_id = $this->push_api_model->insert_data_to_assiagned_team($data);
        }
       // $this->send_mail($insert_id);
        $this->send_push($insert_id);
    }

    public function send_mail($insert_id)
    {
       $row =  $this->push_api_model->get_details_by_order_id($insert_id);
      // print_r($row);
       $data['order_id'] = $row['orders_id'];
       $data['net_paid'] = $row['net_paid'];
       $email = $row['email'];
       $message = $this->load->view('mail_template',$data,'true');
       //echo $message; die;
       //$message = "hello";

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
            $this->email->from('info@gogreen-uae.com','info@gogreen-uae.com');
            $this->email->to($email);
            $this->email->subject('Go Green-Order Confirmation Mail');
            // $message .="<a href = ".base_url()."admin/confirm_password?id=$id>Link</a>";
            $this->email->message($message);  
            $this->email->set_mailtype("html");
            $this->email->send();
            
    }
    public function send_push($insert_id)
    {
        $row =  $this->push_api_model->get_details_by_order_id($insert_id);
        $order_id = $row['orders_id'];
        $net_paid = $row['net_paid'];
        $email = $row['email'];
        $device_token = $row['device_token'];
        $message = "Dear Customer, Thank you for your payment of amount  ".$net_paid." Enjoy our services!";

        //$device_token = $row['device_token'];
        // $device_token = 'cJkUAlB_Fok:APA91bEeBaMYUj08wtd6e4313almVcZbfNuqBkZfRqp29k94Mb-16I5EzpmiaJcWd7xykDowueyXEL1MDvkr4qedEyXzdd1ttguj4OLv6M0a8J-hKLMeTvk2TYhvd9skAe3j9EhyMiO9';

        $user_name = 'Go Green';
        $title = 'Go Green Greetings!';
        $body = $message;  
        $notification = array('title' =>$title , 'body' => $body, 'sound' => 'default', 'badge' => '1');
        $arrayToSend = array('to' => $device_token, 'notification' => $notification,'priority'=>'high');
        $json = json_encode($arrayToSend);
        if(!empty($device_token))
        { 
        $next_level=  $this->push_api_model->sendPush_auto_renew($json);
        print_r($next_level);
        // echo "hellllo";die;
        }
        else
        {
            echo "not working"; //die;
        }
    }
}   
  

    

