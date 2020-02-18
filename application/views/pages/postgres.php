
<h1> First try </h1>



<?php
try {
   $dbh = new PDO('pgsql:host=localhost;port=5432;dbname=postgres;user=postgres;password=rocker');
   echo "PDO connection object created";
}
catch(PDOException $e)
{
      echo $e->getMessage();
} ?>

<h1> Second try </h1>
<?php
pg_connect("host=localhost dbname=postgres user=postgres password=rocker")
    or die("Can't connect to database".pg_last_error());
?>

<h1> Second try </h1>

