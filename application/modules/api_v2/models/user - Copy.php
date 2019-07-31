<?php if(!defined('BASEPATH')) exit('No direct script access allowed');
  
Class User extends CI_Model
{  
  public function getRowData($where = array(), $columns = array(),$table=array(),$flag) {
   //echo "<pre>"; print_r($flag);die;
    if($flag=='r_detail'){
     $query = $this->db->select($columns)->from($table)->where($where)->get();     
   /*echo  $this->db->last_query();die;*/
    }
    elseif($flag == 'user'){
      $query = $this->db->select($columns)->from($table)->where($where)->get();
    }
  //echo  $this->db->last_query();die;
  $res =  $query->row();
   return $res;
  }

  function insert($table,$column=array()){
  
     $query = $this->db->insert($table,$column);
     //echo  $this->db->last_query();die;
    return $this->db->insert_id();
      
  }
  function update($where=array(),$column=array(),$table){
     $this->db->where($where)->update($table,$column);     
     //echo  $this->db->last_query();die;
  }

  function locationRestaurant($table=Null,$column= array(),$flag=Null,$page=Null){
    if($flag == 'l_r'){
     $lat = $column['lat'];
     $lang = $column['lang'];
    //echo $lat;die();
   $query = $this->db->query("SELECT id,resturant_name,image,resturant_adds,resturant_type, ( 6371 * acos( cos( radians($lat) ) * cos( radians(lat) ) * 
   cos( radians( lang ) - radians($lang) ) + sin( radians($lat) ) * 
   sin( radians(lat) ) ) ) AS distance FROM $table HAVING
   distance < 5 ORDER BY distance"); 
    }
    elseif($flag == 'offer'){
      $date =  date("Y-m-d");    
      $sql = "SELECT image FROM $table 
      WHERE valid_upto >= $date order by valid_upto desc LIMIT 4";
      $query = $this->db->query($sql);
      //echo  $this->db->last_query();die; 
    }

    elseif($flag == 'join'){
      $limit = 10*$page;  
      $lat = $column['lat'];
      $lang = $column['lang'];
      $query =  $this->db->query("SELECT r.id,r.resturant_name,r.image,r.resturant_adds,r.resturant_type,s.state_name, ( 6371 * acos( cos( radians($lat) ) * cos( radians(lat) ) * 
   cos( radians( lang ) - radians($lang) ) + sin( radians($lat) ) * 
   sin( radians(lat) ) ) ) AS distance FROM $table as r left join hw_state as s on s.id = r.state_id HAVING
   distance < 5 ORDER BY distance LIMIT $limit,10"); 
    } 
   elseif($flag == 'f_r'){
     $lat = $column['lat'];
     $lang = $column['lang'];
    //echo $lat;die();
     $query = $this->db->query("SELECT id,resturant_name,image,resturant_adds,resturant_type, ( 6371 * acos( cos( radians($lat) ) * cos( radians(lat) ) * 
   cos( radians( lang ) - radians($lang) ) + sin( radians($lat) ) * 
   sin( radians(lat) ) ) ) AS distance FROM $table HAVING
   distance < 100 ORDER BY distance"); 
    }
   return $query->result_array();

   }
   function getArrayData($where = array(),$columns = array(),$table = array(),$flag,$resturant_id=NULL)
   {
      if($flag == 'timing')
      {
       $query = $this->db->select($columns)->from($table)->where($where)->get();
      }
      elseif($flag == 'multiJoin')
      {
        $sql = "SELECT rm.item_name,rm.item_type, rm.id, cu.cusine as cusinename,cu.id as cu_id, rmi.id as resturant_menue_item_id,rmi.varient_menue,rmi.price 
        from resturant_menue as rm 
        LEFT JOIN cusine as cu ON cu.id = rm.cusine_id 
        LEFT JOIN resturant_menue_item as rmi ON rmi.resturant_menue_id = rm.id 
        where rm.resturant_id = $resturant_id";

        //  "select r_c.cusine_id as r_c_cusineId,cus.cusine,r_m_i.id as rmi_id,r_m_i.varient_menue as varient_menue ,r_m_i.price,r_m.item_name  from resturant_cusine as r_c 
        // left join cusine as cus on cus.id = r_c.cusine_id  
        // left join resturant_menue_item as r_m_i on r_m_i.resturant_id= r_c.resturant_id
        // left join resturant_menue as r_m on r_m.cusine_id = cus.id 
        // where cus.is_deleted = 1 AND r_c.resturant_id=13
        // group by r_m.item_name ";

       

        $query = $this->db->query($sql);
     /* echo  $this->db->last_query();die;*/
      }
     return $res = $query->result_array();
    }  
}