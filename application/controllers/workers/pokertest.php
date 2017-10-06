<?php
include_once 'table.php'; 

class PokerTest {
    
    public static function run(){
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
                $four_of_spades = new Card('Four', 'spades', 2); 
                $three_of_spades = new Card('Three', 'spades', 1); 
                $two_of_spades = new Card('Two', 'spades', 0); 
                
                $ace_of_hearts = new Card('Ace', 'hearts' , 12);            
                $king_of_hearts = new Card('King', 'hearts' , 11); 
                $five_of_hearts = new Card('Five', 'hearts' , 3); 
                $six_of_hearts = new Card('Six', 'hearts' , 4);
                
                $ace_of_clubs = new Card('Ace', 'clubs' , 12); 
                $two_of_clubs = new Card('Two', 'clubs' , 0); 
                
                 
                $straight_flush = [$ace_of_diamonds, $king_of_diamonds, $queen_of_diamonds, 
                     $jack_of_diamonds, $ten_of_diamonds, $nine_of_diamonds, $two_of_clubs]; 
                
                $four_of_a_kind = [$ace_of_clubs, $ace_of_diamonds, $ace_of_hearts, 
                     $ace_of_spades, $eight_of_diamonds, $king_of_diamonds, $king_of_hearts]; 
                
                $full_house_a = [$ace_of_clubs, $ace_of_diamonds, $ace_of_hearts, 
                    $king_of_hearts, $king_of_diamonds, $king_of_spades, $two_of_clubs]; 
                
                $full_house_b = [$ace_of_clubs, $ace_of_diamonds, $ace_of_hearts, 
                    $king_of_hearts, $king_of_diamonds, $queen_of_spades, $queen_of_diamonds]; 
                
                $full_house_c = [$ace_of_clubs, $ace_of_diamonds, $ace_of_hearts, 
                    $king_of_hearts, $king_of_diamonds, $jack_of_diamonds, $four_of_spades]; 
                
                $flush = [$ace_of_diamonds, $king_of_diamonds, $jack_of_diamonds, 
                    $two_of_clubs, $nine_of_diamonds,  $six_of_hearts, $ten_of_diamonds]; 
                
                $flusha = [$ace_of_spades, $king_of_spades, $queen_of_spades, 
                    $two_of_spades, $three_of_spades,  $eight_of_diamonds, $ten_of_diamonds]; 
                
                $straight_a = [$ace_of_clubs, $two_of_spades, $three_of_spades, 
                    $four_of_spades, $five_of_hearts, $eight_of_diamonds, $king_of_hearts]; 
                
                $straight_b = [$eight_of_diamonds, $nine_of_diamonds, $ten_of_diamonds, 
                    $jack_of_diamonds, $queen_of_spades, $king_of_hearts, $ace_of_clubs];  
                
                $trips = [$ace_of_clubs, $ten_of_diamonds, $ace_of_hearts, 
                    $six_of_hearts, $jack_of_diamonds, $ace_of_spades, $five_of_hearts]; 
                
                $two_pair_a = [$six_of_hearts, $ace_of_diamonds, $two_of_clubs, $queen_of_diamonds, 
                    $ace_of_spades, $king_of_hearts, $king_of_diamonds]; 
                
                $pair = [$eight_of_diamonds, $three_of_spades, $ten_of_diamonds, $two_of_clubs, 
                    $ace_of_hearts, $two_of_spades, $king_of_hearts];
                
                $high_card = [$eight_of_diamonds, $jack_of_diamonds, $three_of_spades, $four_of_spades,
                        $king_of_hearts, $ten_of_diamonds, $two_of_spades]; 
                
                
                $test_hands = [$straight_flush, $four_of_a_kind, $full_house_a,
                    $full_house_b, $full_house_c, $flush, $flusha, $straight_a, 
                    $straight_b, $trips, $two_pair_a, $pair, $high_card ]; 
                 
                foreach ($test_hands as $hand){
                    usort($hand, array('Card', 'is_bigger'));
                    $suit_info1 = $table->sort_by_suits($hand); 
                    $straight_info1 = $table->sort_straights($hand);  
                    $match_info1 = $table->sort_matches($hand); 
                    echo  "<p>". json_encode($table->find_best_hand($hand, $suit_info1, $straight_info1, $match_info1)). "</p>"; 
                }
           
    }
}
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

