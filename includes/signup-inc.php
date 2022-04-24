<?php

if (isset($_POST["submit"])) {
    $UnivID = $_POST["uni"];
    $Pass = $_POST["pwd"];
    $ConfirmPass = $_POST["confirm"];
    $First = $_POST["fname"];
    $Mid = $_POST["minit"];
    $Last = $_POST["lname"];
    $Stat = $_POST["status"];
    $Email = $_POST["email"];
    $DOB = $_POST["dob"];
    $Tele = $_POST["tele"];
    $Addr = $_POST["addy"];

    require_once 'dbh-inc.php';
    require_once 'functions-inc.php';

    if (emptyInputSignup($UnivID, $Pass, $First, $Last, $Stat, $Email, $DOB, $Tele, $Addr) !== false) {
        header("location: ../signup.php?error=emptyinput");
        exit();
    }
    if (invalidUid($UnivID) !== false) {
        header("location: ../signup.php?error=invaliduid");
        exit();
    }
    if (strlen($UnivID) != 7) {
        header("location: ../signup.php?error=invaliduid");
        exit();
    }
    if ($Pass !== $ConfirmPass) {
        header("location: ../signup.php?error=matchpwd");
        exit();
    }
    if (invalidEmail($Email) !== false) {
        header("location: ../signup.php?error=invalidemail");
        exit();
    }
    if (uidExists($conn, $UnivID) !== false) {
        header("location: ../signup.php?error=uidtaken");
        exit();
    }
    createUser($conn, $UnivID, $Pass, $First, $Mid, $Last, $Stat, $Email, $DOB, $Tele, $Addr);

}
if (isset($_POST["signup"])) {
    $UnivID = $_POST["uni"];
    $Pass = $_POST["pwd"];
    $ConfirmPass = $_POST["confirm"];
    $First = $_POST["fname"];
    $Mid = $_POST["minit"];
    $Last = $_POST["lname"];
    $Stat = $_POST["status"];
    $Email = $_POST["email"];
    $DOB = $_POST["dob"];
    $Tele = $_POST["tele"];
    $Addr = $_POST["addy"];

    require_once 'dbh-inc.php';
    require_once 'functions-inc.php';
    if (emptyInputSignup($UnivID, $Pass, $First, $Last, $Stat, $Email, $DOB, $Tele, $Addr) !== false) {
        header("location: ../users.php?error=emptyinput");
        exit();
    }
    if (invalidUid($UnivID) !== false) {
        header("location: ../users.php?error=invaliduid");
        exit();
    }
    if ($Pass !== $ConfirmPass) {
        header("location: ../users.php?error=matchpwd");
        exit();
    }
    if (invalidEmail($Email) !== false) {
        header("location: ../users.php?error=invalidemail");
        exit();
    }
    if (uidExists($conn, $UnivID) !== false) {
        header("location: ../users.php?error=uidtaken");
        exit();
    }
    createUserAdmin($conn, $UnivID, $Pass, $First, $Mid, $Last, $Stat, $Email, $DOB, $Tele, $Addr);

}
else {
    header("location: ../signup.php");
    exit();
}

?>