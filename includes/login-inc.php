<?php
    if (isset($_POST["submit"])) {
        $UnivID = $_POST["uni"];
        $Pass = $_POST["pwd"];

        require_once 'dbh-inc.php';
        require_once 'functions-inc.php';

        if (emptyInputLogin($UnivID, $Pass) !== false) {
            header("location: ../login.php?error=emptyinput");
            exit();
        }
        loginUser($con, $UnivID, $Pass);
    }
    else {
        header("location: ../login.php");
        exit();
    }
?>