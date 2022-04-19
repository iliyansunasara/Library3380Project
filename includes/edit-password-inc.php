<?php
    session_start();
    if (isset($_POST["submit"])) {
        if (isset($_SESSION["University_id"])) {
            $UnivID = $_SESSION["University_id"];
            $Old = $_POST["old"];
            $New = $_POST["new"];
            $Confirm = $_POST["confirm"];

            require_once 'dbh-inc.php';
            require_once 'functions-inc.php';
    
            if (emptyInputUpdatePass($Old, $New, $Confirm) !== false) {
                header("location: ../edit-password.php?error=emptyinput");
                exit();
            }
            else if ($New != $Confirm) {
                header("location: ../edit-password.php?error=match");
                exit();
            }
            updatePass($conn,'USERS', $UnivID, $Old, $New);
        }
        else if (isset($_SESSION["Staff_id"]) || isset($_SESSION["Admin_id"])) {
            if (isset($_SESSION["Staff_id"])) {
                $StaffID = $_SESSION["Staff_id"];
            }
            else {
                $StaffID = $_SESSION["Admin_id"];
            }
            $Old = $_POST["old"];
            $New = $_POST["new"];
            $Confirm = $_POST["confirm"];

            require_once 'dbh-inc.php';
            require_once 'functions-inc.php';
    
            if (emptyInputUpdatePass($Old, $New, $Confirm) !== false) {
                header("location: ../edit-password.php?error=emptyinput");
                exit();
            }
            else if ($New != $Confirm) {
                header("location: ../edit-password.php?error=match");
                exit();
            }
            updatePass($conn,'STAFF', $StaffID, $Old, $New);
        }
    }
    else {
        header("location: ../login.php");
        exit();
    }
?>