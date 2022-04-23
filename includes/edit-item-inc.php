<?php
    session_start();
    if (isset($_POST["changeItem"])) {
        $ItemID = $_POST["itemID"];
        $Type = $_POST["type"];
        $Condition = $_POST["cond"];
        $LastUpdatedBy = $_SESSION["Admin_id"];

        require_once 'dbh-inc.php';
        require_once 'functions-inc.php';

        if (emptyInputUpdateItem($Type, $Condition, $LastUpdatedBy) !== false) {
            header("location: ../edititem.php?error=emptyinput");
            exit();
        }
        updateItem($conn, $ItemID, $Type, $Condition, $LastUpdatedBy);
        header("location: ../edititem.php?error=none");
    }
    elseif (isset($_POST["deleteItem"])) {
        $ItemID = $_POST["itemID"];
        require_once 'dbh-inc.php';
        require_once 'functions-inc.php';
        deleteItem($conn, $ItemID);
        header("location: ../edititem.php?error=itemDeleted");
    }
    else {
        header("location: ../edititem.php");
        exit();
    }
?>