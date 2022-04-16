<?php
    if (isset($_POST["submit"])) {
        $ID = $_POST["id"];
        $Pass = $_POST["pwd"];

        require_once 'dbh-inc.php';
        require_once 'functions-inc.php';

        if (emptyInputLogin($ID, $Pass) !== false) {
            header("location: ../login.php?error=emptyinput");
            exit();
        }
        loginPerson($conn, $ID, $Pass);
    }
    else {
        header("location: ../login.php");
        exit();
    }
?>