<?php
    session_start();
    if(isset($_POST['submit']) && isset($_SESSION['Admin_id'])){
        require_once 'dbh-inc.php';
        require_once 'functions-inc.php';

        $UnivID = $_POST['uid'];
        $Fname = $_POST['fname'];
        $Mid = $_POST['minit'];
        $Lname = $_POST['lname'];
        $Stat = $_POST['status'];
        $Email = $_POST['email'];
        $PhoneNum = $_POST['tele'];
        $Address = $_POST['addy'];

        $startDOB = $_POST['startDob'];
        $endDOB = $_POST['endDob'];

        $startFines = $_POST['startFines'];
        $endFines = $_POST['endFines'];

        $startBooks = $_POST['startBooks'];
        $endBooks = $_POST['endBooks'];

        $startCalc = $_POST['startCalc'];
        $endCalc = $_POST['endCalc'];

        $startLap = $_POST['startLap'];
        $endLap = $_POST['endLap'];

        $startHead = $_POST['startHead'];
        $endHead= $_POST['endHead'];

        $startEdit = $_POST['startEdit'];
        $endEdit = $_POST['endEdit'];

        $startJoin = $_POST['startJoin'];
        $endJoin = $_POST['endJoin'];

        if (checkDatesGood($startJoin, $endJoin) && checkDatesGood($startDOB, $endDOB) && checkDatesGood($startEdit, $endEdit)) {
            if (checkDatesGood($startFines, $endFines) && checkDatesGood($startBooks, $endBooks)
            && checkDatesGood($startCalc, $endCalc) && checkDatesGood($startLap, $endLap) && checkDatesGood($startHead, $endHead)) {
                createReportUsersTable($conn, $UnivID, $Fname, $Mid, $Lname, $Stat, $Email, $PhoneNum, $Address, $startDOB, $endDOB,
                $startFines, $endFines, $startBooks, $endBooks, $startCalc, $endCalc, $startLap, $endLap, $startHead, $endHead, 
                $startEdit, $endEdit, $startJoin, $endJoin);
            }
            else {
                header("Location: ../newstaff.php?error=startsalarybig");
                exit();
            }
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