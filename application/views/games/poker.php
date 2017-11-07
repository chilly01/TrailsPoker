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
        <?php $position = 0; 
        foreach ($poker_table->player as $key => $val){ ?>
        <tr <?= ($poker_table->winner[$key] == 1) ? 'class="success"' : "";  ?> >
            <td><?= $position++; ?></td>
            <td><?= $poker_table->winner[$key]; ?></td>
            <td><?= $poker_table->best_hand_for_player[$key]->hand_name; ?></td>
            <td><?= $val[0]->display() . " and " .$val[1]->display(); ?></td>
            <td><?php foreach($poker_table->best_hand_for_player[$key]->best_hand as $b_card){
                echo $b_card->display() . " , "; 
            } ?>
        </tr>
       <?php }?>
    </tbody>
    </table>
    
</div>
<br/>
<h3>Flop</h3>
<div><?php foreach ($poker_table->flop as $card) {?>
    <p><?=  $card->display(); ?></p> 
<?php } ?>
</div>
<br/>
<h3>Turn</h3>
<p><?= $poker_table->turn->display(); ?></p>
<br/>
<h3>River</h3>
<p><?= $poker_table->river->display(); ?></p>
<div class="result bold">

</div>
