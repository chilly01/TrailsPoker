<?php

class Model_points extends CI_Model{
    
    
    function __construct()
    {
        // Call the Model constructor
        parent::__construct();        
        $this->load->database();
    }
    
    public function edit_point_award($id, $edit_type, $new_value) {
        $sql = "Update point_awards "
                . " Set " . $edit_type . "=" . $new_value
                . " Where id=". $id;
        
        if ($this->db->query($sql)){
            return $this->db->insert_id(); 
        }
       return false;  
    }
    
    public function create_point_award($event, $player, $place, $amount) {
        
        $sql = "INSERT INTO point_awards (event_id, player_id, place, amount)"
                . " VALUES (".$this->db->escape($event)
                . " ,".$this->db->escape($player)
                . " ,".$this->db->escape($place)
                ." ," .$this->db->escape($amount).")";
        
        if ($this->db->query($sql)){
            return $this->db->insert_id(); 
        }
       return false;     
    }
    
    public function get_all_points() {
     $data = []; 
     $query = $this->db->query(
             "SELECT p.id, p.name, SUM( pa.amount ) AS total
                            FROM `players` p
                            JOIN point_awards pa ON p.id = pa.player_id
                            GROUP BY p.id
                            ORDER BY total DESC"); 
        if ($query->num_rows() > 0)
        {
           foreach ($query->result() as $row){
           $data[$row->name] = [$row->total, $row->id];
           }           
        }
        
     return $data; 
    }
    
}