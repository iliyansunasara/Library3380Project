<?php
    session_start();
    if (isset($_POST["changeBook"])) {
        $BookID = $_POST["bookIDD"];
        $Title = $_POST["title"];
        $Author = $_POST["author"];
        $Genre = $_POST["genre"];
        $AgeGroup = $_POST["ageG"];
        $Fiction = $_POST["isFict"];
        $Condition = $_POST["cond"];
        $LastUpdatedBy = $_SESSION["Admin_id"];

        require_once 'dbh-inc.php';
        require_once 'functions-inc.php';

        if (emptyInputUpdateBook($Title, $Author, $Genre, $AgeGroup, $Fiction, $Condition, $LastUpdatedBy) !== false) {
            header("location: ../editbook.php?error=emptyinput");
            exit();
        }
        updateBook($conn, $BookID, $Title, $Author, $Genre, $AgeGroup, $Fiction, $Condition, $LastUpdatedBy);
    }
    else {
        echo '<script>alert("Something went wrong, please try again!")</script>';
        header("location: ../index.php");
        exit();
    }
?>