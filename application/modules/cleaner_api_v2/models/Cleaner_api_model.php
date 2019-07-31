<?php
  Class Cleaner_api_model extends CI_Model
  {
     
    public function validate_login_cleaner($phone_number,$password)
    {
      $this->db->select('cleaners.id,cleaners.phone_number,cleaners.email,cleaners.first_name,cleaners.last_name,city.name as city,locality.name as locality');
      $this->db->join('city','city.id=cleaners.city_id');
      $this->db->join('locality','locality.id=cleaners.locality_id');
      $this->db->where('cleaners.email',$phone_number);
      $this->db->where('cleaners.is_del',1);
      $this->db->where('cleaners.password',$password);
      $query = $this->db->get('cleaners');
      return $query->row_array();

    }
    public function get_user_id($phone_number)
    {
      $this->db->select('id,phone_number');
      $this->db->where('phone_number',$phone_number);
      $query = $this->db->get('cleaners');
      return $query->row_array();
    }
    public function update_password($user_id,$password)
    {
      $this->db->set('password',$password);
      $this->db->where('id',$user_id);
      $query =  $this->db->update('cleaners');
      //echo $this->db->last_query(); die;
      if($query)
      {
        return 1;
      }
      else
      {
        return 0;
      }
    }
    public function check_user_id($user_id)
    {
      $this->db->select('*');
      $this->db->where('id',$user_id);
      $query = $this->db->get('cleaners');
      return $query->row_array();
    }
    public function update_user_info($data,$user_id)

    {
      $this->db->where('id',$user_id);
      $query = $this->db->update('cleaners',$data);
      if($query)
      {
        return 1;
      }
      else{
          return 0;
      }
    }
    public function check_old_password($user_id,$old_password)
    {
      $this->db->select('*');
      $this->db->where('id',$user_id);
      $this->db->where('password',$old_password);
      $query =  $this->db->get('cleaners');
      return $query->row_array();


    }
    public function change_password($user_id,$new_password)
    {
      $this->db->where('id',$user_id);
      $this->db->set('password',$new_password);
      $query = $this->db->update('cleaners');
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