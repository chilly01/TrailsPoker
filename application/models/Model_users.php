<?php

class Model_users extends CI_Model{
    
    
    function __construct()
    {
        // Call the Model constructor
        parent::__construct();        
        $this->load->database();
    }
    
    public function log_in($username, $password) {       
        
            $sql = "SELECT * FROM users WHERE user_name = ? AND password = ?"; 
            $query = $this->db->query($sql, array($username, $password));
            if ($query->num_rows() > 0){
                $this->session->user_name = $this->input->post('user_name'); 
                $this->session->active = TRUE; 
                return true; 
            }   
            echo "user not found"; 
            return false; 
    }
}


