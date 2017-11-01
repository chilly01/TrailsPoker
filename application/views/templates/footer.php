<em>&copy; 2017 codyhillyard.com</em>
<a href="<?= site_url('pages/index/home') ?>">Poker Main Page</a>
<a href="<?= site_url('pages/index/main') ?>">Developer Page</a>

<?php
 if  ($this->session->active){ ?>
           </br>
           </br>
<a href="<?= site_url('pages/admin/home') ?>">ADMIN PAGE</a>
<a href="<?= site_url('pages/index/logout') ?>">LOGOUT</a>
          
<?php }
else {?>
    <a href="<?= site_url('pages/index/login') ?>">LOGIN</a>
<?php } ?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>

    
</body>
</html>