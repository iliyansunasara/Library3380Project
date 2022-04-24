<?php
    session_start();
    if(isset($_POST['submit']) && isset($_SESSION['Admin_id'])){
        require_once 'dbh-inc.php';
        require_once 'functions-inc.php';

        $BookID = $_POST['bid'];
        $Title = $_POST['title'];
        $Author = $_POST['author'];
        $Genre = $_POST['genre'];
        $AgeGroup = $_POST['ageG'];
        $Fiction = $_POST['isFict'];
        $Condition = $_POST['cond'];
        $Creator = $_POST['creator'];
        $Updator = $_POST['updator'];

        $startAdd = $_POST['startAdd'];
        $endAdd = $_POST['endAdd'];
        $startUp = $_POST['startUP'];
        $endUp = $_POST['endUP'];

        if (checkDatesGood($startAdd, $endAdd) && checkDatesGood($startUp, $endUp)) {
            createReportBookTable($conn, $BookID, $Title, $Author, $Genre, $AgeGroup, $Fiction, $Condition,
            $Creator, $Updator, $startAdd, $endAdd, $startUp, $endUp);
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