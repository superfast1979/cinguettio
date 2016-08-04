<?php
session_start();
require_once("database.php");
if (!isset($_SESSION['email']) || !isset($_SESSION['pwd'])) {
    echo "Non sei connesso!";
    die;
}

$email = $_SESSION['email'];
$br = "<br>";
$sql = "SELECT * FROM
 (SELECT DISTINCT u.email, c.dataOraCreazione, l.nomeL AS stringaDaStampare, c.tipo, c.id
 FROM segue s, utente u, luogo l, cinguettio c 
 WHERE (s.utenteCheSegue='$email' AND s.utenteSeguito=u.email AND c.email=u.email AND  c.id=l.id) 
  OR (s.utenteCheSegue='$email' AND s.utenteCheSegue=u.email AND c.email=u.email AND c.id=l.id)
 UNION
 SELECT DISTINCT u.email, c.dataOraCreazione, t.testo AS stringaDaStampare, c.tipo, c.id
 FROM segue s, utente u, testo t, cinguettio c
 WHERE (s.utenteCheSegue='$email' AND s.utenteSeguito=u.email AND c.email=u.email AND c.id=t.id) 
  OR (s.utenteCheSegue='$email' AND s.utenteCheSegue=u.email AND c.email=u.email AND c.id=t.id)
    UNION
    SELECT DISTINCT u.email, c.dataOraCreazione, CONCAT(f.path,' ',f.nomeF,' ',f.descrizione) AS stringaDaStampare, c.tipo, c.id
 FROM segue s, utente u, foto f, cinguettio c 
 WHERE (s.utenteCheSegue='$email' AND s.utenteSeguito=u.email AND c.email=u.email AND c.id=f.id) 
  OR (s.utenteCheSegue='$email' AND s.utenteCheSegue=u.email AND c.email=u.email AND c.id=f.id)) AS t
 ORDER BY 2 DESC";

$cinguettii = array();
if ($result = db_query($sql)) {
    while ($row = mysqli_fetch_assoc($result)) {
        array_push($cinguettii, $row);
    }
    mysqli_free_result($result);
} else {
    printf(db_error());
}



$error = "";

if (isset($_GET['segnala']) && ($_GET['segnala'] == true)) {
    $idSeg = $_GET['id'];
    $sqlSegnala = "INSERT INTO segnalainappropriato (id, email) VALUES ('$idSeg','$email')";
    $resultSeg = db_query($sqlSegnala);
    $error = db_error();
}

if (isset($_GET['preferito']) && ($_GET['preferito'] == true)) {
    $idPref = $_GET['id'];
    $sqlPref = "INSERT INTO preferisce (id, email) VALUES ('$idSeg','$email')";
    $resultPref = db_query($sqlPref);
    $error = db_error();
}

if (isset($_GET['apprezza']) && ($_GET['apprezza'] == true)) {
    $idApp = $_GET['id'];
    $sqlApp = "INSERT INTO apprezza (id, email) VALUES ('$idSeg','$email')";
    $resultApp = db_query($sqlApp);
    $error = db_error();
//mancano un bel po' di cose
}

$segnalanti = array();
$contaSegnalanti = array();
if (isset($_GET['inappropriato']) && ($_GET['inappropriato'] == true)) {
    print("inappropriato");
    $sqlListaSeg = "SELECT email FROM segnalainappropriato";
    if ($resultListaSeg = db_query($sqlListaSeg)) {
        while ($row = mysqli_fetch_assoc($resultListaSeg)) {
            array_push($segnalanti, $row);
        }
        mysqli_free_result($resultListaSeg);
    } else {
        printf(db_error());
    }
    $sqlNumSeg = "SELECT COUNT(email) AS Segnalanti FROM segnalainappropriato";
    if ($resultNumSeg = db_query($sqlNumSeg)) {
        while ($row = $resultNumSeg->fetch_assoc()) {
            array_push($contaSegnalanti, $row);
        }
        mysqli_free_result($resultNumSeg);
    } else {
        printf(db_error());
    }
}
?>

