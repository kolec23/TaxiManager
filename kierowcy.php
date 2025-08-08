<?php

session_start();
require_once ("mojefunkcje.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
     <title>Uber</title>
</head>
<body>
<nav class="navbar navbar-inverse">
  <div class="container-fluid navigation">
    <div class="navbar-header">
    </div>
    <ul class="nav navbar-nav ">
      <li ><a href="logowanie.php">logowanie</a></li>
	  <li ><a href="zamowienie.php">zamowienie</a></li>
	    <?php
		
		if(isset($_SESSION['rola']))
		{
			
			if($_SESSION['rola']=='kierowca')
			{
				podstronyKierowcy();
			}
			if($_SESSION['rola']=='admin')
			{
				podstronyAdmina();
			}
			
		}
	  ?>
    </ul>
  </div>
</nav>
<div id="container">
	<?php
		if(isset($_SESSION["komunikat"]))
		{
			echo "<span>".$_SESSION["komunikat"]."</span>";
		}
	?>
  <form action="zapiszKierowca.php" method="post">
	<label>Kierowcy</label>
	<br/>
	<label>Imie</label>
	<br/>
	<input type='text' name='imie'/>
	<br/>
	<label>Nazwisko</label>
	<br/>
	<input type='text' name='nazwisko'/>
	<br/>
	<label>samochód</label>
	<br/>
	<?php
		require_once ("databaseconnection.php");
          $connectionString="host=".$host." port=".$port." dbname=".$db_name." user=".$user." password=".$password;
          $dbconnect=pg_connect($connectionString);
		  if($dbconnect)
		  {
			  $query="select concat(samochod.id_samochodu, ' : ', producentauta.nazwa, ' ', samochod.model) as identyfikator, id_samochodu from samochod inner join producentauta on (samochod.producent=producentauta.id_producenta)";
		
			  $result=pg_query($dbconnect, $query);
			  
				if($result==true)
				{
					echo '<select name="samochod">';
				  while($row=pg_fetch_array($result,NULL,PGSQL_ASSOC))
					{
					echo '<option value="'.$row['id_samochodu'].'">'.$row['identyfikator'].'</option>';
					}	
					echo '</select>';
					pg_free_result($result);
					
				}
				pg_close($dbconnect);
		  }
	
	?>
	<input type="submit"/>
  </form>
</div>
</body>
</html>