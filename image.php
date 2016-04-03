<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
    <title>NBA Image Album</title>

    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Fjalla%20One">
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Josefin%20Sans">

    <link rel="stylesheet" href="assets/css/grid.css">
    <link rel="stylesheet" href="assets/css/image.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="assets/js/image.js"></script>
</head>

<body>
<?php
if (!isset($_GET['image']) || !ctype_digit($_GET['image'])) {
    echo 'Invalid URL.';
    exit();
}
?>

<?php

include_once 'mysql_connection.php';

$image_id = $_GET['image'];

if (!empty($_POST['edit_caption'])) {
    if (empty($_SESSION['logged_user'])) {
        echo "<p>You must be logged in to use this feature</p>";
    } else {
        $new_caption = filter_input(INPUT_POST, 'caption', FILTER_SANITIZE_STRING);
        $sql = "update images set caption='$new_caption' where id=$image_id";
        $mysqli->query($sql);
    }
}

if (!empty($_POST['edit_credit'])) {
    if (empty($_SESSION['logged_user'])) {
        echo "<p>You must be logged in to use this feature</p>";
    } else {
        $new_credit = filter_input(INPUT_POST, 'credit', FILTER_SANITIZE_STRING);
        $sql = "update images set credit='$new_credit' where id=$image_id";
        $mysqli->query($sql);
    }
}
?>

<div class="container">
    <?php
    include "header.php";

    include_once 'mysql_connection.php';
    include_once 'util.php';

    $sql = "select * from images where id=$image_id";
    $images = $mysqli->query($sql);
    ?>

    <div class="main">
        <?php
        foreach ($images as $image) {
            $image_id = $image['id'];
            $sql = "select title from albums where id in (select album_id from mappings where image_id=$image_id)";
            $titles = $mysqli->query($sql)->fetch_all();
            show_image($image['id'], $image['caption'], rawurlencode($image['file_name']), $image['credit'], $titles);
        }
        ?>
        <div class="clearfix"></div>
    </div>

</div>
</body>

</html>
