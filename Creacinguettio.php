<?php
session_start();
require_once("database.php");
if (!isset($_SESSION['email']) || !isset($_SESSION['pwd'])) {
    echo "Non sei connesso!";
    die;
}

$email = $_SESSION['email'];
$br = "<br>";

if (isset($_POST['crea'])) {
    //$dataOraCreazione = CURRENT_TIMESTAMP();
//    $sqlId = "SELECT MAX(id) AS maxId FROM cinguettio";
//    $resultId = db_query($sqlId);
//    $rowId = mysqli_fetch_assoc($resultId);
//    $id = $rowId['maxId'] + 1;

    $sqlIdProg = "SELECT MAX(idProg) AS maxIdProg FROM cinguettio WHERE email='$email'";
    $resultIdProg = db_query($sqlIdProg);
    $rowIdProg = mysqli_fetch_assoc($resultIdProg);
    $idProg = $rowIdProg['maxIdProg'] + 1;

    if (($_POST['crea'] == 'testo')) {
        $tipo = 't';
        $testo = addslashes($_POST['testo']);

        $sql = "INSERT INTO `cinguettio` (`idProg`, `tipo`, `email`) "
                . "VALUES ('$idProg', '$tipo', '$email')";
        print($sql);
        if ($resultSql = db_query($sql)) {
            $id = db_insert_id();
            $sqlTesto = "INSERT INTO testo (id, testo) VALUES ('$id', '$testo')";
            print($sqlTesto);
            if ($resultTesto = db_query($sqlTesto)) {
                header("location: Bacheca.php");
            } else {
                $errore = db_error();
            }
        } else {
            $errore = db_error();
        }
    }

    /*  if(($_POST['creazione']=='luogo')){
      $nomeL= addslashes($_POST['nomeL']);
      $latitudine= addslashes($_POST['latitudine']);
      $longitudine= addslashes($_POST['longitudine']);
      $sqlLuogo="INSERT INTO luogo (id, nomeL, latitudine, longitudine) "
      . "VALUES ('$id', '$nomeL', '$latitudine', '$longitudine')";
      if($resultLuogo=db_query($sqlLuogo)){
      header("location: Bacheca.php");
      } else {
      $errore = db_error();
      }
      }

      if(($_POST['creazione']=='foto')){
      $nomeF= addslashes($_POST['nomeF']);
      $path= addslashes($_POST['path']);
      $descrizione= addslashes($_POST['descrizione']);
      $dataCaricamento= CURRENT_DATE();
      $sqlFoto="INSERT INTO foto (id, nomeF, path, descrizione, dataCaricamento) "
      . "VALUES ('$id', '$nomeF', '$path', '$descrizione', '$dataCaricamento')";
      if($resultFoto=db_query($sqlFoto)){
      header("location: Bacheca.php");
      } else {
      $errore = db_error();
      }
      } */
}

$_SESSION['title'] = "Creazione Cinguettio";
include("head.php");
?>

<body>
    <nav class="navbar navbar-default navbar-fixed-top">
        <div class="container-fluid">
            <div class="navbar-header">
                <a class="navbar-brand"><img src="cinguettio logo-04.png" class="img-responsive"  alt="Responsive image" padding-top= "-10px" width="30px" height="30px"></a>
            </div>
            <ul class="nav navbar-nav">
                <li  class="active"><a href="Bacheca.php">Bacheca</a></li>
                <li><a href="Datiutente.php?email=<?php echo $_SESSION['email'] ?>">Dati Utente</a></li>
                <li><a href="Chiseguo.php">Chi Seguo</a></li> 
                <li><a href="Chimisegue.php">Chi Mi Segue</a></li> 
                <li><a href="Logout.php">Logout</a></li> 
            </ul>
        </div>
    </nav>

    <div class="col-md-4"></div>
    <div class="col-md-4">
<?php if ($_GET['crea'] == 'testo') { ?>
            <form method="POST" action="Creacinguettio.php" class = "form-horizontal">
                <div class = "form-group text-center">
                    <label class = "text-center"> Stai scrivendo un cinguettio di tipo &nbsp;
                        <input type="radio" name="tipo" value="t" checked> &nbsp;Testo </label>
                </div>
                <div class = "form-group">
                    <label for = "inputTesto" class = "col-sm-2 control-label">Testo</label>
                    <div class = "col-sm-10">
                        <input type = "text" maxlength="50" name="testo" class = "form-control" placeholder = "Scrivi qui...">
                    </div>
                </div>
                <div class = "form-group">
                    <div class = "col-sm-offset-6 col-sm-6">
                        <button type = "submit" name="crea" value="testo" class = "btn btn-primary">Crea</button>
                    </div>
                </div>
            </form>
    <?php
}

if ($_GET['crea'] == 'foto') {
    ?>

            <?php
        }

        if ($_GET['crea'] == 'luogo') {
            ?>

        <?php }
        ?>
    </div>
    <div class="col-md-4"></div>
</body>