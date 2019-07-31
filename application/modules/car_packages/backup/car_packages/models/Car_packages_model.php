<?php
  Class Car_packages_model extends CI_Model
  {
     

    public function insert_car_details($data)
    {

      $query = $this->db->insert('car_detail' , $data);
      $result = $this->db->insert_id();
      return $result;

    }
    public function check_reg_no($user_id,$reg_no)
    {

      $this->db->select('*');
      $this->db->where('user_id', $user_id);
      $this->db->where('reg_no', $reg_no);
      $query = $this->db->get('car_detail');
      $row = $query->row_array();
      if($row)
      {
        return 1;
      }
      else{
        return 0;
      }
    }

    public function get_cars($user_id)
    {
      $this->db->select('car_detail.id,car_detail.is_package,car_detail.parking_number,car_brand.name as brand,car_detail.reg_no,car_model.name as model,car_detail.type,car_detail.color,booked_packages.expiry_date');
      $this->db->join('car_model','car_model.id=car_detail.model','left');
      $this->db->join('car_brand','car_brand.id=car_detail.brand','left');
       $this->db->join('booked_packages','booked_packages.car_id=car_detail.id','left');
      $this->db->where('car_detail.user_id',$user_id);
      $query = $this->db->get('car_detail');
      //echo $this->db->last_query(); die;
      return $query->result_array();
    }
    public function get_cars_updated($user_id)
    {
      $this->db->select('car_detail.id,car_detail.is_package,car_detail.parking_number,car_brand.name as brand,car_detail.reg_no,car_model.name as model,car_detail.type,car_detail.color');
      $this->db->join('car_model','car_model.id=car_detail.model','left');
      $this->db->join('car_brand','car_brand.id=car_detail.brand','left');
      // $this->db->join('booked_packages','booked_packages.car_id=car_detail.id','left');
      $this->db->where('car_detail.user_id',$user_id);
      $query = $this->db->get('car_detail');
      //echo $this->db->last_query(); die;
      return $query->result_array();
    }
    public function get_models($brand_id)
    {
      $this->db->select('*');
      $this->db->where('brand_id',$brand_id);
      $query = $this->db->get('car_model');
      return $query->result_array();
    }
    public function get_brand()
    {
      $this->db->select('*');
      $query = $this->db->get('car_brand');
      return $query->result_array();
    }
    public function check_brand_name($name)
    {
      $this->db->select('*');
      $this->db->where('name',$name);
      $query = $this->db->get('car_brand');
      //echo $this->db->last_query(); die;
      return $query->row_array();
      
    }
    public function check_model_name($name)
    {
      $this->db->select('*');
      $this->db->where('name',$name);
      $query = $this->db->get('car_brand');
      //echo $this->db->last_query(); die;
      return $query->row_array();
      
    }
    public function insert_brand($data)
    {
        $this->db->insert('car_brand',$data);
       $insert_id = $this->db->insert_id();
       return  $insert_id;

    }
    public function insert_model($data)
    {
       $bool = $this->db->insert('car_model',$data);
       if($bool)
       {
        return 1;
       }
       else{
        return 0;
       }
    }
    public function get_package($locality_id,$car_type)
    {
      $this->db->select('*');
      $this->db->where('locality_id',$locality_id);
      $this->db->where('type',$car_type);
      $query = $this->db->get('packages');
      //echo $this->db->last_query(); die;
      return $query->result_array();

    }
    public function insert_book_package($data)
    {
      $query = $this->db->insert('booked_packages',$data);
      if($query)
      {
        return 1;
      }
      else
      {
        return 0;
      }

    }
    public function check_car_existence($car_id)
    {
      $this->db->select('*');
      $this->db->where('car_id',$car_id);
      $query = $this->db->get('booked_packages');
      $bool = $query->row_array();
      if($bool)
      {
        return 1;
      }
      else{
        return 0;
      }
    }
    public function insert_user_payment_data($user_payment_data)
    {
      $query = $this->db->insert('user_payment',$user_payment_data);
      if($query)
      {
        return 1;
      }
      else
      {
        return 0;
      }
    }
    public function is_package_on_car($car_id)
    {
      $this->db->select('*');
      $this->db->where('car_id',$car_id);
      $query = $this->db->get('booked_packages');
      return $query->row_array();
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
    public function update_is_package_as_expire($id)
    {
      $this->db->set('is_package',1);
      $this->db->where('id',$id);
      $query = $this->db->update('car_detail');
      if($query)
      {
        return 1;
      }
      else{
        return 0;
      }

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
    public function get_week_before_data($user_id,$today,$next_week)
    {
      $this->db->select('booked_packages.car_id,booked_packages.user_id,booked_packages.expiry_date,booked_packages.days,booked_packages.package_type,booked_packages.purchase_date');
      $this->db->where('expiry_date>',$today);
      $this->db->where('expiry_date<',$next_week);
      $this->db->where('user_id',$user_id);
      $query = $this->db->get('booked_packages');
      return $query->result_array();
    }
  }
?>