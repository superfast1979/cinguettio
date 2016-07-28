<?php
session_start();
require_once("database.php");
require_once("utility.php");

$errore = "";

$prova = "";

if (isset($_POST['ok'])) {
    $email = addslashes($_POST['mail']);
    $user = addslashes($_POST['nick']);
    $password = addslashes($_POST['pwd']);
    $confpassword = addslashes($_POST['confpwd']);

    if ($password == $confpassword && !UserExists($email)) {

        $sql = "INSERT INTO `utente` (`Email`, `Nickname`, `Psw`) VALUES ('$email', '$user', '$password')";

        if ($result = db_query($sql)) {
            header("location: Login.php");
        } else {
            $errore = db_error();
        }
    } else {
        if ($password != $confpassword) {
            $errore = "La password è diversa";
        } else {
            $errore = "Email già utilizzata";
        }
    }
}
?>
  <?php
    $_SESSION['title'] = "Registrazione";
    include("head.php");
    ?>
<body>
    <div class="row">		
        <div class="col-md-4 col-sm-2 col-xs-1"></div>
        <div class="col-md-4 col-sm-8 col-xs-10">
            
            <form class="form-horizontal" method="post" action="Registrazione.php">
                
                <h1 class="form-group">
                    <label for="moreSpace" class="col-sm-9 control-label "> <br>Registrazione</label>
                    <div class="col-sm-3">
                        <img src="cinguettio logo-04.png" class="img-responsive"  alt="Responsive image" align="center">
                    </div>
                </h1>
                <div class="form-group">
                    <label for="inputNicknamel3" class="col-sm-2 control-label">Nickname</label>
                    <div class="col-sm-10">
                        <input type="text" name="nickname" class="form-control" id="inputNicknamel3">
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="inputPassword3" class="col-sm-2 control-label">Password</label>
                    <div class="col-sm-10">
                        <input type="password" name="pwd" class="form-control" id="inputPassword3" placeholder="Password">
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="inputPassword3" class="col-sm-2 control-label">Conferma Password</label>
                    <div class="col-sm-10">
                        <input type="password" name="confpwd" class="form-control" id="inputPassword3">
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="inputEmail3" class="col-sm-2 control-label">Email</label>
                    <div class="col-sm-10">
                        <input type="email" name="email" class="form-control" id="inputEmail3" placeholder="Email">
                    </div>
                </div>
                
                <div class="form-group text-center">
                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" class="btn btn-primary">Iscriviti</button>
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
