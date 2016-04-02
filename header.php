<?php
$html = "
<div class='header'>
    <h1>
        NBA Image Album
    </h1>
    
    <span><a href='index.php' class='nodec'>Home</a></span>
    <span><a href='images.php?album=all' class='nodec'>All Images</a></span>";
if (empty($_SESSION['logged_user'])) {
    $html .= "<span><a href='login.php' class='nodec'>Log in</a></span>";
} else {
    $html .= "<span><a href='logout.php' class='nodec'>Log out</a></span>";
}

$html .= "</div>";
echo $html;
?>
