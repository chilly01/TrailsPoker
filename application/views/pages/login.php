<h1>login page:</h1> 
<?php 

?>
<div id="validation_errors"><?= validation_errors(); ?></div>
<?= form_open('Pages/validate'); ?><p>
<?= form_input('user_name'); ?></p><p>
<?= form_password('password'); ?></p><p>
<?= form_submit('login_submit', 'Login'); ?></p>
<?= form_close(); ?>
