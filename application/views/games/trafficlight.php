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
    
    <div class="lightoutput"> 
        <p>There is stuff here... just work at it...</p>
    </div> 
</div>