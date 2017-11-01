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
    </thead><tbody>
        <?php $position = 0; 
        foreach ($poker_table->player as $key => $val){ ?>
        <tr>
            <td><?= $position++; ?></td>
            <td><?= $poker_table->winner[$key]; ?></td>
            <td><?= $poker_table->best_hand_for_player[$key]->hand_name; ?></td>
            <td><?= json_encode($val); ?></td>
        </tr>
       <?php }?>
    </tbody>
    </table>
    
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

