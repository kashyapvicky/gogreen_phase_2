<?php
  Class Orders_api_model extends CI_Model
  {
     public function get_orders_by_user_id($user_id)
     {

        $this->db->select('bp.id as package_id,bp.car_id as car_id,bp.purchase_date,bp.expiry_date,bp.services,cd.reg_no,cd.parking_number,br.name as brand,md.name as model,up.orders_id,up.id as payment_key,up.id as id');
        $this->db->where('bp.user_id',$user_id);
        $this->db->where('expiry_date >', 'CURDATE()',FALSE);
        $this->db->join('car_detail as cd','cd.id = bp.car_id','left');
        $this->db->join('car_brand as br','br.id = cd.brand','left');
        $this->db->join('car_model as md','md.id = cd.model','left');
        $this->db->join('user_payment as up','up.id=bp.payment_key','left');
        $query = $this->db->get('booked_packages as bp');
        //echo $this->db->last_query(); die;
        return $query->result_array();
        //$this->db->where('bp.expiry_date')
     }
     public function get_expired_orders_by_user_id($user_id)
     {

        $this->db->select('bp.id as package_id ,bp.car_id as car_id,bp.purchase_date,bp.expiry_date,bp.services,cd.reg_no,cd.parking_number,br.name as brand,md.name as model,up.orders_id,up.id as payment_key,up.id as id');
        $this->db->where('bp.user_id',$user_id);
        $this->db->where('expiry_date <=', 'CURDATE()',FALSE);
        $this->db->join('car_detail as cd','cd.id = bp.car_id','left');
        $this->db->join('car_brand as br','br.id = cd.brand','left');
        $this->db->join('car_model as md','md.id = cd.model','left');
        $this->db->join('user_payment as up','up.id=bp.payment_key','left');
        $query = $this->db->get('booked_packages as bp');
        //echo $this->db->last_query(); die;
        return $query->result_array(); die;

        //$this->db->where('bp.expiry_date')
     }
     public function check_user_id($user_id)
     {
        $this->db->where('id',$user_id);
        $query = $this->db->get('users');
        return $query->row_array();
     }
     public function update_cleaners_rating_info($feedback,$activity_id)
     {
        $this->db->where('id',$activity_id);
        $this->db->set('feedback',$feedback);
        $this->db->set('status',2);
        $query = $this->db->update('cleaner_job_done_history');
        if($query)
        {
            return 1;
        }
        else
        {
            return 0;
        }
     }
     public function check_cleaner_existence($cleaner_id)
     {
        $this->db->select('*');
        $this->db->where('id',$cleaner_id);
        $query = $this->db->get('cleaners');
        return $query->row_array();
     }
     public function get_package_detail($user_id,$car_id,$orders_id)
     {
        $this->db->select('bp.id,bp.one_time_service_date,bp.days,bp.expiry_date,bp.amount,bp.package_type,bp.is_off,u.service_stop as subscription');
        $this->db->join('users as u','u.id=bp.user_id','left');
         $this->db->where('bp.user_id',$user_id);
        // $this->db->where('car_id',$car_id);
        $this->db->where('bp.payment_key',$orders_id);
        $this->db->where('bp.car_id',$car_id);
        // $this->db->group_by('payment_key');
        //$this->db->where('payment_key',);
        $query = $this->db->get('booked_packages as bp');
        //echo $this->db->last_query(); die;
        return $query->row_array();

     }

     public function increment_to_rating_and_count_column($cleaner_id,$rating)
     {
        $this->db->where('id',$cleaner_id);
        $this->db->set('rating','rating + ' . (int)$rating,FALSE);
        //$this->db->set('points', 'points + ' . (int) $points, FALSE);
        $this->db->set('count_who_rated','count_who_rated+1',FALSE);
        //echo"hello";
        $this->db->update('cleaners');
        //echo $this->db->last_query(); die;
     }
     public function get_cleaners_detail_of_assiagned_team($user_id,$orders_id,$car_id)
     {
        $this->db->select('as.team_id,cl.first_name,cl.last_name,cl.phone_number,cl.email,cl.rating,cl.count_who_rated');
        $this->db->join('team_cleaner as tcl','tcl.team_id=as.team_id');
        $this->db->join('cleaners as cl','cl.id = tcl.cleaner_id');
      //  $this->db->where('cl.is_del',1);
        $this->db->where('as.user_id',$user_id);
        $this->db->where('as.payment_key',$orders_id);
        $query = $this->db->get('assiagned_team as as');
        //echo $this->db->last_query(); die;
        return $query->result_array();
     }
     public function get_order_id_by_cleaner_id($cleaner_id)
     {

        // $this->db->select('tcl.cleaner_id,ast.team_id,bp.payment_key');
        // $this->db->join('team_cleaner as tcl','tcl.team_id=ast.team_id','left');
        // $this->db->join('assiagned_team as ast','ast.team_id=tcl.team_id');
        // $this->db->join('booked_packages as bp','bp.payment_key=ast.payment_key');
        // $this->db->where('tcl.cleaner_id',$cleaner_id);
        // $query = $this->db->get('team_cleaner');
        //$this->db->select('tc.cleaner_id, at.payment_key,bp.package_type');
        $this->db->select('tc.cleaner_id,tc.team_id, at.payment_key,bp.package_type,bp.expiry_date,bp.id as booked_package_id,bp.purchase_date,bp.days,bp.one_time_service_date,bp.user_id,bp.car_id,md.name as model,cb.name as brand,cd.reg_no,cd.color,cd.parking_number,cd.apartment_number,bp.services,up.orders_id,ct.name as city,lt.name as locality,st.name as street,cd.type as car_type,u.name as user_name,u.phone_number as phone_number');
        $this->db->join('assiagned_team as at', 'at.team_id=tc.team_id','left');
        $this->db->join('booked_packages as bp','bp.payment_key=at.payment_key');
        $this->db->join('car_detail as cd','cd.id=bp.car_id','left');
        $this->db->join('city as ct','ct.id=cd.city_id','left');
        $this->db->join('locality as lt','lt.id=bp.locality_id','left');
        $this->db->join('street as st','st.id=bp.street_id','left');
        $this->db->join('car_model as md','md.id=cd.model','left');
        $this->db->join('car_brand as cb','cb.id=cd.brand','left');
        $this->db->join('users as u','u.id=bp.user_id');
        $this->db->join('user_payment as up','up.id=at.payment_key','left');
        // phase 2 changes
        // purchase date should be before than the current date
        $this->db->where('bp.purchase_date <=','CURDATE()',FALSE);

        // phaase 2 changes ends here



        $this->db->where('bp.expiry_date >','CURDATE()',FALSE);
        $this->db->where('bp.is_off',1);
        $this->db->where('u.service_stop',1);
        $this->db->where('tc.cleaner_id',$cleaner_id);
        $query = $this->db->get('team_cleaner as tc');
        //echo $this->db->last_query(); die;
        return $query->result_array();


     }
     public function get_completed_job_count($cleaner_id)
     {
        //$this->db->count('id');
        $this->db->where('cleaner_id',$cleaner_id);
        $this->db->where('job_done_date','CURDATE()',FALSE);

        //$query =  $this->db->get('cleaner_job_done_history');
        $count = $this->db->count_all_results('cleaner_job_done_history');
        return $count;
     }

     // public function update_done_job_data($data)
     // {
     //    $this->db->where('car_id',$car_id);
     //   $query =  $this->db->update('cleaner_job_done_history',$data);
     //   if($query)
     //   {
     //        return 1;
     //   }
     //   else
     //   {
     //        return 0;
     //   }
     // }
     public function insert_done_job_data($data)
     {
        $this->db->insert('cleaner_job_done_history',$data);
        $insert_id = $this->db->insert_id();

        return  $insert_id;
     }
     public function check_car_already_cleaned($car_id)
     {
        $this->db->select('id,attendent,cleaner_id as tbl_cleaner_id,car_id');
        //$this->db->where('cleaner_id',$cleaner_id);

        $this->db->where('car_id',$car_id);
        $this->db->where('attendent',1);
        //$this->db->or_where('attendent',2);
        $this->db->where('job_done_date','CURDATE()',FALSE);
        $query = $this->db->get('cleaner_job_done_history');
        //echo $this->db->last_query();die;
        return $query->row_array();
     }
     public function check_is_car_respondent_by_this_cleaner($car_id,$cleaner_id)
     {
        $this->db->select('id,attendent,cleaner_id as tbl_cleaner_id,car_id');
        $this->db->where('cleaner_id',$cleaner_id);

        $this->db->where('car_id',$car_id);
        //$this->db->where('attendent',1);
        //$this->db->or_where('attendent',2);
        $this->db->where('job_done_date','CURDATE()',FALSE);
        $query = $this->db->get('cleaner_job_done_history');
        //echo $this->db->last_query();die;
        return $query->row_array();
     }
     public function get_cleaner_job_done_detail($cleaner_id)
     {
        $this->db->select('ch.id,ch.services,ch.attendent as status,cd.parking_number,cd.apartment_number,cd.color,cd.reg_no,cb.name as brand,cm.name as model,cl.rating as rating,cl.count_who_rated,ch.car_id,ch.payment_key,st.name');
        $this->db->join('car_detail as cd','cd.id=ch.car_id','left');
        $this->db->join('car_model as cm','cm.id=cd.model','left');
        $this->db->join('car_brand as cb','cb.id=cd.brand','left');
        $this->db->join('booked_packages as bp','bp.payment_key=ch.payment_key','left');
        $this->db->join('street as st','st.id=bp.street_id','left');
        //$this->db->join('user_payment as up','up.id=ch.payment_key','left');
        $this->db->join('cleaners as cl','cl.id=ch.cleaner_id');
         //$this->db->where('ch.job_done_date','CURDATE()',FALSE);
        $this->db->where('ch.cleaner_id',$cleaner_id);
        $this->db->group_by('ch.payment_key');
        $query = $this->db->get('cleaner_job_done_history as ch');
        // echo $this->db->last_query(); die;
        return $query->result_array();
     }
     public function get_assiagned_order_payment($cleaner_id)
     {
        $this->db->select('up.id,up.status as payment_status,up.net_paid,up.partial_payment,up.orders_id,up.user_id,st.name as street_name,cd.apartment_number,u.name as username,u.phone_number');
        $this->db->join('assiagned_team as at','at.team_id=tc.team_id','left');
        $this->db->join('user_payment as up','up.id=at.payment_key');
        $this->db->join('booked_packages as bp','bp.payment_key=up.id','left');
        $this->db->group_by('bp.payment_key');
        $this->db->join('car_detail as cd','cd.id=bp.car_id','left');
        $this->db->join('street as st','st.id=bp.street_id','left');
        $this->db->join('users as u','u.id=up.user_id','left');
        $this->db->where('up.payment_type',1);

        //status 1 means payment is not collected yet
        //$this->db->where('up.status',1);
        $this->db->where('tc.cleaner_id',$cleaner_id);
        $query = $this->db->get('team_cleaner as tc');
        //echo $this->db->last_query();die;
        return $query->result_array();
     }
     public function insert_to_payment_collected($data)
     {
        $this->db->insert('payment_collected',$data);
         return $this->db->insert_id();
     }
     public function update_status_of_order_payment($id)
     {
        $this->db->set('status',2);
        $this->db->where('id',$id);
        $query = $this->db->update('user_payment');
     }
     public function check_payment_status($id)
     {
        $this->db->select('status');
        $this->db->where('id',$id);
        $query = $this->db->get('user_payment');
        return $query->row_array();

     }
     public function get_today_completed_job($cleaner_id)
     {
        $this->db->where('cleaner_id',$cleaner_id);
        $this->db->where('job_done_date','CURDATE()',FALSE);
        $query =  $this->db->get('cleaner_job_done_history');
        return $query->result_array();
        // $count = $this->db->count_all_results('cleaner_job_done_history');
        // return $count;
     }
     public function check_this_car_done_by_others($car_id,$cleaner_id)
     {
        $this->db->select('*');
        $this->db->where('car_id',$car_id);
        $this->db->group_by('car_id');
        $this->db->where('job_done_date','CURDATE()',FALSE);
        $this->db->where('cleaner_id!=',$cleaner_id);
        $query =  $this->db->get('cleaner_job_done_history');
        //echo $this->db->last_query(); die;
       return $query->row_array();
     }
     public function get_basick_info($cleaner_id)
     {
        $this->db->select('cl.count_who_rated,cl.rating,cl.first_name,ct.name as city_name,lt.name as locality_name,cl.image_string');
        $this->db->join('city as ct','ct.id=cl.city_id','left');
        $this->db->join('locality as lt','lt.id=cl.locality_id','left');
        $this->db->where('cl.id',$cleaner_id);
        $query = $this->db->get('cleaners as cl','left');
        return $query->row_array();
     }
     public function get_car_detail($id,$car_id)
     {
        //$this->db->select_min('ch.attendent');
        $this->db->select('ch.job_done_date,COUNT(ch.id),ch.cleaner_id,ch.attendent,ch.id,cl.first_name,cl.image_string,cl.last_name');
        $this->db->join('cleaners as cl','cl.id=ch.cleaner_id');
        $this->db->where('ch.car_id',$car_id);
        $this->db->where('ch.payment_key',$id);
        $this->db->group_by('ch.job_done_date');
        $this->db->where('ch.attendent',1);
        //$this->db->group_by('ch.job_done_date');
        $query = $this->db->get('cleaner_job_done_history as ch');
        //echo $this->db->last_query(); die;
        return $query->result_array();

     }
     public function get_car_detail_2($id,$car_id,$date)
     {
        //$this->db->select_min('ch.attendent');
        $this->db->select('ch.job_done_date,COUNT(ch.id) as not_attendent_count,ch.cleaner_id,ch.attendent,ch.id,cl.image_string,cl.first_name,cl.last_name');
        $this->db->join('cleaners as cl','cl.id=ch.cleaner_id');
        $this->db->where('ch.car_id',$car_id);
        $this->db->where('ch.payment_key',$id);
        $this->db->group_by('ch.job_done_date');
        $this->db->where('ch.attendent',2);
        //$this->db->count('ch.id as count');
        if(!empty($date))
        {
            $this->db->where_not_in('ch.job_done_date',$date);
        }

        //$this->db->group_by('ch.job_done_date');
        $query = $this->db->get('cleaner_job_done_history as ch');
        //echo $this->db->last_query(); die;
        return $query->result_array();

     }
     public function check_if_user_already_rated($activity_id)
     {
        $this->db->select('*');
        $this->db->where('id',$activity_id);
        $this->db->where('status',2);
        $query = $this->db->get('cleaner_job_done_history');
        return $query->row_array();
     }
     public function update_status_as_activity_rated($activity_id)
     {
        $this->db->where('id',$activity_id);
        $this->db->set('status',2);
        $this->db->update('cleaner_job_done_history');
     }
     public function get_all_todays_task()
     {
        $this->db->select('bp.car_id,bp.payment_key,bp.days,bp.one_time_service_date,at.team_id,bp.package_type,bp.expiry_date,bp.services,bp.payment_key,bp.user_id');
        $this->db->join('assiagned_team as at','at.payment_key=bp.payment_key');//if no team assiagn then no result 
        $this->db->where('bp.expiry_date >','CURDATE()',FALSE);
        $query = $this->db->get('booked_packages as bp');
        //echo $this->db->last_query(); die;
        return $query->result_array();
     }
     public function insert_ignored_car($data)
     {
        $this->db->insert('cleaner_job_done_history',$data);
        $insert_id = $this->db->insert_id();

        return  $insert_id;

     }
     public function check_this_car_cleaned_or_not($car_id)
     {
        $this->db->select('*');
        $this->db->where('car_id',$car_id);
        $this->db->where('job_done_date','CURDATE()',FALSE);
        $this->db->where('attendent',1);
        $query = $this->db->get('cleaner_job_done_history');
        return $query->row_array();
     }
     public function get_all_cleaner_of_the_team($team_id)
     {
        $this->db->select('tc.cleaner_id,at.payment_key,at.id,at.team_id');
        $this->db->join('team_cleaner as tc','tc.team_id=at.team_id','left');
        $this->db->where('at.team_id',$team_id);
        $query = $this->db->get('assiagned_team as at');
        return $query->result_array();
     }
     public function get_number_of_cleaners_by_order_id($id)
     {
        $this->db->select('count(tc.id) as cleaner_count,at.payment_key,at.team_id');
        $this->db->join('team_cleaner as tc','tc.team_id=at.team_id');
        $this->db->where('at.payment_key',$id);
        $query = $this->db->get('assiagned_team as at');
        return $query->row_array();


     }
     public function check_this_cleaner_responded_or_not($cleaner_id,$car_id)
     {
        $this->db->select('*');
        $this->db->where('car_id',$car_id);
        $this->db->where('cleaner_id',$cleaner_id);
        $this->db->where('job_done_date','CURDATE()',FALSE);
        //$this->db->where('attendent',1);
        $query = $this->db->get('cleaner_job_done_history');
        return $query->row_array();
     }
     public function car_ignored_by_this_cleaner_data_insert($ignored_car_data)
     {
        $this->db->insert('cleaner_job_done_history',$ignored_car_data);
        return $this->db->insert_id();
     }
     public function insert_collected_amount($id,$partial_amount)
     {
        $this->db->where('id',$id);
        $this->db->set('partial_payment', 'partial_payment + ' . (int) $partial_amount, FALSE);
        $query = $this->db->update('user_payment');
        if($query)
        {
            return 1;
        }
        else
        {
            return 0;
        }
        
     }
     public function get_net_paid_and_partial_paid_amount($id)
     {
        $this->db->select('id,net_paid,partial_payment');
        $this->db->where('id',$id);
        $query =$this->db->get('user_payment');
        return $query->row_array();
     }
     public function update_attendent_status($id,$data)
     {
        $this->db->where('id',$id);
        $query = $this->db->update('cleaner_job_done_history',$data);
        if($query)
        {
            return 1;
        }
        else
        {
            return 0;
        }
     }

    public function insert_write_off($data)
    {
      $this->db->insert('payment_collected',$data);
      return $this->db->insert_id();
    }

    public function is_currently_package_active($car_id)
    {
        $this->db->select('id,auto_renewal');
        $this->db->where('car_id',$car_id);
        $this->db->where('expiry_date >', 'CURDATE()',FALSE);
        $this->db->where('purchase_date <=','CURDATE()',FALSE);
        $query = $this->db->get('booked_packages');
        return $query->row_array();

    }
    public function update_package_mode($package_id,$mode)
    {
        $this->db->where('id',$package_id);
        $this->db->set('auto_renewal',$mode);
        $query = $this->db->update('booked_packages');
        if($query)
        {
            return 1;
        }
        else
        {
            return 0;
        }

    }
    public function update_package_status_is_off($package_id,$mode)
    {
        $this->db->where('id',$package_id);
        $this->db->set('is_off',$mode);
        $query = $this->db->update('booked_packages');
        if($query)
        {
            return 1;
        }
        else
        {
            return 0;
        }

    }

    public function stop_user_service($id,$status)
    {
      $this->db->where('id',$id);
      $this->db->set('service_stop',$status);
      $query = $this->db->update('users');
     // echo $this->db->last_query(); die;
      if($query)
      {
        return 1;
      }
      else
      {
        return 0;
      }

    }

    public function get_device_token($id)
    {
      $this->db->where('id',$id);
      $query  = $this->db->get('users');
      return $query->row_array();
    }

     public function sendPush($json)
    {
      $url = "https://fcm.googleapis.com/fcm/send";
      $serverKey = 'AAAAuNPqydM:APA91bHlf3OKR8YVWvTkXvhkuKJBO5uxVlfCgjP4v0x59eGJ-QjyInshYaKicrFY9irdr8BptL7p01nCvtn65Hb3eHu7TcufSOgy9mtnvXA5YGRf8uT4Y9xTA379TduU3wnhO5XVOuUn';
      $headers = array();
      $headers[] = 'Content-Type: application/json';
      $headers[] = 'Authorization: key='. $serverKey;
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL, $url);
      curl_setopt($ch, CURLOPT_CUSTOMREQUEST,"POST");
      curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
      curl_setopt($ch, CURLOPT_HTTPHEADER,$headers);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
      $response = curl_exec($ch);

      //print_r($response); die;
      if ($response === FALSE)
      {
       die('FCM Send Error: ' . curl_error($ch));
      }
      return curl_close($ch);
    }
    public function start_user_service($id,$status)
    {
      $this->db->where('id',$id);
      $this->db->set('service_stop',$status);
      $query = $this->db->update('users');
     // echo $this->db->last_query(); die;
      if($query)
      {
        return 1;
      }
      else
      {
        return 0;
      }

    }

    public function get_user_info($user_id)
    {
        $this->db->where('id',$user_id);
        $query   = $this->db->get('users');
        return $query->row_array();
    }
}
?>