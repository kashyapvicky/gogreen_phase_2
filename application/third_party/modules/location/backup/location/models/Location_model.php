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
  }
?>