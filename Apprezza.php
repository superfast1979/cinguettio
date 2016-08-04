<?php
session_start();
require_once("database.php");
if (!isset($_SESSION['email']) || !isset($_SESSION['pwd'])) {
    echo "Non sei connesso!";
    die;
}

$email = $_SESSION['email'];
$commenti = array();
print($_GET['idCinguettio']);
$error = "";
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

    <?php
    for ($i = 0; $i < count($commenti); $i++) {
        ?>
        <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-8">
                <?php
                $panel = "panel panel-primary";
                if ($commenti[$i]['tipo'] == 'f') {
                    $panel = "panel panel-foto";
                    $tipo = 'Foto';
                }
                if ($commenti[$i]['tipo'] == 't') {
                    $panel = "panel panel-testo";
                    $tipo = 'Testo';
                }
                if ($commenti[$i]['tipo'] == 'l') {
                    $panel = "panel panel-luogo";
                    $tipo = 'Luogo';
                }
                ?>               
                <div class="<?php echo $panel; ?>">
                    <div class="panel-heading">[<?php echo $tipo ?>]&nbsp;<a href="Datiutente.php?email=<?php echo $commenti[$i]['email'] ?>"><?php echo $commenti[$i]['email'] ?></a>&nbsp;<?php echo $commenti[$i]['dataOraCreazione']; ?></div>
                    <div class="panel-body">
                        <?php echo $commenti[$i]['stringaDaStampare']; ?>
                        <?php if ($tipo == 'Testo') { ?>
                            <div class="post_testo pull-right">
                                <input type="hidden" name="idCinguettio" id="idCinguettio" value="<?php echo $commenti[$i]['id']; ?>">
                                <button id="bottone" type="button" class="btn btn-danger">Lista Segnalanti&nbsp; &nbsp; &nbsp; &nbsp; 
                                </button>
                                <div class="post_div_testo" id="risultato" style="display: none;"></div>
                            </div> 

                            <div class="btn-group pull-right">
                                <a href="Bacheca.php?segnala=true&id=<?php echo $commenti[$i]['id']; ?>"
                                   <button type="button" class="btn btn-danger">&nbsp; 
                                        <span class="glyphicon glyphicon-thumbs-down " aria-hidden="true"></span>
                                        &nbsp; 
                                    </button>
                                </a>
                            </div>
                        <?php } ?>
                        <?php if ($tipo == "Foto") { ?>
                            <div class="post_foto pull-right">
                                <button type="button" class="btn btn-primary">Apprezza 
                                    <span class="glyphicon glyphicon-heart-empty " aria-hidden="true"></span>
                                </button>
                                <div class="post_div_foto" style="display: none;">
                                    <form method="POST" action="Apprezza.php">
                                        <input type="hidden" name="idCinguettio" value="<?php echo $commenti[$i]['id']; ?>"/>
                                        <textarea maxlength="50"></textarea><br>
                                        <input type="submit" value="Invia">
                                    </form>
                                </div>
                            </div>
                        <?php } ?>
                        <?php if ($tipo == "Luogo") { ?>
                            <div class="btn-group pull-right">
                                <button href="Bacheca.php?preferito=true&utente=<?php echo $commenti[$i]['email']; ?>"
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
                        $(this).find(".post_div_testo").html(msg).toggle();
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

