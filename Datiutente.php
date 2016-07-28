<?php
session_start();
require_once("database.php");
if (!isset($_SESSION['email']) || !isset($_SESSION['pwd'])) {
    echo "Non sei connesso!";
    die;
}

$_SESSION['title'] = "Dati Utente";
include("head.php");
?>
<body>
    <nav class="navbar navbar-default navbar-fixed-top">
        <div class="container-fluid">
            <div class="navbar-header">
                <a class="navbar-brand"><img src="cinguettio logo-04.png" class="img-responsive"  alt="Responsive image" padding-top= "-10px" width="30px" height="30px"></a>
            </div>
            <ul class="nav navbar-nav">
                <li><a href="Bacheca.php" class='active'>Bacheca</a></li>
                <li class="active"><a href="Datiutente.php">Dati Utente</a></li>
                <li><a href="Chiseguo.php">Chi Seguo</a></li> 
                <li><a href="Chimisegue.html">Chi Mi Segue</a></li> 
                <li><a href="Logout.php">Logout</a></li> 
            </ul>
        </div>
    </nav>
    
    <?php
    $email = $_SESSION['email'];
    $br = "<br>";

    $sql = "SELECT * FROM utente WHERE email='$email'";

    if ($result = db_query($sql)) {
        echo "<center><table class=\"table\" <th>Dati Utente</th>";
        // output data of each row
        while ($row = $result->fetch_assoc()) {
            echo "<tr><td>Nome</td><td>" . $row["nome"] . "</td></tr>"
                    . "<tr><td>Cognome</td><td>" . $row["cognome"] . "</td></tr> "
                    . "<tr><td>Nickname</td><td>" . $row["nickname"] . "</td></tr>"
                    . "<tr><td>Hobby</td><td>" . $row["hobby"] . "</td></tr>"
                    . "<tr><td>Data di Nascita</td><td>" . $row["dataNascita"] . "</td></tr>"
                    . "<tr><td>Sesso</td><td>" . $row["sesso"] . "</td></tr>"
                    . "<tr><td>Stato di Nascita</td><td>" . $row["statoN"] . "</td></tr>"
                    . "<tr><td>Regione di Nascita</td><td>" . $row["regioneN"] . "</td></tr>"
                    . "<tr><td>Citta' di Nascita</td><td>" . $row["cittaN"] . "</td></tr>"
                    . "<tr><td>Citta' di Residenza</td><td>" . $row["nomeC"] . "</td></tr>";
        }
        echo "</table>";
    } else {
        echo "0 results";
    }
    ?>
    
    <a href="Modificadatiutente.php">Modifica i tuoi dati</a>
</body>

