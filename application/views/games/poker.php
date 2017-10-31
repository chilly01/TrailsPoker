<div>
    <h1 class="h1">Poker Page</h1>
</div>
<div class="bold">
    <div><?php foreach ($poker_table->player as $key => $playerhand){ ?>
        <h3><?= $key . " Place: " . $poker_table->winner[$key]; ?></h3>
        <p><?= json_encode($playerhand); ?></p>
        <p><?= $poker_table->best_hand_for_player[$key]->hand_name ." :: " 
                . json_encode($poker_table->best_hand_for_player[$key]->value); ?></p>
        <p><?= json_encode($poker_table->best_hand_for_player[$key]->best_hand); ?></p> 
         <?php }?> </div>
</div>
<br/>
<h3>Flop</h3>
<p><?= json_encode($poker_table->flop); ?></p>
<br/>
<h3>Turn</h3>
<p><?= json_encode($poker_table->turn); ?></p>
<br/>
<h3>River</h3>
<p><?= json_encode($poker_table->river); ?></p>
<div class="result bold">

</div>

