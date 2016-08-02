<?php
session_start();
require_once("database.php");
if (!isset($_SESSION['email']) || !isset($_SESSION['pwd'])) {
    echo "Non sei connesso!";
    die;
}

$errore = "";
$prova = "";
$email = $_SESSION['email'];

$sql = "SELECT * FROM utente WHERE email='$email'";

if ($result = db_query($sql)) {
        $row = mysqli_fetch_assoc($result);
    }

if (isset($_POST['cambia'])) {
    $nome = addslashes($_POST['nome']);
    $cognome = addslashes($_POST['cognome']);
    $nickname = addslashes($_POST['nickname']);
    $password = addslashes($_POST['pwd']);
    $confpassword = addslashes($_POST['confpwd']);
    $hobby = addslashes($_POST['hobby']);
    $dataNascita = addslashes($_POST['dataNascita']);
    $sesso = addslashes($_POST['sesso']);
    $statoN = addslashes($_POST['statoN']);
    $regioneN = addslashes($_POST['regioneN']);
    $cittaN = addslashes($_POST['cittaN']);
    $nomeC = addslashes($_POST['nomeC']);

    $sqlCitta = "INSERT INTO citta (nomeC)"
                . " VALUES('$nomeC')";
    
    $resCitta= db_query($sqlCitta);
    printf("%s", $sqlCitta);

    if ($password == $confpassword) {   
        
        $sql = "UPDATE `utente` SET nome='$nome', cognome='$cognome', nickname='$nickname',"
                . "psw='$password',hobby='$hobby',"
                . "dataNascita='$dataNascita', sesso='$sesso', statoN='$statoN',"
                . "regioneN='$regioneN', cittaN='$cittaN', nomeC='$nomeC'"
                . "WHERE email='$email'";

        if ($result = db_query($sql)) {
            header("location: DatiUtente.php?email=$email");
        } else {
            $errore = db_error();
        }
    } else {
        if ($password != $confpassword) {
            $errore = "La password è diversa";
        } else {
            $errore = "Errore";
        }
    }
} else {
    $sql = "SELECT * FROM utente NATURAL JOIN citta WHERE email='$email'";
    if ($result = db_query($sql)) {
        $row = mysqli_fetch_assoc($result);
    }
}
?>
  <?php
    $_SESSION['title'] = "Modifica Dati";
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
                <li class="active"><a href="Datiutente.php?email=<?php echo $email?>">Dati Utente</a></li>
                <li><a href="Chiseguo.php">Chi Seguo</a></li> 
                <li><a href="Chimisegue.html">Chi Mi Segue</a></li> 
                <li><a href="Logout.php">Logout</a></li> 
            </ul>
        </div>
    </nav>
    
    <div class="row">		
        <div class="col-md-4 col-sm-2 col-xs-1"></div>
        <div class="col-md-4 col-sm-8 col-xs-10">
            
            <form class="form-horizontal" method="post" action="Modificadatiutente.php">
                
                <h1 class="form-group">
                    <label for="moreSpace" class="col-sm-9 control-label "> <br>Modifica Dati</label>
                    <div class="col-sm-3">
                        <img src="cinguettio logo-04.png" class="img-responsive"  alt="Responsive image" align="center">
                    </div>
                </h1>
                <div class="form-group">
                    <label for="inputNome3" class="col-sm-4 control-label">Nome</label>
                    <div class="col-sm-8">
                        <input type="text" name="nome" value="<?php echo $row['nome'];?>" class="form-control" id="inputNome3">
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="inputCognome3" class="col-sm-4 control-label">Cognome</label>
                    <div class="col-sm-8">
                        <input type="text" name="cognome" value="<?php echo $row['cognome']?>" class="form-control" id="inputCognome3">
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="inputNickname3" class="col-sm-4 control-label">Nickname</label>
                    <div class="col-sm-8">
                        <input type="text" name="nickname" value="<?php echo $row['nickname']?>" class="form-control" id="inputNickname3">
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="inputPassword3" class="col-sm-4 control-label">Password</label>
                    <div class="col-sm-8">
                        <input type="password" name="pwd" value="<?php echo $row['psw']?>" class="form-control" id="inputPassword3" placeholder="Password">
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="inputPassword3" class="col-sm-4 control-label">Ripeti Password</label>
                    <div class="col-sm-8">
                        <input type="password" name="confpwd" value="<?php echo $row['psw']?>" class="form-control" id="inputPassword3">
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="inputHobby3" class="col-sm-4 control-label">Hobby</label>
                    <div class="col-sm-8">
                        <input type="text" name="hobby" value="<?php echo $row['hobby']?>" class="form-control" id="inputHobby3">
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="inputSesso3" class="col-sm-4 control-label">Sesso</label>
                    <div class="col-sm-8">
                        <input type="radio" name="sesso" id="optionsRadios1" value="M"> M
                        <input type="radio" name="sesso" id="optionsRadios2" value="F"> F
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="inputDataNascita3" class="col-sm-4 control-label">Data di Nascita</label>
                    <div class="col-sm-8">
                        <input type="text" name="dataNascita" value="<?php echo $row['dataNascita']?>" class="form-control" id="dataNascita3">
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="inputStatoN3" class="col-sm-4 control-label">Stato di Nascita</label>
                    <div class="col-sm-8">
                        <input type="text" name="statoN" value="<?php echo $row['statoN']?>" class="form-control" id="inputStatoN3">
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="inputRegioneN3" class="col-sm-4 control-label">Regione di Nascita</label>
                    <div class="col-sm-8">
                        <input type="text" name="regioneN" value="<?php echo $row['regioneN']?>" class="form-control" id="inputRegioneN3">
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="inputCittaN3" class="col-sm-4 control-label">Citta' di Nascita</label>
                    <div class="col-sm-8">
                        <input type="text" name="cittaN" value="<?php echo $row['cittaN']?>" class="form-control" id="inputCittaN3">
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="inputNomeC3" class="col-sm-4 control-label">Citta' di Residenza</label>
                    <div class="col-sm-8">
                        <input type="text" name="nomeC" value="<?php echo $row['nomeC']?>" class="form-control" id="inputNomeC3">
                    </div>
                </div>
                            
                <div class="form-group text-center">
                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" name="cambia" class="btn btn-primary">Cambia Dati</button>
                        <button type = "reset" class="btn btn-primary" name="reset">Premi per svuotare tutti i campi</button>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-md-4 col-sm-2 col-xs-1"></div>
    </div>
    
    
    
    
    
    <?php /*<form method="post" action="Registrazione.php">
        Compila i seguenti campi per accedere a Cinguettio
        <table>
            <tr>
                <td>Nickname:</td><td> <input type = "text" name = "nick" required/></td>
            </tr>
            <tr>
                <td>Password:</td><td> <input type = "password" name = "pwd" required/></td>
            </tr>
            <tr>
                <td>Conferma Password: </td><td> <input type = "password" name = "confpwd" required/></td> 
            </tr>
            <tr>
                <td>E-mail:</td><td> <input type = "email" placeholder="name@email.com" required name = "mail"/></td>
            </tr>
        </table>

        <button class="button button" input type= "submit" name="ok">Questi sono i miei dati</a></button>
        <button class="button button" input type = "reset" name="reset">Premi per svuotare tutti i campi</button></li> 
        </form>     */
    ?>

<p><?php echo $errore ?></p>
</body>