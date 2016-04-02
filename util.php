<?php
function display_image($image_id, $caption, $file_name, $credit){
    $html = "
        <div class='image' id='image$image_id'>
            <p class='caption'><span class='bold'>$caption</span></p>
            <figure>
                <a href='image.php?image=$image_id'><img src='images/$file_name' alt='$caption'></a>
            </figure>
            <p class='credit'><a href='$credit' target='_blank'>Credit</a></p>
        </div>
    ";
    echo $html;
}

function display_album($album_id, $title, $date_created, $date_modified, $description, $cover_path) {
    $html = "
    <div class='album' id='album$album_id'>
        <p class='title'><a href='images.php?album=$album_id' class='nodec'>$title</a></p>";
        
    if (!empty($cover_path)) {
        $html .= "<a href='images.php?album=$album_id' class='cover'>
                <figure>
                    <img src='images/$cover_path' alt='$cover_path'>
                </figure>
            </a>";
    } else {
        $html .= "<figure><h1>Empty</h1></figure>";
    }

    $html .= "
        <p><span class='bold'>Date Created: </span>$date_created</p>
        <p><span class='bold'>Date Modified: </span>$date_modified</p>
        <p><span class='bold'>Description: </span>$description</p>
    </div>";

    echo $html;
}

function get_cover_by_ablum_id($mysqli, $album_id) {
    $sql = "select * from images where id = (select image_id from mappings where album_id=$album_id limit 1)";
    $results = $mysqli->query($sql);
    $image = $results->fetch_row();
    if (empty($image)) {
        return "";
    } else {
        return $image[2];
    }
}

function display_upload_form($albums) {
    $html = "<form action='index.php' method='post' enctype='multipart/form-data' class='cover' id='upload'>
        <span><b>Upload Image</b></span>
        <input type='file' name='fileToUpload' id='fileToUpload' required> <br><br>
        <label for='select_albums'><b>Add this image to which albums?</b></label>
        <select name='select_albums[]' multiple='multiple' id='select_albums'>";

    $html .= "<option value='0'>Do not add to any album</option>";
    foreach ($albums as $a) {
        $aid = $a[0];
        $t = $a[1];
        $html .= "<option value='$aid'>$t</option>";
    }
    $html .= "</select><br><br>
        <label for='caption'>
            <input type='text' name='caption' id='caption' placeholder='Caption' required>
            <span>Caption</span>
        </label>
        <label for='credit'>
            <input type='text' name='credit' id='credit' placeholder='Credit' required>
            <span>Credit</span>
        </label>
        <input type='submit' value='Upload' name='add_to_albums'> <br>
    </form>";
    echo $html;
}

function show_image($image_id, $caption, $file_name, $credit, $album_titles){
    $html = "
        <div class='image' id='image$image_id'>
            <p class='caption'><span class='bold'>$caption</span></p>
            <img src='images/$file_name' alt='$caption'>
            <p class='credit'>Credit: <a href='$credit' target='_blank'>$credit</a></p>
            <p>In Albums: ";
    ?>
    <?php
    foreach ($album_titles as $album_title) {
        $html .= "<span class='tag'>$album_title[0]</span>";
    }

    $html .= "</p>
        </div>
    ";
    echo $html;
}
?>
