<!DOCTYPE html>
<html>
<head>
    <title>NBA Image Album</title>

    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Fjalla%20One">
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Josefin%20Sans">

    <link rel="stylesheet" href="assets/css/grid.css">
    <link rel="stylesheet" href="assets/css/images.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="assets/js/images.js"></script>
</head>

<body>
    <?php
    if (!isset($_GET['album']) || !ctype_digit($_GET['album'])) {
        echo 'Invalid URL.';
        exit();
    }
    ?>

<div class="container">
    <?php
    include "header.php";

    $album_id = $_GET['album'];

    include_once 'mysql_connection.php';
    include_once 'util.php';

    $sql = "select * from images where id in (select image_id from mappings where album_id=$album_id);";
    $images = $mysqli->query($sql);
    ?>

    <div class="main">
        <?php
        foreach ($images as $image) {
            echo "<div class='responsive'>";
            display_image($image['id'], $image['caption'], rawurlencode($image['file_name']), $image['credit']);
            echo "</div>";
        }
        ?>
        <div class="clearfix"></div>
    </div>

</div>
</body>

</html>
