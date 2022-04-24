<?php
    require_once 'dbh-inc.php';
    require_once 'functions-inc.php';
    if (isset($_POST["addStaff"])) {
        $StaffID = $_POST["sid"];
        $Pass = $_POST["pwd"];
        $Confirm = $_POST["confirm"];
        $First = $_POST["fname"];
        $Mid = $_POST["minit"];
        $Last = $_POST["lname"];
        $DOB = $_POST["dob"];
        $Salary = $_POST["salary"];
        $Email = $_POST["email"];
        $Tele = $_POST["tele"];
        $Addr = $_POST["addy"];
        $Stat = $_POST["status"];
    
        require_once 'dbh-inc.php';
        require_once 'functions-inc.php';
    
        if (emptyInputAddStaff($StaffID, $Pass, $Confirm, $First, $Last, $DOB, $Salary, $Email, $Tele, $Addr, $Stat) !== false) {
            header("location: ../staff.php?error=emptyinput");
            exit();
        }
        if (invalidSid($StaffID) !== false) {
            header("location: ../staff.php?error=invalidsid");
            exit();
        }
        if ($Pass !== $Confirm) {
            header("location: ../staff.php?error=matchpwd");
            exit();
        }
        if (invalidEmail($Email) !== false) {
            header("location: ../staff.php?error=invalidemail");
            exit();
        }
        if (sidExists($conn, $StaffID) !== false) {
            header("location: ../staff.php?error=sidtaken");
            exit();
        }
        addStaff($conn, $StaffID, $Pass, $First, $Mid, $Last, $DOB, $Salary, $Email, $Tele, $Addr, $Stat);
    }
    if (isset($_POST["submit"])) {
        $StaffID = $_POST["sid"];
        $First = $_POST["fname"];
        $Mid = $_POST["minit"];
        $Last = $_POST["lname"];
        $Email = $_POST["email"];
        $DOB = $_POST["dob"];
        $Tele = $_POST["tele"];
        $Addr = $_POST["addy"];
        $Salary = $_POST["salary"];

        if (emptyInputStaffUpdate($StaffID, $First, $Last, $Email, $DOB, $Tele, $Addr, $Salary) !== false) {
            header("location: ../staff.php?error=emptyinput");
            exit();
        }
        if (invalidEmail($Email) !== false) {
            header("location: ../staff.php?error=invalidemail");
            exit();
        }
        updateStaffAdmin($conn, $StaffID, $First, $Mid, $Last, $Email, $DOB, $Tele, $Addr, $Salary);
    }
    if (isset($_GET['delete'])) {
        $StaffID = $_GET['delete'];
        if (sidCOB($conn, $StaffID) === false && sidCOI($conn, $StaffID) === false) {
            deleteStaff($conn, $StaffID);
            header("location: ../staff.php?error=staffDeleted");
            exit();
        }
        else {
            header("location: ../staff.php?error=staffCO");
            exit();
        }
    }
    else {
        header("location: ../index.php");
        exit();
    }
?>