<?php

class Model_trails extends CI_Model{

    function __construct(){
        // Call the Model constructor
        parent::__construct();   
    }
    
    function make_trail(){
        error_reporting(-1); 
        $info = $this->ip_details($this->get_ip());
        
        $customer_ip = isset($info->ip) ?  $info->ip : 'unknown_ip'; 
        $customer_city = isset($info->city) ?  $info->city : 'unknown_city'; 
        $customer_country =  isset($info->country) ?  $info->country : 'unknown_country'; 
        
        $sql = "INSERT INTO trails (info) VALUES (". $this->db->escape($customer_ip . " , " .$customer_city. " , " .$customer_country) .")";
        if ($this->db->query($sql)) {
            return $this->db->insert_id();
        } 
        else  { 
            return false;             
        }
    }
    
    function get_history(){
       $data = []; 
        
        $query = $this->db->query("SELECT id, count(info) as count, info, MAX(date) AS date FROM trails GROUP BY info ORDER BY date DESC;"); 
        if ($query->num_rows() > 0)
        {
           foreach ($query->result() as $row){
              $data[$row->info] = [$row->count, $row->date];
           }           
        }
        return $data; 
    }
    
    private function get_ip(){
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
     
    private function ip_details($ip) {
        $json = file_get_contents("http://ipinfo.io/{$ip}/geo");
        $details = json_decode($json); // HERE!!!
        return $details;
    }
} 