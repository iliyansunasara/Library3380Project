<?php
    session_start();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Team 18 Library</title>
        <link rel="stylesheet" href="css/reset.css?<?php echo time(); ?>">
        <link rel="stylesheet" href="css/style.css?<?php echo time(); ?>">
        <link rel="shortcut icon" type="image/png" href="img/lib-logo.png">
    </head>
    <body>
        <div class="bar">
            <div class="header-final">
                <nav>
                    <div class="img-for-logo">
                        <a href="index.php"><img class="img-book" src = "img/book.png" alt="Library Logo"></a>
                    </div>
                    <div class="logo-name"> 
                        <a class="logo-name-name"href="index.php"><h1>Team 18 Library</h1></a>
                    </div> 
                    <div class="loggedin">
                        <?php
                            if(isset($_SESSION["University_id"])) {
                                $UserID = $_SESSION["University_id"];
                                require_once 'includes/dbh-inc.php';
                                //$sql = "SELECT Fname, Lname FROM USERS WHERE 'University_id' = $UserID;";
                                $sql = "SELECT University_id, Fname, Lname FROM USERS WHERE University_id = '$UserID';";
                                $result = $conn->query($sql);
                                $row = $result->fetch_assoc();
                                //echo "<p>Hello there, ". $_SESSION['University_id'] .".</p>";
                                echo "Hello there, " . $row["Fname"]. " " . $row["Lname"] . "<br>";
                            }
                            else if (isset($_SESSION["Staff_id"])) {
                                $UserID = $_SESSION["Staff_id"];
                                require_once 'includes/dbh-inc.php';
                                $sql = "SELECT Fname, Lname FROM STAFF WHERE `Staff_id` = $UserID;";
                                $result = $conn->query($sql);
                                $row = $result->fetch_assoc();
                                //echo "<p>Hello there, ". $_SESSION['Staff_id'] .".</p>";
                                echo "Hello there, " . $row["Fname"]. " " . $row["Lname"] . "<br>";
                            }
                            else if (isset($_SESSION["Admin_id"])) {
                                $UserID = $_SESSION["Admin_id"];
                                require_once 'includes/dbh-inc.php';
                                $sql = "SELECT Fname, Lname FROM LIBRARIAN WHERE `Admin_id` = $UserID;";
                                $result = $conn->query($sql);
                                $row = $result->fetch_assoc();
                                //echo "<p>Hello there, ". $_SESSION['Admin_id'] .".</p>";
                                echo "Hello there, " . $row["Fname"]. " " . $row["Lname"] . "<br>";
                            }
                        ?>
                    </div>
                        <ul>
                            <li><a href="index.php">Home</a></li>
                            <?php
                                if(isset($_SESSION["University_id"])) {
                                    echo "<li><a href='profile.php'>Profile</a>";
                                    echo "<ul>";
                                                    
                                                        echo "<li><a href='checkouts.php'>Checkouts</a></li>";
                                                
                                                    
                                                        echo "<li><a href='requests.php'>Requests</a></li>";
                                                
                                                    
                                                        echo "<li><a href='fines.php'>Fines</a></li>";
                                                
                
                                                        echo "<li><a href='editprofile.php'>Edit Profile</a></li>";
                                                echo "</ul>";
                                    echo "</li>";
                                    echo "<li><a href='includes/logout-inc.php'>Logout</a></li>";
                                }
                                else if (isset($_SESSION["Staff_id"])) {
                                    echo "<li><a href='profile.php'>Profile</a>";
                                    echo "<ul>";
                                                    
                                                        echo "<li><a href='checkouts.php'>Checkouts</a></li>";
                                                
                                                    
                                                        echo "<li><a href='requests.php'>Requests</a></li>";
                                                
                                                    
                                                        echo "<li><a href='fines.php'>Fines</a></li>";
                                                
                
                                                        echo "<li><a href='editprofile.php'>Edit Profile</a></li>";
                                                echo "</ul>";
                                    echo "</li>";
                                    echo "<li><a href='includes/logout-inc.php'>Logout</a></li>";
                                }
                                else if (isset($_SESSION["Admin_id"])) {
                                    echo "<li><a href='profile.php'>Profile</a>";
                                    echo "<ul>";
                                                    
                                                        echo "<li><a href='checkouts.php'>Checkouts</a></li>";
                                                
                                                    
                                                        echo "<li><a href='requests.php'>Requests</a></li>";
                                                
                                                    
                                                        echo "<li><a href='fines.php'>Fines</a></li>";
                                                
                
                                                        echo "<li><a href='editprofile.php'>Edit Profile</a></li>";
                                                echo "</ul>";
                                    echo "</li>";
                                    echo "<li><a href='includes/logout-inc.php'>Logout</a></li>";
                                }
                                else {
                                    echo "<li><a href='login.php'>Login</a></li>";
                                    echo "<li><a href='signup.php'>Signup</a></li>";
                                }
                            ?>
                        </ul>
                </nav>
            </div>
        </div>
        <div class = background_wrapper>
            <div class = middle_wrapper>