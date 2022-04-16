<?php
session_start();
if (isset($_POST["addBook"])) {
    $BookID = $_POST["bookid"];
    $Title = $_POST["title"];
    $Author = $_POST["author"];
    // $Cover = $_POST["coverAddy"];
    $Genre = $_POST["genre"];
    $AgeGroup = $_POST["ageG"];
    $Fiction = $_POST["isFict"];
    $Condition = $_POST["cond"];
    $CreatedBy = $_SESSION["Staff_id"];
    $LastUpdatedBy = $_SESSION["Staff_id"];

    require_once 'dbh-inc.php';
    require_once 'functions-inc.php';

    if (emptyInputAddbook($BookID, $Title, $Author, $Genre, $AgeGroup, $Fiction, $Condition, $CreatedBy, $LastUpdatedBy) !== false) {
        header("location: ../addbook.php?error=emptyinput");
        exit();
    }
    if (invalidBookID($BookID) !== false) {
        header("location: ../addbook.php?error=invalidBookID");
        exit();
    }
    if (strlen($BookID) != 12) {
        header("location: ../addbook.php?error=invalidBookID");
        exit();
    }
    if (bookIDExists($conn, $BookID) !== false) {
        header("location: ../addbook.php?error=bookIDtaken");
        exit();
    }
    addBook($conn, $BookID, $Title, $Author, $Genre, $AgeGroup, $Fiction, $Condition, $CreatedBy, $LastUpdatedBy);
}
else {
    header("location: ../addbook.php");
    exit();
}

?>