<?php

	require_once("databaseconnection.php");
	$zamowienie=htmlentities($_POST['id_zamowienia'], ENT_QUOTES,"UTF-8");
	//napisać procedurę wstawiającom datę zakończenia.
	
	 $connectionString="host=".$host." port=".$port." dbname=".$db_name." user=".$user." password=".$password;
	 $dbconnect=pg_connect($connectionString);
		  if($dbconnect)
		  {
				$query="update zamowienie set data_zakonczenia=now() where id_zamowienia=$1";
				$result=pg_query_params($dbconnect, $query, array($zamowienie));
				pg_free_result($result);
				pg_close($dbconnect);
				header("Location: mojeJazdy.php");		 
		  }
	echo "błą połączenia z bazą";
	
?>