<?php
    session_start();
    
    
    require_once("header.php");
	session_set_cookie_params (0, "/", ".cinguettio.it");
	if (!isset($_SESSION['email']) || !isset($_SESSION['pwd'])) {
		echo "Non sei connesso!";
		die;
	}
	else {
		echo "Sei connesso!";
		die;
	}
?>

<html>
	<title>Bacheca</title>
	<head>
		<link rel="stylesheet" type="text/css" href="css.css">
	</head>
	<body>
		<ul>
			<li><a class="active" href="Bacheca.php" class='active'>Bacheca</a></li>
			<li><a href="Datiutente.php">Dati Utente</a></li>
			<li><a href="Chiseguo.php">Chi Seguo</a></li>
			<li><a href="Chimisegue.html">Chi Mi Segue</a></li>
			<li><a href="Logout.php">Logout</a></li>
		</ul>
		<br>
		<br>
		<form method="post" action="Bacheca.php">
			<textarea name="cintesto" rows="2" cols="100" placeholder="Cinguettio" autofocus></textarea>
			<input type="submit" value="Invia">
		</form>

		<?php
			if (isset ($_POST['Invia'])) {
				
				$sql="SELECT MAX(IdProg) FROM Cinguettio c,Utente u WHERE c.email=u.email";
				$res=mysql_query($sql,$cid);
				if(is_null($res)==TRUE)
					$contaid=0;
				else
					$contaid=$contaid+1;
				
				$testo=addslashes($_POST['cintesto']);
				$id=addslashes($contaid);
				$email=addslashes($_POST['mail']);
				$data=addslashes(date("d/m/Y"));
				$sql = "insert into cinguettio (IdProg, Email, DataCreazione) values ('$id', '$email', '$data');"; 
				$res=mysql_query($sql,$cid) or die( "Errore " .mysql_error());
				$sql = "insert into testo (IdProg, Testo) values ('$id', '$testo');"; 
				$res=mysql_query($sql,$cid) or die( "Errore " .mysql_error());
			}
		?>
		
		Lista Cinguettii pubblicati in ordine (in alto meno recente)
		
		<?php
			$sql="SELECT * FROM Cinquettio NATURAL JOIN Testo";
			$res=mysql_query($sql,$cid);
			if($res && mysql_num_rows($res)>0){
				while($row=mysql_fetch_assoc($res)){
					echo $row[‘ID’]." <br> ";
					echo $row[‘Testo’]." <br> ";
					echo $row[‘Data’]." <br><br><br> ";
				}
			} else
			echo "nessun risultato";
		?>
		
	</body>
</html>