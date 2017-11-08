<div>
    <h1 class="h1">Poker Page</h1>
</div>

<div class>
    <table class="table table-bordered table-striped">
        <thead>
        <th>Position</th>
        <th>Place</th>
        <th>Poker Rank</th>
        <th>Hand</th>
        <th>Best Hand</th>
    </thead><tbody>
        <?php $seat_position = 0; 
        foreach ($poker_table->player as $key => $val){
            $class = ""; 
            if ($poker_table->place[$key] === 1) {
                $class = 'class="success"'; 
            } elseif ($poker_table->place[$key] === 2){
              $class = 'class="warning"';   
            }elseif ($poker_table->place[$key] === 3){ 
                $class = 'class="danger"';
            }
            ?>
        <tr <?= $class; ?> >
            <td><?= $seat_position++; ?></td>
            <td><?= $poker_table->place[$key]; ?></td>
            <td><?= $poker_table->best_hand_for_player[$key]->hand_name; ?></td>
            <td><?= $val[0]->display() . " and " .$val[1]->display(); ?></td>
            <td><?php 
            $best_hand = ""; 
            foreach($poker_table->best_hand_for_player[$key]->best_hand as $b_card){
                $best_hand .=  $b_card->display() . " , "; 
            } ?>
            <?= chop($best_hand, ", "); ?>                 
        </tr>
      <?php } ?>
    </tbody>
    </table>
    
</div>
<br/>

<table  class="table table-bordered table-striped" style="padding: 10px">
    <thead>
        <tr>
            <th>Flop</th>
            <th>Turn</th>
            <th>River</th>
        </tr>
    </thead>
    <tbody>
        <tr class="info">
            <td><?php 
                    $flop = ""; 
                    foreach ($poker_table->flop as $card) {
                        $flop .= $card->display() . " , ";     
                    }
                echo chop($flop, ", "); ?> 
            </td>
            <td><?= $poker_table->turn->display(); ?></td>
            <td><?= $poker_table->river->display(); ?></td>
        </tr>
    </tbody>
</table>

<div class="result bold">

</div>
