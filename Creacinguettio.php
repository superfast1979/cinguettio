<?php
session_start();
require_once("database.php");
require_once("utility.php");

if (!isset($_SESSION['email']) || !isset($_SESSION['pwd'])) {
    echo "Non sei connesso!";
    die;
}

$email = $_SESSION['email'];
$br = "<br>";

function rimuovi_cinguettio($id, $error) {
    $sql = "DELETE FROM `cinguettio` WHERE id = '$id'";
    db_query($sql);
    header("location: Creacinguettio.php?crea=foto&upload_error=$error");
}

if (isset($_POST['crea'])) {

    $sqlIdProg = "SELECT MAX(idProg) AS maxIdProg FROM cinguettio WHERE email='$email'";
    $resultIdProg = db_query($sqlIdProg);
    $rowIdProg = mysqli_fetch_assoc($resultIdProg);
    $idProg = $rowIdProg['maxIdProg'] + 1;

    if (($_POST['crea'] == 'testo')) {
        $tipo = 't';
    } else if (($_POST['crea'] == 'luogo')) {
        $tipo = 'l';
    } else {
        $tipo = 'f';
    }

    $sql = "INSERT INTO `cinguettio` (`idProg`, `tipo`, `email`) "
            . "VALUES ('$idProg', '$tipo', '$email')";
    print($sql);

    if ($resultSql = db_query($sql)) {
        $id = db_insert_id();
    } else {
        $error = db_error();
        header("location: Creacinguettio.php?crea=foto&upload_error=$error");
    }

    if (($_POST['crea'] == 'testo')) {
        $testo = addslashes($_POST['testo']);
        $sqlTesto = "INSERT INTO testo (id, testo) VALUES ('$id', '$testo')";
        print($sqlTesto);
        if ($resultTesto = db_query($sqlTesto)) {
            header("location: Bacheca.php");
        } else {
            rimuovi_cinguettio($id, db_error());
        }
    }

    if (($_POST['crea'] == 'luogo')) {
        $nomeL = addslashes($_POST['nomeL']);
        $latitudine = addslashes($_POST['latitudine']);
        $longitudine = addslashes($_POST['longitudine']);
        $sqlLuogo = "INSERT INTO luogo (id, nomeL, latitudine, longitudine) "
                . "VALUES ('$id', '$nomeL', '$latitudine', '$longitudine')";
        if ($resultLuogo = db_query($sqlLuogo)) {
            header("location: Bacheca.php");
        } else {
            rimuovi_cinguettio($id, db_error());
        }
    }


    if (($_POST['crea'] == 'foto')) {
        /*
         *  http://www.w3schools.com/php/php_file_upload.asp 
         *  http://php.net/manual/en/features.file-upload.post-method.php
         */

        $target_dir = "foto/";
        $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
        $imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);

        $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
        if ($check === false) {
            rimuovi_cinguettio($id, "Il file non è una immagine oppure size superiore a 2 MBytes");
        }

        // Check if file already exists
        if (file_exists($target_file)) {
            rimuovi_cinguettio($id, "Il file esiste nella cartella di destinazione");
        }

        // Check file size: max 2MB
        if ($_FILES["fileToUpload"]["size"] > 2000000) {
            rimuovi_cinguettio($id, "size superiore a 2 MBytes");
        }

        if (!move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
            rimuovi_cinguettio($id, "errore nel caricamento file");
        }

        $nomeF = addslashes(basename($_FILES["fileToUpload"]["name"]));
        $path = addslashes($target_dir);
        $descrizione = addslashes($_POST['description']);
        $sqlFoto = "INSERT INTO foto (id, nomeF, path, descrizione, dataCaricamento) "
                . "VALUES ('$id', '$nomeF', '$path', '$descrizione', CURRENT_DATE())";
        print($sqlFoto);
        if ($resultFoto = db_query($sqlFoto)) {
            header("location: Bacheca.php");
        } else {
            rimuovi_cinguettio($id, db_error());
        }
    }
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
            <form action="Creacinguettio.php" method="post" enctype="multipart/form-data">
                <div class = "form-group text-center">
                    <label class = "text-center"> Stai scrivendo un cinguettio di tipo &nbsp;
                        <input type="radio" name="tipo" value="f" checked> &nbsp;Foto </label>
                </div>
                <div class = "form-group text-center">
                    <label for = "sfoglia" class = "control-label">Seleziona una immagine da caricare</label>
                    <center><input type="file" name="fileToUpload" id="fileToUpload"></center>
                </div>   
                <div class = "form-group text-center">
                    <label for = "inputTesto" class = "control-label">Descrizione</label>
                    <div class = "text-center">
                        <input type = "text" maxlength="20" name="description" class = "form-control" placeholder = "Scrivi qui...">
                    </div>
                </div>                
                <div class = "form-group">
                    <div class = "text-center">
                        <button type = "submit" name="crea" value="foto" class = "btn btn-primary">Crea</button>
                    </div>
                </div>
            </form>

            <?php
            if (isset($_GET['upload_error']) && isValidInput($_GET['upload_error'])) {
                ?>
                <p> <?php echo $_GET['upload_error']; ?> </p>
                <?php
            }
        }

        if ($_GET['crea'] == 'luogo') {
            ?>
            <form method="POST" action="Creacinguettio.php" class = "form-horizontal">
                <div class = "form-group text-center">
                    <label class = "text-center"> Stai scrivendo un cinguettio di tipo &nbsp;
                        <input type="radio" name="tipo" value="l" checked> &nbsp;Luogo </label>
                </div>
                <div class = "form-group">
                    <label for = "inputTesto" class = "col-sm-4 control-label">Nome del Luogo</label>
                    <div class = "col-sm-8">
                        <input type = "text" maxlength="20" name="nomeL" class = "form-control" placeholder = "Scrivi il nome del luogo qui...">
                    </div>
                </div>
                <div class = "form-group">
                    <label for = "inputTesto" class = "col-sm-4 control-label">Latitudine</label>
                    <div class = "col-sm-8">
                        <input type = "text" maxlength="20" name="latitudine" class = "form-control" placeholder = "Formato xx.yyyyyy">
                    </div>
                </div>
                <div class = "form-group">
                    <label for = "inputTesto" class = "col-sm-4 control-label">Longitudine</label>
                    <div class = "col-sm-8">
                        <input type = "text" maxlength="20" name="longitudine" class = "form-control" placeholder = "Formato xx.yyyyyy">
                    </div>
                </div>
                <div class = "form-group">
                    <div class = "col-sm-offset-6 col-sm-6">
                        <button type = "submit" name="crea" value="luogo" class = "btn btn-primary">Crea</button>
                    </div>
                </div>
            </form>
        <?php }
        ?>
    </div>
    <div class="col-md-4"></div>
</body>