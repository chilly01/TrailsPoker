<?php

class Card {
    public $name = ''; 
    public $suit = ''; 
    public $value = ''; 
    
    function __construct($name,$suit,$value) {
        $this->name = $name;
        $this->suit = $suit;
        $this->value = $value;
    }
}

class Table {
   
    public $player; // array of array of 2 cards
    public $player_count = 0; 
    
    public $community; 
    public $flop; 
    public $turn; 
    public $river; 
    
    private $deck = [];
    private $names = ["Two", "Three", "Four", "Five",
                      "Six", "Seven", "Eight", "Nine", 
                       "Ten", "Jack", "Queen", "King", "Ace"]; 
    
    private $suits = ["spades", "hearts", "diamonds", "clubs"]; 
    private $val = 0; 
    
    function __construct($number_of_players) {
        $this->player_count = $number_of_players;
        $this->create_shuffled_deck(); 
        $this->deal_hands(); 
        $this->deal_community_cards(); 
        $this->score_hands(); 
    }
    
    function create_shuffled_deck(){
        $this->deck  = array();  
        $value = 0; 
            for ($s=0; $s < 4; $s++){
                for ($v=0; $v < 13; $v++){
                    $this->deck[$value] = new Card($this->names[$v], $this->suits[$s], $v);                    
                    $value++; 
                }
            }
            $shuffle = shuffle($this->deck);
            return $shuffle;
    }
    
    function deal_hands(){        
         for ($cards_in_hand = 0; $cards_in_hand < 2; $cards_in_hand++){
                for($x = 0; $x < $this->player_count; $x++){
                    $name = "player_" .$x ; 
                    $this->player[$name][$cards_in_hand] = $this->deck[$this->val];
                    $this->val++; 
                }}
        
    }
    
    function deal_community_cards(){
        $this->flop = [$this->deck[$this->val],$this->deck[$this->val+1],$this->deck[$this->val+2]]; 
        $this->turn = $this->deck[$this->val+4]; 
        $this->river = $this->deck[$this->val+6];
        $this->community = array_merge($this->flop, [$this->turn, $this->river]); 
    }
    
    function sort_by_suits($hand){
        $spades = []; 
        $hearts = []; 
        $diamonds = []; 
        $clubs = []; 
        
        foreach ($hand as $card){
            switch ($card->suit){
                case "spades":
                    $spades[]=$card;
                    break; 
                case "hearts":
                    $hearts[]=$card;
                    break;  
                case "diamonds":
                    $diamonds[]=$card;
                    break;  
                case "clubs":
                    $clubs[]=$card;
                    break;  
            }
        }
        
        return [$spades, $hearts, $diamonds, $clubs]; 
    }
    
    function sort_matches($hand){
        $paired = 1; 
        $cc = 0; 
        $known = array(); 
       
        foreach($hand as $card){            
            if (array_key_exists($card->name, $known)){
                $cc++; 
                continue; 
            }
            $val = $card->name;
            for ($x = $cc + 1; $x < 7; $x++){
                if ($val == $hand[$x]->name){
                    $paired++; 
                }
            }
            $cc++;             
            if ($paired > 1){
            $known[$card->name]=$paired; 
            }
            $paired = 1; 
        }
        
        return $known;         
    }
    
