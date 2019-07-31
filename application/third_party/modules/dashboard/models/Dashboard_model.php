<?php
  Class Dashboard_model extends CI_Model
  {

    public function get_dashboard_stat()
    {
      
      $query = $this->db->query("SELECT count(id) AS num_of_rows FROM users");
      $total_user_row = $query->row_array();
      $total_user = $total_user_row['num_of_rows'];
      $query = $this->db->query("SELECT count(id) AS num_of_street FROM street");
      $total_street_row = $query->row_array();
      $total_street = $total_street_row['num_of_street'];
      $query = $this->db->query("SELECT count(id) AS num_of_locality FROM locality");
      $total_locality_row = $query->row_array();
      $total_locality = $total_locality_row['num_of_locality'];
      $query = $this->db->query("SELECT count(id) AS num_of_city FROM city");
      $total_city_row = $query->row_array();
      $total_city = $total_city_row['num_of_city'];
      $query = $this->db->query("SELECT count(id) AS num_of_packages FROM packages");
      $total_packages_row = $query->row_array();
      $total_packages = $total_packages_row['num_of_packages'];
      $query = $this->db->query("SELECT count(id) AS num_of_cleaners FROM cleaners");
      $total_cleaner_row = $query->row_array();
      $total_cleaners = $total_cleaner_row['num_of_cleaners'];

      $query = $this->db->query("SELECT count(id) AS active_customer FROM users WHERE is_payment=2");
      $active_customer_row = $query->row_array();
      $active_customer = $active_customer_row['active_customer'];


      $data = array(
        'total_user' =>$total_user,
        'total_city' =>$total_city,
        'total_locality' =>$total_locality,
        'total_street' =>$total_street,
        'total_packages' =>$total_packages,
        'total_cleaners'=>$total_cleaners,
        'active_customer'=>$active_customer
      );
        return $data;
      
    }
       
  }
?>