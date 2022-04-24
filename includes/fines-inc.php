<?php
    require_once 'dbh-inc.php';
    require_once 'functions-inc.php';
    if (isset($_POST["updateFine"])) {
        $UnivID = $_POST["uid"];
        $Fine = $_POST["fines"];
    
        require_once 'dbh-inc.php';
        require_once 'functions-inc.php';
    
        if ($Fine < 0) {
            header("location: ../fines.php?error=emptyinput");
            exit();
        }
        updateUserFine($conn, $UnivID, $Fine);
    }
    if (isset($_POST["addFine"])) {
        $UnivID = $_POST["uid"];
        $Fine = $_POST["fines"];
    
        require_once 'dbh-inc.php';
        require_once 'functions-inc.php';
        if ($Fine < 0|| empty($UnivID)) {
            header("location: ../fines.php?error=emptyinput");
            exit();
        }
        else if (uidExists($conn, $UnivID) === false){
            header("location: ../fines.php?error=uidNotFound");
            exit();
        }
        else {
            updateUserFine($conn, $UnivID, $Fine);
        }
    }
    else {
        header("location: ../index.php");
        exit();
    }
?>