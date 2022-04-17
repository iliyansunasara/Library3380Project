<?php
session_start();
if (isset($_POST["addStaff"])) {
    $StaffID = $_POST["staffid"];
    $Pass = $_POST["pwd"];
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

    if (emptyInputAddStaff($StaffID, $Pass, $First, $Last, $DOB, $Salary, $Email, $Tele, $Addr, $Stat) !== false) {
        header("location: ../addstaff.php?error=emptyinput");
        exit();
    }
    if (invalidSid($StaffID) !== false) {
        header("location: ../addstaff.php?error=invalidsid");
        exit();
    }
    if (strlen($StaffID) != 8) {
        header("location: ../addstaff.php?error=invalidsid");
        exit();
    }
    if (invalidEmail($Email) !== false) {
        header("location: ../addstaff.php?error=invalidemail");
        exit();
    }
    if (sidExists($conn, $StaffID) !== false) {
        header("location: ../addstaff.php?error=sidtaken");
        exit();
    }
    addStaff($conn, $StaffID, $Pass, $First, $Mid, $Last, $DOB, $Salary, $Email, $Tele, $Addr, $Stat);
}
elseif (isset($_POST["deleteStaff"])) {
    $StaffID = $_POST["staffid"];
    require_once 'dbh-inc.php';
    require_once 'functions-inc.php';
    if(empty($StaffID)) {
        header("location: ../deletestaff.php?error=emptyinput");
        exit();
    }
    elseif(noStaff($conn, $StaffID) !== false) {
        deleteStaff($conn, $StaffID);
        exit();
    }
    header("location: ../deletestaff.php?error=noStaffID");
}
else {
    header("location: ../addstaff.php");
    exit();
}

?>