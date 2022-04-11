<?php
    session_start();
    if (isset($_POST["submit"])) {
        $StaffID = $_SESSION["Staff_id"];
        $First = $_POST["fname"];
        $Mid = $_POST["minit"];
        $Last = $_POST["lname"];
        $Email = $_POST["email"];
        $Tele = $_POST["tele"];
        $Addr = $_POST["addy"];

        require_once 'dbh-inc.php';
        require_once 'functions-inc.php';

        if (emptyInputUpdateProfile($First, $Last, $Email, $Tele, $Addr) !== false) {
            header("location: ../editprofile.php?error=emptyinput");
            exit();
        }
        if (invalidEmail($Email) !== false) {
            header("location: ../editprofile.php?error=invalidemail");
            exit();
        }
        updateStaff($conn, $StaffID, $First, $Mid, $Last, $Email, $Tele, $Addr);
}
else {
    header("location: ../login.php");
    exit();
}
?>