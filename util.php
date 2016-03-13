<?php
function display_image($image_id, $caption, $file_name, $credit){
    $html = "
        <div class='image' id='image$image_id'>
            <p class='caption'>$caption</p>
            <img src='images/$file_name' alt='$caption'>
            <p class='credit'><a href='$credit' target='_blank'>Credit</a></p>
        </div>
    ";
    echo $html;
}

function display_album($album_id, $title, $date_created, $date_modified, $description, $cover_path) {
    $html = "
        <div class='album' id='album$album_id'>
            <p><a href='images.php?album=$album_id'>$title</a></p>
            <img src='images/$cover_path' alt='$cover_path'>
            <p>Date Created: $date_created</p>
            <p>Date Modified: $date_modified</p>
            <p>Description: $description</p>
        </div>
    ";
    echo $html;
}

?>