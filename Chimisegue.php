<?php
session_start();
require_once("database.php");
if (!isset($_SESSION['email']) || !isset($_SESSION['pwd'])) {
    echo "Non sei connesso!";
    die;
}

$email = $_SESSION['email'];
$br = "<br>";

$sql = "SELECT u.email, u.nome, u.cognome, u.sesso,u.hobby, u.dataNascita, u.nickname, u.nomeC  FROM segue s, utente u "
        . "WHERE u.email=s.utenteCheSegue AND s.utenteSeguito='$email'";

$dati = array();
if ($result = db_query($sql)) {
    while ($row = mysqli_fetch_assoc($result)) {
        array_push($dati, $row);
    }
    mysqli_free_result($result);
} else {
    printf(db_error());
}

$_SESSION['title'] = "Chi Mi Segue";
include("head.php");
?>
<body>
    <nav class="navbar navbar-default navbar-fixed-top">
        <div class="container-fluid">
            <div class="navbar-header">
                <a class="navbar-brand"><img src="cinguettio logo-04.png" class="img-responsive"  alt="Responsive image" padding-top= "-10px" width="30px" height="30px"></a>
            </div>
            <ul class="nav navbar-nav">
                <li><a href="Bacheca.php">Bacheca</a></li>
                <li><a href="Datiutente.php?email=<?php echo $_SESSION['email'] ?>">Dati Utente</a></li>
                <li><a href="Chiseguo.php">Chi Seguo</a></li> 
                <li class="active"><a href="Chimisegue.php">Chi Mi Segue</a></li> 
                <li><a href="Logout.php">Logout</a></li> 
            </ul>
        </div>
    </nav>


    <?php
    echo "<center><table class=\"table\" <th><h2>Chi mi Segue</h2></th>";
    for ($i = 0; $i < count($dati); $i++) {
        echo "<tr><td>Nome: &nbsp; </td><td>" . $dati[$i]['nome'] . "</td>"
        . "<td>Cognome: &nbsp;</td><td>" . $dati[$i]['cognome'] . "</td> "
        . "<td>Email: &nbsp;</td><td>" . $dati[$i]['email'] . "</td> "
        . "<td>Nickname: &nbsp;</td><td>" . $dati[$i]['nickname'] . "</td>"
        . "<td>Hobby: &nbsp;</td><td>" . $dati[$i]['hobby'] . "</td>"
        . "<td>Data di Nascita: </td><td>" . $dati[$i]['dataNascita'] . "</td>"
        . "<td>Sesso: &nbsp;</td><td>" . $dati[$i]['sesso'] . "</td>"
        . "<td>Citta' di Residenza: </td><td>" . $dati[$i]['nomeC'] . "</td></tr>";
    }
    echo "</table>";
    ?>
</body>
