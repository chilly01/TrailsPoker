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
    
    function is_bigger($card){
        if ($card->value === $this->value){
            return ($this->suit > $card->suit); 
        }
        return ($this->value > $card->value); 
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
            $this->best_hand_for_player[$pv] = $this->find_best_hand($hand, $suit_info, $straight_info, $match_info); 
            
            echo "<div> Player" . $pv ." --- <p>straight_info: ". json_encode($straight_info) . "</p><br/>"; 
            echo "Suit Info: <br/>"; 
            foreach ($suit_info as $sinfo){
                echo json_encode($sinfo) . " <br/>"; 
            }
            echo "<p> Match Info: ". json_encode($match_info) . "</p> Player" . $pv++ ."---  <br/></div><br/>";
        } 
    }
    
    function find_best_hand($hand, $suit_info, $straight_info, $match_info){
        $is_straight_flush = $this->detect_straight_flush($suit_info); 
        if ($is_straight_flush[0]){
            return ['straight-flush', $is_straight_flush[1], $is_straight_flush['suit']]; 
        }
        $is_four_of_a_kind = $this->detect_four_of_a_kind($match_info); 
        if ($is_four_of_a_kind){
            foreach($match_info as $key=>$value){
                if ($value > 3){
                    return ['four-of-a-kind', $key]; 
                }
            }
        
        }
        $is_full_house = $this->detect_full_house($match_info); 
        if ($is_full_house)
        {
            return ['full-house',$is_full_house]; // value of the triple , // value of the pair ]
        }
        
        
        
        return 'not done'; 
    }
    
    
    
    
    
    function detect_straight_flush($hand_by_suits){
        $suit_counter = 0; 
        foreach ($hand_by_suits as $suit){
            if (count($suit)>4){
                $value = $this->sort_straights($suit);
                $value['suit'] = $this->suits[$suit_counter];
                return $value; 
            }
            $suit_counter++; 
        }
        return [false]; 
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
        if (is_numeric($player_count) && (1 < $player_count && $player_count < 12 )){                  
            $table = new Table($player_count); 
            echo json_encode($table); 
            } else {
                 echo "Invalid Player Count <br/><br/>"; 
                 
                 $table = new Table(2); 
                 echo "<p>". json_encode($table) . "<p/>"; 
                  
                 
                 $hand = [new Card('Ten', 'spades' , 8), 
                     new Card('Ten', 'diamonds' , 8), 
                     new Card('Queen', 'diamonds' , 10), 
                     new Card('Ace', 'clubs' , 12), 
                     new Card( 'Ace', 'spades' , 12), 
                     new Card('Eight', 'diamonds' , 6), 
                     new Card('Ace', 'hearts' , 12) ]; 
                $suit_info = $table->sort_by_suits($hand); 
                $straight_info = $table->sort_straights($hand);  
                $match_info = $table->sort_matches($hand);                  
                 
                 echo json_encode($table->find_best_hand($hand, $suit_info, $straight_info, $match_info)); 
            } 
    }
}
