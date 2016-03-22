<?php
function display_image($image_id, $caption, $file_name, $credit){
    $html = "
        <div class='image' id='image$image_id'>
            <p class='caption'><span class='bold'>$caption</span></p>
            <figure>
                <img src='images/$file_name' alt='$caption'>
            </figure>
            <p class='credit'><a href='$credit' target='_blank'>Credit</a></p>
        </div>
    ";
    echo $html;
}

function display_album($album_id, $title, $date_created, $date_modified, $description, $cover_path, $albums) {
    if (!empty($cover_path)) {
        $html = "
        <div class='album' id='album$album_id'>
            <p class='title'><a href='images.php?album=$album_id' class='nodec'>$title</a></p>
            <a href='images.php?album=$album_id' class='cover'>
                <figure>
                    <img src='images/$cover_path' alt='$cover_path'>
                </figure>
            </a>
            <p><span class='bold'>Date Created: </span>$date_created</p>
            <p><span class='bold'>Date Modified: </span>$date_modified</p>
            <p><span class='bold'>Description: </span>$description</p>
        </div>";
    } else {
        $html = "
        <div class='album' id='album$album_id'>
            <p class='title'><a href='images.php?album=$album_id' class='nodec'>$title</a></p>
            <a class='cover'>
                <div class='dummy'>
                    <form action='' method='post' enctype='multipart/form-data' class='cover'>
                        <label>Upload Image</label>
                        <input type='file' name='fileToUpload' id='fileToUpload' required>
                        
                        <label for='select_albums'>Add this image to other albums?</label>
                        <select name='select_albums[]' multiple='multiple' id='select_albums'>";
        $html .= "<option value='0'>Do not add to any album.</option>";
        foreach ($albums as $a) {
            $aid = $a[0];
            $t = $a[1];
            if ($aid == $album_id) {
                $html .= "<option value='$aid' selected>$t</option>";
            } else {
                $html .= "<option value='$aid'>$t</option>";
            }
        }
        $html .= "</select><br>
                        <input type='text' name='caption' id='caption' placeholder='Caption' required>
                        <input type='text' name='credit' id='credit' placeholder='Credit' required>
                        <input type='hidden' name='album_id' value='$album_id' required><br>
                        <input type='submit' value='Upload' name='add_to_albums'>
                    </form>
                </div>  
            </a>
            <p><span class='bold'>Date Created: </span>$date_created</p>
            <p><span class='bold'>Date Modified: </span>$date_modified</p>
            <p><span class='bold'>Description: </span>$description</p>
        </div>";
    }
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
?>