    function sort_straights($hand){
        $has = []; 
        for($x = 0; $x < 13; $x++){
            $has[$x]=false; 
        }
        foreach($hand as $card){
            $has[$card->value] = true; 
        }   
        
          if ($has[8] && $has[9] && $has[10] && $has[11] && $has[12]) {
            return [true, "Ace"];
        } elseif ($has[7] && $has[8] && $has[9] && $has[10] && $has[11]) {
            return [true, "King"];        
        } elseif ($has[6] && $has[7] && $has[8] && $has[9] && $has[10]) {
            return [true, "Queen"]; 
        } elseif ($has[5] && $has[6] && $has[7] && $has[8] && $has[9]) {
            return [true, "Jack"]; 
        }  elseif ($has[4] && $has[5] && $has[6] && $has[7] && $has[8]) {
            return [true, "Ten"]; 
        }  elseif ($has[3] && $has[4] && $has[5] && $has[6] && $has[7]) {
            return [true, "Nine"]; 
        } elseif ($has[2] && $has[3] && $has[4] && $has[5] && $has[6]) {
            return [true, "Eight"]; 
        } elseif ($has[1] && $has[2] && $has[3] && $has[4] && $has[5]) {
            return [true, "Seven"]; 
        } elseif ($has[0] && $has[1] && $has[2] && $has[3] && $has[4]) {
            return [true, "Six"]; 
        } elseif ($has[12] && $has[0] && $has[1] && $has[2] && $has[3]) {
            return [true, "Five"]; 
        }
        return [false, "None"]; 
        
    }
    
    function score_hands(){
        $pv = 0; 
        foreach ($this->player as $player_hand){ 
            $hand = array_merge($this->community, $player_hand); 
            $suit_info = $this->sort_by_suits($hand); 
            $match_info = $this->sort_matches($hand); 
            $straight_info =$this->sort_straights($hand); 
            $sf = $this->detect_straight_flush($suit_info); 
            
            
            echo json_encode($straight_info) . " <br/><br/><br/>" . json_encode($sf) . " <br/><br/><br/>" . json_encode($match_info) . " --- Player" . $pv++ ."--- <br/> <br/>";
        } 
    }
    
    function detect_straight_flush($hand_by_suits){
        foreach ($hand_by_suits as $suit){
            if (count($suit)>4){
                return $this->sort_straights($suit); 
            }
        }
        return false; 
    }
    
    function detect_four_of_a_kind($matches){        
        return in_array(4,$matches); 
    }
    
    function detect_full_house($matches){
       $has_3 = in_array(3,$matches); 
       $has_2 = in_array(2,$matches); 
       return ($has_3 && $has_2); 
    }
    
    function detect_flush($hand_by_suits){
        foreach ($hand_by_suits as $suit){
            if (count($suit)>4){
                return true;  
            }
        }
        return false; 
    }
    
    function detect_two_pair($matches){    
        return false; 
    }
    
}
   


class API extends CI_Controller {
    
    private $names = ["Two", "Three", "Four", "Five",
                      "Six", "Seven", "Eight", "Nine", 
                       "Ten", "Jack", "Queen", "King", "Ace"]; 
    
    private $suits = ["s", "h", "d", "c"]; 
    
   
    public function poker($player_count){
        if (is_numeric($player_count)){
            $deck = $this->create_deck(); 
           
            $player = array(); 
            $val = 0; 
            for ($cards_in_hand = 0; $cards_in_hand < 2; $cards_in_hand++){
                for($x = 0; $x < $player_count; $x++){
                    $player[$x][$cards_in_hand] = $deck[$val];
                    $val++; 
                }}
                
        $val++; // burn 1 card
        $community = [$deck[$val],$deck[$val+1],$deck[$val+2],$deck[$val+4],$deck[$val+6]]; // card 3,5 burned 
                
        foreach ($player as $player_hand){ 
            $hand = array_merge($community, $player_hand); 
            $is_flush = $this->check_flush($hand);
            $is_pair = $this->check_straight($hand); 
            $match = $this->check_pair($hand); 
            echo "<br/>" . json_encode($is_flush) ."<br/>" . json_encode($is_pair) . "<br/>". json_encode($match) . "<br/><br/>"; 
        
        }
        
        
        $table = new Table($player_count); 
        echo "<br/><br/>" . json_encode($table); 

            } else {
                echo "Invalid Player Count"; 
            } 
    }
    
