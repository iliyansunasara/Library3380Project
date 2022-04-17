<?php
session_start();
?>
<?php


if (isset($_POST["addBook"])) {
    $file = $_FILES["cover"];
    $BookID = $_POST["bookid"];
    $Title = $_POST["title"];
    $Author = $_POST["author"];
    //print_r($file);
    $fileDestination = "";
    $fileName = $_FILES['cover']['name'];
    $fileTmpName = $_FILES['cover']['tmp_name'];
    $fileSize = $_FILES['cover']['size'];
    $fileError = $_FILES['cover']['error'];
    $fileType = $_FILES['cover']['type'];

    $fileExt = explode('.', $fileName);
    $fileActualExt = strtolower(end($fileExt));
    
    $allowed = array('jpg', 'png', 'gif', 'jpeg');

    if(in_array($fileActualExt, $allowed)) {
        if($fileError === 0) {
            if($fileSize < 500000) {
                // $fileNameNew = uniqid('', true).".".$fileActualExt;
                $fileDestination = '../covers/'.$_POST["bookid"].'.'.$fileActualExt;
                // $fileDestination = '../covers/'.$fileNameNew; //FIX MAYBE
                move_uploaded_file($fileTmpName, $fileDestination);
            }
            else {
                header("Location: ../addbook.php?error=filesize");
            }
        }
        else {
            header("Location: ../addbook.php?error=filefailed");
            exit();
        }
    }
    else {
        header("Location: ../addbook.php?error=filetype");
        exit();
    }
    // $Cover = 'covers/'.$fileNameNew;
    $Cover = 'covers/'.$_POST["bookid"].'.'.$fileActualExt;
    $Genre = $_POST["genre"];
    $AgeGroup = $_POST["ageG"];
    $Fiction = $_POST["isFict"];
    $Condition = $_POST["cond"];
    $CreatedBy = $_SESSION["Admin_id"];
    $LastUpdatedBy = $_SESSION["Admin_id"];

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
    addBook($conn, $BookID, $Title, $Author, $Cover, $Genre, $AgeGroup, $Fiction, $Condition, $CreatedBy, $LastUpdatedBy);
}
else {
    header("location: ../addbook.php");
    exit();
}

?>