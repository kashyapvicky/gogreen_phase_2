<?php
  Class Coupans_model extends CI_Model
  {
    public function check_img($imgname)
    {
      $this->db->select('*');
      $this->db->where('img_name',$imgname);
     $query =  $this->db->get('coupans');
      if($query->row_array())
      {
        return 1;
      }
      else{
        return 0;
      }
    }
    public function insert_coupan($data,$flag,$coupan_id=null)
    {
      if($flag==1)
      {
        $this->db->where('id',$coupan_id);
        $query = $this->db->update('coupans',$data);
        if($query)
        {
          return 1;
        }
        else
        {
          return 0;
        }
      }
      else
      {

        $query = $this->db->insert('coupans',$data);
        if($query)
        {
          return 1;
        }
        else{
          return 0;
        }
      }
    } 
    public function get_all_coupans()
    {
      $this->db->select('*');
      $query = $this->db->get('coupans');
      return $query->result_array();
    }
    public function check_coupan_code_exist($coupan_code)
    {
      $this->db->where('coupan_code',$coupan_code);
       $query = $this->db->get('coupans');
       return $query->row_array();
    } 
    public function delete_coupan_by_id($id)
    {
      $this->db->where('id',$id);
      $query =  $this->db->delete('coupans');
      if($query)
      {
        return 1;
      }
      else
      {
        return 0;
      }
    }
    public function get_coupans_for_edit($coupan_id)
    {
      $this->db->select('*');
      $this->db->where('id',$coupan_id);
      $query = $this->db->get('coupans');
      return $query->row_array();
    }
  }
?>