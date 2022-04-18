<?php
    session_start();
    if(isset($_POST['staffReport']) && isset($_SESSION['Admin_id'])){
        require_once 'dbh-inc.php';
        require_once 'functions-inc.php';
        $start = $_POST['start'];
        $end = $_POST['end'];
        if (checkDatesGood($start, $end)) {
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