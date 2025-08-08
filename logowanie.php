<?php
session_start();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css"/>
    <title>Uber</title>
</head>
<body>
    <div id="container">
        <form method="post">
            <span>Login</span>
            <input id="login" name="login" type="text"/>
            <br/>
            <span>Haslo</span>
           <input id="haslo" name="haslo" type="Password"/>
           <br/>
           <input type="submit" value="zaloguj"/>
           <br/>
  
           <span id="info" name="info">
                <?php
                    if(!isset($_POST['login']) || !isset($_POST['haslo']))
                    {
                         echo "Uzupełnij dane";
                    }
                    else
                    {
                
                             //sprawdzić istnienie w bazie
                             //logika zapisania danych do bazy
							 require_once("databaseconnection.php");
                             $connectionString="host=".$host." port=".$port." dbname=".$db_name." user=".$user." password=".$password;
                             $dbconnect=pg_connect($connectionString);
                             if($dbconnect)
                             {
								$login=$_POST['login'];
								$haslo=$_POST['haslo'];
                                 $querry="select * from konto where login=$1";
                                 $result=pg_query_params($dbconnect,$querry,array($login));
								if(!$result)
								{
									echo "Podany dane są nieprawidlowe";
								}
								else
								{
									$row=pg_fetch_array($result, NULL, PGSQL_ASSOC);
									if(password_verify($haslo,$row['haslo']))
									{
										$_SESSION['rola']=$row['rola'];
										$_SESSION['uzytkownik']=$row['login'];
							
							
										pg_free_result($result);
										header("Location: index.php");
										exit();
									}
									else
									{
										echo "Podany dane są nieprawidlowe";
									}
							
								}
                                 pg_close($dbconnect);
                             }
                         
                     }
                
                ?>
           </span>
        </form>
    </div>
</body>
</html>