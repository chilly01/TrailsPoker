<?php

include_once "workers/table.php";
include_once "workers/pokertest.php";

class API extends CI_Controller {
    
       public function poker($player_count){
        if (is_numeric($player_count) && (1 < $player_count && $player_count < 12 )){                  
            $table = new Table($player_count); 
            echo json_encode($table); 
            } else {
                PokerTest::run(); 
            }
    }
}
