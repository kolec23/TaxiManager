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
  <form action="zapiszJazda.php" method="post">
	<label>Kierowcy</label>
	<br/>
	<?php
		require_once ("databaseconnection.php");
          $connectionString="host=".$host." port=".$port." dbname=".$db_name." user=".$user." password=".$password;
          $dbconnect=pg_connect($connectionString);
		  if($dbconnect)
		  {
			  $query="select concat(kierowca_id,' ', imie, ' ', nazwisko) as identyfikator from kierowca";
		
			  $result=pg_query($dbconnect, $query);
			  
				if($result==true)
				{
					echo '<select name="kierowca">';
				  while($row=pg_fetch_array($result,NULL,PGSQL_ASSOC))
					{
					echo '<option value"'.$row['identyfikator'].'">'.$row['identyfikator'].'</option>';
					}	
					echo '</select>';
					pg_free_result($result);
				}
				pg_close($dbconnect);
		  }
	
	?>
	<br/>
	<label>Data rozpoczencia</label>
	<br/>
	<input type="datetime-local" name="dataRozpoczencia"/>
	<br/>
	<h2>Miejsce Startu</h2>
	<label>województwo</label>
	<select name="wojewodztwoStartu">
		<option value="Dolnośląskie">Dolnośląskie</option>
		<option value="Kujawsko-Pomorskie">Kujawsko-Pomorskie</option>
		<option value="Lubelskie">Lubelskie</option>
		<option value="Lubuskie">Lubuskie</option>
		<option value="Łódzkie">Łódzkie</option>
		<option value="Małopolskie">Małopolskie</option>
		<option value="Mazowieckie">Mazowieckie</option>
		<option value="Opolskie">Opolskie</option>
		<option value="Podkarpackie">Podkarpackie</option>
		<option value="Podlaskie">Podlaskie</option>
		<option value="Pomorskie">Pomorskie</option>
		<option value="Śląskie">Śląskie</option>
		<option value="Świętokrzyskie">Świętokrzyskie</option>
		<option value="Warmińsko-Mazurskie">Warmińsko-Mazurskie</option>
		<option value="Wielkopolskie">Wielkopolskie</option>
		<option value="Zachodniopomorskie">Zachodniopomorskie</option>
	</select>
	<br/>
	<label>miejscowosc</label>
	<br/>
	<input type="text" name="miejscowoscStartu"/>
	<br/>
	<label>ulica:</label>
	<br/>
	<input type="text" name="ulicaStartu"/>
	<br/>
	<label>numer domu:</label>
	<br/>
	<input type="text" name="numerDomuStartu"/>
	
	
	<h2>Miejsce Docelowe</h2>
	<label>województwo</label>
	<select name="wojewodztwoDocelowe">
		<option value="Dolnośląskie">Dolnośląskie</option>
		<option value="Kujawsko-Pomorskie">Kujawsko-Pomorskie</option>
		<option value="Lubelskie">Lubelskie</option>
		<option value="Lubuskie">Lubuskie</option>
		<option value="Łódzkie">Łódzkie</option>
		<option value="Małopolskie">Małopolskie</option>
		<option value="Mazowieckie">Mazowieckie</option>
		<option value="Opolskie">Opolskie</option>
		<option value="Podkarpackie">Podkarpackie</option>
		<option value="Podlaskie">Podlaskie</option>
		<option value="Pomorskie">Pomorskie</option>
		<option value="Śląskie">Śląskie</option>
		<option value="Świętokrzyskie">Świętokrzyskie</option>
		<option value="Warmińsko-Mazurskie">Warmińsko-Mazurskie</option>
		<option value="Wielkopolskie">Wielkopolskie</option>
		<option value="Zachodniopomorskie">Zachodniopomorskie</option>
	</select>
	<br/>
	<label>miejscowosc</label>
	<br/>
	<input type="text" name="miejscowoscDocelowe"/>
	<br/>
	<label>ulica:</label>
	<br/>
	<input type="text" name="ulicaDocelowe"/>
	<br/>
	<label>numer domu:</label>
	<br/>
	<input type="text" name="numerDomuDocelowe"/>
	
	
	<h2>Dane klienta</h2>
	<label>Imie</label>
	<br/>
	<input type="text" name="imieKlienta"/>
	<br/>
	<label>Nazwisko</label>
	<br/>
	<input type="text" name="nazwiskoKlienta"/>
	<br/>
	<label>Telefon</label>
	<br/>
	<input type="text" name="telefonKlienta"/>
	<br/>
	<input type="submit"/>
  </form>
</div>
</body>
</html>