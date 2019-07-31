<?php
  Class Add_customer_model extends CI_Model
  {


   public function get_all_users()
   {
    return $this->db->get('users')->result_array();
   }
   public function insert_user($data)
   {
    $this->db->insert('users',$data);
    return $this->db->insert_id();
   }
    public function get_all_brands()
    {
      $this->db->select('*');
      $query = $this->db->get('car_brand');
      return $query->result_array();
    }

    public function get_all_models()
    {
      $this->db->select('*');
      $query = $this->db->get('car_model');
      return $query->result_array();
    }

     public function get_all_models_of_brand($brand_id)
    {
      $this->db->select('*');
      $this->db->where('brand_id',$brand_id);
      $query = $this->db->get('car_model');
      return $query->result_array();
    }
    public function get_inactive_cars($user_id)   // used twice in coontroller
    {
      $this->db->where('user_id',$user_id);
      $this->db->where('is_package',1);
      return $this->db->get('car_detail')->result_array();
    }
    public function update_car_detail($data,$car_id)
    {
      $this->db->where('id',$car_id);
      $query = $this->db->update('car_detail',$data);
      if($query)
      {
        return 1;
      }
      else
      {
        return 0;
      }
    }
    public function insert_car_detail($data)
    {
       $this->db->insert('car_detail',$data);
       return $this->db->insert_id();
    }

    public function is_phone_exist($phone_number)
    {
      $this->db->where('phone_number',$phone_number);
      $query = $this->db->get('users');
      return $query->row_array();
    }
    public function is_email_exist($email)
    {
      $this->db->where('email',$email);
      $query = $this->db->get('users');
      return $query->row_array();
    }
    public function check_reg_no($reg_no,$car_id)
    {
      $this->db->where('reg_no',$reg_no);
      if(!empty($car_id))
      {
        $this->db->where('id!=',$car_id);
      }
      $query = $this->db->get('car_detail');
      return $query->row_array();
    }
     public function get_city()
   {
      $this->db->where('status',1);
      $query = $this->db->get('city');
      return $query->result_array();
   }
    public function get_locality_by_ajax($city_id)
   {
     $this->db->select('*');
     $this->db->where('status',1);
     $this->db->where('city_id',$city_id);
     $query = $this->db->get('locality');
     return $query->result_array();
   }
   public function get_streets_by_ajax($locality_id)
   {
      $this->db->where('status',1);
      $this->db->where('locality_id',$locality_id);
      $query = $this->db->get('street');
      return $query->result_array();

   }
    public function get_package_details_on_locality($locality_id,$car_id,$services)
    {
      $this->db->select('p.*');
      $this->db->join('packages as p','p.id=pl.package_id');
      $this->db->join('car_detail as cd','cd.type=p.type');
      // $this->db->join('package_location as pl','pl.locality_id',$locality_id);
      $this->db->where('cd.id',$car_id);
      $this->db->where('pl.locality_id',$locality_id);
      $query =  $this->db->get('package_locations as pl');
      return $query->row_array();
    }
    public function insert_user_payment_data($user_payment_data)
    {
      $query = $this->db->insert('user_payment',$user_payment_data);
      $insert_id = $this->db->insert_id();
      return  $insert_id;
    }
    public function update_is_payment($user_id)
    {
      $this->db->set('is_payment',2);
      $this->db->where('id',$user_id);
      $query = $this->db->update('users');
      if($query)
      {
        return 1;
      }
      else{
        return 0;
      }
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
  public function update_package_status($car_id)
  {
    $this->db->set('status',2);
    $this->db->where('car_id',$car_id);
    $this->db->update('booked_packages');
  }
  public function update_is_packege_car_key($car_id)
  {
    $this->db->set('is_package',2);
    $this->db->where('id',$car_id);
    $query = $this->db->update('car_detail');
    if($query)
    {
      return 1;
    }
    else{
      return 0;
    }
  }
  public function insert_book_package($data)
  {
    $query = $this->db->insert('booked_packages',$data);
    $insert_id = $this->db->insert_id();
    return  $insert_id;
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
  public function get_mail_address_and_paid_amount($id)
  {
    $this->db->select('u.email,up.net_paid');
    $this->db->join('users as u','u.id=up.user_id','left');
    $this->db->where('up.id',$id);
    $query = $this->db->get('user_payment as up');
    return $query->row_array();

  }
  public function get_all_cars($user_id)
  {
    $this->db->select('cm.name as model,cb.name as brand,cd.reg_no,cd.color,cd.parking_number,cd.status,cd.is_package,cd.type,cd.id,cb.id as brand_id,cm.id as model_id');
    $this->db->where('user_id',$user_id);
    $this->db->join('car_model as cm','cm.id=cd.model','left');
    $this->db->join('car_brand as cb','cb.id=cd.brand','left');
    $query = $this->db->get('car_detail as cd');

    return $query->result_array();

  }
  public function delete_car($car_id)
  {
    $this->db->where('id',$car_id);
    $this->db->where('is_package',1);
    $query = $this->db->delete('car_detail');
    if($query)
    {
      return 1;
    }
    else
    {
      return 0;
    }
  }


  }
?>