<?php
    if (isset($_POST["submit"])) {
        $StaffID = $_POST["sid"];
        $Pass = $_POST["spwd"];

        require_once 'dbh-inc.php';
        require_once 'functions-inc.php';

        if (emptyInputLogin($StaffID, $Pass) !== false) {
            header("location: ../login.php?error=emptyinput");
            exit();
        }
        loginStaff($conn, $StaffID, $Pass);
    }
    else {
        header("location: ../login.php");
        exit();
    }
?>