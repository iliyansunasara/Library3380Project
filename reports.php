<?php
    include_once 'header.php';
?>
    <?php
        if(isset($_SESSION["Admin_id"])) {
            echo '<div class="prof">';
                echo '<ul>';
                    echo "<li><a href='newstaff.php' class='buttonTwo'>Staff Report</a></li>";
                    echo "<li><a href='report-users.php' class='buttonTwo'>Users Report</a></li>";
                    echo "<li><a href='report-co-book.php' class='buttonTwo'>Checkout Books Report</a></li>";
                    echo "<li><a href='report-book.php' class='buttonTwo'>Book Report</a></li>";
                    echo "<li><a href='report-item.php' class='buttonTwo'>Item Report</a></li>";
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