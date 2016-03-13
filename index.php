<!DOCTYPE html>
<html>
<head>
    <title>Photo Gallery</title>

    <link rel="stylesheet" href="assets/css/grid.css">
    <link rel="stylesheet" href="assets/css/index.css">
</head>

<body>
<?php
include_once 'mysql_connection.php';
include 'util.php';

$sql = "select a.*, i.file_name from albums a
          inner join (
            select image_id, album_id from mappings group by album_id
          ) t on a.id = t.album_id
          inner join images i on t.image_id=i.id;";
$albums = $mysqli->query($sql);

foreach ($albums as $album) {
    echo "<div class='responsive'>";
    display_album($album['id'], $album['title'], $album['date_created'],
        $album['date_modified'], $album['description'], $album['file_name']);
    echo "</div>";
}
?>

    <div class="clearfix"></div>

</body>

</html>
