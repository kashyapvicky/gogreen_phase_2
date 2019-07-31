<?php
  Class Location_model extends CI_Model
  {

    public function insert_city($data)
    {
      $query = $this->db->insert('city', $data);
      return $query;

    }
    public function get_city()
    {
      $this->db->select('*');
      $this->db->where('status',1);
      $this->db->group_by('name');
      $query = $this->db->get('city');
      return $query->result_array();
    }

    public function insert_locality($data)
    {
      $this->db->insert('locality', $data);
      $insert_id = $this->db->insert_id();
      return  $insert_id;
      //return $query;//return 1 if inserted 0 if not
    }

    public function get_locality_ajax($city_id)
    {
      $this->db->select('*');
      $this->db->where('status', 1);
      $this->db->where('city_id', $city_id);
      $query = $this->db->get('locality');
      $result = $query->result_array();
      return $result;
    }

    public function insert_street($data)
    {
     // echo"<script>alert('here')</script>";die;
      $query = $this->db->insert('street', $data);
      return $query;//return 1 if inserted 0 if not
    }


     public function get_streets_ajax($locality_id)
    {
      $this->db->select('*');
      $this->db->where('status', 1);
      $this->db->where('locality_id', $locality_id);
      $query = $this->db->get('street');
      $result = $query->result_array();
      return $result;
    }
    public function inactive_city_locality_street($city_id)
    {
      $this->db->where('id', $city_id);
      $this->db->set('status',2);
      $this->db->update('city');
      // $this->db->where('city_id',$city_id);
      // $this->db->set('status',2);
      // $this->db->update('locality');
      // $this->db->where('city_id',$city_id);
      // $this->db->set('status',2);
      // $this->db->update('street');

      if($this->db->affected_rows()>0)
      {
        return 1;
      }
      else
      {
        return 0;
      }
    }
    public function inactive_cities()
    {
      $this->db->select('*');
      $this->db->where('status',2);
     $query =  $this->db->get('city');
     return $query->result_array();
    }
    public function inactive_localities()
    {
      $this->db->select('*');
      $this->db->where('status',2);
      $query =  $this->db->get('locality');
      return $query->result_array();
    }

    public function activate_city($id)
    {
      $this->db->set('status',1);
      $this->db->where('id',$id);
      $this->db->update('city');
      if($this->db->affected_rows()>0)
      {
        return 1;
      }
      else
      {
        return 0;
      }
    }
    public function activate_locality($id)
    {
      $this->db->set('status',1);
      $this->db->where('id',$id);
      $this->db->update('locality');
      if($this->db->affected_rows()>0)
      {
        return 1;
      }
      else
      {
        return 0;
      }
    }
    public function inactivte_locality($locality_id)
    {
      $this->db->set('status',2);
      $this->db->where('id',$locality_id);
      $query = $this->db->update('locality');
      if($query)
      {
        return 1;
      }
      else
      {
        return 0;
      }
    }
    public function is_city_already_exist($city)
    {
      $this->db->select('*');
      $this->db->where('name',$city);
      $query = $this->db->get('city');
      return $query->row_array();
    }
    public function is_locality_already_exist($city_id,$locality_name)
    {
      $this->db->select('*');
      $this->db->where('city_id',$city_id);
      $this->db->where('name',$locality_name);
      $query = $this->db->get('locality');
      return $query->row_array();
    }
    public function is_street_already_exist($locality_id,$city_id,$street)
    {
      $this->db->select('*');
      $this->db->where('locality_id',$locality_id);
      $this->db->where('city_id',$city_id);
      $this->db->where('name',$street);
      $query = $this->db->get('street');
      return $query->row_array();
    }
    public function get_city_to_edit($city_id)
    {
      $this->db->select('*');
      $this->db->where('id',$city_id);
      $query = $this->db->get('city');
      return $query->row_array();
    }
    public function edit_city($city_name,$city_id)
    {
      $this->db->where('id',$city_id);
      $this->db->set('name',$city_name);
      $query = $this->db->update('city');
      if($query)
      {
        return 1;
      }
      else{
        return 0;
      }
    }
    public function get_locality_to_edit($locality_id)
    {
      $this->db->select('city.name as city,locality.id,locality.name as locality,locality.start_time,locality.end_time');
      $this->db->join('city','city.id=locality.city_id','left');
      $this->db->where('locality.id',$locality_id);
      $query = $this->db->get('locality');
      return $query->row_array();
    } 
    public function get_street_to_edit($street_id)
    {
      $this->db->select('city.name as city,locality.name as locality,st.name as street,st.id');
      $this->db->join('city','city.id=st.city_id','left');
      $this->db->join('locality','locality.id=st.locality_id','left');
      $this->db->where('st.id',$street_id);
      $query = $this->db->get('street as st');
      return $query->row_array();
    }
    public function update_locality($data,$locality_id)
    {
      $this->db->where('id',$locality_id);
      $query = $this->db->update('locality',$data);
      if($query)
      {
        return 1;
      }
      else
      {
        return 0;
      }
    }
    public function update_street($name,$id)
    {
      $this->db->where('id',$id);
      $this->db->set('name',$name);
      $query = $this->db->update('street');
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