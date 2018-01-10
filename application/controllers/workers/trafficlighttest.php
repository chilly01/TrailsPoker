<?php
include_once 'trafficlight.php'; 

$tl = new VoidTrafficLight(); 
for($i=0; $i<40; $i++){
    echo "$i) " . $tl->UpdateController();
}
$tl->change_sensor(); 
for($i=0; $i<60; $i++){
    echo "$i) " . $tl->UpdateController();
}
 $tl->change_sensor(); 
 for($i=0; $i<24; $i++){
    echo "$i) " . $tl->UpdateController();
}
 $tl->change_sensor(); 
 for($i=0; $i<17; $i++){
    echo "$i) " . $tl->UpdateController();
}
 $tl->change_sensor(); 
 for($i=0; $i<34; $i++){
    echo "$i) " . $tl->UpdateController();
}
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

