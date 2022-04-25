<?php
    require_once 'dbh-inc.php';
    require_once 'functions-inc.php';
    if (isset($_GET['deleteBook'])) {
        $BookID = $_GET['deleteBook'];
        $UnivID = $_GET['user'];
        deleteUserBookReq($conn, $UnivID, $BookID);
        header("location: ../requests.php?error=none");
        exit();
    }
    if (isset($_GET['deleteItem'])) {
        $ItemID = $_GET['deleteItem'];
        $UnivID = $_GET['user'];
        deleteUserItemReq($conn, $UnivID, $ItemID);
        header("location: ../requests.php?error=none");
        exit();
    }
    else {
        header("location: ../index.php");
        exit();
    }
?>