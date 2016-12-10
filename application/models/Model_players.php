<?php

class Model_players extends CI_Model{
    
    
    function __construct()
    {
        // Call the Model constructor
        parent::__construct();        
        $this->load->database();
    }
    
    function get_players(){
        $players = [];  
        $query = $this->db->query("select id, name from players;");

        if ($query->num_rows() > 0)
        {
           foreach ($query->result() as $row)
           {
              $players[$row->id] = $row->name;
           }
           asort($players);
        }
        return $players; 
    }
    
       public function create_player($name) {
        $sql = "INSERT INTO players (name)"
                . " VALUES (".$this->db->escape(trim($name)).")";
        
        if ($this->db->query($sql)){
            return $this->db->insert_id(); 
        }
       return false;     
    }
    
    public function get_player($param = 0) {
        $sql = "select p.name as player_name, "
                . "e.name as event_name, e.date, pa.* "
                . "from point_awards pa "
                . "join events e on pa.event_id = e.id "
                . "join players p on p.id = pa.player_id "
                . "where pa.player_id = '". $param ." order by e.name asc';";
        
        $query = $this->db->query($sql); 
        
        if ($query->num_rows() > 0)
        {
            $data = []; 
           foreach ($query->result() as $row)
           {
             $data[] =  $row; 
           }
         
        return $data;
        } 
        return false;
    }
      
}