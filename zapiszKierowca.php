<?php

session_start();


function komunikatZwrotny($komunikat)
{
	$_SESSION["komunikat"]=$komunikat;
		header("Location: zamowienie.php");
		exit;
}
	require_once ("databaseconnection.php");
	if(isset($_POST["imie"],$_POST["nazwisko"], $_POST["samochod"]))
	{
		$imie=htmlentities($_POST["imie"], ENT_QUOTES,"UTF-8");
		$nazwisko=htmlentities($_POST["nazwisko"], ENT_QUOTES, "UTF-8");
		$samochod=htmlentities($_POST["samochod"], ENT_QUOTES, "UTF-8");
	
		
		if($imie!="" && $nazwisko!="" && $samochod!="")
		{
			//logika zapisania danych do bazy
			$connectionString="host=".$host." port=".$port." dbname=".$db_name." user=".$user." password=".$password;
			$dbconnect=pg_connect($connectionString);
			 if($dbconnect)
		  {
			  $query="insert into kierowca( imie, nazwisko, id_auta) values($1, $2, $3)";
			  $result=pg_query_params($dbconnect, $query, array($imie, $nazwisko, $samochod));
			pg_close($dbconnect);
		  }
	
		
		}
	}
	else
	{
		komunikatZwrotny("uzupelnij dane");
	}
	header("Location: index.php");	
?>