<?php
  Class Cleaner_model extends CI_Model
  {


    public function get_all_cleaners()
    {
      $this->db->where('is_del',1);
      $this->db->select('cleaners.*,city.name as city,locality.name as locality');
      $this->db->join('city','city.id=cleaners.city_id');
      $this->db->join('locality','locality.id=cleaners.locality_id');

      $query = $this->db->get('cleaners');
      return $query->result_array();
    }

    public function total_rows()
    {
      $query = $this->db->query('SELECT * FROM users');
      return $query->num_rows();
    }

   public function get_city()
   {
      $query = $this->db->get('city');
      return $query->result_array();
   }
   public function get_locality_by_ajax($city_id)
   {
     $this->db->select('*');
     $this->db->where('city_id',$city_id);
     $query = $this->db->get('locality');
     return $query->result_array();
   }
   public function insert_cleaner_data($data)
   {
     $query = $this->db->insert('cleaners',$data);
     if($query)
     {
      return 1;
     }
     else{
      return 0;
     }
   }
   public function update_cleaner_data($data,$cleaner_id)
   {
    $this->db->where('id',$cleaner_id);
    $query = $this->db->update('cleaners',$data);
     // $query = $this->db->insert('cleaners',$data);
     if($query)
     {
      return 1;
     }
     else{
      return 0;
     }
   }
   public function check_phone_number($phone_number,$id)
   {
    $this->db->select('*');
    $this->db->where('phone_number',$phone_number);
    $this->db->where('id!=', $id);
    $query = $this->db->get('cleaners');
    // echo $this->db->last_query(); die;
    return $query->row_array();

   }
   public function inactivate_cleaner($id)
   {
      $this->db->where('id',$id);
      $this->db->set('is_del',2);
      $query = $this->db->update('cleaners');
      if($query)
      {
        return 1;
      }
      else
      {
        return 0;
      }

   }
   public function get_cleaner_to_edit($cleaner_id)
   {

      $this->db->select('cl.id,cl.status as cleaner_status,cl.first_name,cl.email,cl.password,cl.last_name,cl.phone_number,cl.city_id as city_id,cl.locality_id as locality_id,ct.name as city,lt.name as locality');
      $this->db->join('locality as lt','lt.id=cl.locality_id','left');
      $this->db->join('city as ct','ct.id=cl.city_id','left');
      $this->db->where('cl.id',$cleaner_id);
      $query = $this->db->get('cleaners as cl');
      return $query->row_array();

   }
  }
?>