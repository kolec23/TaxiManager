<?php



	session_start();


function komunikatZwrotny($komunikat)
{
	$_SESSION["komunikat"]=$komunikat;
		header("Location: zamowienie.php");
		exit;
}
	require_once ("databaseconnection.php");
	if(isset($_POST["kierowca"],$_POST["wojewodztwoStartu"], $_POST["dataRozpoczencia"], $_POST["miejscowoscStartu"],$_POST["ulicaStartu"], $_POST["numerDomuStartu"], $_POST["wojewodztwoDocelowe"],$_POST["miejscowoscDocelowe"], $_POST["ulicaDocelowe"], $_POST["numerDomuDocelowe"], $_POST["imieKlienta"], $_POST["nazwiskoKlienta"],$_POST["telefonKlienta"]))
	{
		$kierowca=htmlentities($_POST["kierowca"], ENT_QUOTES,"UTF-8");
		$wojewodztwoStartu=htmlentities($_POST["wojewodztwoStartu"], ENT_QUOTES, "UTF-8");
		$dataRozpoczencia=htmlentities($_POST["dataRozpoczencia"], ENT_QUOTES, "UTF-8");
		$miejscowoscStartu=htmlentities($_POST["miejscowoscStartu"], ENT_QUOTES, "UTF-8");
		$ulicaStartu=htmlentities($_POST["ulicaStartu"], ENT_QUOTES,"UTF-8");
		$numerDomuStartu=htmlentities($_POST["numerDomuStartu"], ENT_QUOTES, "UTF-8");
		$wojewodztwoDocelowe=htmlentities( $_POST["wojewodztwoDocelowe"],ENT_QUOTES, "UTF-8");
		$miejscowoscDocelowe=htmlentities($_POST["miejscowoscDocelowe"], ENT_QUOTES, "UTF-8");
		$ulicaDocelowe=htmlentities($_POST["ulicaDocelowe"], ENT_QUOTES, "UTF-8");
		$numerDomuDocelowe=htmlentities($_POST["numerDomuDocelowe"], ENT_QUOTES, "UTF-8");
		$imieKlienta=htmlentities( $_POST["imieKlienta"], ENT_QUOTES, "UTF-8");
		$nazwiskoKlienta=htmlentities($_POST["nazwiskoKlienta"], ENT_QUOTES, "UTF-8");
		$telefonKlienta=htmlentities($_POST["telefonKlienta"], ENT_QUOTES, "UTF-8");
		
		if($kierowca!="" && $wojewodztwoStartu!="" && $dataRozpoczencia!="" && $miejscowoscStartu!="" && $ulicaStartu!="" && $numerDomuStartu!="" && $wojewodztwoDocelowe!="" && $ulicaDocelowe!="" && $numerDomuDocelowe!="" && $imieKlienta!="" && $nazwiskoKlienta!="" && $telefonKlienta!="" && $miejscowoscDocelowe!="")
		{
			//logika zapisania danych do bazy
			$connectionString="host=".$host." port=".$port." dbname=".$db_name." user=".$user." password=".$password;
			$dbconnect=pg_connect($connectionString);
			if($dbconnect)
			{
				//pozyskanie identyfikatora klienta
				$querry='select * from klient where imie=$1 and nazwisko=$2 and telefon=$3';
				$result=pg_query_params($dbconnect, $querry, array($imieKlienta,$nazwiskoKlienta,$telefonKlienta));
				
				if(pg_num_rows($result)<1) //brak klienta nowy klient
				{
					pg_free_result($result);
					$querry='insert into klient(imie, nazwisko, telefon) values($1, $2, $3)';
					$result=pg_query_params($dbconnect, $querry, array($imieKlienta, $nazwiskoKlienta, $telefonKlienta));
					pg_free_result($result);
					
					$querry='select * from klient where imie=$1 and nazwisko=$2 and telefon=$3';
					$result=pg_query_params($dbconnect, $querry, array($imieKlienta,$nazwiskoKlienta,$telefonKlienta));
					$row=pg_fetch_array($result,NULL,PGSQL_ASSOC);
					$idKlienta=$row["id_klienta"]; //!!
					pg_free_result($result);
				}
				else
				{
					$querry='select * from klient where imie=$1 and nazwisko=$2 and telefon=$3';
					$result=pg_query_params($dbconnect, $querry, array($imieKlienta,$nazwiskoKlienta,$telefonKlienta));
					$row=pg_fetch_array($result,NULL,PGSQL_ASSOC);
					$idKlienta=$row["id_klienta"]; //!!
					pg_free_result($result);
				}
				
				
				//pozyskiwani identyfikatora miejsca docelowego
				$querry='select * from adres where wojewodztwo=$1 and miejscowosc=$2 and ulica=$3 and numer_domu=$4';
				$result=pg_query_params($dbconnect, $querry, array($wojewodztwoDocelowe, $miejscowoscDocelowe, $ulicaDocelowe,$numerDomuDocelowe));
				if(pg_num_rows($result)<1) //brak danego adresu
				{
					pg_free_result($result);
					$querry='insert into adres(wojewodztwo,miejscowosc, ulica,numer_domu) values ($1, $2, $3, $4)';
					$result=pg_query_params($dbconnect, $querry, array($wojewodztwoDocelowe, $miejscowoscDocelowe, $ulicaDocelowe, $numerDomuDocelowe));
					pg_free_result($result);
					
					$querry='select * from adres where wojewodztwo=$1 and miejscowosc=$2 and ulica=$3 and numer_domu=$4';
					$result=pg_query_params($dbconnect, $querry, array($wojewodztwoDocelowe, $miejscowoscDocelowe, $ulicaDocelowe,$numerDomuDocelowe));
					$row=pg_fetch_array($result, NULL, PGSQL_ASSOC);
					$idAdresuDocelowe=$row["id_adresu"]; //!!
					pg_free_result($result);
				}
				else
				{
					$querry='select * from adres where wojewodztwo=$1 and miejscowosc=$2 and ulica=$3 and numer_domu=$4';
					$result=pg_query_params($dbconnect, $querry, array($wojewodztwoDocelowe, $miejscowoscDocelowe, $ulicaDocelowe,$numerDomuDocelowe));
					$row=pg_fetch_array($result, NULL, PGSQL_ASSOC);
					$idAdresuDocelowe=$row["id_adresu"]; //!!
					pg_free_result($result);
				}
				
				//pozyskiwanie identyfikatora miejscowoscStartu
				$querry='select * from adres where wojewodztwo=$1 and miejscowosc=$2 and ulica=$3 and numer_domu=$4';
				$result=pg_query_params($dbconnect, $querry, array($wojewodztwoStartu, $miejscowoscStartu, $ulicaStartu,$numerDomuStartu));
				if(pg_num_rows($result)<1)
				{
					pg_free_result($result);
					$querry='insert into adres(wojewodztwo,miejscowosc, ulica,numer_domu) values ($1, $2, $3, $4)';
					$result=pg_query_params($dbconnect, $querry, array($wojewodztwoStartu, $miejscowoscStartu, $ulicaStartu, $numerDomuStartu));
					pg_free_result($result);
					
					$querry='select * from adres where wojewodztwo=$1 and miejscowosc=$2 and ulica=$3 and numer_domu=$4';
					$result=pg_query_params($dbconnect, $querry, array($wojewodztwoStartu, $miejscowoscStartu, $ulicaStartu,$numerDomuStartu));
					$row=pg_fetch_array($result, NULL, PGSQL_ASSOC);
					$idAdresuStartu=$row["id_adresu"]; //!!
					pg_free_result($result);
					
				}
				else
				{
					$querry='select * from adres where wojewodztwo=$1 and miejscowosc=$2 and ulica=$3 and numer_domu=$4';
					$result=pg_query_params($dbconnect, $querry, array($wojewodztwoStartu, $miejscowoscStartu, $ulicaStartu,$numerDomuStartu));
					$row=pg_fetch_array($result, NULL, PGSQL_ASSOC);
					$idAdresuStartu=$row["id_adresu"]; //!!
					pg_free_result($result);
				}
				
				//pozyskanie identyfikatora kierowcy
				$querry='select kierowca_id, imie, nazwisko from kierowca';
				$result=pg_query($dbconnect, $querry);
				while($row=pg_fetch_array($result, NULL, PGSQL_ASSOC))
				{
					//dokonczyć wyznaczanie id kierowcy
					if($kierowca===$row['kierowca_id'].' '.$row['imie'].' '.$row['nazwisko']);
					{
						$idKierowcy=$row['kierowca_id']; //!!
						break;
					}
				}
				//sprawdzanie dostepnego terminu
				$querry='select * from zamowienie where (data_rozpoczencia<$1 and $1<data_zakonczenia and kierowca_id=$2) or (data_rozpoczencia<$1 and data_zakonczenia is null and kierowca_id=$2)';
				$result=pg_query_params($dbconnect, $querry, array($dataRozpoczencia, $idKierowcy));
				if(pg_num_rows($result)>0)
				{
					
					komunikatZwrotny("Podany termin jest zajęty");
				}
				else
				{
					$querry='insert into Zamowienie(kierowca_id,data_rozpoczencia,miejsce_startu,miejsce_docelowe,klient_id) values($1,$2,$3,$4, $5)';
					$result=pg_query_params($dbconnect, $querry, array($idKierowcy, $dataRozpoczencia, $idAdresuStartu, $idAdresuDocelowe, $idKlienta));
					header("Location: index.php");
				}
				pg_close($dbconnect);
			}
		}
		else
		{
			komunikatZwrotny("uzupelnij dane");
		}
		
	}
	else
	{
		komunikatZwrotny("uzupelnij dane");
	}

?>