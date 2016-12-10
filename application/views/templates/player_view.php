<div id="points_div" style="margin: auto;">
    <h1><?= $player_info[0]->player_name; ?></h1>
<table id="point_table" class="table table-condensed table-bordered ptc">
    <tr class="ptc"><th>Event Name</th><th>Date</th><th>Place</th><th>Points</th></tr>
<?php foreach ($player_info as  $value) { ?>
    <tr>
        <td><?= $value->event_name; ?></td>
        <td><?= $value->date; ?></td>
        <td><?= $value->place; ?></td>
        <td><?= $value->amount; ?></td>
    </tr>
<?php } ?>

</table>
</div>