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
  <form action="zapiszSamochod.php" method="post">
	<label>Samochód</label>
	<br/>
	<label>Rejestracja</label>
	<br/>
	<input type='text' name='rejestracja'/>
	<br/>
	<label>Producent</label>
	<br/>
	<input type='text' name='producent'/>
	<br/>
	<label>Model</label>
	<br/>
	<input type='text' name='model'/>
	<input type="submit"/>
  </form>
</div>
</body>
</html>