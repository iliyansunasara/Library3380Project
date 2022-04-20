<?php
    session_start();
    if (isset($_POST["changeBook"])) {
        $file = $_FILES["cover"];
        $BookID = $_POST["bookIDD"];
        $Title = $_POST["title"];
        $Author = $_POST["author"];
        
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
                    $fileDestination = '../covers/'.$_POST["bookIDD"].'.'.$fileActualExt;
                    // $fileDestination = '../covers/'.$fileNameNew; //FIX MAYBE
                    move_uploaded_file($fileTmpName, $fileDestination);
                    // copy($_FILES[$file][$fileTmpName], $fileDestination);
                }
                else {
                    header("Location: ../addbook.php?error=filesize");
                    exit();
                }
            }
            else {
                header("Location: ../addbook.php?error=filefailed");
                exit();
            }
        }
        else {
            // header("Location: ../addbook.php?error=filetype");
            // exit();
            $fileName = $_POST["cover-old"];
            $fileExt = explode('.', $fileName);
            $fileActualExt = strtolower(end($fileExt));
        }

        // $Cover = 'covers/'.$fileNameNew;
        $Cover = 'covers/'.$_POST["bookIDD"].'.'.$fileActualExt;
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
        updateBook($conn, $BookID, $Title, $Author, $Cover, $Genre, $AgeGroup, $Fiction, $Condition, $LastUpdatedBy);
        header("location: ../editbook.php?error=none");
    }
    elseif (isset($_POST["deleteBook"])) {
        $BookID = $_POST["bookIDD"];
        require_once 'dbh-inc.php';
        require_once 'functions-inc.php';
        deleteBook($conn, $BookID);
        header("location: ../editbook.php?error=bookDeleted");
    }
    else {
        header("location: ../editbook.php");
        exit();
    }
?>