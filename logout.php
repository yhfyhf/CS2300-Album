<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
    <title>NBA Image Album</title>

    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Fjalla%20One">
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Josefin%20Sans">

    <link rel="stylesheet" href="assets/css/grid.css">
    <link rel="stylesheet" href="assets/css/login.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="assets/js/images.js"></script>
</head>

<body>

<div class="container">
    <?php
    unset($_SESSION["logged_user"] );
    unset( $_SESSION );
    $_SESSION = array();
    session_destroy();
    header("Location: login.php");
    exit();
    ?>
</div>
</body>

</html>
