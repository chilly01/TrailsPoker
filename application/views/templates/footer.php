<em>&copy; 2017 codyhillyard.com</em>
<a href="<?= site_url() ?>">Poker Main Page</a>
<a href="<?= site_url().'pages/index/main' ?>">Developer Page</a>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
<script>
    $.get("https://ipinfo.io", function(response) {
  console.log(response.ip, response.city, response.country);
}, "jsonp"); 
</script>
    
</body>
</html>