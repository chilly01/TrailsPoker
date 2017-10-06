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
    
    public static function is_bigger($a, $b){
        if ($a->value === $b->value){
            return ($a->suit < $b->suit); 
        }
        return ($a->value < $b->value); 
    }
    
} 

class Table {
   
    public $player; // array of array of 2 cards
    public $best_hand_for_player; // array of hand rank and value per player
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
        $known = []; 
        $temp = [];        
        $result = [
            "single"=> [],
            "pairs" => [], 
            "trips" => [],
            "quads" => []
        ]; 
       
        foreach($hand as $card){            
            if (array_key_exists($card->name, $known)){
                $cc++; 
                continue; 
            }
            $val = $card->name;
            $temp[] = $card; 
            for ($x = $cc + 1; $x < 7; $x++){
                if ($val == $hand[$x]->name){
                    $temp[] = $hand[$x]; 
                    $paired++; 
                }
            }
            $cc++;             
                $known[$card->name]=$paired; 
                switch ($paired){
                    case 1: 
                        $result['single'][] = $temp; 
                        break; 
                    case 2:
                        $result['pairs'][] = $temp;  
                        break; 
                    case 3: 
                        $result['trips'][] = $temp; 
                        break; 
                    case 4:
                        $result['quads'][] = $temp; 
                        break;
                    default:
                        break; 
                 }                             
                
            $paired = 1; 
            $temp = []; 
        }
        return $result;         
    }
    
    function sort_straights($hand){
        $has = []; 
        for($x = 0; $x < 13; $x++){
            $has[$x]=false; 
        }
        foreach($hand as $card){
            $has[$card->value] = $has[$card->value] ? $has[$card->value]  : $card; 
        }
               
        if ($has[12] && $has[11] && $has[10] && $has[9] && $has[8]) {
            return [$has[12],$has[11],$has[10],$has[9],$has[8]];
        } elseif ($has[11] && $has[10] && $has[9] && $has[8] && $has[7]) {
            return [$has[11] , $has[10] , $has[9] , $has[8] , $has[7]];        
        } elseif ($has[10] && $has[9] && $has[8] && $has[7] && $has[6]) {
            return  [$has[10] , $has[9] , $has[8] , $has[7] , $has[6]]; 
        } elseif ($has[9] && $has[8] && $has[7] && $has[6] && $has[5]) {
            return  [$has[9] , $has[8] , $has[7] , $has[6] , $has[5]]; 
        }  elseif ($has[8] && $has[7] && $has[6] && $has[5] && $has[4]) {
            return  [$has[8] , $has[7] , $has[6] , $has[5] , $has[4]]; 
        }  elseif ($has[7] && $has[6] && $has[5] && $has[4] && $has[3]) {
            return  [$has[7] , $has[6] , $has[5] , $has[4] , $has[3]]; 
        } elseif ($has[6] && $has[5] && $has[4] && $has[3] && $has[2]) {
            return  [$has[6] , $has[5] , $has[4] , $has[3] , $has[2]]; 
        } elseif ($has[5] && $has[4] && $has[3] && $has[2] && $has[1]) {
            return  [$has[5] , $has[4] , $has[3] , $has[2] , $has[1]]; 
        } elseif ($has[4] && $has[3] && $has[2] && $has[1] && $has[0]) {
            return  [$has[4] , $has[3] , $has[2] , $has[1] , $has[0]]; 
        } elseif ($has[3] && $has[2] && $has[1] && $has[0] && $has[12]) {
            return  [$has[3] , $has[2] , $has[1] , $has[0] , $has[12]]; 
        }
        return false; 
        
    }
    
    function score_hands(){
        $pv = 0; 
        foreach ($this->player as $player_hand){ 
            
            $hand = array_merge($this->community, $player_hand);
            usort($hand, array('Card', 'is_bigger')); 
            $suit_info = $this->sort_by_suits($hand); 
            $match_info = $this->sort_matches($hand); 
            $straight_info =$this->sort_straights($hand); 
            $this->best_hand_for_player['player_'.$pv++] = $this->find_best_hand($hand, $suit_info, $straight_info, $match_info);                      
        } 
    }
    
    function find_best_hand($hand, $suit_info, $straight_info, $match_info){
        $is_straight_flush = $this->detect_straight_flush($suit_info); 
        if ($is_straight_flush){
            return ['straight-flush', $is_straight_flush]; 
        }
        $is_four_of_a_kind = $this->detect_four_of_a_kind($match_info, $hand); 
        if ($is_four_of_a_kind){
            return ['four-of-a-kind', $is_four_of_a_kind];          
        }
        $is_full_house = $this->detect_full_house($match_info); 
        if ($is_full_house)
        {
            return ['full-house',$is_full_house]; // value of the triple , // value of the pair ]
        }
        $is_flush = $this->detect_flush($suit_info); 
        if ($is_flush){
            return ['flush', $is_flush]; 
        }
        if ($straight_info){
            return ['straight', $straight_info]; 
        }
        $is_trips = $this->detect_trips($match_info, $hand); 
        if ($is_trips){
            return ['trips', $is_trips]; 
        }
        $is_two_pair = $this->detect_two_pair($match_info); 
        if ($is_two_pair){
            return ['two-pair', $is_two_pair]; 
        }
        $is_pair = $this->detect_pair($match_info, $hand); 
        if ($is_pair){
            return ['pair', $is_pair]; 
        }
        
        return ['high-card', array_slice($hand,0,5)]; 
    }
    
    function detect_pair($matches, $hand){
        if (count($matches['pairs']) > 0){
            $result = $matches['pairs'][0]; 
            $value = $result[0]->value; 
            foreach ($hand as $card){
              if ($value != $card->value){
                $result[] = $card;
                if (count($result) > 4){
                    return $result;} 
                }
        }}
        return false; 
    }
    
    function detect_trips($matches, $hand){
        if (count($matches['trips']) > 0){
            $result = $matches['trips'][0];
            $value = $result[0]->value; 
            foreach ($hand as $card){
              if ($value != $card->value){
                $result[] = $card;
                if (count($result) > 4){
                    return $result;} 
                }
            
                }}
        return false; 
            
    }
    
    function detect_straight_flush($hand_by_suits){
        foreach ($hand_by_suits as $suit){
            if (count($suit)>4){
                $value = $this->sort_straights($suit);
                return $value; 
            }
        }
        return false; 
    }
    
    function detect_four_of_a_kind($matches, $hand){  
        if  (count($matches['quads']) > 0){
            $quads = $matches['quads'][0]; 
            $value = $quads[0]->value; 
                    foreach ($hand as $card){
                       if ($value != $card->value){
                           $quads[] = $card; 
                           return $quads; 
                       } 
                    }
        } 
        return false; 
    }
    
    function detect_full_house($matches){ 
        $trips = count($matches['trips']); 
        $pairs = count($matches['pairs']);
        if ($trips > 1 || ($trips > 0 && $pairs > 0)){
            $set_a = $matches['trips'][0];           
            if ($trips > 1){
                return array_merge($set_a, [$matches['trips'][1][0], $matches['trips'][1][1]]);
            }
              return array_merge($set_a, $matches['pairs'][0]);
            }
       return false; 
    }
    
    function detect_flush($hand_by_suits){
        foreach ($hand_by_suits as $suit){
            if (count($suit)>4){
                return array_slice($suit, 0, 5);  
            }
        }
        return false; 
    }
    
    function detect_two_pair($matches){ 
        
        if (count($matches['pairs']) > 1){             
            return array_merge($matches['pairs'][0], $matches['pairs'][1], $matches['single'][0]);           
        }
        return false; 
    }
    
}
   
class Hand {
    public $name; 
    public $hand;
    public $best_hand; 
    public $value; 
    public $score; 
    
    private $suit_info; 
    private $match_info; 
    private $straight_info; 
    
    function __construct($name, $array_of_cards) {
        $this->name = $name; 
        
        usort($array_of_cards, array('Card', 'is_bigger')); 
        $this->hand = $array_of_cards; 
    }
    
    function process(){
        $this->suit_info = $this->find_suits($this->hand); 
        $this->match_info = $this->find_pairs($this->hand); 
        $this->straight_info = $this->find_straight($this->hand);
        $this->score = $this->score_hand(); 
    }
    
   
    function find_suits($hand){
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
     }
     
    function find_pairs($hand){
        return $hand; 
    }
    
    function find_straight($hand){
        return $hand; 
    }
}
