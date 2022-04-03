<?php
    session_start();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Team 18 Library</title>
        <link rel="stylesheet" href="css/reset.css">
        <link rel="stylesheet" href="css/style.css">
        <link rel="shortcut icon" type="image/png" href="img/lib-logo.png">
    </head>
    <body>
        <nav>
            <div class="header">
                <div class="inner-header">
                    <div class="logo-container">
                        <a href="index.php"><img class="img-book" src = "img/lib-main-logo.png" alt="Library Logo"></a>
                    </div>
                    <ul class="navigation">
                        <li><a href="index.php">Home</a></li>
                        <?php
                            if(isset($_SESSION["University_id"])) {
                                echo "<li><a href='profile.php'>Profile</a></li>";
                                echo "<li><a href='includes/logout-inc.php'>Logout</a></li>";
                            }
                            else {
                                echo "<li><a href='login.php'>Login</a></li>";
                                echo "<li><a href='signup.php'>Signup</a></li>";
                            }
                        ?>
                    </ul>
                    <div class="logo-name"> 
                        <a class="logo-name-name"href="index.php"><h1>Team 18 Library</h1></a>
                    </div>
                </div>
            </div>
        </nav>