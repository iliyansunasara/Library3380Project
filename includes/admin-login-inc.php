<?php
    if (isset($_POST["submit"])) {
        $AdminID = $_POST["adminid"];
        $Pass = $_POST["adminpwd"];

        require_once 'dbh-inc.php';
        require_once 'functions-inc.php';

        if (emptyInputLogin($AdminID, $Pass) !== false) {
            header("location: ../login.php?error=emptyinput");
            exit();
        }
        loginAdmin($conn, $AdminID, $Pass);
    }
    else {
        header("location: ../login.php");
        exit();
    }
?>