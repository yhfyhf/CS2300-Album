<?php
    require_once 'config.php';

    $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

    if ($mysqli->errno) {
        print($mysqli->error);
        exit();
    }
?>
