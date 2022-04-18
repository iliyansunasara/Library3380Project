<?php
    include_once 'header.php';
?>

    <?php
        if(isset($_POST['staffReport']) && isset($_SESSION['Admin_id'])){
            require_once 'dbh-inc.php';
            require_once 'functions-inc.php';
            $start = $_POST['start'];
            $end = $_POST['end'];
            if (checkDatesGood($start, $end)) {
                createNewStaffTable($conn, $start, $end);
            }
            else {
                header("Location: newstaff.php?error=startdatebig");
                exit();
            } 
        }
        else {
            header("Location: login.php?error=loginpls");
            exit();
        }
    ?>

<?php
    include_once 'footer.php';
?>