<?php
	session_start();
	$_SESSION = array();
	session_destroy();
	$msg = "Informazioni: log-out effettuato con successo.";
	$msg = urlencode($msg);
	header("location: Login.php?msg=$msg");
	exit();
?>
