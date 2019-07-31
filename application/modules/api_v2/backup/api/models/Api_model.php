<?php
  Class Api_model extends CI_Model
  {
    public function insert_data($data)
    {
      $this->db->insert('users', $data);
      $result = $this->db->insert_id();
      return $result;
    } 

    public function check_email_existence($email)
    {
      $this->db->select('*');
      $this->db->where('email', $email);
      $query = $this->db->get('users');
      $email_existed = $query->row_array();
      return $email_existed;

    }
    public function check_phone_existence($phone_number)
    {
      $this->db->select('*');
      $this->db->where('phone_number',$phone_number);
      $query = $this->db->get('users');
      $bool = $query->row_array();
      if($bool)
      {
        return 1;
      }
      else{
        return 0;
      }
    }
    public function update_soocial_id_on_combo($phone_number,$email,$social_id,$login_type)
    {
      if($login_type == 'FB')
      {
        $this->db->set('social_id_fb',$social_id);
        $this->db->where('phone_number',$phone_number);
        $this->db->where('email',$email);
        $bool = $this->db->update('users');
          if($bool)
         {
          $this->db->where('email',$email);
          $this->db->where('phone_number',$phone_number);
          $query =  $this->db->get('users');
          return $query->row_array();
         }
         else
         {
          return 0;
         }
      }
      else
      {
        $this->db->set('social_id_gl',$social_id);
        $this->db->where('phone_number',$phone_number);
        $this->db->where('email',$email);
        $bool = $this->db->update('users');
          if($bool)
         {
          $this->db->where('email',$email);
          $this->db->where('phone_number',$phone_number);
          $query =  $this->db->get('users');
          return $query->row_array();
         }
         else
         {
          return 0;
         }
      }
    }
    public function phone_email_existence($phone_number,$email)
    {
      $this->db->select('*');
      $this->db->where('phone_number',$phone_number);
      $this->db->where('email',$email);
      $query = $this->db->get('users');
      return $query->row_array();
    }

    public function insert_car_details($data)
    {

      $query = $this->db->insert('car_detail' , $data);
      $result = $this->db->insert_id();
      return $result;

    }

    public function login($email,$password)
    {

      $this->db->select('id,name,email,phone_number,is_phone_verified,is_payment');
      $this->db->where('email',$email);
      $this->db->where('password',$password);
      $query =  $this->db->get('users');
      return $query->row_array();

    }
     public function login_google($email,$phone_number,$login_type)
    {

      $this->db->select('*');
      $this->db->where('email',$email);
      $this->db->where('phone_number',$phone_number);
       $this->db->where('login_type',$login_type);
      $query =  $this->db->get('users');
      return $query->result_array();

    }
    public function check_social_id_gl($social_id)
    {

      $this->db->select('id,name,email,phone_number,is_phone_verified,is_payment');
      $this->db->where('social_id_gl',$social_id);
      $query =  $this->db->get('users');
      return $query->row_array();

    }
    public function check_social_id_fb($social_id)
    {

      $this->db->select('id,name,email,phone_number,is_phone_verified,is_payment');
      $this->db->where('social_id_fb',$social_id);
      $query =  $this->db->get('users');
      return $query->row_array();

    }

    public function update_token($user_id,$device_token)
    {
      $this->db->set('device_token', $device_token);
      $this->db->where('id', $user_id);
     $query =  $this->db->update('users');
     return $query;
    }
    public function get_all_city()
    {

      $this->db->select('city.*,count(locality.city_id) as serving');
      $this->db->join('locality','city.id=locality.city_id','left');
      $this->db->where('city.status',1);
      $this->db->group_by('city.name');
      $query = $this->db->get('city');
       //echo $this->db->last_query(); die;
      return $query->result_array();
    }

    public function get_locality_api($id)
    {

      $this->db->select('id,name,start_time,end_time');
      $this->db->where('city_id',$id);
      $query = $this->db->get('locality');
      $locality =  $query->result_array();
      return $locality;
      //print_r($locality); die; 
    }

     public function get_street_api($id)
    {

      $this->db->select('id,name');
      $this->db->where('locality_id',$id);
      $query = $this->db->get('street');
      $locality =  $query->result_array();
      return $locality;
      //print_r($locality); die; 
    }
    public function varify_phone_number($phone_number)
    {
      $this->db->select('*');
      $this->db->where('phone_number' , $phone_number);
      $query = $this->db->get('users');
     // echo $this->db->last_query(); die;
      return $query->row_array();
    }

    public function check_email_to_reset_password($email)
    {
      $this->db->select('*');
      $this->db->where('email', $email);
      $query = $this->db->get('users');
      return $query->row_array();

    }
//     public function send_link_to_mail($email,$id)
//     {
//       $to      = 'veee.kay258@gmail.com';
//       $subject = 'the subject';
//       $message = 'hello';
//       $headers = 'coolkashyap.com@gmail.com';

//       if(mail($to,$subject,$message,$headers)){
// echo "sent"; die;
//       }else {
// echo "no"; die;
//         # code...
//      //  }
//      //  ini_set('display_errors',1); die;
//      //  echo $email;
//      //  echo $id;
//      // $to = $email;
//      //  $message = "click on the link below to reset your password";
//      //  echo $message;
//      //  $message .=  "<br>";
//      //  //$message .="<a href = http://localhost/gogreen/admin/reset_user_password?id=$id>Link</a>";
//      //  $this->load->library('email');
//      //  $this->email->from('coolkashyap.com@gmail.com','vicky');
//      //  $this->email->to('veee.kay258@gmail.com');
//      //  $this->email->subject('Password Reset Link');
//      //  $this->email->message('Testing purpose');
//      //  $this->email->send();
//      //   if($this->email->send())
//      //   {
//      //    return 1
//      //   }
//      //   else{
//      //    return 2;
//      //   }
//      //  echo $message; die;
     
//      // $subject = "Password  Reset Link";
//      //  $message = "Your OTP is ".$otp.". Do Not Share It With Anyone";
//      //   echo "$message"; die;
//      //  $subject = "Password Varification Link";
//      //  $headers =  'MIME-Version: 1.0' . "\r\n"; 
//      //  $headers .= 'From:vicky@ripenapps.com' . "\r\n";
//      //  $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n"; 
//      //  $bool = mail($to,$subject,$message,$headers);
//      //   echo $bool;
//      //   return $bool;

//      //   $this->load->library('email');

//      //  $config['protocol']    = 'smtp';

//      //  $config['smtp_host']    = 'smtp.gmail.com';

//      //  $config['smtp_port']    = '567';

//      //  $config['smtp_timeout'] = '7';

//      //  $config['smtp_user']    = 'veee.kay258@gmail.com';

//      //  $config['smtp_pass']    = 'Heyudude@0';

//      //  $config['charset']    = 'utf-8';

//      //  $config['newline']    = "\r\n";

//      //  $config['mailtype'] = 'text'; // or html

//      //  $config['validation'] = TRUE; // bool whether to validate email or not      

//      //  $this->email->initialize($config);


//      //  $this->email->from('veee.kay258@gmail.com', 'vicky');
//      //  $this->email->to('coolkashyap.com@gmail.com'); 


//      //  $this->email->subject('Email Test');

//      //  $this->email->message('Testing the email class.');  

//      //  $this->email->send();

//      //  echo $this->email->print_debugger();

//    }


    public function update_phone_verify_key($id)
    {

      $this->db->set('is_phone_verified', '1');
      $this->db->where('id', $id);
      $query = $this->db->update('users');
      if($query)
      {
        return 1;
      }
      else{
        return 0;
      } 
    }
    public function update_social_id_fb($email,$social_id,$phone_number,$is_phone_verified)
    {

      $this->db->set('social_id_fb',$social_id);
      $this->db->set('phone_number',$phone_number);
      $this->db->set('is_phone_verified',$is_phone_verified);
      $this->db->where('email',$email);
       $bool = $this->db->update('users');
        if($bool)
       {
        $this->db->where('email',$email);
        return $this->db->get('users')->row()->id;
       }
       else
       {
        return 0;
       }
       
    }
     public function update_social_id_gl($email,$social_id,$phone_number,$is_phone_verified)
    {

      $this->db->set('social_id_gl',$social_id);
      $this->db->set('phone_number',$phone_number);
      $this->db->set('is_phone_verified',$is_phone_verified);
      $this->db->where('email',$email);
       $bool = $this->db->update('users');
       if($bool)
       {
        $this->db->where('email',$email);
        return $this->db->get('users')->row()->id;
       }
       else
       {
        return 0;
       }
    }
    public function update_phone_number($id,$phone_number)
    {
      $this->db->set('phone_number', $phone_number);
      $this->db->where('id', $id);
      $query = $this->db->update('users');
      if($query)
      {
        return 1;
      }
      else{
        return 0;
      } 

    }
  }
?>