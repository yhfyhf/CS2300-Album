<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
    <title>NBA Image Album</title>

    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Fjalla%20One">
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Josefin%20Sans">

    <link rel="stylesheet" href="assets/css/grid.css">
    <link rel="stylesheet" href="assets/css/login.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="assets/js/images.js"></script>
</head>

<body>

<div class="container">
    <?php
    include_once 'mysql_connection.php';
    include_once 'header.php';

    $username = filter_input( INPUT_POST, 'username', FILTER_SANITIZE_STRING );
    $password = filter_input( INPUT_POST, 'password', FILTER_SANITIZE_STRING );

    if (empty($username) || empty($password)) {
        // show login form
        ?>
        <div class="main">
            <?php
            if (empty($_SESSION['logged_user'])) {
                ?>
                <h1>Login</h1>

                <form action="login.php" method="post" id="login">
                    <label for="username">
                        <input type="text" name="username" id="username" placeholder="Username">
                        <span>Username</span>
                    </label>
                    <label for="password">
                        <input type="password" name="password" id="password" placeholder="Password">
                        <span>Password</span>
                    </label>
                    <input type="submit" value="Login" name="login">
                </form>
                <?php
            } else {
                $html .= "<span><a href='logout.php' class='nodec'>Log out</span>";
            }
            ?>
        </div>
        <?php
    } else {
        $sql = "select * from users where username='$username'";
        $result = $mysqli->query($sql);

        if ($result && $result->num_rows == 1) {
            $row = $result->fetch_assoc();
            $db_hash_password = $row['hashpassword'];

            if (password_verify($password, $db_hash_password)) {
                $_SESSION['logged_user'] = $username;
                echo "<p>Congratulations, $username, you logged in.</p>";
            } else {
                echo "<p>You did not login successfully.</p>";
            }
        } else {
            echo "<p>You did not login successfully.</p>";
        }
    }
    ?>

</div>
</body>

</html>
