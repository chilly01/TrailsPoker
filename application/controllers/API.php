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
            if ($paired > 1){
                $known[$card->name]=$paired; 
                switch ($paired){
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
            $this->best_hand_for_player[$pv] = $this->find_best_hand($hand, $suit_info, $straight_info, $match_info);                      
        } 
    }
    
    function find_best_hand($hand, $suit_info, $straight_info, $match_info){
        $is_straight_flush = $this->detect_straight_flush($suit_info); 
        if ($is_straight_flush){
            return ['straight-flush', $is_straight_flush]; 
        }
        $is_four_of_a_kind = $this->detect_four_of_a_kind($match_info); 
        if ($is_four_of_a_kind){
            return ['four-of-a-kind', $match_info['quads']];          
        }
        $is_full_house = $this->detect_full_house($match_info); 
        if ($is_full_house)
        {
            return ['full-house',$is_full_house]; // value of the triple , // value of the pair ]
        }
        
        
        
        return ['not done', $hand]; 
    }
    
    function detect_straight_flush($hand_by_suits){
        $suit_counter = 0; 
        foreach ($hand_by_suits as $suit){
            if (count($suit)>4){
                $value = $this->sort_straights($suit);
                return $value; 
            }
            $suit_counter++; 
        }
        return false; 
    }
    
    function detect_four_of_a_kind($matches){  
        return (count($matches['quads']) > 0); 
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
        if (is_numeric($player_count) && (1 < $player_count && $player_count < 12 )){                  
            $table = new Table($player_count); 
            echo json_encode($table); 
            } else {
                 echo "Invalid Player Count <br/><br/>"; 
                 
                 $table = new Table(2); 
                  
                 // cards for testing 
                $ace_of_diamonds = new Card('Ace', 'diamonds' , 12); 
                $king_of_diamonds = new Card('King', 'diamonds' , 11); 
                $queen_of_diamonds = new Card('Queen', 'diamonds' , 10); 
                $jack_of_diamonds = new Card('Jack', 'diamonds' , 9); 
                $ten_of_diamonds = new Card('Ten', 'diamonds' , 8); 
                $nine_of_diamonds = new Card('Nine', 'diamonds' , 7); 
                $eight_of_diamonds = new Card('Eight', 'diamonds' , 6); 
                
                $ace_of_spades = new Card('Ace', 'spades' , 12); 
                $king_of_spades = new Card('King', 'spades' , 11); 
                $queen_of_spades = new Card('Queen', 'spades' , 10); 
                
                $ace_of_hearts = new Card('Ace', 'hearts' , 12);            
                $king_of_hearts = new Card('King', 'hearts' , 11); 
                
                $ace_of_clubs = new Card('Ace', 'clubs' , 12); 
                $two_of_clubs = new Card('Two', 'clubs' , 12); 
                
                 
                $straight_flush = [$ace_of_diamonds, $king_of_diamonds, $queen_of_diamonds, 
                     $jack_of_diamonds, $ten_of_diamonds, $nine_of_diamonds, $two_of_clubs]; 
                
                $four_of_a_kind = [$ace_of_clubs, $ace_of_diamonds, $ace_of_hearts, 
                     $ace_of_spades, $eight_of_diamonds, $king_of_diamonds, $king_of_hearts]; 
                
                $full_house_a = [$ace_of_clubs, $ace_of_diamonds, $ace_of_hearts, 
                    $king_of_hearts, $king_of_diamonds, $king_of_spades, $two_of_clubs]; 
                
                $full_house_b = [$ace_of_clubs, $ace_of_diamonds, $ace_of_hearts, 
                    $king_of_hearts, $king_of_diamonds, $queen_of_spades, $queen_of_diamonds]; 
                
                $full_house_c = [$ace_of_clubs, $ace_of_diamonds, $ace_of_hearts, 
                    $king_of_hearts, $king_of_diamonds, $jack_of_diamonds, $two_of_clubs]; 
                
                $test_hands = [$straight_flush, $four_of_a_kind, $full_house_a, $full_house_b, $full_house_c]; 
                 
                foreach ($test_hands as $hand){
                    usort($hand, array('Card', 'is_bigger'));
                    $suit_info1 = $table->sort_by_suits($hand); 
                    $straight_info1 = $table->sort_straights($hand);  
                    $match_info1 = $table->sort_matches($hand); 
                    echo  "<p>". json_encode($table->find_best_hand($hand, $suit_info1, $straight_info1, $match_info1)). "</p>"; 
                }
            } 
    }
}
