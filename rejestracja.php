<?php
    require_once("databaseconnection.php");
    session_start();
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>rejestracja</title>
    <link rel="StyleSheet" href="style.css"/>
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
           <span>Powtorz haslo</span>
           <input id="haslopow" name="haslopow" type="password" />
           <br/>
           <span>Rola</span>
           <select id="rola" name="rola">
                <option value="admin">admin</option>
                <option value="kierowca" selected>kierowca</option>
           </select>
           <br>
           <input type="submit" value="Stworz konto" />
          
            </br>
           <span id="info" name="info">
            <?php
            //mechanizm zakładania konta
               if(!isset($_POST['login']) || !isset($_POST['haslo'])|| !isset($_POST['haslopow']))
               {
                    echo "Uzupełnij dane";
               }
               else
               {
                    if($_POST['haslo']!=$_POST['haslopow'])
                    {
                        echo "HASŁO NIE JEST ZGODNE!";
                    }
                    else
                    {
                        //sprawdzić istnienie w bazie
                        //logika zapisania danych do bazy
                        $connectionString="host=".$host." port=".$port." dbname=".$db_name." user=".$user." password=".$password;
                        $dbconnect=pg_connect($connectionString);
                        if($dbconnect)
                        {
                            $hasz=password_hash($_POST['haslo'], PASSWORD_DEFAULT);
                            $querry="insert into konto(login, haslo,rola) values ($1,$2,$3)";
                            @$result=pg_query_params($dbconnect,$querry,array($_POST['login'],$hasz,$_POST['rola']));
                            if(!$result) 
                            {
                                echo "Prawdopodobnie istnieje uzytkownik o danym loginie";
                            }
							@pg_free_result($result);
                            pg_close($dbconnect);
							
							//Wrocenie do strony głownej
							header("Location: index.php");
							exit();
                        }
                    }

               }
            ?>
           </span>
        </form>
    </div>

    <script>
        function walidacja()
        {
            var haslo1=document.getElementById("haslo").value;
            var haslo2=document.getElementById("haslopow").value;
            if(haslo1!==haslo2)
            {
                document.getElementById("info").innerHTML="HASŁO NIE JEST ZGODNE!";
            }
            else
            {
                document.getElementById("info").innerHTML="";
            }
         
        }

        document.getElementsByName("haslopow")[0].addEventListener('change', walidacja);
        document.getElementsByName("haslo")[0].addEventListener('change', walidacja);
    </script>

</body>
</html>