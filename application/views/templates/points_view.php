<div id="points_div" style="margin: auto;">
    <style>
        .ptc{
            border: 1px solid white; 
            color: white; 
            background-color: black; 
        }
        #point_table{
            margin: 0px auto; 
        }
    </style>
<table id="point_table" class="table table-condensed table-bordered ptc">
    <tr class="ptc"><th>Name</th><th>Points</th></tr>

<?php
$count=1; 
foreach ($points as $key =>$value){     
	if ($key != 'NO PLAYER'){   
	?>
    <tr class="ptc"><td class="ptc">
            <a href="<?= site_url('pages/player/'.$value[1]); ?>">
                <?= '#'.$count++.' '.$key; ?></a>
        </td><td class="ptc"> <?= $value[0]; ?></td></tr>       
        <?php } } ?>
</table>
</div>
