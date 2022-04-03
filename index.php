<?php
    include_once 'header.php';
?>
    <div class="loggedin">
        <?php
            if(isset($_SESSION["University_id"])) {
                echo "<p>Hello there, ". $_SESSION["University_id"] .".</p>";
            }
        ?>
    </div>
    
<?php
    include_once 'footer.php';
?>