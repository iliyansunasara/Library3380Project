<?php
    include_once 'header.php';
?>
    <?php
        if(isset($_SESSION["Admin_id"])) {
            echo '<div class="prof">';
                echo '<ul>';
                    echo "<li><a href='newstaff.php' class='buttonTwo'>New Staff</a></li>";
                    echo "<li><a href='newbooks.php' class='buttonTwo'>New Books</a></li>";
                    echo "<li><a href='newitems.php' class='buttonTwo'>New Items</a></li>";
            echo '</ul>';
            echo '</div>';
        }
        else {
            header("location: index.php");
            exit();
        }
    ?>
<?php
    include_once 'footer.php';
?>