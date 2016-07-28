<?php
session_start();
require_once("database.php");

$error = "";

if (isset($_POST['ok'])) {
    $email = addslashes($_POST['email']);
    $password = addslashes($_POST['pwd']);
    $sql = "SELECT * FROM utente WHERE email='$email' and psw='$password'";

    if ($result = db_query($sql)) {
    //   printf("Select returned %d rows.\n", mysqli_num_rows($result));
        
        if (mysqli_num_rows($result) == 1) {
            mysqli_free_result($result);
            $_SESSION['logged'] = TRUE; 
            $_SESSION['email'] = $email;
            $_SESSION['pwd'] = $password;
            header("location: Bacheca.php");
        } else {
            mysqli_free_result($result);
            $error = "Username o Password errati!";
        }
    }
}
?>
<?php
$_SESSION['title'] = "Login";
include("head.php");
?>

<body>
    <div class="row">		
        <div class="col-md-4 col-sm-2 col-xs-1"></div>
        <div class="col-md-4 col-sm-8 col-xs-10">
            <img src="cinguettio logo-03.png" width="" height="" class="img-responsive" alt="Responsive image">
            <br>
            <form class="form-horizontal" method="post" action="Login.php">
                <div class="form-group">
                    <label for="inputEmail3" class="col-sm-2 control-label">Email</label>
                    <div class="col-sm-10">
                        <input type="email" name="email" class="form-control" id="inputEmail3" placeholder="Email">
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputPassword3" class="col-sm-2 control-label">Password</label>
                    <div class="col-sm-10">
                        <input type="password" name="pwd" class="form-control" id="inputPassword3" placeholder="Password">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <div class="checkbox">
                            <label>
                                <input type="checkbox"> Ricordami
                            </label>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" name="ok" class="btn btn-primary btn-block">Entra</button>
                    </div>
                </div>
                <div>
                    <div class="col-sm-offset-2 col-sm-10 text-center">
                        <a href="Registrazione.php">Registrati qui &nbsp;&nbsp;&nbsp;&nbsp;</a>
                        <a href="PasswordDimenticata.php">Dimenticato la password?</a>
                    </div> 
                </div>
            </form>
<?php
/*        <form method="post" action="Login.php">
                <ul class="list-unstyled">
                    <li>Username: <input type = "text" name = "email"/ ></li>
                    <li>Password: <input type = "password" name = "pwd"/></li>
                    <li><button class="button button" input type= "submit" name="ok">OK</button>
                        <button class="button button" input type = "reset" name="annulla">Cancella</button></li>
                    <li><a href="Registrazione.php">Registrati qui</a></li>
                    <li><a href="PasswordDimenticata.php">Dimenticato la password?</a></li>
                </ul>
           </form>*/ ?>
        </div>
        <div class="col-md-4 col-sm-2 col-xs-1"></div>
    </div>
<p><?php echo $error ?></p>
</body>