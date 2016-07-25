<?php
    session_start();
    require_once("database.php");
	session_set_cookie_params (0, "/", ".cinguettio.it");
	if (!isset($_SESSION['nick']) || !isset($_SESSION['pwd'])) {
		echo "Non sei connesso!";
		die;
	}
?>
<html>
	<title>Dati Utente</title>
	<head>
		<link rel="stylesheet" type="text/css" href="css.css">
	</head>
	<body>
		<ul>
				<li><a href="Bacheca.php">Bacheca</a></li>
				<li><a class="active" href="Datiutente.php">Dati Utente</a></li>
				<li><a href="Chiseguo.php">Chi Seguo</a></li>
				<li><a href="Chimisegue.html">Chi Mi Segue</a></li>
				<li><a href="Logout.php">Logout</a></li>
		</ul>
		<br>
		<br>
		<br>
		<br>
		<br>
		<br>
		<br>
		Dati Utente <br>
		<a href="Modificadatiutente.php">Modifica i tuoi dati</a>
	</body>
</html>
