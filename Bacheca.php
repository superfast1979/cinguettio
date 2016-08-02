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
 (SELECT DISTINCT u.email, c.dataOraCreazione, l.nomeL AS stringaDaStampare, c.tipo
 FROM segue s, utente u, luogo l, cinguettio c 
 WHERE (s.utenteCheSegue='$email' AND s.utenteSeguito=u.email AND c.email=u.email AND  c.id=l.id) 
  OR (s.utenteCheSegue='$email' AND s.utenteCheSegue=u.email AND c.email=u.email AND c.id=l.id)
 UNION
 SELECT DISTINCT u.email, c.dataOraCreazione, t.testo AS stringaDaStampare, c.tipo
 FROM segue s, utente u, testo t, cinguettio c
 WHERE (s.utenteCheSegue='$email' AND s.utenteSeguito=u.email AND c.email=u.email AND c.id=t.id) 
  OR (s.utenteCheSegue='$email' AND s.utenteCheSegue=u.email AND c.email=u.email AND c.id=t.id)
    UNION
    SELECT DISTINCT u.email, c.dataOraCreazione, CONCAT(f.path,' ',f.nomeF,' ',f.descrizione) AS stringaDaStampare, c.tipo
 FROM segue s, utente u, foto f, cinguettio c 
 WHERE (s.utenteCheSegue='$email' AND s.utenteSeguito=u.email AND c.email=u.email AND c.id=f.id) 
  OR (s.utenteCheSegue='$email' AND s.utenteCheSegue=u.email AND c.email=u.email AND c.id=f.id)) AS t
 ORDER BY 2 DESC";


$cinguettii = array();
if ($result = db_query($sql)) {
//    printf("$br Select returned %d rows.\n", mysqli_num_rows($result));
    while ($row = mysqli_fetch_assoc($result)) {
        array_push($cinguettii, $row);
//        printf("$br %s %s %s", $row['email'], $row['dataOraCreazione'], $row['stringaDaStampare']);
    }
    mysqli_free_result($result);
} else {
    printf(db_error());
}


if(($_GET['segnala'])==true){
    $idSeg=$_GET['id'];
    $utenteSeg=$_GET['email'];
    $sqlSegnala= "INSERT INTO segnalainappropriato (id, email) VALUES ('$idSeg','$email')";
    $resultSeg=db_query($sqlSegnala);
}
// TODO
// STEP 1
// recuperare l'utente loggato da $_SESSION['email'] OK
// fare query per recuperare la lista dei cinguettii dell'utente
// fare query per recuperare la lista dei cinguettii degli utenti seguiti
// ordinarli per data
// fare un loop per stampare l'id e il tipo di cinguettio
// $results = db_query("SELECT ---- ");
// STEP 2
// per ogni id di cinguettio e tipo preleviamo le info dalla tabella relativa
// e stampiamo il contenuto
?>


<?php
$_SESSION['title'] = "Bacheca";
include("head.php");
?>
<body>
    <?php /*
     * <ul>
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
     */
    ?>
    <nav class="navbar navbar-default navbar-fixed-top">
        <div class="container-fluid">
            <div class="navbar-header">
                <a class="navbar-brand"><img src="cinguettio logo-04.png" class="img-responsive"  alt="Responsive image" padding-top= "-10px" width="30px" height="30px"></a>
            </div>
            <ul class="nav navbar-nav">
                <li class="active"><a href="Bacheca.php" class='active'>Bacheca</a></li>
                <li><a href="Datiutente.php?email=<?php echo $email ?>">Dati Utente</a></a></li>
                <li><a href="Chiseguo.php">Chi Seguo</a></li> 
                <li><a href="Chimisegue.html">Chi Mi Segue</a></li> 
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
                        <?php echo $cinguettii[$i]['stringaDaStampare']; ?>
                        <?php if ($tipo == 'Testo') { ?>
                            <div class="btn-group pull-right">
                                <button href="Bacheca.php?segnala=true&id=<?php echo $cinguettii[$i]['id']; ?>&utente=<?php echo $cinguettii[$i]['email']; ?>"
                                        type="button" class="btn btn-danger">Inappropriato &nbsp; 
                                    <span class="glyphicon glyphicon-thumbs-down " aria-hidden="true"></span></button>
                                <button type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <span class="caret"></span>
                                    <span class="sr-only">Toggle Dropdown</span>
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a href="#">Action</a></li>
                                    <li><a href="#">Another action</a></li>
                                    <li><a href="#">Something else here</a></li>
                                    <li role="separator" class="divider"></li>
                                    <li><a href="#">Separated link</a></li>
                                </ul>
                            </div> 
                        <?php } ?>
                        <?php if ($tipo == "Foto") { ?>
                            <div class="btn-group pull-right">
                                <button href="Bacheca.php?apprezza=true&utente=<?php echo $cinguettii[$i]['email']; ?>"
                                        type="button" class="btn btn-primary">Apprezza &nbsp; 
                                    <span class="glyphicon glyphicon-heart-empty" aria-hidden="true"></span></button>
                                <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <span class="caret"></span>
                                    <span class="sr-only">Toggle Dropdown</span>
                                </button>
                                <ul class="dropdown-menu">
                                    <li>Action</li>
                                    <li role="separator" class="divider"></li>
                                    <li>Separated link</li>
                                </ul>
                            </div> 
                        <?php } ?>
                        <?php if ($tipo == "Luogo") { ?>
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

</body>

