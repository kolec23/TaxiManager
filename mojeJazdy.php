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
    <table class= "table table-striped" >
      <thead>
      <tr >
		<th>Zamówienie_id</th>
        <th>Kierowca_id</th>
        <th>Kierowca</th>
        <th>Start</th>
		<th>Cel</th>
		<th>Operacje</th>
      </tr>
      <thead>
       <tbody>
        <?php
          require_once ("databaseconnection.php");
          $connectionString="host=".$host." port=".$port." dbname=".$db_name." user=".$user." password=".$password;
          
          $dbconnect=pg_connect($connectionString);
          if($dbconnect)
          {
              $query="select zamowienie.id_zamowienia, kierowca.kierowca_id, concat(kierowca.imie, ' ', kierowca.nazwisko) as kierowca, 
			concat(ads.miejscowosc,' ', ads.ulica, ' ', ads.numer_domu) as \"start\",
			concat(adc.miejscowosc,' ', adc.ulica, ' ', adc.numer_domu) as \"cel\",
			zamowienie.data_rozpoczencia, zamowienie.data_zakonczenia
			from kierowca inner join zamowienie on (kierowca.kierowca_id=zamowienie.kierowca_id) 
			inner join adres as ads on (zamowienie.miejsce_startu=ads.id_adresu)
			inner join adres as adc on (zamowienie.miejsce_docelowe=adc.id_adresu)
			where zamowienie.data_zakonczenia is null";
			  $result=pg_query($dbconnect, $query);
			  if($result==true)
			  {
				  while($row=pg_fetch_array($result,NULL,PGSQL_ASSOC))
					{
					 echo '<tr>';
					 
					 echo '<td>';
					 echo $row['id_zamowienia'];
					 echo '</td>';
					 
					 echo '<td>';
					 echo $row['kierowca_id'];
					 echo '</td>';
					 
					 echo '<td>';
					 echo $row['kierowca'];
					 echo '</td>';
					 
					 echo '<td>';
					 echo $row['start'];
					 echo '</td>';
					 
					  echo '<td>';
					 echo $row['cel'];
					 echo '</td>';
					 
					 //Przyciski do zakonczenia zlecenia
					   echo '<td>';
					 echo '<form method="post" action="zakonczJazdy.php">';
						echo '<input type="hidden" value='.$row['id_zamowienia'].' name="id_zamowienia"/>';
						echo '<input type="submit" value="zakoncz podróż"/>';
					 echo '</form>';
					 
					 echo '</td>';
					 
					 echo '</tr>';
				}
			pg_free_result($result);
			pg_close($dbconnect);
			  }
          }
          
        ?>
       </tbody>
    </table>
</div>
</body>
</html>