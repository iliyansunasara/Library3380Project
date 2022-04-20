<?php
    session_start();
    if(isset($_POST['submit']) && isset($_SESSION['Admin_id'])){
        require_once 'dbh-inc.php';
        require_once 'functions-inc.php';


        $StaffID = $_POST['sid'];
        $UnivID = $_POST['uid'];
        $BookID = $_POST['bid'];
        $Title = $_POST['title'];
        $Author = $_POST['author'];
        $Genre = $_POST['genre'];
        $AgeGroup = $_POST['ageG'];
        $Fiction = $_POST['isFict'];
        $Condition = $_POST['cond'];

        $startCOB = $_POST['startCOB'];
        $endCOB = $_POST['endCOB'];

        if (checkDatesGood($startCOB, $endCOB)) {
            createReportCOBTable($conn, $StaffID, $UnivID, $BookID, $Title, $Author, $Genre, $AgeGroup, $Fiction, $Condition, $startCOB, $endCOB);
    }
        else {
            header("Location: ../newstaff.php?error=startdatebig");
            exit();
        } 
    }
    else {
        header("Location: ../login.php?error=loginpls");
        exit();
    }
?>