    private function create_deck(){
        $deck = array();  
        $value = 0; 
            for ($s=0; $s < 4; $s++){
                for ($v=0; $v < 13; $v++){
                    $deck[$value] = [$this->names[$v], $v, $this->suits[$s]];
                    $value++; 
                }
            }
        shuffle($deck);
        return $deck; 
        
    }
    
    private function check_flush($hand){
        $sc = $sm = $hc = $hm = $dc = $dm = $cc = $cm =0;  
         
        foreach($hand as $card){
            switch($card[2]){
                case "s":
                    $sc++; 
                    $sm = ($card[1] > $sm) ? $card[1] : $sm; 
                    break; 
                case "h": 
                    $hc++; 
                    $hm = ($card[1] > $hm) ? $card[1] : $hm; 
                    break; 
                case "d": 
                    $dc++; 
                    $dm = ($card[1] > $dm) ? $card[1] : $dm; 
                    break; 
                case "c": 
                    $cc++; 
                    $cm = ($card[1] > $cm) ? $card[1] : $cm; 
                    break;
            }
        }            
        if ($sc >= 5) {return [true, "spades", $sm];}
        if ($hc >= 5) {return [true, "hearts", $sm];}
        if ($dc >= 5) {return [true, "diamonds", $sm];}
        if ($cc >= 5) {return [true, "clubs", $sm];}        
        return false; 
        
    }
    
    private function check_pair($hand){
        $paired = 1; 
        $cc = 0; 
        $known = array(); 
       
        foreach($hand as $card){            
            if (array_key_exists($card[0], $known)){
                $cc++; 
                continue; 
            }
            $val = $card[0];
            for ($x = $cc + 1; $x < 7; $x++){
                if ($val == $hand[$x][0]){
                    $paired++; 
                }
            }
            $cc++;             
            if ($paired > 1){
            $known[$card[0]]=$paired; 
            }
            $paired = 1; 
        }
        
        return $known; 
    }
    
    
    private function check_straight($hand){
        $list = [];
        foreach($hand as $card){
            $list[$card[0]]=$card[1]; 
        } 
        $has_2 = in_array(0,$list); 
        $has_3 = in_array(1,$list); 
        $has_4 = in_array(2,$list); 
        $has_5 = in_array(3,$list); 
        $has_6 = in_array(4,$list); 
        $has_7 = in_array(5,$list); 
        $has_8 = in_array(6,$list);        
        $has_9 = in_array(7,$list); 
        $has_t = in_array(8,$list); 
        $has_j = in_array(9,$list); 
        $has_q = in_array(10,$list); 
        $has_k = in_array(11,$list);        
        $has_a = in_array(12,$list); 
        
              
        if ($has_t && $has_j && $has_q && $has_k && $has_a) {
            return [true, "Ace"];
        } elseif ($has_9 && $has_t && $has_j && $has_q && $has_k) {
            return [true, "King"];        
        } elseif ($has_8 && $has_9 && $has_t && $has_j && $has_q) {
            return [true, "Queen"]; 
        } elseif ($has_7 && $has_8 && $has_9 && $has_t && $has_j) {
            return [true, "Jack"]; 
        }  elseif ($has_6 && $has_7 && $has_8 && $has_9 && $has_t) {
            return [true, "Ten"]; 
        }  elseif ($has_5 && $has_6 && $has_7 && $has_8 && $has_9) {
            return [true, "Nine"]; 
        } elseif ($has_4 && $has_5 && $has_6 && $has_7 && $has_8) {
            return [true, "Eight"]; 
        } elseif ($has_3 && $has_4 && $has_5 && $has_6 && $has_7) {
            return [true, "Seven"]; 
        } elseif ($has_2 && $has_3 && $has_4 && $has_5 && $has_6) {
            return [true, "Six"]; 
        } elseif ($has_a && $has_2 && $has_3 && $has_4 && $has_5) {
            return [true, "Five"]; 
        }
        
        return [false, 'None']; 
    }
    
    
}
