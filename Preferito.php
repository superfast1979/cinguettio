<?php
session_start();
require_once("database.php");
if (!isset($_SESSION['email']) || !isset($_SESSION['pwd'])) {
    echo "Non sei connesso!";
    die;
}

$preferenti = array();
if (isset($_POST['pref']) && ($_POST['pref'] == true)) {
    $html = "<p align='right'>";
    $idCinguettio = $_POST['id'];
    $sqlListaPref = "SELECT email FROM preferisce WHERE id='$idCinguettio'";
    if ($resultListaPref = db_query($sqlListaPref)) {
        while ($row = mysqli_fetch_assoc($resultListaPref)) {
            array_push($preferenti, $row);
            $html .= $row['email'];
            $html .= "<br>";
        }
        mysqli_free_result($resultListaPref);
    } else {
        printf(db_error());
    }
    $html .= "</p>";
    
    print($html);
}
?>