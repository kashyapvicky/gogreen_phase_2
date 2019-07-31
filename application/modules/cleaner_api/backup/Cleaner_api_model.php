<?php
  Class Cleaner_api_model extends CI_Model
  {
     
    public function validate_login_cleaner($phone_number,$password)
    {
      $this->db->select('cleaners.id,cleaners.phone_number,cleaners.email,cleaners.first_name,cleaners.last_name,city.name as city,locality.name as locality');
      $this->db->join('city','city.id=cleaners.city_id');
      $this->db->join('locality','locality.id=cleaners.locality_id');
      $this->db->where('phone_number',$phone_number);
      $this->db->where('password',$password);
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
  }
?>