<?php
session_start();
require_once("database.php");
if (!isset($_SESSION['email']) || !isset($_SESSION['pwd'])) {
    echo "Non sei connesso!";
    die;
}

$email = $_SESSION['email'];
$br = "<br>";
$panel = "panel panel-default";

$_SESSION['title'] = "Chi Seguo";
include("head.php");

function isValidInput($str) {
    return (isset($str) && $str != "");
}

if (isset($_POST['cerca'])) {

    $nomeSql = "SELECT email FROM utente WHERE ";
    $nomeSql .= "email NOT IN ";
    $nomeSql .= "(SELECT u.email FROM segue s, utente u WHERE (s.utenteCheSegue = '$email' AND s.utenteSeguito = u.email) OR";
    $nomeSql .= "(s.utenteCheSegue = '$email' AND s.utenteCheSegue = u.email))";
    $whereClause = "";

    if (isValidInput($_POST['nome'])) {
        $nome = addslashes($_POST['nome']);
        $whereClause = " AND nome='$nome'";
    }

    if (isValidInput($_POST['hobby'])) {
        $hobby = addslashes($_POST['hobby']);
        $whereClause .= " AND hobby='$hobby'";
    }

    if (isValidInput($_POST['eta'])) {
        $eta = addslashes($_POST['eta']);
        $whereClause .= "AND YEAR(dataNascita) = (YEAR(CURDATE()) - '$eta')";
    }

    if (isset($_POST['sesso'])) {
        $sesso = addslashes($_POST['sesso']);
        $whereClause .= " AND sesso='$sesso'";
    }

    if (isValidInput($_POST['nomeC'])) {
        $nomeC = addslashes($_POST['nomeC']);
        $whereClause .= " AND nomeC='$nomeC'";
    }

    $sqlCerca = $nomeSql . $whereClause;

//    $sqlCerca = "SELECT nome, cognome, dataNascita, sesso, email, hobby FROM utente WHERE "
//            . "nome='$nome' OR hobby='$hobby' OR cast(dataNascita AS DATE)='(CURRENT_DATE - cast($eta as DATE)' OR sesso='$sesso' OR nomeC='$nomeC'";

    $seguibili = array();
    if ($resultCerca = db_query($sqlCerca)) {
        while ($row = mysqli_fetch_assoc($resultCerca)) {
            array_push($seguibili, $row);
        }
        mysqli_free_result($resultCerca);
    } else {
        printf(db_error());
    }
    // creare una select degli utenti con le opzioni di ricerca, se presenti.
    // inizializzare un array associativo per valorizzare la lista di utenti
    // nel panel della ricerca con icona aggiuni
}

if (isset($_GET['aggiungi'])) {

    $utenteAggiunto = $_GET['utente'];
    $utenteCheAggiunge = $_SESSION['email'];

    $sqlAggiungi = "INSERT INTO segue (utenteSeguito, utenteCheSegue) "
            . "VALUES('$utenteAggiunto','$utenteCheAggiunge')";
    if ($result = db_query($sqlAggiungi)) {
        $sqlVerificaEsperto="UPDATE utente SET dataUpEsperto=CURRENT_DATE()"
                . "WHERE email='$utenteAggiunto'"
                . "AND 3<=(SELECT COUNT(utenteCheSegue) FROM segue "
                . "WHERE utenteSeguito='$utenteAggiunto')";
        $result=db_query($sqlVerificaEsperto);
        header("location: ChiSeguo.php?amico=aggiunto");
    } else {
        $errore = db_error();
    }


// fare update DB per aggiunta associazione $_GET['utente'] negli utenti seguiti da $email
}

if (isset($_GET['elimina'])) {

    $utenteEliminato = $_GET['utente'];
    $utenteCheElimina = $_SESSION['email'];

    $sqlRimuovi = "DELETE FROM segue WHERE utenteCheSegue='$utenteCheElimina' 
        AND utenteSeguito='$utenteEliminato'";

    if ($result = db_query($sqlRimuovi)) {
        $sqlVerificaNonEsperto="UPDATE utente SET dataUpEsperto=NULL"
                . "WHERE email='$utenteEliminato'"
                . "AND 3>(SELECT COUNT(utenteCheSegue) FROM segue "
                . "WHERE utenteSeguito='$utenteEliminato')";
        $result=db_query($sqlVerificaNonEsperto);
        header("location: ChiSeguo.php?amico=rimosso");
    } else {
        $errore = db_error();
    }

    // fare update DB per rimozione $_GET['utente'] dagli utenti seguiti da $email
}


