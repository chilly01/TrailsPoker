<?php

class Model_events extends CI_Model{
    
    
    function __construct()
    {
        // Call the Model constructor
        parent::__construct();        
        $this->load->database();
    }
    
    function get_events(){
        $data = []; 
        
        $query = $this->db->query("Select * from events;"); 
        if ($query->num_rows() > 0)
        {
           foreach ($query->result() as $row){
              $data[$row->id] = [$row->name, $row->date];
           }           
        }
        return $data; 
    }
    
       public function set_event($event) {
        
        $sql = "INSERT INTO events (name, date, notes)"
                . " VALUES (".$this->db->escape($event['name'])
                . " ,".$this->db->escape($event['date'])
                ." ," .$this->db->escape($event['notes']).")";
        
        if ($this->db->query($sql)){
            return $this->db->insert_id(); 
        }
       return false;     
    }
    
    function update_event($event, $points){
        
    }
    
}
