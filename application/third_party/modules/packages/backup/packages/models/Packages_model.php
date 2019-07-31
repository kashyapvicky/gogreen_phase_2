<?php
  Class Packages_model extends CI_Model
  {

  	public function get_city()
    {

      $this->db->select('*');
      $this->db->where('status',1);
      $this->db->group_by('name');
      $query = $this->db->get('city');
      return $query->result_array();
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

    public function get_locality_and_city($city_id,$car_type)
    {
      if($car_type == 'suv')
      {
        $this->db->select('locality.*,city.id as city_id,city.name as city');
        $this->db->join('city','city.id = locality.city_id');
        $this->db->where_in('city_id',$city_id);
        $this->db->where('locality.is_suv',1);
        //$this->db->where('locality.is_package',1);
        $this->db->order_by('city.name');
        $query = $this->db->get('locality');
        $result = $query->result_array();
        return $result;
      }
      elseif($car_type == 'saloon')
      {
        $this->db->select('locality.*,city.id as city_id,city.name as city');
        $this->db->join('city','city.id = locality.city_id');
        $this->db->where_in('city_id',$city_id);
        $this->db->where('locality.is_saloon',1);
        //$this->db->where('locality.is_package',1);
        $this->db->order_by('city.name');
        $query = $this->db->get('locality');
        $result = $query->result_array();
        return $result;
      }
  		
    }

    public function get_city_via_ajax($city_id)
    {
      $this->db->select('id,name');
      $this->db->where_in('id',$city_id);
      $this->db->order_by('name');
      $query = $this->db->get('city');
      //echo $this->db->last_query(); die;
      $result = $query->result_array();
      return $result;
    }
    
   
   public function insert_package_details($data)
   {
      $query = $this->db->insert('packages',$data);
      //$query = $this->db->insert('packages',$data_once);
      if($query)
      {
        return 1;
      }
      else{
        return 0;
      }
   }
   public function update_is_suv($locality_id)
   {
      $this->db->set('is_suv','2');
      $this->db->where('id',$locality_id);
      $this->db->update('locality');
   }
   public function update_is_saloon($locality_id)
   {
      $this->db->set('is_saloon','2');
      $this->db->where('id',$locality_id);
      $this->db->update('locality');
   }
   public function get_packages()
   {
      $this->db->select('packages.*,city.name as city,locality.name as locality');
      $this->db->join('city','packages.city_id=city.id');
      $this->db->join('locality','packages.locality_id=locality.id');
      $query = $this->db->get('packages');
      return $query->result_array();
   }
   public function del_package($id)
   {
      $this->db->where('id', $id);
      $query = $this->db->delete('packages');
      if($query)
      {
        return 1;
      }
      else{
        return 0;
      }
   }
   public function update_is_saloon_on_delete($locality_id)
   {
      $this->db->set('is_saloon','1');
      $this->db->where('id',$locality_id);
      $query = $this->db->update('locality');
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

   public function update_is_suv_on_delete($locality_id)
   {
      $this->db->set('is_suv','1');
      $this->db->where('id',$locality_id);
      $query = $this->db->update('locality');
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
   public function get_final_locality($locality_id)
   {
    $this->db->select('name,id');
      //$this->db->join('city','city.id = locality.city_id');
      $this->db->where_in('id',$locality_id);
      //$this->db->where('locality.is_package','1');
      $this->db->order_by('name');
      $query = $this->db->get('locality');
      $result = $query->result_array();
      return $result;
   }
  }
?>