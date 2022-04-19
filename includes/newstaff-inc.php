<?php
    session_start();
    if(isset($_POST['submit']) && isset($_SESSION['Admin_id'])){
        require_once 'dbh-inc.php';
        require_once 'functions-inc.php';
        $StaffID = $_POST['sid'];
        $Fname = $_POST['fname'];
        $Mid = $_POST['minit'];
        $Lname = $_POST['lname'];
        $startDOB = $_POST['startDob'];
        $endDOB = $_POST['endDob'];
        $Email = $_POST['email'];
        $PhoneNum = $_POST['tele'];
        $startSal = $_POST['startSal'];
        $endSal = $_POST['endSal'];
        $startEdit = $_POST['startEdit'];
        $endEdit = $_POST['endEdit'];
        $startHire = $_POST['startHire'];
        $endHire = $_POST['endHire'];
        if (checkDatesGood($startHire, $endHire) && checkDatesGood($startDOB, $endDOB) && checkDatesGood($startEdit, $endEdit)) {
            if (checkDatesGood($startSal, $endSal)) {
                createNewStaffTable($conn, $startHire, $endHire, $StaffID, $Fname,
                $Mid, $Lname, $startDOB, $endDOB, $Email, $PhoneNum,
                $startSal, $endSal,$startEdit, $endEdit);
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