<?php
    include_once 'header.php';
?>

<?php
    if(isset($_SESSION["University_id"])) {
        echo '<div class="prof">';
            echo '<ul>';
                echo "<li><a href='checkouts.php' class='buttonTwo'>Checkouts</a></li>";
                echo "<li><a href='requests.php' class='buttonTwo'>Requests</a></li>";
                echo "<li><a href='fines.php' class='buttonTwo'>Fines</a></li>";
                echo "<li><a href='editprofile.php' class='buttonTwo'>Edit Profile</a></li>";
            echo '</ul>';
        echo '</div>';
    }
    elseif(isset($_SESSION["Staff_id"]) || isset($_SESSION["Admin_id"])) {
        echo '<div class="prof">';
            echo '<ul>';
                echo "<li><a href='checkouts.php' class='buttonTwo'>Checkouts</a></li>";
                echo "<li><a href='requests.php' class='buttonTwo'>Requests</a></li>";
                echo "<li><a href='fines.php' class='buttonTwo'>Fines</a></li>";
                echo "<li><a href='editprofile.php' class='buttonTwo'>Edit Profile</a></li>";
                if(isset($_SESSION["Admin_id"])) {
                    //echo "<li><a href='users.php' class='buttonTwo'>Users</a></li>";
                    //echo "<li><a href='staff.php' class='buttonTwo'>Staff</a></li>";
                    echo "<li><a href='add-to-lib.php' class='buttonTwo'>Add to Library</a></li>";
                }
            echo '</ul>';
        echo '</div>';
    }
    else {
        header("location: login.php");
    }
?>

<?php
    include_once 'footer.php';
?>