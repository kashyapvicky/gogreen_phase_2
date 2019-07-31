<?php
  Class Teams_model extends CI_Model
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
    public function get_streets($letters,$locality_id)
    {
      $this->db->where('locality_id',$locality_id);
      $this->db->like('name', $letters, 'after');
      $query =  $this->db->get('street');
      return $query->result_array();
    }
    // public function get_alphabatically_streets($letters)
    // {
    //   $this->db->
    // }
    public function get_textarea_street($street_id)
    {
      $this->db->select('name,id,locality_id,city_id');
      $this->db->where('id',$street_id);
      $query = $this->db->get('street');
      return $query->row_array();
    }
    public function get_cleaners($locality_id,$string)
    {
      $this->db->select('*');
      $this->db->where('locality_id',$locality_id);
      $this->db->where('status',1);
      $this->db->where('is_del',1);
      $this->db->like('first_name', $string, 'after');
      $query=  $this->db->get('cleaners');
      return $query->result_array();
    }

    public function get_textarea_cleaner($cleaner_id)
    {
      $this->db->select('first_name,id,locality_id,city_id');
      $this->db->where('id',$cleaner_id);
      $this->db->where('status',1);
      $this->db->where('is_del',1);
      $query = $this->db->get('cleaners');
      return $query->row_array();
    }
    public function insert_team($data)
    {
      $this->db->insert('teams',$data);
      $insert_id = $this->db->insert_id();

      return  $insert_id;
    }
    public function insert_street_id_to_team($data)
    {
      $this->db->insert('teams_street',$data);
      $insert_id_street = $this->db->insert_id();
      return  $insert_id_street;
    }
    public function insert_cleaners_id_to_team($data)
    {
        $this->db->insert('team_cleaner',$data);
        $insert_id = $this->db->insert_id();
        return  $insert_id;

    }
    public function update_cleaner_status($cleaner_id)
    {
      $this->db->set('status',2);
      $this->db->where('id',$cleaner_id);
      $this->db->update('cleaners');
    }
    public function get_teams_detail()
    {
      $this->db->select('teams.id,teams.name,teams.jobs,locality.name as locality, city.name as city');
      $this->db->join('locality','locality.id = teams.locality_id','left');
      $this->db->join('city','city.id=teams.city_id','left');
      $this->db->where('teams.status',1);
      $query = $this->db->get('teams');
      return $query->result_array();

    }
    public function get_team_info($team_id)
    {
      $this->db->select('tm.name,tm.id,ts.street_id');
      $this->db->join('teams_street as ts','tm.id=ts.team_id');
      $this->db->where('tm.id',$team_id);
      $query = $this->db->get('teams as tm');
      return $query->row_array();
    }
    public function get_cleaner_assaigned_to_this_team($team_id)
    {
      $this->db->select('cl.first_name,cl.id as cleaner_id');
      $this->db->join('cleaners as cl','cl.id=tc.cleaner_id');
      $this->db->where('cl.is_del',1);
      $this->db->where('tc.team_id',$team_id);
      $query=$this->db->get('team_cleaner as tc');
      return $query->result_array();
    }
    public function get_all_free_cleaner_on_street($street_id)
    {
      $this->db->select('cl.first_name,cl.id as cleaner_id,cl.status');
      $this->db->join('locality as lt','lt.id=st.locality_id');
      $this->db->join('cleaners as cl','cl.locality_id=lt.id');
      $this->db->where('cl.status',1);
      $this->db->where('cl.is_del',1);
      $this->db->where('st.id',$street_id);
      $query = $this->db->get('street as st');
      // echo $this->db->last_query(); die;
      return $query->result_array();
    }


    public function update_status_as_inactive($ids)// function used twice in coontroller
    {
      $this->db->where_in('id',$ids);
      $this->db->set('status',1);
      $this->db->update('cleaners');
    }
    public function delete_all_cleaner_from_team_cleaners($team_id)
    {
      $this->db->where('team_id',$team_id);
      $this->db->delete('team_cleaner');
    }
    public function update_status_as_active($ids)
    {
      $this->db->where_in('id',$ids);
      $this->db->set('status',2);
      $this->db->update('cleaners');
    }
    public function insert_all_cleaners_to_team_cleaners($cleaners,$team_id)
    {

      foreach ($cleaners as $key => $value)
      {

        $data = array(
          'team_id'=>$team_id,
          'cleaner_id'=>$value
        );
        $this->db->insert('team_cleaner',$data);
      }
    }
    public function check_team_dependency($team_id)
    {
      $this->db->select('at.id as at_id,at.team_id,at.payment_key as at_payment_key,bp.expiry_date,bp.id as bp_id,bp.payment_key as bp_payment_key');
      $this->db->join('booked_packages as bp','bp.payment_key=at.payment_key');
      $this->db->where('bp.expiry_date >', 'CURDATE()',FALSE);
      $this->db->where('at.team_id',$team_id);
      $query = $this->db->get('assiagned_team as at');
      return $query->result_array();

    }
    public function get_all_cleaner_associated_to_team($team_id)
    {
      $this->db->select('cleaner_id');
      $this->db->where('team_id',$team_id);
      $query = $this->db->get('team_cleaner');
      return $query->result_array();
    }
    // public function update_cleaner_status($ids)
    // { 
    //   $this->db->where_in('id',$ids);
    //   $this->db->set('status',1);
    //   $this->db->update('cleaners');
    // }
    public function soft_delete_the_team($team_id)
    {
      $this->db->where('id',$team_id);
      $this->db->set('status',2);
      $this->db->update('teams');

    }
    public function get_team_location($team_id)
    {
      $this->db->select('ct.name as city,ct.id as city_id,lt.name as locality,lt.id as locality_id,st.name as streets,st.id as street_id');
      $this->db->join('locality as lt','lt.id=t.locality_id','left');
      $this->db->join('city as ct','ct.id=t.city_id','left');
      $this->db->join('teams_street as ts','ts.team_id=t.id','left');
      $this->db->join('street as st','st.id=ts.street_id','left');
      $this->db->where('t.id',$team_id);
      $query =   $this->db->get('teams as t');
      return $query->result_array();
    }
    public function get_all_localities($city_id)
    {
      $this->db->select('id,name');
      $this->db->where('city_id',$city_id);
      $query = $this->db->get('locality');
      return $query->result_array();
    }
    public function get_all_streets($locality_id)  // used twice from controller
    {
      $this->db->select('id,name');
      $this->db->where('locality_id',$locality_id);
      $query = $this->db->get('street');
      return $query->result_array();
    }
    public function update_city_and_location_of_team($city_id,$locality_id,$team_id)
    {
      $this->db->where('id',$team_id);
      $this->db->set('city_id',$city_id);
      $this->db->set('locality_id',$locality_id);
      $this->db->update('teams');
    }
    public function delete_all_street_of_teams($team_id)
    {
      $this->db->where('team_id',$team_id);
      $this->db->delete('teams_street');
    }
    public function insert_new_streets_to_this_team($team_id,$street_id)
    {
     $ts_array = array
     (
      'team_id'=>$team_id,
      'street_id'=>$street_id
     );
     $this->db->insert('teams_street',$ts_array);
    }
    public function get_all_cleaner_id_working_on_this_team($team_id)
    {
      $this->db->select('cleaner_id');
      $this->db->where('team_id',$team_id);
      $query = $this->db->get('team_cleaner');
      return $query->result_array();
    }
    public function update_cleaner_locations($cleaner_id_column,$locality_id)
    {
      $this->db->where_in('id',$cleaner_id_column);
      $this->db->set('locality_id',$locality_id);
      $this->db->update('cleaners');
    }

  }
?>