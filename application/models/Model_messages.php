<?php

class Model_messages extends CI_Model{
    
    
    function __construct()
    {
        // Call the Model constructor
        parent::__construct();        
        $this->load->database();
    }
    
    
    public function get_message() {
        $query = $this->db->query('Select message from updates order by id desc limit 1;');
        $update = $query->row(); 
        return $update->message; 
    }
    
    public function set_message($message) {
        
        $sql = "INSERT INTO updates (message) VALUES (".$this->db->escape($message).")";
        if ($this->db->query($sql)){
            return $this->db->insert_id(); 
        } else {
            return ":::: SQL ERROR ::::"; 
        }
       return false;     
    }
}

