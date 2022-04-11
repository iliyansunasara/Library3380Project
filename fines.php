<?php
    include_once 'header.php';
?>
    <?php
        if(isset($_SESSION["University_id"])) {
            require_once 'includes/dbh-inc.php';
            require_once 'includes/functions-inc.php';
            createFineTable($conn, $_SESSION["University_id"]);
        }
        else if(isset($_SESSION["Staff_id"])){
            require_once 'includes/dbh-inc.php';
            require_once 'includes/functions-inc.php';
            createUsersFineTable($conn);
        }
        else {
            header("location: login.php");
        }
    ?>
<?php
    include_once 'footer.php';
?>