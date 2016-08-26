<?php
session_start();
require_once("database.php");
if (!isset($_SESSION['email']) || !isset($_SESSION['pwd'])) {
    echo "Non sei connesso!";
    die;
}

$email = $_SESSION['email'];
$idFotoStampa = $_GET['idCinguettio'];
$error = "";

$sqlEmail = "SELECT email, dataOraCreazione FROM cinguettio WHERE id='$idFotoStampa'";
if ($resultEmail = db_query($sqlEmail)) {
    $rowEmail = mysqli_fetch_assoc($resultEmail);
}

$sqlStampaFoto = "SELECT descrizione, CONCAT(path,nomeF) AS RelPath FROM foto WHERE id='$idFotoStampa'";
if ($resultStampaFoto = db_query($sqlStampaFoto)) {
    $rowStampaFoto = mysqli_fetch_assoc($resultStampaFoto);
}

$sqlApprezzamenti = "SELECT commento, email, dataOraC FROM apprezzamento WHERE id='$idFotoStampa'";
$apprezzamenti = array();
if ($resultApprezzamenti = db_query($sqlApprezzamenti)) {
    while ($rowApprezzamenti = mysqli_fetch_assoc($resultApprezzamenti)) {
        array_push($apprezzamenti, $rowApprezzamenti);
    }
    mysqli_free_result($resultApprezzamenti);
} else {
    printf(db_error());
}
?>

<?php
$_SESSION['title'] = "Commenti";
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
                
    <div class="row">
        <div class="col-md-4"></div>
        <div class="col-md-4">
            <div class="panel-foto text-center">
                <div class="panel-heading ">[F]&nbsp;<a href="Datiutente.php?email=<?php echo $rowEmail['email'] ?>"><?php echo $rowEmail['email'] ?></a>&nbsp;<?php echo $rowEmail['dataOraCreazione']; ?></div>
                <div class="panel-body">
                    <?php echo $rowStampaFoto['descrizione'] ?> <br>
                    <img src="<?php echo $rowStampaFoto['RelPath'] ?>" align="center">
                </div>
            </div>
            <?php
            for ($i = 0; $i < count($apprezzamenti); $i++) {
                ?>
                <div class="panel-foto text-center">
                    <div class="panel-heading"><a href="Datiutente.php?email=<?php echo $apprezzamenti[$i]['email'] ?>"><?php echo $apprezzamenti[$i]['email'] ?></a>&nbsp;<?php echo $apprezzamenti[$i]['dataOraC']; ?></div>
                    <div class="panel-body">
                        <?php echo $apprezzamenti[$i]['commento'] ?>
                    </div>
                </div>
                <?php } ?>
        </div>
        <div class="col-md-4"></div>
    </div>
</body>

