<?php
session_start();
require_once("database.php");
if (!isset($_SESSION['email']) || !isset($_SESSION['pwd'])) {
    echo "Non sei connesso!";
    die;
} 
?>
    // TODO
    // STEP 1
    // recuperare l'utente loggato da $_SESSION['email']
    // fare query per recuperare la lista dei cinguettii dell'utente
    // fare query per recuperare la lista dei cinguettii degli utenti seguiti
    // ordinarli per data
    // fare un loop per stampare l'id e il tipo di cinguettio
    // STEP 2
    // per ogni id di cinguettio e tipo preleviamo le info dalla tabella relativa
    // e stampiamo il contenuto

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
        
    <?php    $email=$_SESSION[email];
    
    $sql= "SELECT DISTINCT u.email, c.id, l.nomeL
            FROM segue s, utente u, luogo l, cinguettio c
            WHERE (s.utenteCheSegue=$email AND s.utenteSeguito=u.email 
                AND c.email=u.email AND c.id=l.id)
            OR (s.utenteCheSegue=$email AND s.utenteCheSegue=u.email
                AND c.email=u.email AND c.id=l.id)	
            ORDER BY c.dataOraCreazione DESC";
    
        if ($result = mysqli_query($mysqli, $sql)) {
            printf("Select returned %d rows.\n", mysqli_num_rows($result));
            mysqli_free_result($result);
        }
    ?>
</body>

