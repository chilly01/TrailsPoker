<h1>Create New Event</h1>

<?= form_open('Pages/create_new_event'); ?>
<div id="event_div">
 <p>
    <label>Event Name:</label><?= form_input('Event_name', 'Event Name'); ?></p><p>
    <label>Event Date:</label><?= form_input('Event_date', 'Event Date'); ?></p><p>    
    <label>Event Notes:</label><?= form_textarea('Event_notes', 'Event Notes'); ?></p>
</div>
<div id="first_place" class="container">
<p><label>First:</label><?= form_dropdown('players_1', $players, 0); ?> &nbsp;
        <?= form_input('name_1', " "); ?></p>
<p><label>Second:</label><?= form_dropdown('players_2', $players, 0); ?> &nbsp;
        <?= form_input('name_2', " "); ?></p>  
<p><label>Third:</label><?= form_dropdown('players_3', $players, 0); ?> &nbsp;
        <?= form_input('name_3', " "); ?></p>
<p><label>Fourth:</label><?= form_dropdown('players_4', $players, 0); ?> &nbsp;
        <?= form_input('name_4', " "); ?></p>
<p><label>Fifth:</label><?= form_dropdown('players_5', $players, 0); ?> &nbsp;
        <?= form_input('name_5', " "); ?></p>
<p><label>Sixth:</label><?= form_dropdown('players_6', $players, 0); ?> &nbsp;
        <?= form_input('name_6', " "); ?></p>
<p><label>Seventh:</label><?= form_dropdown('players_7', $players, 0); ?> &nbsp;
        <?= form_input('name_7', " "); ?></p>
<p><label>Eighth:</label><?= form_dropdown('players_8', $players, 0); ?> &nbsp;
        <?= form_input('name_8', " "); ?></p>
<p><label>Ninth:</label><?= form_dropdown('players_9', $players, 0); ?> &nbsp;
        <?= form_input('name_9', " "); ?></p>
<p><label>Tenth:</label><?= form_dropdown('players_10', $players, 0); ?> &nbsp;
        <?= form_input('name_10', " "); ?></p>
    
</div>

<div id="sides">

<p><?= form_checkbox('side_1', 'active', FALSE); ?>
    <label>Side 1:</label><?= form_dropdown('players_s1', $players, 0); ?> &nbsp;
        <?= form_input('name_s1', " "); ?></p>
<p><?= form_checkbox('side_2', 'active', FALSE); ?>
    <label>Side 2:</label><?= form_dropdown('players_s2', $players, 0); ?> &nbsp;
        <?= form_input('name_s2', " "); ?></p>
<p><?= form_checkbox('side_3', 'active', FALSE); ?>
    <label>Side 3:</label><?= form_dropdown('players_s3', $players, 0); ?> &nbsp;
        <?= form_input('name_s3', " "); ?></p>
</div>

        
<?= form_submit('login_submit', 'Submit'); ?></p>
<?= form_close(); ?>

