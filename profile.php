<?php
    include_once 'header.php';
?>

<?php
    if(isset($_SESSION["University_id"]) || isset($_SESSION["Staff_id"]) || isset($_SESSION["Admin_id"])) {
        echo '<div class="prof">';
            echo '<ul>';
                echo "<li><a href='checkouts.php'>Checkouts</a></li>";
                echo "<li><a href='requests.php'>Requests</a></li>";
                echo "<li><a href='fines.php'>Fines</a></li>";
                echo "<li><a href='editprofile.php'>Edit Profile</a></li>";
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