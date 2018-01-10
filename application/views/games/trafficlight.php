<?php

function run_light($tl, $times_to_run){
   $tl->change_sensor(); 
    for($i=0; $i<$times_to_run; $i++){
         $tl->UpdateController();
         echo json_encode($tl) . ","; 
    }  
}

?>

<script>
var times = 0; 
var first_30 = [<?php 
    run_light($trafficlight, 10);     
    run_light($trafficlight, 50);     
    run_light($trafficlight, 30);     
    run_light($trafficlight, 10); 
    run_light($trafficlight, 90); 
    run_light($trafficlight, 140); 
    run_light($trafficlight, 10); 
    run_light($trafficlight, 104); 
    run_light($trafficlight, 110); 
?>]; 

var timeout = setInterval(reloadLight, 1000); 

function reloadLight(){
    var val = first_30[times++];
    var html = '<h1>' + val.car_waiting + '</h1>';  
    html += '<h1 style="background-color:' + val.eastwest + ' ">' + val.time_ew + "</h1>"; 
    html += '<h1 style="background-color:' + val.north  + '">' + val.time_n + "</h1>"; 
    $(".lightoutput").html(JSON.stringify(val) + html); 
}



</script>
<div>
<h1>I was given this task to do</h1> 

<p>Write code for a controller for a stop light at a T-Intersection according to the following rules. </p>
<ul>
    <li>The straight part of the intersection runs East-West and receives the heaviest traffic and should be green most often.</li> 
    <li>The intersecting road runs North and only receives light traffic and therefore contains a single sensor to inform the light of the presence of a car. If the sensor is activated for more than 10 seconds the light for the East/Westbound commuters should turn yellow for 3 seconds, then red. 2 seconds later the light for Northbound commuters should turn green. </li>
    <li>If the sensor goes inactive for more than 5 seconds the light will then cycle back to be green for East/West bound commuters. </li>
    <li>Additionally, the Northbound light will never be green for longer than 40 seconds and the East/Westbound lights will never be green for less than 30s.</li>
    <li>Your controller will be called once per second.</li>
</ul>
    <div class="lightoutput"> 
        <p>There is stuff here... just wait for it...</p>
    </div> 
</div>