<?php
$_SESSION['title'] = "Bacheca";
include("head.php");
?>
<body>
    <nav class="navbar navbar-default navbar-fixed-top">
        <div class="container-fluid">
            <div class="navbar-header">
                <a class="navbar-brand"><img src="cinguettio logo-04.png" class="img-responsive"  alt="Responsive image" padding-top= "-10px" width="30px" height="30px"></a>
            </div>
            <ul class="nav navbar-nav">
                <li class="active"><a href="Bacheca.php" class='active'>Bacheca</a></li>
                <li><a href="Datiutente.php?email=<?php echo $email ?>">Dati Utente</a></a></li>
                <li><a href="Chiseguo.php">Chi Seguo</a></li> 
                <li><a href="Chimisegue.php">Chi Mi Segue</a></li> 
                <li><a href="Logout.php">Logout</a></li> 
            </ul>
        </div>
    </nav>

    <?php
    for ($i = 0; $i < count($cinguettii); $i++) {
        ?>
        <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-8">
                <?php
                $panel = "panel panel-primary";
                if ($cinguettii[$i]['tipo'] == 'f') {
                    $panel = "panel panel-foto";
                    $tipo = 'Foto';
                }
                if ($cinguettii[$i]['tipo'] == 't') {
                    $panel = "panel panel-testo";
                    $tipo = 'Testo';
                }
                if ($cinguettii[$i]['tipo'] == 'l') {
                    $panel = "panel panel-luogo";
                    $tipo = 'Luogo';
                }
                ?>               
                <div class="<?php echo $panel; ?>">
                    <div class="panel-heading">[<?php echo $tipo ?>]&nbsp;<a href="Datiutente.php?email=<?php echo $cinguettii[$i]['email'] ?>"><?php echo $cinguettii[$i]['email'] ?></a>&nbsp;<?php echo $cinguettii[$i]['dataOraCreazione']; ?></div>
                    <div class="panel-body">
                        <?php if ($tipo == 'Testo') { 
                            echo $cinguettii[$i]['stringaDaStampare'];                            
                            ?>
                            <div class="post_testo pull-right">
                                <input type="hidden" name="idCinguettio" id="idCinguettio" value="<?php echo $cinguettii[$i]['id']; ?>">
                                <button id="bottone" type="button" class="btn btn-danger">Lista Segnalanti&nbsp; &nbsp; &nbsp; &nbsp; 
                                </button>
                                <div class="post_div_testo" id="risultato" style="display: none;"></div>
                            </div> 

                            <div class="btn-group pull-right">
                                <a href="Bacheca.php?segnala=true&id=<?php echo $cinguettii[$i]['id']; ?>"
                                   <button type="button" class="btn btn-danger">&nbsp; 
                                        <span class="glyphicon glyphicon-thumbs-down " aria-hidden="true"></span>
                                        &nbsp; 
                                    </button>
                                </a>
                            </div>
                        <?php } ?>
                        <?php if ($tipo == "Foto") { 
                             ?>
                            <a href="Apprezza.php?idCinguettio=<?php echo $cinguettii[$i]['id'];?>"><?php echo $cinguettii[$i]['stringaDaStampare'];?></a>
                            <div class="post_foto pull-right">
                                <button type="button" class="btn btn-primary">Apprezza 
                                    <span class="glyphicon glyphicon-heart-empty " aria-hidden="true"></span>
                                </button>
                                <div class="post_div_foto" style="display: none;">
                                    <form method="GET" action="Apprezza.php">
                                        <input type="hidden" name="idCinguettio" value="<?php echo $cinguettii[$i]['id']; ?>"/>
                                        <textarea maxlength="50"></textarea><br>
                                        <input type="submit" value="Conferma">
                                        <input type="reset" value="Azzera">
                                    </form>
                                </div>
                            </div>
                        <?php } ?>
                        <?php if ($tipo == "Luogo") { 
                            echo $cinguettii[$i]['stringaDaStampare'];
                            ?>
                            <div class="btn-group pull-right">
                                <button href="Bacheca.php?preferito=true&utente=<?php echo $cinguettii[$i]['email']; ?>"
                                        type="button" class="btn btn-success">Preferito &nbsp; 
                                    <span class="glyphicon glyphicon-pushpin" aria-hidden="true"></span></button>
                                <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <span class="caret"></span>
                                    <span class="sr-only">Toggle Dropdown</span>
                                </button>
                                <ul class="dropdown-menu">
                                    <li>A</li>
                                    <li role="separator" class="divider"></li>
                                    <li>Separated link</li>
                                </ul>
                            </div> 
                        <?php } ?>
                    </div>
                </div>
            </div>
            <div class="col-md-2"></div>
        </div>
        <?php
    }
    ?>
    <p><?php echo $error; ?></p>
    <script type="text/javascript">
        $(document).ready(function () {

            $(".post_testo").click(function () {
                var idCinguettio = $(this).find("input").val();
                $.ajax({
                    type: "POST",
                    url: "Inappropriato.php",
                    data: "id=" + idCinguettio + "&inappropriato=true",
                    dataType: "html",
                    context: this,
                    success: function (msg)
                    {
                        $(this).find(".post_div_testo").html(msg).toggle(1000);
                    },
                    error: function ()
                    {
                        alert("Chiamata fallita, si prega di riprovare...");
                    }
                });
            });

            $(".post_foto").click(function () {
                $(this).find(".post_div_foto").show(1000);
            });

        });
    </script>
</body>

