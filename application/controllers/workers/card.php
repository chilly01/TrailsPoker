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

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

