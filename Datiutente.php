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
                <li><a href="Bacheca.php">Bacheca</a></li>
                <li class="active"><a href="Datiutente.php?email=<?php echo $_SESSION['email'] ?>">Dati Utente</a></li>
                <li><a href="Chiseguo.php">Chi Seguo</a></li> 
                <li><a href="Chimisegue.php">Chi Mi Segue</a></li> 
                <li><a href="Logout.php">Logout</a></li> 
            </ul>
        </div>
    </nav>

    <?php
    $email = $_GET['email'];
    $br = "<br>";

    $sql = "SELECT * FROM utente WHERE email='$email'";
    $sqlSeguaci = "SELECT COUNT(utenteCheSegue) AS NumSeguaci FROM segue WHERE utenteSeguito='$email'";
    $sqlSeguiti = "SELECT COUNT(utenteSeguito) AS NumSeguiti FROM segue WHERE utenteCheSegue='$email'";
    $sqlContaLuoghi = "SELECT COUNT(l.nomeL) AS contaLuoghi FROM luogo l, preferisce p WHERE p.email='$email' AND l.id=p.id";


    $sqlLuoghi = "SELECT l.nomeL, l.latitudine, l.longitudine FROM luogo l, preferisce p WHERE p.email='$email' AND l.id=p.id";
    $luoghi = array();
    if ($resultLuoghi = db_query($sqlLuoghi)) {
        while ($row = mysqli_fetch_assoc($resultLuoghi)) {
            array_push($luoghi, $row);
        }
        mysqli_free_result($resultLuoghi);
    } else {
        printf(db_error());
    }

    if ($resultContaLuoghi = db_query($sqlContaLuoghi)) {
        $rowContaLuoghi = mysqli_fetch_assoc($resultContaLuoghi);
        if ($rowContaLuoghi['contaLuoghi'] != 0) {
            $marginesterno = '<div class="col-md-2">';
            $margineinterno = '<div class="col-md-0">';
            $spaziotabelle = '<div class="col-md-4">';
        } else {
            $marginesterno = '<div class="col-md-4">';
            $margineinterno = '<div class="col-md-0">';
            $spaziotabelle = '<div class="col-md-4">';
        }
    }
    ?>
    <?php echo $marginesterno ?>
    </div>
    <?php echo $spaziotabelle ?>
    <?php
    if ($result = db_query($sql)) {
        echo "<center><table class=\"table\" <th><h2>Dati Utente</h2></th>";
        // output data of each row
        while ($row = $result->fetch_assoc()) {
            echo "<tr><td width='50%' align='right'>Nome</td><td>" . $row["nome"] . "</td></tr>"
            . "<tr><td width='50%' align='right'>Cognome</td><td>" . $row["cognome"] . "</td></tr> "
            . "<tr><td width='50%' align='right'>Nickname</td><td>" . $row["nickname"] . "</td></tr>"
            . "<tr><td width='50%' align='right'>Hobby</td><td>" . $row["hobby"] . "</td></tr>"
            . "<tr><td width='50%' align='right'>Data di Nascita</td><td>" . $row["dataNascita"] . "</td></tr>"
            . "<tr><td width='50%' align='right'>Sesso</td><td>" . $row["sesso"] . "</td></tr>"
            . "<tr><td width='50%' align='right'>Stato di Nascita</td><td>" . $row["statoN"] . "</td></tr>"
            . "<tr><td width='50%' align='right'>Regione di Nascita</td><td>" . $row["regioneN"] . "</td></tr>"
            . "<tr><td width='50%' align='right'>Citta' di Nascita</td><td>" . $row["cittaN"] . "</td></tr>"
            . "<tr><td width='50%' align='right'>Citta' di Residenza</td><td>" . $row["nomeC"] . "</td></tr>"
            . "<tr><td width='50%' align='right'>Esperto dal</td><td>" . $row["dataUpEsperto"] . "</td></tr>";
        }
    }
    if ($resultSeguiti = db_query($sqlSeguiti)) {
        while ($rowSeguiti = mysqli_fetch_assoc($resultSeguiti)) {
            echo "<tr><td width='50%' align='right'>Amici Seguiti</td><td>" . $rowSeguiti["NumSeguiti"] . "</td></tr>";
        }
    }
    if ($resultSeguaci = db_query($sqlSeguaci)) {
        while ($rowSeguaci = mysqli_fetch_assoc($resultSeguaci)) {
            echo "<tr><td width='50%' align='right'>Amici Che Seguono</td><td>" . $rowSeguaci["NumSeguaci"] . "</td></tr>";
        }
    }

    echo "</table>";

    if ($_SESSION['email'] == $_GET['email']) {
        ?><a href="Modificadatiutente.php"><button class="btn btn-primary btn-block">Modifica i tuoi dati</button></a><br><br><?php
        }
        ?>
    </div>
    <?php echo $margineinterno ?></div>
    <?php echo $spaziotabelle ?>
<?php
if ($resultContaLuoghi = db_query($sqlContaLuoghi)) {
    $rowContaLuoghi = mysqli_fetch_assoc($resultContaLuoghi);
    if ($rowContaLuoghi['contaLuoghi'] != 0) {
        ?>
                <center><table class="table" <th><h2>Luoghi Preferiti</h2></th>
                        <thead>
                            <tr>
                                <th>Luogo</th>
                                <th>Latitudine</th>
                                <th>Longitudine</th>
                            </tr>
                        </thead>
        <?php
        for ($i = 0; $i < count($luoghi); $i++) {
            echo "<tr><td>" . $luoghi[$i]['nomeL'] . "</td>"
            . "<td>" . $luoghi[$i]['latitudine'] . "</td> "
            . "<td>" . $luoghi[$i]['longitudine'] . "</td></tr>";
        }
        ?>
                    </table>
                    <?php }
                }
                ?>

    </div>
    <?php echo $marginesterno ?></div>
    <br><br><br>
</body>

