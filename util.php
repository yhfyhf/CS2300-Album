<?php
function display_image($image_id, $caption, $file_name, $credit){
    if (empty($_SESSION['logged_user'])) {
        $html = "
            <div class='image' id='image$image_id'>
                <p class='caption'>
                    <span class='bold'>$caption</span>
                </p>
                <figure>
                    <a href='image.php?image=$image_id'><img src='images/$file_name' alt='$caption'></a>
                </figure>
                <p class='credit'><a href='$credit' target='_blank'>Credit</a></p>
            </div>
        ";
    } else {
        $html = "
            <div class='image' id='image$image_id'>
                <p class='caption'>
                    <span class='bold'>$caption</span>
                    <button class='delete_image' id='delete_image$image_id'>Delete</button>
                </p>
                <figure>
                    <a href='image.php?image=$image_id'><img src='images/$file_name' alt='$caption'></a>
                </figure>
                <p class='credit'><a href='$credit' target='_blank'>Credit</a></p>
            </div>
        ";
    }
    echo $html;
}

function display_album($album_id, $title, $date_created, $date_modified, $description, $cover_path) {
    if (empty($_SESSION['logged_user'])) {
        $html = "
    <div class='album' id='album$album_id'>
        <p class='title'><a href='images.php?album=$album_id' class='nodec'>$title</a></p>";
    } else {
        $html = "
    <div class='album' id='album$album_id'>
        <p class='title' id='title$album_id'>
            <span id='span_title$album_id'>$title</span>
            <button class='delete_album' id='delete_album$album_id'>Delete</button>
        </p>
        <form action='index.php' class='edit_title' id='edit_title$album_id' method='post'>
            <label for='title'>
                <input type='text' name='title' id='title' class='title' data-index='$album_id' value='$title' required>
                <span>Title</span>
            </label>
            <input type='text' name='album_id' value='$album_id' class='hidden' required>
            <input type='submit' name='edit_title' class='hidden'>
        </form>";
    }

    if (!empty($cover_path)) {
        $html .= "<a href='images.php?album=$album_id' class='cover'>
                <figure>
                    <img src='images/$cover_path' alt='$cover_path'>
                </figure>
            </a>";
    } else {
        $html .= "<a href='images.php?album=$album_id' class='cover'>
                      <figure>
                          <h1>Empty</h1>
                      </figure>
                  </a>";
    }

    if (empty($_SESSION['logged_user'])) {
        $html .= "
        <p><span class='bold'>Date Created: </span>$date_created</p>
        <p><span class='bold'>Date Modified: </span>$date_modified</p>
        <p><span class='bold'>Description: </span>$description</p>
    </div>";
    } else {
        $html .= "
        <p><span class='bold'>Date Created: </span>$date_created</p>
        <p><span class='bold'>Date Modified: </span>$date_modified</p>
        <p class='description logged' id='description$album_id'><span class='bold'>Description: </span>$description</p>
        <form action='index.php' class='edit_description' id='edit_description$album_id' method='post'>
            <label for='description'>
                <input type='text' name='description' id='description' class='description' data-index='$album_id' value='$description' required>
                <span>Description</span>
            </label>
            <input type='text' name='album_id' value='$album_id' class='hidden' required>
            <input type='submit' name='edit_description' class='hidden'>
        </form>
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

function show_image($image_id, $caption, $file_name, $credit, $date_taken, $album_titles, $albums, $belonged_aids){
    if (empty($_SESSION['logged_user'])) {
        $html = "
        <div class='image' id='image$image_id'>
            <p class='caption'><span class='bold'>$caption</span></p>
            <img src='images/$file_name' alt='$caption'>
            <p class='date_taken'><span class='bold'>Date taken: </span>$date_taken</p>
            <p class='credit'><span class='bold'>Credit: </span><a href='$credit' target='_blank'>$credit</a></p>
            <p><span class='bold'>In Albums: </span>";
    } else {
        $html = "
        <div class='image' id='image$image_id'>
            <p class='caption logged'><span class='bold'>$caption</span></p>
            <form action='image.php?image=$image_id' id='edit_caption' method='post'>
                <label for='caption'>
                    <input type='text' name='caption' id='caption' value='$caption' required>
                    <span>Caption</span>
                </label>
                <input type='submit' name='edit_caption' class='hidden'>
            </form>
            <img src='images/$file_name' alt='$caption'>
            <p class='date_taken'><span class='bold'>Date taken:</span> $date_taken</p>
            <p class='credit'>
                <span class='bold'>Credit: </span><a href='$credit' target='_blank'>$credit</a>
                <button id='btn-edit'>Edit</button>
            </p>
            <form action='image.php?image=$image_id' id='edit_credit' method='post'>
                <label for='credit'>
                    <input type='text' name='credit' id='credit' value='$credit' required>
                    <span>Credit</span>
                </label>
                <input type='submit' name='edit_credit' class='hidden'>
            </form>
            <p><span class='bold'>In Albums: </span>";
    }
    foreach ($album_titles as $album_title) {
        $html .= "<span class='tag'>$album_title[0]</span>";
    }

    $html .= "</p>";
    if (!empty($_SESSION['logged_user'])) {
        $html .= "
            <form action='image.php?image=$image_id' method='post' enctype='multipart/form-data' class='cover' id='update_to_albums'>
                <h3>Update albums this image belongs to:</h3>
                <select name='select_albums[]' multiple='multiple' id='select_albums'>";

        $html .= "<option value='0'>Does not belong to any album</option>";
        foreach ($albums as $a) {
            $aid = $a[0];
            $t = $a[1];
            if (in_array($aid, $belonged_aids)) {
                $html .= "<option value='$aid' selected>$t</option>";
            } else {
                $html .= "<option value='$aid'>$t</option>";
            }
        }
        $html .= "</select> <br>
                    <input type='submit' value='Update' name='update_to_albums'> <br>
                </form>";
    }
    $html .= "<div class='clearfix'></div>
        </div>";
    echo $html;
}
?>
