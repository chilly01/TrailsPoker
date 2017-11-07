<?php
include_once 'card.php'; 
include_once 'hand.php'; 

class Table {
   
    public $player; // array of array of 2 cards
    public $best_hand_for_player = []; // array of hand rank and value per player
    public $winner = []; 
    private $player_count = 0; 
    
    private $community; 
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
    
    function score_hands(){
        $pv = 0; 
        foreach ($this->player as $player_hand){             
            $hand = array_merge($this->community, $player_hand);
            $name = 'player_'.$pv++; 
            $this->best_hand_for_player[$name] = new Hand($name, $hand);             
        } 
        $temp = $this->best_hand_for_player; 
        usort($temp, array('Hand', 'comp'));
        $cur_score = $temp[0]->value; 
        $cycle = 0; 
        $rank = 1; 
        foreach ($temp as $player){
            $cycle++; 
            if ($cur_score != $player->value){ 
                $rank = $cycle; 
                $cur_score = $player->value; 
            }
            $this->winner[$player->name] = $rank;            
        }
    }
}
