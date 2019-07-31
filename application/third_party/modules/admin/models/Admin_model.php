<?php
  Class Admin_model extends CI_Model
  {


    public function admin_credentials()
    {

      $this->db->select('*');
      $query = $this->db->get('admin');
      return $query->row_array();
    }

    public function check_email_existense($email)
    {
      $this->db->select('*');
      $this->db->where('email', $email);
      $query = $this->db->get('admin');
       $arr =  $query->result_array();

      if(!empty($arr))
      {
       
        return true;
      }
      else{
        
        return false;
      }
    }


    public function get_id_by_email($email)
    {
      $this->db->select('*');
      $this->db->where('email' , $email);
       $query = $this->db->get('admin');
       $row = $query->row();
       $id = $row->id;
       return $id;
    }

    public function update_password($id,$data)
    {
      $this->db->where('id', $id);
      $result = $this->db->update('admin',$data);
       //echo $this->db->last_query(); die;
      //echo $result; die;
      return $result;
    }
     public function reset_user_password($id,$data)
    {
      $this->db->where('id', $id);
      $result = $this->db->update('users',$data);
       //echo $this->db->last_query(); die;
      //echo $result; die;
      return $result;
    }
    public function check_current_password($password)
    {
      $this->db->where('password',$password);
      $this->db->select('*');
      $query = $this->db->get('admin');
      return $query->row_array();
    }
    public function update_password_admin($new,$current)
    {
      $this->db->where('password',$current);
      $this->db->set('password',$new);
      $query = $this->db->update('admin');
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