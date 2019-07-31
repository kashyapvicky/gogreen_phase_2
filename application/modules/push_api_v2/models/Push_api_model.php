<?php
  Class push_api_model extends CI_Model
  {

    public function get_7_2_days_ahead_package($date,$add2days)
    {
      $where = "(bp.status=1 AND  bp.package_type='monthly') AND (bp.expiry_date='".$date."' or bp.expiry_date='".$add2days."')";
      $this->db->where($where);
     
      $this->db->select('bp.expiry_date,bp.purchase_date,up.net_paid as amount,up.payment_type,bp.id as package_id,u.id as user_id,u.device_token,u.device_type,up.id as order_id');
      $this->db->join('booked_packages as bp','bp.user_id=u.id');
      $this->db->join('user_payment as up','up.id=bp.payment_key');
      $this->db->group_by('up.id');

      $query = $this->db->get('users as u');
      //echo $this->db->last_query(); die;
      return $query->result_array();

    }
  
   //  public function sendPush($json)
   //  {
   //    $url = "https://fcm.googleapis.com/fcm/send";
   //    $serverKey = 'AAAAuNPqydM:APA91bHlf3OKR8YVWvTkXvhkuKJBO5uxVlfCgjP4v0x59eGJ-QjyInshYaKicrFY9irdr8BptL7p01nCvtn65Hb3eHu7TcufSOgy9mtnvXA5YGRf8uT4Y9xTA379TduU3wnhO5XVOuUn';
   //    $headers = array();
   //    $headers[] = 'Content-Type: application/json';
   //    $headers[] = 'Authorization: key='. $serverKey;
   //    $ch = curl_init();
   //    curl_setopt($ch, CURLOPT_URL, $url);
   //    curl_setopt($ch, CURLOPT_CUSTOMREQUEST,"POST");
   //    curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
   //    curl_setopt($ch, CURLOPT_HTTPHEADER,$headers);
   //    curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
   //    $response = curl_exec($ch);

   //    // print_r($response); die;
   //    if ($response === FALSE) {
   //     die('FCM Send Error: ' . curl_error($ch));
   //    }
   //    return curl_close($ch);
   // }


  


 

  public function sendPush($json,$device_token,$device_type,$body,$title,$api_code,$order_id)
  {
    $url = "https://fcm.googleapis.com/fcm/send";
    // $token = $target;
     $serverKey = "AAAAuNPqydM:APA91bHlf3OKR8YVWvTkXvhkuKJBO5uxVlfCgjP4v0x59eGJ-QjyInshYaKicrFY9irdr8BptL7p01nCvtn65Hb3eHu7TcufSOgy9mtnvXA5YGRf8uT4Y9xTA379TduU3wnhO5XVOuUn";
     if (!defined('API_ACCESS_KEY')) define('API_ACCESS_KEY', $serverKey);
    // define( 'API_ACCESS_KEY', $serverKey );
      $registrationIds = array($device_token);
     $msg = array
      (
        'message'  => $body,
        'title'    => $title,
        'notification_for'=>'go green'
      );
      $fields = array
      (
        'registration_ids'    => $registrationIds,
        'data' => array
        (
         'message'  => $body,
         'title'    => $title,
         'notification_for'=>'go green',
         'order_id'=>$order_id,
         'api_code'=>$api_code,
        )
      );
      
      $headers = array
      (
         'Authorization: key=' .$serverKey,
         'Content-Type: application/json'
     );

     $ch = curl_init();
      curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
      curl_setopt( $ch,CURLOPT_POST, true );

      curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
      curl_setopt( $ch,CURLOPT_RETURNTRANSFER,1);
      curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
      //echo $device_type; die;

      if($device_type=='Android')
      {
        //echo "android"; die;
        curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode($fields )); 
      }
      else
      {
        
        curl_setopt( $ch,CURLOPT_POSTFIELDS,$json);
      }
      $result = curl_exec($ch );
      curl_close( $ch );
      return $result;    
   }


  public function get_fraudster()
  {

      $sub5days = date('Y-m-d', strtotime('-5 days'));
      $this->db->select('up.id as user_payment_id,up.net_paid,bp.purchase_date,u.id as user_id,u.device_token,u.device_type');
      $this->db->where('bp.purchase_date < ', $sub5days);
      $this->db->where('bp.status',1);// 2 are exired and renewed as 1
      $this->db->where('bp.expiry_date >', 'CURDATE()',FALSE);
      $this->db->where('up.payment_type',1);//COD
      $this->db->where('up.status',1);
      $this->db->join('booked_packages as bp','bp.payment_key=up.id');
      $this->db->join('users as u','u.id=up.user_id');
      $this->db->group_by('up.id');

      $query = $this->db->get('user_payment as up');
      return $query->result_array();


  }

  public function get_expired_packages()
  {

    $this->db->select('bp.*,up.pt_token,up.payment_type,up.id as order_id,up.pt_password,up.pt_email,up.pt_token,up.coupan_applied as cpn,us.name,us.email,us.password,us.phone_number');
    //$this->db->where('up.payment_type',2); //online orders only
    $this->db->where('bp.auto_renewal',2);
    $this->db->where('expiry_date', 'CURDATE()',FALSE);
    $this->db->join('user_payment as up','up.id=bp.payment_key');
    $this->db->join('users as us','us.id=bp.user_id');
    $this->db->where('us.service_stop',1);
    $this->db->where('us.status',1);
    $this->db->where('bp.status',1);
    $this->db->where('bp.package_type','monthly');
    $query =$this->db->get('booked_packages as bp');
     echo $this->db->last_query(); die;
    return $query->result_array();  
  }

  public function update_package_status_as_renew($id)
  {
    $this->db->where('id',$id);
    $this->db->set('status',2);
    $this->db->update('booked_packages');
  }
  public function insert_user_payment_data($user_payment_data)
  {
    $query = $this->db->insert('user_payment',$user_payment_data);
    $insert_id = $this->db->insert_id();
    return  $insert_id;
  }
  public function update_order_id($insert_id,$order_id)
  {
    $this->db->set('orders_id',$order_id);
    $this->db->where('id',$insert_id);
    $query = $this->db->update('user_payment');
    //echo $this->db->last_query(); die;
    if($query)
    {
      return 1;
    }
    else{
      return 0;
    }
  }
  public function get_team_id_by_street_id($street_id)
  {
    // $this->db->select('team_id');
    // $this->db->where('street_id',$street_id);
    // $query = $this->db->get('teams_street');
    // return $query->row_array();
    $this->db->select('t.id,t.jobs');
    $this->db->where('ts.street_id',$street_id);
    $this->db->join('teams_street as ts','ts.team_id=t.id');
    $this->db->where('t.status',1);//only active teams
    $this->db->order_by('jobs','ASC');
    $this->db->limit(1);
    $query = $this->db->get('teams as t');
    //echo $this->db->last_query(); die;
    return $query->row_array();
    //echo $this->db->last_query(); die;
  }
  public function insert_data_to_assiagned_team($data)
  {
    $this->db->insert('assiagned_team',$data);
    $insert_id = $this->db->insert_id();

    return  $insert_id;
  }
  public function increment_job_by_one_in_teams_tabel($team_id)
  {
        $this->db->where('id',$team_id);
        $this->db->set('jobs', 'jobs+1', FALSE);
        $this->db->update('teams');
       // echo $this->db->last_query(); die;
  }

 
  public function get_details_by_order_id($order_id)
  {
    $this->db->select('u.id,u.email,up.orders_id,up.net_paid,u.device_token');
    $this->db->join('users as u','u.id=up.user_id');
    $this->db->where('up.id',$order_id);
    $query = $this->db->get('user_payment as up');
    return $query->row_array();
  }

   public function sendPush_auto_renew($json)
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
    public function insert_book_package($data)
    {
      $query = $this->db->insert('booked_packages',$data);
      $insert_id = $this->db->insert_id();
      return  $insert_id;
    }

}
?>