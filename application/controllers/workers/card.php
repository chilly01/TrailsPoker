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
    
    public function display(){
        return $this->name . " of " .$this->suit; 
    }
    
} 
