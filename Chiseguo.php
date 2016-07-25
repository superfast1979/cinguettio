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
	<title>Chi Seguo</title>
	<head>
		<link rel="stylesheet" type="text/css" href="css.css">
	</head>
	<body>
		<ul>
				<li><a href="Bacheca.php">Bacheca</a></li>
				<li><a href="Datiutente.html">Dati Utente</a></li>
				<li><a class="active" href="Chiseguo.php">Chi Seguo</a></li>
				<li><a href="Chimisegue.html">Chi Mi Segue</a></li>
				<li><a href="Logout.php">Logout</a></li>
		</ul>
		
		Chi seguo
		
		<form action="Chiseguo.php" method="POST" id=search">
					<input type="text" name="cerca" size="60" placeholder="Cerca"/>
					<input type="submit" value="Invia">
		</form>
		
		<?php
			if (isset ($_POST['Invia'])) {
				$sql="SELECT * FROM utente WHERE Nickname='$_POST[cerca]'";
				$res=mysql_query($sql,$cid);
				if($res && mysql_num_rows($res)>0){
					while($row=mysql_fetch_assoc($res)){
						echo $row[‘Nickname’]." - ";
						echo $row[‘Nome’]." <br> ";
					}
				} else
				echo "nessun risultato";
			}
		?>
		
	</body>
</html>