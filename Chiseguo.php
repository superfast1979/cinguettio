<?php
session_start();
require_once("database.php");
if (!isset($_SESSION['email']) || !isset($_SESSION['pwd'])) {
    echo "Non sei connesso!";
    die;
}

$email = $_SESSION['email'];
$br = "<br>";
$panel = "panel panel-foto";

$_SESSION['title'] = "Chi Seguo";
include("head.php");
?>

<body>
    <nav class="navbar navbar-default navbar-fixed-top">
        <div class="container-fluid">
            <div class="navbar-header">
                <a class="navbar-brand"><img src="cinguettio logo-04.png" class="img-responsive"  alt="Responsive image" padding-top= "-10px" width="30px" height="30px"></a>
            </div>
            <ul class="nav navbar-nav">
                <li class="active"><a href="Bacheca.php">Bacheca</a></li>
                <li><a href="Datiutente.php?email=<?php echo $email ?>">Dati Utente</a></a></li>
                <li><a href="Chiseguo.php" class="active">Chi Seguo</a></li> 
                <li><a href="Chimisegue.html">Chi Mi Segue</a></li> 
                <li><a href="Logout.php">Logout</a></li> 
            </ul>
        </div>
    </nav>

    <?php
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
    <div class = "row">
        <?php
    for ($i = 0; $i < count($seguiti); $i++) {
        ?>

            <div class="col-md-4">
                <div class="<?php echo $panel; ?>">
                    <div class="panel-body">
    <?php echo $seguiti[$i]['utenteSeguito'] ?>
                    </div>
                </div>
            </div>
        </div> <?php
}
?>
    <div class="col-md-8">
        <div class="<?php echo $panel; ?>">
            <div class="panel-body">
<?php echo $seguiti[$i]['utenteSeguito'] ?>
            </div>
        </div>
    </div>


</body>