<?php

session_start();


function komunikatZwrotny($komunikat)
{
	$_SESSION["komunikat"]=$komunikat;
		//header("Location: zamowienie.php");
		exit;
}
	require_once ("databaseconnection.php");
	if(isset($_POST["rejestracja"],$_POST["producent"], $_POST["model"]))
	{
		$rejestracja=htmlentities($_POST["rejestracja"], ENT_QUOTES,"UTF-8");
		$producent=htmlentities($_POST["producent"], ENT_QUOTES, "UTF-8");
		$model=htmlentities($_POST["model"], ENT_QUOTES, "UTF-8");
	
		
		if($rejestracja!="" && $producent!="" && $model!="")
		{
			//logika zapisania danych do bazy
			$connectionString="host=".$host." port=".$port." dbname=".$db_name." user=".$user." password=".$password;
			$dbconnect=pg_connect($connectionString);
			
			 if($dbconnect)
			{
			
			$query="select * from producentauta where nazwa=$1";
			 $result=pg_query_params($dbconnect, $query, array($model));
	
			 if(pg_num_rows($result)<1) //brak danego modelu
			 {
				
				 pg_free_result($result);
				 
				$query='insert into producentauta (nazwa) values($1)';
				$result=pg_query_params($dbconnect, $query, array( $model));
				 pg_free_result($result);
				 
				 $query="select * from producentauta where nazwa=$1";
				$result=pg_query_params($dbconnect, $query, array($model));
				$row=pg_fetch_array($result,NULL,PGSQL_ASSOC);
				$id_modelu=$row['id_producenta'];
				pg_free_result($result);
			  $query="insert into samochod( rejestracja, producent, model) values($1, $2, $3)";
			  $result=pg_query_params($dbconnect, $query, array($rejestracja, $id_modelu, $model));
			 }
			 else
			 {
				 $row=pg_fetch_array($result,NULL,PGSQL_ASSOC);
				$id_modelu=$row['id_producenta'];
				pg_free_result($result);
				  $query="insert into samochod( rejestracja, producent, model) values($1, $2, $3)";
			  $result=pg_query_params($dbconnect, $query, array($rejestracja, $id_modelu, $model));
			 }
			pg_close($dbconnect);
		  }
	
		
		}
	}
	else
	{
		komunikatZwrotny("uzupelnij dane");
	}
	//header("Location: index.php");	
?>