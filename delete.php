<?php session_start(); ?>

<?php
include_once 'mysql_connection.php';

if (empty($_SESSION['logged_user'])) {
    echo "You must be logged in to use this feature";
} else {
    if (!empty($_POST['album_id'])) {
        $album_id = filter_input(INPUT_POST, 'album_id', FILTER_SANITIZE_NUMBER_INT);
        $sql = "delete from albums where id='$album_id'";
        $mysqli->query($sql);
        echo "true";
    } elseif (!empty($_POST['image_id'])) {
        $image_id = filter_input(INPUT_POST, 'image_id', FILTER_SANITIZE_NUMBER_INT);
        $sql = "delete from images where id='$image_id'";
        $mysqli->query($sql);
        echo "true";
    } else {
        echo "false";
    }
}
?>
