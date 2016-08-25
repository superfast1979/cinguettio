<?php

function db_connect() {

    static $mysqli;

    if (!isset($mysqli)) {
        $config = parse_ini_file('./configDb.ini');
        $mysqli = mysqli_connect($config['host'], $config['username'], $config['password'], $config['dbname']);
    }

    if ($mysqli === false) {
        echo "Error: Unable to connect to MySQL." . PHP_EOL;
        echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
        die();
    }
    return $mysqli;
}

function db_query($query) {
    $mysqli_conn = db_connect();
    $result = mysqli_query($mysqli_conn, $query);
    return $result;
}

function db_insert_id() {
    $mysqli_conn = db_connect();
    return mysqli_insert_id($mysqli_conn);
}

function db_error() {
    $connection = db_connect();
    return mysqli_error($connection);
}

?>
