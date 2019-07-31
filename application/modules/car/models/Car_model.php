<?php
  Class Car_model extends CI_Model
  {

    public function get_brands()
    {
      $this->db->select('*');
      $query = $this->db->get('car_brand');
      return $query->result_array();
    }
    public function insert_model($data)
    {
     $query =  $this->db->insert('car_model',$data);
     if($query)
     {
      return 1;
     }
     else{
      return 0;
     }
    }
    public function add_brand($data)
    {
      $query = $this->db->insert('car_brand',$data);
      return $query;
    }
    public function get_brand_with_models()
    {
      $this->db->select('car_model.name as model,car_model.id as model_id,car_brand.name as brand,car_brand.id as brand_id');
      $this->db->join('car_model','car_model.brand_id = car_brand.id','left');
      $query = $this->db->get('car_brand');
      return $query->result_array();
    }
    public function delete_brand_and_model($brand_id,$model_id)
    {
      // $this->db->where('id', $brand_id);
      // $query = $this->db->delete('car_brand');
      // if($query)
      // {
        $this->db->where('id', $model_id);
        $this->db->where('brand_id', $brand_id);
        $bool = $this->db->delete('car_model'); 
        return $bool;
     // }

    }
    public function get_brands_and_model($model_id)
    {
      $this->db->select('car_model.name as model,car_model.id as model_id,car_brand.name as brand,car_brand.id as brand_id');
      $this->db->join('car_model','car_model.brand_id=car_brand.id');
      $this->db->where('car_model.id',$model_id);
      $query  = $this->db->get('car_brand');
      return $query->row_array();
    }
    public function update_braand_and_model($brand_id,$model_id,$brand_name,$model_name)
    {
      $this->db->where('id',$brand_id);
      $this->db->set('name',$brand_name);
      $this->db->update('car_brand');


      $this->db->where('id',$model_id);
      $this->db->set('name',$model_name);
      $this->db->update('car_model');
    }
    public function check_brand_exist($brand_id,$brand_name)
    {
      $this->db->select('*');
      $this->db->where('id!=',$brand_id);
      $this->db->where('name',$brand_name);
      $query = $this->db->get('car_brand');
      return $query->row_array();
    }
    public function delete_brand($brand_id)
    {
      $this->db->where('id',$brand_id);
      $this->db->delete('car_brand');

      $this->db->where('brand_id',$brand_id);
      $this->db->delete('car_model');

    }
     public function delete_model($model_id)
    {
      $this->db->where('id',$model_id);
      $this->db->delete('car_model');

      // $this->db->where('brand_id',$brand_id);
      // $this->db->delete('car_model');

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
  }
?>