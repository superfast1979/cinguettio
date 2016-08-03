<?php
session_start();
require_once("database.php");
if (!isset($_SESSION['email']) || !isset($_SESSION['pwd'])) {
    echo "Non sei connesso!";
    die;
}

$segnalanti = array();
$contaSegnalanti = array();
if (isset($_POST['inappropriato']) && ($_POST['inappropriato'] == true)) {
    $html = "<p align='right'>";
    $sqlListaSeg = "SELECT email FROM segnalainappropriato";
    if ($resultListaSeg = db_query($sqlListaSeg)) {
        while ($row = mysqli_fetch_assoc($resultListaSeg)) {
            array_push($segnalanti, $row);
            $html .= $row['email'];
            $html .= "<br>";
        }
        mysqli_free_result($resultListaSeg);
    } else {
        printf(db_error());
    }
    $sqlNumSeg = "SELECT COUNT(email) AS Segnalanti FROM segnalainappropriato";
    if ($resultNumSeg = db_query($sqlNumSeg)) {
        while ($row = $resultNumSeg->fetch_assoc()) {
            array_push($contaSegnalanti, $row);
        }
        mysqli_free_result($resultNumSeg);
    } else {
        printf(db_error());
    }    
    $html .= "</p>";
    
    print($html);
}
?>
