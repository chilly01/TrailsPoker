<?php
include_once 'card.php'; 

class Hand {
    public $name; 
    private $hand;
    public $hand_name; 
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
        $this->process(); 
    }
    
    function process(){
        $this->suit_info = $this->find_suits($this->hand); 
        $this->match_info = $this->find_pairs($this->hand); 
        $this->straight_info = $this->find_straight($this->hand);
        $this->score = $this->find_best_hand(); 
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
        return [$spades,$hearts,$diamonds,$clubs]; 
     }
     
    function find_pairs($hand){
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
    
    function find_straight($hand){
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
    
    function find_best_hand(){
        $is_straight_flush = $this->detect_straight_flush(); 
        if ($is_straight_flush){
            $this->best_hand = $is_straight_flush; 
            $this->hand_name = 'straight-flush'; 
            return 8; 
        }
        $is_four_of_a_kind = $this->detect_four_of_a_kind(); 
        if ($is_four_of_a_kind){
            $this->best_hand = $is_four_of_a_kind; 
            $this->hand_name = 'four-of-a-kind'; 
            return 7;      
        }
        $is_full_house = $this->detect_full_house(); 
        if ($is_full_house){
            $this->best_hand = $is_full_house; 
            $this->hand_name = 'full-house'; 
            return 6;  
        }
        $is_flush = $this->detect_flush(); 
        if ($is_flush){
             $this->best_hand = $is_flush; 
            $this->hand_name = 'flush'; 
            return 5;   
        }
        if ($this->straight_info){
            $this->value = $this->straight_info[0]->value; 
            $this->best_hand = $this->straight_info; 
            $this->hand_name = 'straight'; 
            return 4;   
        }
        $is_trips = $this->detect_trips(); 
        if ($is_trips){
            $this->best_hand = $is_trips; 
            $this->hand_name = 'triples'; 
            return 3;   
        }
        $is_two_pair = $this->detect_two_pair(); 
        if ($is_two_pair){
            $this->best_hand = $is_two_pair; 
            $this->hand_name = 'two-pair'; 
            return 2;   
        }
        $is_pair = $this->detect_pair(); 
        if ($is_pair){
            $this->best_hand = $is_pair; 
            $this->hand_name = 'pair'; 
            return 1;   
        }
        $val = []; 
        for($cnt=0; $cnt<5; $cnt++){
            $val[] = $this->hand[$cnt]->value; 
        }
        $this->value = $val; 
        $this->best_hand = array_slice($this->hand,0,5); 
        $this->hand_name = 'high-card'; 
        return 0; 
    }
    
    function detect_pair(){
        if (count($this->match_info['pairs']) > 0){
            $result = $this->match_info['pairs'][0]; 
            $value = $result[0]->value; 
            $pv[0] = $value; 
            foreach ($this->hand as $card){
              if ($value != $card->value){
                $result[] = $card;
                $pv[] = $card->value; 
                if (count($result) > 4){
                    $this->value = $pv; 
                    return $result;} 
                }
        }}
        return false; 
    }
    
    function detect_trips(){
        if (count($this->match_info['trips']) > 0){
            $result = $this->match_info['trips'][0];
            $value = $result[0]->value; 
            $hv = array($value); 
            foreach ($this->hand as $card){
              if ($value != $card->value){
                $result[] = $card;
                $hv[] = $card->value; 
                if (count($result) > 4){
                    $this->value = $hv; 
                    return $result;} 
                }            
            }                
        }
        return false;          
    }
    
    function detect_straight_flush(){
        foreach ($this->suit_info as $suit){
            if (count($suit)>4){
                $value = $this->find_straight($suit);
                $this->value = $value ? [$suit[0]->value, $suit[0]->suit] : null; 
                return $value; 
            }
        }
        return false; 
    }
    
    function detect_four_of_a_kind(){  
        if  (count($this->match_info['quads']) > 0){
            $quads = $this->match_info['quads'][0]; 
            $value = $quads[0]->value; 
                    foreach ($this->hand as $card){
                       if ($value != $card->value){
                           $quads[] = $card; 
                           $this->value = [$quads[0]->value, $card->value]; 
                           return $quads; 
                       } 
                    }
        } 
        return false; 
    }
    
    function detect_full_house(){ 
        $trips = count($this->match_info['trips']); 
        $pairs = count($this->match_info['pairs']);
        if ($trips > 1 || ($trips > 0 && $pairs > 0)){
            $set_a = $this->match_info['trips'][0];           
            if ($trips > 1){
                $this->value = [$set_a[0]->value, $this->match_info['trips'][1][0]->value]; 
                return array_merge($set_a, [$this->match_info['trips'][1][0], $this->match_info['trips'][1][1]]);
            }
            $this->value = [$set_a[0]->value, $this->match_info['pairs'][0][0]->value]; 
            return array_merge($set_a, $this->match_info['pairs'][0]);
            }
       return false; 
    }
    
    function detect_flush(){
        foreach ($this->suit_info as $suit){
            if (count($suit)>4){
                $value = []; 
                for($x=0; $x<5; $x++){
                    $value[] = $suit[$x]->value; 
                }
                $this->value = $value; 
                return array_slice($suit, 0, 5);  
            }
        }
        return false; 
    }
    
    function detect_two_pair(){ 
        
        if (count($this->match_info['pairs']) > 1){     
            
            $cardvalue1 = $this->match_info['pairs'][0][0]->value; 
            $cardvalue2 = $this->match_info['pairs'][1][0]->value; 
            
            foreach ($this->hand as $card){
                if ($card->value != $cardvalue1 && $card->value != $cardvalue2){
                    $this->value = [$cardvalue1, $cardvalue2, $card->value];
                 return array_merge($this->match_info['pairs'][0], 
                    $this->match_info['pairs'][1], 
                    [$card]);      
                }
            }
            
            
           
            
            return array_merge($this->match_info['pairs'][0], 
                    $this->match_info['pairs'][1], 
                    $this->match_info['single'][0]);           
        }
        return false; 
    }
    
    public static function comp($a,$b){
        if ($a->score != $b->score){            
            return ($a->score < $b->score); 
        }else{
            switch ($a->score){
                case 0:
                    for($x=0; $x<5; $x++){
                        if ($a->value[$x] != $b->value[$x]){
                            return ($a->value[$x] < $b->value[$x]);
                        }
                    }
                    break; 
                case 1: 
                    if ($a->value[0] != $b->value[0]){                        
                       return ($a->value[0] < $b->value[0]);
                    }else{
                        for($y=1; $y<4; $y++){
                            if ($a->value[$y] != $b->value[$y]){
                                return ($a->value[$y] < $b->value[$y]);
                            }
                        }
                    }
                    break; 
                case 2:
                    if ($a->value[0] != $b->value[0]){
                        return ($a->value[0] < $b->value[0]);
                    } 
                    if ($a->value[1] != $b->value[1]){
                        return ($a->value[1] < $b->value[1]);                        
                    } 
                    return ($a->value[2] < $b->value[2]);
                case 3: 
                    if ($a->value[0] != $b->value[0]){
                        return ($a->value[0] < $b->value[0]);                        
                    }                    
                    for($u=1; $u<3; $u++){
                            if ($a->value[$u] != $b->value[$u]){
                                return ($a->value[$u] < $b->value[$u]);
                            }
                        }
                    break;
                case 4:
                    return ($a->value < $b->value); 
                    break; 
                case 5: 
                    for($f=0; $f<5;$f++){
                       if ($a->value[$f] != $b->value[$f]){
                        return ($a->value[$f] < $b->value[$f]);
                       }
                    }
                    break;
                case 6: 
                case 7: 
                    if ($a->value[0] != $b->value[0]){
                        return ($a->value[0] < $b->value[0]);
                    } 
                    if ($a->value[1] != $b->value[1]){
                    return ($a->value[1] < $b->value[1]);
                    } 
                case 8:
                    return ($a->value[0] < $b->value[0]);
                    break;                         
                default: 
                    break; 
            }
        }
        
    }
}

