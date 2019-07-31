<?php
  Class Pay_model extends CI_Model
  {


    public function insert_write_off_entry($data)
    {
      $this->db->insert('payment_collected',$data);
      return $this->db->insert_id();
    }

    public function update_status($transaction_id)
    {
      $date = date('Y-m-d');
      $this->db->where('transaction_id',$transaction_id);
      $this->db->set('paytab_status',2);
      $this->db->set('status',2);

      $this->db->set('created_at',$date);
      $query = $this->db->update('payment_collected');
      if($query)
      {
        return 1;
      }
      else
      {
        return 0;
      }
    }

    public function get_user_detail($id)
    {
      $this->db->where('id',$id);
      $query = $this->db->get('users');
      return $query->row_array();
    }

    


  }
?>