<?php
  Class User_model extends CI_Model
  {


    public function get_all_users()
    {

      $this->db->select('users.*,count(car_detail.user_id) as no_of_cars,count(CASE WHEN car_detail.is_package = 2 then 1 ELSE NULL END) as active_cars,ct.name as city,lt.name as locality,st.name as street');
      $this->db->join('booked_packages as bp','bp.user_id=users.id','left');
      $this->db->join('city as ct','ct.id=bp.city_id','left');
      $this->db->join('locality as lt','lt.id=bp.locality_id','left');
      $this->db->join('street as st','st.id=bp.street_id','left');
      $this->db->join('car_detail', 'users.id = car_detail.user_id','left');
      $this->db->group_by('users.email');
      $query = $this->db->get('users');
      return $query->result_array();
      // $this->db->select('*');
      // $query = $this->db->get('users');
      // return $query->result_array();
    }

    public function total_rows()
    {
      $query = $this->db->query('SELECT * FROM users');
      return $query->num_rows();
    }

   

    public function get_car_details($id)
    {

      $this->db->select('cb.name as brand,cr.id,cm.name as model,cr.reg_no,cr.status,ct.name as city,ct.id as city_id,lt.name as locality,lt.id as locality_id,st.name as street,st.id as street_id,bp.package_type,bp.id as package_id,bp.user_id as package_user_id');
      $this->db->join('city as ct','ct.id=cr.city_id','left');
      $this->db->join('locality as lt','lt.id=cr.locality_id','left');
      $this->db->join('street as st','st.id=cr.street_id','left');
      $this->db->join('booked_packages as bp','bp.car_id=cr.id','left');
      $this->db->join('car_brand as cb','cb.id = cr.brand');
      $this->db->join('car_model as cm','cm.id = cr.model');
      //$this->db->join('packages as p','p.id='.$id.'','left');
      //$this->db->join('cleaner')
      //$this->db->group_by('user_id');
      $this->db->where('cr.user_id', $id);
      $query = $this->db->get('car_detail as cr');
      //echo $this->db->last_query(); die;
     // echo"<pre>";print_r($query->result_array()); die;
      return $query->result_array();
    }
    public function get_purchase_history($id,$user_id)
    {
      $this->db->select('booked_packages.*,user_payment.net_paid');
      $this->db->join('user_payment','user_payment.user_id=booked_packages.user_id');
      $this->db->where('booked_packages.id',$id);
      $query = $this->db->get('booked_packages');
      return $query->row_array();
    }
    public function get_user_detai($id)
    {
      $this->db->select('*');
      $this->db->where('id',$id);
      $query = $this->db->get('users');
      return $query->row_array();

    } 

  }
?>