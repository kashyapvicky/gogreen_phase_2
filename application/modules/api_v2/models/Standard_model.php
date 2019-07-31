<?php if(!defined('BASEPATH')) exit('No direct script access allowed');
  
Class Standard_model extends CI_Model
{
    function __construct()
    {
      parent::__construct();
      $this->load->library('memcached_library');
    }
    private $table = null;
    private $condition = null;
    private $join = null;
    private $right_join = null;
    private $left_join = null;
    private $field = null;
    private $select_as_array = null;
    private $limit = null;
    private $offset = 0;
    private $groupby = null;
    private $order_by = null;
    private $where_in = null;
    private $or_where_in = null;
    private $having = null;
    private $insert_batch = null;
    private $update_batch = null;
    private $database = null;
    private $memcached = null;
    private $like = null;

    /* This function used to set private variables which is required for DB queries*/
    public function set_query_data($data){
        if( count($data) ){
            
            $this->table = ( isset($data['table']) ) ? $data['table'] :  null;
            if($this->table == null){
                return "missing table name";
            }
            $this->condition       = ( isset($data['condition']) ) ? $data['condition'] :  null;
            $this->having       = ( isset($data['having']) ) ? $data['having'] :  null;
            $this->field           = ( isset($data['field']) ) ? $data['field'] :  null;
            $this->select_as_array = ( isset($data['select_as_array']) ) ? $data['select_as_array'] : false;
            $this->join            = ( isset($data['join']) ) ? $data['join'] :  null;
            $this->right_join      = ( isset($data['right_join']) ) ? $data['right_join'] :  null;
            $this->left_join       = ( isset($data['left_join']) ) ? $data['left_join'] :  null;
            $this->groupby         = ( isset($data['group_by'])) ? $data['group_by'] : null;
            $this->order_by        = ( isset($data['order_by'])) ? $data['order_by'] : null;
            $this->limit           = ( isset($data['limit'])) ? $data['limit'] : null;
            $this->offset          = ( isset($data['offset'])) ? $data['offset'] : null;            
            $this->where_in        = ( isset($data['where_in'])) ? $data['where_in'] : null;
            $this->or_where        = ( isset($data['or_where'])) ? $data['or_where'] : null;
            $this->or_where_in     = ( isset($data['or_where_in'])) ? $data['or_where_in'] : null;
            $this->insert_batch    = ( isset($data['insert_batch'])) ? $data['insert_batch'] : null;
            $this->update_batch    = ( isset($data['update_batch'])) ? $data['update_batch'] : null;
            $this->database        = ( isset($data['database'])) ? $this->load->database($data['database'], true) : $this->load->database('default', true);
            $this->memcached       = ( isset($data['memcached_key'])) ? $data['memcached_key'] : null;
            $this->like            = ( isset($data['like'])) ? $data['like'] : null;
        }
        else{
            return "missing parmeters";
        }
    }
    public function select(){
        if( !$this->database->table_exists( $this->table ) )
        {
            return;
        }
            
       if( $this->memcached ){

            if(!isset($this->memcached['key'])){
                die('Missing parameter Memecached Key');
            }

            $mem_cache_data = $this->memcached_library->get($this->memcached['key']);

            if($mem_cache_data){
              
                return $mem_cache_data;
            }
        }

        $this->database->select( $this->field )->from( $this->table );
        if( $this->join ){ 
        // Here check for join is set if it is join operation is performed
            foreach ( $this->join as $table_name => $join_condition ) {
                $this->database->join( $table_name , $join_condition);
            }
        }
        if( $this->right_join ){ 
        // Here check for join is set if it is join operation is performed
            foreach ( $this->right_join as $table_name => $join_condition ) {
                $this->database->join( $table_name , $join_condition, 'RIGHT');
            }
        }
        if( $this->left_join ){ 
        // Here check for join is set if it is join operation is performed
            foreach ( $this->left_join as $table_name => $join_condition ) {
                $this->database->join( $table_name , $join_condition, 'LEFT');
            }
        }
        if( $this->condition ){
            // Here check for condition if condition is set where condition is applied
            $this->database->where( $this->condition );
        }

        if($this->or_where){
            $this->database->or_where( $this->or_where );
        }

        if($this->where_in){
            //$this->database->where_in( $this->where_in );
             $this->database->where_in( $this->where_in['where_in_field'], $this->where_in['where_in_array'] );
        }

        if($this->or_where_in){
            $this->database->where_in( $this->or_where_in['or_where_in_field'], $this->or_where_in['where_in_array'] );
        }

        if($this->groupby){
            foreach ( $this->groupby as  $groupby ) {
                $this->database->group_by( $groupby );
            }
            
        }
        if( $this->having ){
          // Here applying condition with having clause
          $this->database->having( $this->having );
        }
        
        if($this->order_by){
            foreach ( $this->order_by as  $key => $value ) {
                $this->database->order_by( $key, $value );
            }
            
        }
        if( $this->limit ){
            // $this->database->limit( $this->limit, $this->offset );
            if (isset($this->offset)) {
                $this->database->limit( $this->limit, $this->offset );
            } else {
                $this->database->limit( $this->limit );
            }
        }
        if($this->like){
            $this->database->like($this->like);
        }
        $result = $this->database->get();


        /*Here check for num rows returned by query if num rows <=1 then row() is returned otherwise result is returned*/
        if( $result->num_rows <= 1 )
        {
            $row = $result->row();

            // If memcached parameter is set then create memcached for result
            if( $this->memcached )
                $this->create_memecached( $row );

            return $row;
        } else {
            $query_result = null;
            if ($this->select_as_array) {
                $query_result = $result->result_array();
                //return $query_result;
            } else {
                $query_result = $result->result();
                //return $result->result();
            }

            // If memcached parameter is set then create memcached for result
            if( $this->memcached ) 
                $this->create_memecached( $query_result );

            return $query_result;
        }
    }
    public function insert( $data = '' ){
        if( $this->insert_batch )
            return $this->database->insert_batch( $this->table , $data); 
        else
            return $this->database->insert( $this->table , $data );
    }

    public function insert_and_id( $data = '' ){
        $status =  $this->database->insert( $this->table , $data );
            if( $status )
                $last_id = $this->database->insert_id();
        return $last_id;
    } 

    public function delete(){
        return $this->database->delete( $this->table , $this->condition );
    }
    public function update( $data ){
        if( $this->update_batch ){
             $this->database->trans_start();
             $this->database->update_batch($this->table , $data, $this->condition ); 
             $this->database->trans_complete();    
             return $this->database->trans_status() ;
        }else{

            $this->database->where( $this->condition );
            return $this->database->update( $this->table, $data );
        }
    }

    public function create_memecached($data){
       
        if( !isset($this->memcached['key'] ) )
            die('Missing memecached key');
        else if( !isset($this->memcached['key'] ) )
            die('Missing memecached expiration time');

        $this->memcached_library->add($this->memcached['key'] , $data, $this->memcached['time']);
    }
}
?>