<?php
session_start();
if (isset($_POST["addItem"])) {
    $ItemID = $_POST["itemid"];
    $Type = $_POST["type"];
    $Condition = $_POST["cond"];
    $CreatedBy = $_SESSION["Staff_id"];
    $LastUpdatedBy = $_SESSION["Staff_id"];

    require_once 'dbh-inc.php';
    require_once 'functions-inc.php';

    if (emptyInputAdditem($ItemID, $Type, $Condition, $CreatedBy, $LastUpdatedBy) !== false) {
        header("location: ../additem.php?error=emptyinput");
        exit();
    }
    if (invalidItemID($ItemID) !== false) {
        header("location: ../additem.php?error=invalidItemID");
        exit();
    }
    if (strlen($ItemID) != 12) {
        header("location: ../additem.php?error=invalidItemID");
        exit();
    }
    if (itemIDExists($conn, $ItemID) !== false) {
        header("location: ../additem.php?error=itemIDtaken");
        exit();
    }
    addItem($conn, $ItemID, $Type, $Condition, $CreatedBy, $LastUpdatedBy);
}
else {
    header("location: ../additem.php");
    exit();
}

?>