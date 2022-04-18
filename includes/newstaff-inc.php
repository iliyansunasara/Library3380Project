<?php
    session_start();
    if(isset("staffReport") && isset($_SESSION['Admin_id'])){
        require_once 'includes/dbh-inc.php';
        require_once 'includes/functions-inc.php';
        $start = $_POST['start'];
        $end = $_POST['end']);
        if (checkDatesGood($start, $end) {
            createNewStaffTable($conn, $start, $end);
        }
        else {
            header("Location: newstaff.php.php?error=startdatebig");
            exit();
        }
        
    }
    else {
        header("Location: login.php?error=loginpls");
        exit();
    }
?>