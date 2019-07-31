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
        $this->db->where('locality.status',1);
        $this->db->where('city.status',1);
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
        $this->db->where('locality.status',1);
        //$this->db->where('locality.is_package',1);
        $this->db->order_by('city.name');
        $query = $this->db->get('locality');
        $result = $query->result_array();
        return $result;
      }
      
    }
 public function get_locality_and_city_edit($city_id,$car_type,$package_locality)
    {
      if($car_type == 'suv')
      {
        $this->db->select('locality.*,city.id as city_id,city.name as city');
        $this->db->join('city','city.id = locality.city_id');
        $this->db->where_in('city_id',$city_id);


        $where = "locality.is_suv=1 AND locality.status=1";
        $this->db->where($where);
        $this->db->or_where_in('locality.id',$package_locality);



        // $this->db->where('locality.is_suv',1);
        // $this->db->where('locality.status',1);
        // $this->db->where('city.status',1);
        //$this->db->where('locality.is_package',1);
        $this->db->order_by('city.name');
        $query = $this->db->get('locality');
        // echo $this->db->last_query(); die;
        $result = $query->result_array();
        return $result;
      }
      elseif($car_type == 'saloon')
      {
        $this->db->select('locality.*,city.id as city_id,city.name as city');
        $this->db->join('city','city.id = locality.city_id');
        $this->db->where_in('city_id',$city_id);

        $where = "locality.is_saloon=1 AND locality.status=1";
        $this->db->where($where);
        $this->db->or_where_in('locality.id',$package_locality);

        // $this->db->where('locality.is_saloon',1);
        // $this->db->where('locality.status',1);
        //$this->db->where('locality.is_package',1);
        $this->db->order_by('city.name');
        $query = $this->db->get('locality');
        // echo $this->db->last_query(); die;
        $result = $query->result_array();
        return $result;
      }
  		
    }

    public function get_city_via_ajax($city_id)
    {
      $this->db->select('id,name');
      $this->db->where_in('id',$city_id);
      $this->db->where('status',1);
      $this->db->order_by('name');
      $query = $this->db->get('city');
      //echo $this->db->last_query(); die;
      $result = $query->result_array();
      return $result;
    }
    
   
   public function insert_package_details($data)
   {
      $query = $this->db->insert('packages',$data);
      $insert_id = $this->db->insert_id();
      //$query = $this->db->insert('packages',$data_once);
      if($insert_id)
      {
        return $insert_id;
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
      $this->db->select('packages.*');
      // $this->db->join('package_locations as pl','pl.id=packages.id');
      // $this->db->join('city','pl.city_id=city.id');
      // $this->db->join('locality','pl.locality_id=locality.id');
      $query = $this->db->get('packages');
      return $query->result_array();
   }
   public function del_package($id)
   {
      $this->db->where('id',$id);
      $query = $this->db->delete('packages');
      // echo $this->db->last_query(); die;
      if($query)
      {
        return 1;
      }
      else
      {
        return 0;
      }
   }
   public function delete_package_locations($id)
   {
    $this->db->where('package_id',$id);
     $query = $this->db->delete('package_locations');
      // echo $this->db->last_query(); die;
      if($query)
      {
        return 1;
      }
      else
      {
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
      $this->db->where('locality.status',1);
      $this->db->order_by('name');
      $query = $this->db->get('locality');
      $result = $query->result_array();
      return $result;
   }
    public function insert_locations_of_inserted_package($data)
    {
      $this->db->insert('package_locations',$data);
       return $this->db->insert_id();
    }

    public function package_details_to_edit($package_id)
    {
      $this->db->select('*');
      $this->db->where('id',$package_id);
      $query = $this->db->get('packages');
      return $query->row_array();
    }
    public function get_package_location_by_id($package_id)
    {
      $this->db->select('ct.name as city,ct.id as city_id,lt.name as locality,lt.id as locality_id');
      $this->db->join('city as ct','ct.id=pl.city_id');
      $this->db->join('locality as lt','lt.id=pl.locality_id');
      $this->db->where('package_id',$package_id);
      $query = $this->db->get('package_locations as pl');
      return $query->result_array();
    }
    public function get_all_cities()
    {
      $this->db->select('*');
      $query = $this->db->get('city');
      return $query->result_array();
    }
    public function get_all_localities($flag,$package_locality)
    {
      $this->db->select('locality.*,ct.name as city');
      $this->db->join('city as ct','ct.id=locality.city_id');
      if($flag==1)
      {
        // suv check
        $array = array('locality.is_suv =' => 1, 'locality.status' => 1);
        $this->db->where($array);
        if(!empty($package_locality))
        {
          $this->db->or_where_in('locality.id',$package_locality);
        }
      }
      else
      {
        $array = array('locality.is_saloon =' => 1, 'locality.status' => 1);
        $this->db->where($array);
         if(!empty($package_locality))
        {
          $this->db->or_where_in('locality.id',$package_locality);
        }
      }
      $query = $this->db->get('locality');
      return $query->result_array();
    }
    public function get_all_localities_of_respective_packages($package_id)
    {
      $this->db->select('locality_id');
      $this->db->where('package_id',$package_id);
      $query = $this->db->get('package_locations');
      return $query->result_array();
    }
    public function set_default_status_to_localities($package_localities,$type)
    {
      $this->db->where_in('id',$package_localities);
      if($type=='saloon')
      {
        $this->db->set('is_saloon',1);
      }
      else
      {
        $this->db->set('is_suv',1);
      }
      $this->db->update('locality');


    }
    public function delete_all_entries_of_respective_package($package_id)
    {
      $this->db->where('package_id',$package_id);
      $this->db->delete('package_locations');
    }
    public function update_package_details($data,$package_id)
    {
      $this->db->where('id',$package_id);
     $query =  $this->db->update('packages',$data);
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