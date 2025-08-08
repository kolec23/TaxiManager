<?php
 function podstronyKierowcy()
 {
	echo '<li><a href="mojeJazdy.php">jazdy</a></li>';
	echo '<li><a href="wyloguj.php" class=wazne">Wyloguj</a></li>';
 }
 
 function podstronyAdmina()
 {
	 	echo '<li><a href="kierowcy.php">dodaj kierowce</a></li>';
		echo '<li><a href="samochody.php">dodaj Samochod</a></li>';
		echo '<li><a href="rejestracja.php">Stwórz użytkownika</a></li>';
		echo '<li><a href="wyloguj.php" class=wazne">Wyloguj</a></li>';
 }
?>