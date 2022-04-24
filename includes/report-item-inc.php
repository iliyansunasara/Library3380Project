<?php
    session_start();
    if(isset($_POST['submit']) && isset($_SESSION['Admin_id'])){
        require_once 'dbh-inc.php';
        require_once 'functions-inc.php';

        $BookID = $_POST['iid'];
        $ItemType = $_POST['itemType'];
        $Condition = $_POST['cond'];
        $Creator = $_POST['creator'];
        $Updator = $_POST['updator'];

        $startAdd = $_POST['startAdd'];
        $endAdd = $_POST['endAdd'];
        $startUp = $_POST['startUP'];
        $endUp = $_POST['endUP'];

        if (checkDatesGood($startAdd, $endAdd) && checkDatesGood($startUp, $endUp)) {
            createReportItemTable($conn, $BookID, $ItemType, $Condition, $Creator, $Updator, $startAdd, $endAdd, $startUp, $endUp);
    }
        else {
            header("Location: ../newstaff.php?error=startdatebig");
            exit();
        } 
    }
    else {
        header("Location: ../login.php?error=loginpls");
        exit();
    }
?>