<?php
    include_once 'header.php';
?>

    <?php
        if(isset($_SESSION["Admin_id"])) {
            echo '<div class="prof">';
                echo '<ul>';
                    echo "<li><a href='addbook.php' class='buttonTwo'>Add Book</a></li>";
                    echo "<li><a href='additem.php' class='buttonTwo'>Add Item</a></li>";
            echo '</ul>';
        echo '</div>';
        }
        else {
            header("location: login.php");
            exit();
        }
    ?>
<?php
    include_once 'footer.php';
?>