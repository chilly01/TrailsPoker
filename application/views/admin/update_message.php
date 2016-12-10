<h1>Main Message</h1> 
<div id="validation_errors"><?= validation_errors(); ?></div>
<?= form_open('Pages/update_main_message'); ?><p>
<?= form_textarea('message', $last_message); ?></p><p>
<?= form_submit('login_submit', 'Submit'); ?></p>
<?= form_close(); ?>
