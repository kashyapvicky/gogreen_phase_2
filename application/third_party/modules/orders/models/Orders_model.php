<?php
  Class Orders_model extends CI_Model
  {
    public function get_all_orders($payment_type)
    {
      $this->db->select('up.id as primary_id,up.status,up.orders_id,up.net_paid,up.user_id,up.transaction_id,users.id as user_id,users.name as username,users.phone_number,t.name as team_name,t.id');
      $this->db->where('payment_type',$payment_type,FALSE);
      $this->db->join('users','users.id=up.user_id','left');
      $this->db->join('assiagned_team as at','at.payment_key=up.id');
      //$this->db->group_by('')
      $this->db->join('teams as t','t.id=at.team_id');
      $query = $this->db->get('user_payment as up');
     // echo $this->db->last_query(); die;
      return $query->result_array();

    }
    public function get_user_detail_by_id($user_id)
    {
      $this->db->select('*');
      $this->db->where('id',$user_id);
      $query = $this->db->get('users');
      return $query->row_array();

    }
    public function get_packages_detail($user_id)
    {
      $this->db->select('id,user_id,package_type,purchase_date,expiry_date,services,one_time_service_date,days,frequency,amount,status');
      $this->db->where('user_id',$user_id);
      $query = $this->db->get('booked_packages');
      return $query->result_array();
    }
    public function get_car_detail($user_id)
    {
      $this->db->select('cd.id as car_id,cd.type,cd.color,cd.reg_no,cd.parking_number,cb.name as brand,cm.name as model');
      $this->db->join('car_brand as cb','cb.id=cd.brand','left');
      $this->db->join('car_model as cm','cm.id=cd.model','left');
      $this->db->where('user_id',$user_id);
      $query = $this->db->get('car_detail as cd');
      return $query->result_array();
    }
    public function get_crew_detail($user_id)
    {
      $this->db->select('cl.first_name as name,cl.phone_number,cl.id,at.team_id');
      //$this->db->join('assiagned_team as at','at.user_id=')
      $this->db->join('team_cleaner as tc','tc.team_id=at.team_id','left');
      $this->db->join('cleaners as cl','cl.id=tc.cleaner_id','left');
      $this->db->where('at.user_id',$user_id);
     // $this->db->group_by('at.user_id');
      $this->db->group_by('cl.id');
      $query=$this->db->get('assiagned_team as at');
      return $query->result_array();
    }
    public function get_user_history($user_id)
    {
      $this->db->select('up.id,up.orders_id,u.name,bp.package_type,t.name as team_name,up.net_paid,up.status');
      $this->db->join('users as u','u.id=up.user_id','left');
      $this->db->join('booked_packages as bp','bp.payment_key=up.id','left');
      $this->db->join('assiagned_team as at','at.payment_key=up.id','left');
      $this->db->join('teams as t','t.id=at.team_id','left');
      $this->db->group_by('up.id');
      $this->db->where('up.user_id',$user_id);
      $query = $this->db->get('user_payment as up');
      return $query->result_array();
    }
    public function get_pending_payment_order()
    {
      $this->db->select('up.orders_id,up.net_paid,u.name,u.phone_number');
      $this->db->join('users as u','u.id=up.user_id','left');
      $this->db->where('up.payment_type',1);
      $this->db->where('up.status',1);
      $query = $this->db->get('user_payment as up');
      return $query->result_array();
    }
    public function get_teams_working_on_this_package($id)
    {
        $this->db->select('tm.name as team_name,tm.id as team_id,bp.id as booked_packages_id,bp.payment_key as payment_key');
        $this->db->join('teams_street as ts','ts.street_id=bp.street_id');
        $this->db->join('teams tm','tm.id=ts.team_id');
        $this->db->where('bp.payment_key',$id);
        $query = $this->db->get('booked_packages as bp');
        return $query->result_array();

       
    }
    public function update_assiagned_team_tabel($team_id,$payment_key)
    {
      $this->db->where('payment_key',$payment_key);
      $this->db->set('team_id',$team_id);
      $query = $this->db->update('assiagned_team');
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