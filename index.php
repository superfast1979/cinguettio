<?php
session_start();
if (!isset($_SESSION['email']) || !isset($_SESSION['pwd'])) {
    header("location: Login.php");
} else {
    header("location: Bacheca.php");
}
?>
