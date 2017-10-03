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
    
       public function poker($player_count){
        if (is_numeric($player_count)){                  
            $table = new Table($player_count); 
            echo json_encode($table); 
            } else {
                 echo "Invalid Player Count"; 
            } 
    }
}
