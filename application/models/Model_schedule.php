<?php

class Model_events extends CI_Model{
    
    /* there should be a table called events 

     *  id (primary-int)
     * name (varchar)
     * date (date)
     * notes (varchar)
     * 
     *      */
    function __construct()
    {
        // Call the Model constructor
        parent::__construct();        
        $this->load->database();
    }
    
    public function get_schedule () 
    {
         $data = []; 
       
        return $data; 
    }
}