$sql = "SELECT utenteSeguito FROM segue WHERE utenteCheSegue='$email'";
$seguiti = array();
if ($result = db_query($sql)) {
//    printf("$br Select returned %d rows.\n", mysqli_num_rows($result));
    while ($row = mysqli_fetch_assoc($result)) {
        array_push($seguiti, $row);
//        printf("$br %s %s %s", $row['email'], $row['dataOraCreazione'], $row['stringaDaStampare']);
    }
    mysqli_free_result($result);
} else {
    printf(db_error());
}
?>

<body>
    <nav class="navbar navbar-default navbar-fixed-top">
        <div class="container-fluid">
            <div class="navbar-header">
                <a class="navbar-brand"><img src="cinguettio logo-04.png" class="img-responsive"  alt="Responsive image" padding-top= "-10px" width="30px" height="30px"></a>
            </div>
            <ul class="nav navbar-nav">
                <li><a href="Bacheca.php">Bacheca</a></li>
                <li><a href="Datiutente.php?email=<?php echo $email ?>">Dati Utente</a></a></li>
                <li class="active"><a href="Chiseguo.php">Chi Seguo</a></li> 
                <li><a href="Chimisegue.php">Chi Mi Segue</a></li> 
                <li><a href="Logout.php">Logout</a></li> 
            </ul>
        </div>
    </nav>

    <div class = "row">
        <div class="col-md-1"></div>
        <div class="col-md-3">
            <?php
            for ($i = 0; $i < count($seguiti); $i++) {
                ?>
                <div class="<?php echo $panel; ?>">
                    <div class="panel-chiseguo">
                        <?php echo $seguiti[$i]['utenteSeguito'] ?>
                        <a href="Chiseguo.php?elimina=true&utente=<?php echo $seguiti[$i]['utenteSeguito']; ?>">
                            &nbsp; <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                        </a>
                    </div>
                </div>
                <?php
            }
            ?>
        </div>
        <div class="col-md-1"></div>
        <div class = "col-md-6">
            <div class="<?php echo $panel; ?>">
                <div class="panel-chiseguo">
                    <form class="form-horizontal" method="post" action="Chiseguo.php">
                        <div class="form-group">
                            <label for="inputNome3" class="col-sm-2 control-label">Nome</label>
                            <div class="col-sm-10">
                                <input type="text" name="nome" class="form-control" id="inputNome3" placeholder="es. Luca">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputEta3" class="col-sm-2 control-label">Eta'</label>
                            <div class="col-sm-10">
                                <input type="text" name="eta" class="form-control" id="inputEta3" placeholder="es. 22">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputNomeC3" class="col-sm-2 control-label">Citta' di Residenza</label>
                            <div class="col-sm-10">
                                <input type="text" name="nomeC" class="form-control" id="inputNomeC3" placeholder="es. Milano">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputHobby3" class="col-sm-2 control-label">Hobby</label>
                            <div class="col-sm-10">
                                <input type="text" name="hobby" class="form-control" id="inputHobby3" placeholder="es. calcio">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputSesso3" class="col-sm-2 control-label">Sesso</label>
                            <div class="col-sm-10">
                                <input type="radio" name="sesso" id="optionsRadios1" value="M"> M
                                <input type="radio" name="sesso" id="optionsRadios2" value="F"> F
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <button type="submit" name="cerca" class="btn btn-cerca btn-block">Cerca</button>
                            </div>
                        </div>
                    </form>
                </div>
                <br>
                <?php
                if (isset($_POST['cerca'])) {
                    for ($i = 0; $i < count($seguibili); $i++) {
                        ?>
                        <div class="<?php echo $panel; ?>">
                            <div class="panel-chiseguo">
                                <?php echo $seguibili[$i]['email'] ?>
                                <a href="Chiseguo.php?aggiungi=true&utente=<?php echo $seguibili[$i]['email']; ?>">
                                    &nbsp; <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                                </a>
                            </div>
                        </div>
                        <?php
                    }
                }
                ?>                
            </div>
        </div>
        <div class="col-md-1"></div>
    </div>
    <p align="center"><?php
        if (isset($_GET['amico'])) {
            if ($_GET['amico'] == "aggiunto") {
                echo "Amico aggiunto";
            } else {
                echo "Amico rimosso";
            }
        }
        ?>
    </p>

</body>