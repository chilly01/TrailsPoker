<?php

class Model_trails extends CI_Model{

    function __construct(){
        // Call the Model constructor
        parent::__construct();   
    }
    
    function make_trail(){
        $info = $this->ip(); 
        echo $info; 
        $sql = "INSERT INTO trails (info) VALUES (".$this->db->escape($info).")";
        if ($this->db->query($sql)) {
            return $this->db->insert_id();
        } 
        else  { 
            return false;             
        }
    }
    
    private function ip(){
        $ipaddress = '';
        if (isset($_SERVER['HTTP_CLIENT_IP']))
            $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
        else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
        else if(isset($_SERVER['HTTP_X_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
        else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
        else if(isset($_SERVER['HTTP_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_FORWARDED'];
        else if(isset($_SERVER['REMOTE_ADDR']))
            $ipaddress = $_SERVER['REMOTE_ADDR'];
        else
            $ipaddress = 'UNKNOWN';
        return $ipaddress ;
     }
} 