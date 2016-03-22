<!DOCTYPE html>
<html>
<head>
    <title>NBA Image Album</title>

    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Fjalla%20One">
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Josefin%20Sans">

    <link rel="stylesheet" href="assets/css/grid.css">
    <link rel="stylesheet" href="assets/css/index.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="assets/js/index.js"></script>
</head>

<body>
<div class="container">
    <?php
    include "header.php";

    include_once 'mysql_connection.php';
    include 'util.php';
    /*$sql = "select a.*, i.file_name from albums a
              inner join (
                select image_id, album_id from mappings group by album_id
              ) t on a.id = t.album_id
              inner join images i on t.image_id=i.id;";*/
    $sql = "select id, title, date_created, date_modified, description from albums";
    $result = $mysqli->query($sql);
    $albums = $result->fetch_all();
    ?>

    <div class="main">
        <?php
        if (!empty($albums)) {
            foreach ($albums as $album) {
                echo "<div class='responsive'>";
                $file_name = get_cover_by_ablum_id($mysqli, $album[0]);
                display_album($album[0], $album[1], substr($album[2], 0, 10),
                    substr($album[3], 0, 10), $album[4],
                    rawurlencode($file_name), $albums);
                echo "</div>";
            }
        }
        ?>
        <div class="clearfix"></div>
    </div>

    <?php
    if (!empty($_POST['add_album'])) {
        $title = htmlentities($_POST['title']);
        $description = htmlentities($_POST['description']);
        if (empty($title)) {
            echo "<p>Album title cannot be empty.</p>";
        }

        require_once "mysql_connection.php";
        $sql = "insert into albums (title, description) values ('$title', '$description')";
        $mysqli->query($sql);
        $mysqli->commit();
        echo '<script type="text/javascript">window.location.href="index.php";</script>';
    } else {
        ?>
        <form action="index.php" method="post" id="add_album">
            <label for="title">
                <input type="text" name="title" placeholder="Title" id="title">
                <span>Title</span>
            </label>
            <label for="description">
                <input type="text" name="description" placeholder="Description" id="description">
                <span>Description</span>
            </label>
            <input type="submit" value="Add Album" name="add_album" id="add">
        </form>
        <?php
    }
    ?>

    <?php

    if(isset($_POST["add_to_albums"])) {
        $target_dir = "images/";
        $file_name = rawurlencode(basename($_FILES["fileToUpload"]["name"]));
        $target_file = $target_dir . $file_name;
        $uploadOk = 1;
        $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
        $alert_message = "";

        $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
        if($check !== false) {
            $uploadOk = 1;
        } else {
            $alert_message .= "File is not an image.<br>";
            $uploadOk = 0;
        }

        $uploadOk = 1;

        // Check if file already exists
        if (file_exists($target_file)) {
            $alert_message .= "Sorry, file already exists.<br>";
            $uploadOk = 0;
        }

        // Check file size
        if ($_FILES["fileToUpload"]["size"] > 10000000) {
            $alert_message .= "Sorry, your file is too large.<br>";
            $uploadOk = 0;
        }

        // Allow certain file formats
        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
            && $imageFileType != "gif" ) {
            $alert_message .= "Sorry, only JPG, JPEG, PNG & GIF files are allowed.<br>";
            $uploadOk = 0;
        }

        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            $alert_message .= "Sorry, your file was not uploaded.<br>";

        // if everything is ok, try to upload file
        } else {
            if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                $alert_message .= "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.<br>";
            } else {
                $alert_message .= "Sorry, there was an error uploading your file.<br>";
            }
        }

        if ($uploadOk == 1) {
            $album_ids = $_POST['select_albums'];
            $caption = $_POST['caption'];
            $credit = $_POST['credit'];
            $album_id = $_POST['album_id'];
            $sql = "insert into images (caption, file_name, credit) values ('$caption', '$file_name', '$credit')";
            $mysqli->query($sql);
            $image_id = $mysqli->insert_id;

            foreach ($album_ids as $album_id) {
                if ($album_id == 0) {
                    continue;
                }
                $sql = "insert into mappings (album_id, image_id) values ('$album_id', '$image_id')";
                $mysqli->query($sql);
                $sql = "update albums set date_modified=current_timestamp where id=$album_id";
                $mysqli->query($sql);
            }

            $mysqli->commit();
            echo '<script type="text/javascript">window.location.href="index.php";</script>';
        } else {
            echo "<br><b>$alert_message</b><br>";
        }
    }
    ?>
</div>
</body>
</html>
