<?php
    session_start();
    require_once("header.php");
    session_set_cookie_params (0, "/", ".cinguettio.it");
	if (!isset($_SESSION['nick']) || !isset($_SESSION['pwd'])) {
		echo "Non sei connesso!";
		die;
	}
?>
<html>
	<head>
		<title>Registrazione</title>
		<link rel="stylesheet" type="text/css" href="css.css">
		<script type= "text/javascript" src ="countries.js"></script>
	</head>
	<body>
		<ul>
				<li><a href="Bacheca.php">Bacheca</a></li>
				<li><a class="active" href="Datiutente.php">Dati Utente</a></li>
				<li><a href="Chiseguo.php">Chi Seguo</a></li>
				<li><a href="Chimisegue.html">Chi Mi Segue</a></li>
				<li><a href="Logout.php">Logout</a></li>
		</ul>
		
		<form method="post" action="Modificadatiutente.php">
			Modifica i tuoi dati personali
			<table>
				<tr>
					<td>Nome: </td><td> <input type = "text" name = "nome"></td>
				</tr>
				<tr>
					<td>Cognome: </td><td> <input type = "text" name = "cognome"></td>
				</tr>
				<tr>
					<td>Data di Nascita(gg/mm/aaaa): </td><td> <input type = "text" name = "dataNascita"></td>
				</tr>
				<tr>
					<td>Luogo di Nascita: </td><td> <input type="text" name="luogoNascita"></td>
				</tr>
				<tr>
					<td>Sesso:</td>
					<td>
						<input type="radio" name="sesso" value="M">M
                        <input type="radio" name="sesso" value="F">F
					</td>
				</tr>
				<tr>
					<td>Hobby:</td><td> <input type = "text" name = "hobby"></td>
				</tr>
			</table>
			Città di resisenza:
			<table>
				<tr>
					<td>Città:</td><td> <input type = "text" name = "citta"></td>
				</tr>
				<tr>
					<td>Prefisso Telefonico:</td><td> <input type = "text" name = "preftel"></td>
				</tr>
				<tr>
					<td>Targa:</td><td> <input type = "text" name = "targa"></td>
				</tr>
				<tr>
					<td>CAP:</td><td> <input type = "text" name = "cap"></td>
				</tr>
			</table>
			 
						
			<button class="button button" input type= "submit" name="ok">Salva</button>
			<button class="button button" input type = "reset" name="cancella">Cancella Tutto</button>
		</form>
	</body>
</html>
<?php
    if (isset ($_POST['ok'])) {
        $nome=addslashes($_POST['nome']);
		$cognome=addslashes($_POST['cognome']);
		$dataNascita=addslashes($_POST['dataNascita']);
		$luogoNascita=addslashes($_POST['luogoNascita']);
		$sesso=addslashes($_POST['sesso']);
		$hobby=addslashes($_POST['hobby']);
		$citta=addslashes($_POST['citta']);
		$preftel=addslashes($_POST['preftel']);
		$targa=addslashes($_POST['targa']);
		$cap=addslashes($_POST['cap']);
		$sql="INSERT INTO Citta (NomeC, PrefissoTel, Targa, CAP) values ('$citta', '$preftel', '$targa', '$cap');";
		$res=mysql_query($sql,$cid) or die( "Errore " .mysql_error()); 
		$sql="UPDATE Utente SET Nome='$nome', Cognome='$cognome', DataNascita='$dataNascita', LuogoNascita='$luogoNascita', Sesso='$sesso', Hobby='$hobby' WHERE Nickname='$_SESSION[nick]' AND Pswd='$_SESSION[pwd]'"; 
		$res=mysql_query($sql,$cid) or die( "Errore " .mysql_error());    
	}
	
	header("location: Datiutente.php");
?>