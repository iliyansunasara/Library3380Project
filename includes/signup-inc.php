<?php

if (isset($_POST["submit"])) {
    $UnivID = $_POST["uni"];
    $Pass = $_POST["pwd"];
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
    if (invalidEmail($Email) !== false) {
        header("location: ../signup.php?error=invalidemail");
        exit();
    }
    if (uidExists($conn, $UnivID) !== false) {
        header("location: ../signup.php?error=uidtaken");
        exit();
    }
    /*PASSWORD LENGTH MAYBE????*/
    //echo "It Works";
    createUser($conn, $UnivID, $Pass, $First, $Mid, $Last, $Stat, $Email, $DOB, $Tele, $Addr);

}
else {
    header("location: ../signup.php");
    exit();
}

?>