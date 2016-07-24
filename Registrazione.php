<?php
session_start();
require_once("header.php");
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
<head>
    <title>Registrazione</title>
    <link rel="stylesheet" type="text/css" href="css2.css">
</head>
<body>
    <form method="post" action="Registrazione.php">
        Compila i seguenti campi per accedere a Cinguettio
        <table>
            <tr>
                <td>Nickname:</td><td> <input type = "text" name = "nick" required/></td>
            </tr>
            <tr>
                <td>Password:</td><td> <input type = "password" name = "pwd" required/></td>
            </tr>
            <tr>
                <td>Conferma Password: </td><td> <input type = "password" name = "confpwd" required/></td> /*manca controllo conferma password e collegamento a db*/
            </tr>
            <tr>
                <td>E-mail:</td><td> <input type = "email" placeholder="name@email.com" required name = "mail"/></td>
            </tr>
        </table>

        <button class="button button" input type= "submit" name="ok">Questi sono i miei dati</a></button>
        <button class="button button" input type = "reset" name="reset">Premi per svuotare tutti i campi</button></li>

</form>
<p><?php echo $errore ?></p>
</body>
