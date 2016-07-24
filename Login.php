<?php
session_start();
require_once("header.php");

$error = "";

if (isset($_POST['ok'])) {
    $email = addslashes($_POST['email']);
    $password = addslashes($_POST['pwd']);
    $sql = "SELECT * FROM utente WHERE email='$email' and Psw='$password'";

    if ($result = db_query($sql)) {
        printf("Select returned %d rows.\n", mysqli_num_rows($result));
        
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
<head>
    <title>Login</title>
    <link rel="stylesheet" type="text/css" href="css2.css">
</head>

<body>
    <div align="center">Cinguettio</div>		
    <form method="post" action="Login.php">
        <ul align="center">
            <li>Username: <input type = "text" name = "email"/ ></li>
            <li>Password: <input type = "password" name = "pwd"/></li>
            <li><button class="button button" input type= "submit" name="ok">OK</button>
                <button class="button button" input type = "reset" name="annulla">Cancella</button></li>
            <li><a href="Registrazione.php">Registrati qui</a></li>
            <li><a href="PasswordDimenticata.php">Dimenticato la password?</a></li>
        </ul>
    </form>
    <p><?php echo $error ?></p>
</body>