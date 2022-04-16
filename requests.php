<?php
    include_once 'header.php';
?>
    <?php
        if(isset($_SESSION["University_id"])) {
            require_once 'includes/dbh-inc.php';
            require_once 'includes/functions-inc.php';
            createBookReqTable($conn, $_SESSION["University_id"]);
            createItemReqTable($conn, $_SESSION["University_id"]);
        }
        else if(isset($_SESSION["Staff_id"])) {
            require_once 'includes/dbh-inc.php';
            require_once 'includes/functions-inc.php';
            createUserBookReqTable($conn, $_SESSION["Staff_id"]);
            createUserItemReqTable($conn, $_SESSION["Staff_id"]);
        }
        else if(isset($_SESSION["Admin_id"])) {
            require_once 'includes/dbh-inc.php';
            require_once 'includes/functions-inc.php';
            createUserBookReqTable($conn, $_SESSION["Admin_id"]);
            createUserItemReqTable($conn, $_SESSION["Admin_id"]);
        }
        else {
            header("location: login.php");
        }
    ?>
<?php
    include_once 'footer.php';
?>