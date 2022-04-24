<?php
    require_once 'dbh-inc.php';
    require_once 'functions-inc.php';
    if (isset($_POST["submit"])) {
        $UnivID = $_POST["uni"];
        $First = $_POST["fname"];
        $Mid = $_POST["minit"];
        $Last = $_POST["lname"];
        $Stat = $_POST["status"];
        $Email = $_POST["email"];
        $DOB = $_POST["dob"];
        $Tele = $_POST["tele"];
        $Addr = $_POST["addy"];
        $Fine = $_POST["fine"];

        if (emptyInputUserUpdate($UnivID, $First, $Last, $Stat, $Email, $DOB, $Tele, $Addr, $Fine) !== false) {
            header("location: ../users.php?error=emptyinput");
            exit();
        }
        if (invalidEmail($Email) !== false) {
            header("location: ../users.php?error=invalidemail");
            exit();
        }
        updateUserAdmin($conn, $UnivID, $First, $Mid, $Last, $Stat, $Email, $DOB, $Tele, $Addr, $Fine);
    }
    if (isset($_GET['delete'])) {
        $UnivID = $_GET['delete'];
        if (uidCOI($conn, $UnivID) === false && uidCOB($conn, $UnivID) === false) {
            deleteUser($conn, $UnivID);
            header("location: ../users.php?error=userDeleted");
            exit();
        }
        else {
            header("location: ../users.php?error=hasCO");
            exit();
        }
    }
    else {
        header("location: ../index.php");
        exit();
    }
?>