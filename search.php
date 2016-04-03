<?php
if (isset($_POST['search'])) {
    echo "<h1>Search Results</h1>";

    $query = filter_input(INPUT_POST, 'query', FILTER_SANITIZE_STRING);
    $queries = explode(" ", $query);

    echo "<h2>Albums</h2>";
    $albums = array();
    $images = array();

    foreach ($queries as $query) {
        $sql = "select * from albums where title like '%$query%' or description like '%$query%'";
        $result = $mysqli->query($sql);
        $albums = array_merge($albums, $result->fetch_all());

        $sql = "select * from images where caption like '%$query%' or file_name like '%$query%'";
        $result = $mysqli->query($sql);
        $images = array_merge($images, $result->fetch_all());
    }
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
        } else {
            echo "<p><b>No related albums.</b></p>";
        }
        ?>
        <div class="clearfix"></div>
<?php

    echo "<h2>Images</h2>";

    if (!empty($images)) {
        foreach ($images as $image) {
            echo "<div class='responsive'>";
            display_image($image[0], $image[1], rawurlencode($image[2]), $image[3]);
            echo "</div>";
        }
    } else {
        echo "<p><b>No related images.</b></p>";
    }

    echo "<div class='clearfix'></div>";
    echo "</div>";

} else {
?>
    <form action="index.php" method="post" id="search">
        <input type="text" name="query" placeholder="Query" required>
        <input type="submit" value="Search" name="search">
    </form>
<?php
}
?>
