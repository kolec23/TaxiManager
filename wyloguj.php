<?php
	session_start();
	if(isset($_SESSION['rola']))
	{
		unset($_SESSION['rola']);
		
	}
	header("Location: index.php");
	exit();

?>