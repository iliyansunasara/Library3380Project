<?php
    session_start();
        if(isset($_SESSION["University_id"])) {
            require_once 'dbh-inc.php';

            //checking if student or faculty member & get current number of books
            $uniID = mysqli_real_escape_string($conn, $_SESSION['University_id']);
            $sql = "SELECT *
            FROM users
            WHERE users.University_id = '$uniID'";
            $result = mysqli_query($conn, $sql);
            $q_results_status = mysqli_num_rows($result);
            $data = mysqli_fetch_assoc($result);
            $status = $data['Status'];
            
            if(!isset($data['Num_of_books'])) {
                $num_of_books = 0;
            }
            else {
                $num_of_books = $data['Num_of_books'];
            }

            if($status == "S" && $num_of_books >= 2)
            {
                //echo "You already have 2 books checked out!"
                header("location: ../index.php?error=stud_exceed");
                exit();
            }

            if($status == "F" && $num_of_books >= 3)
            {
                //echo "You already have 3 books checked out!";
                header("location: ../index.php?error=fac_exceed");
                exit();
            }

            $num_of_books += 1;
            
            $date = date('Y-m-d');
            //updating users info
            $bookID = mysqli_real_escape_string($conn, $_POST['bookID']);
            $sql = "UPDATE users
            SET Last_updated = '$date', Num_of_books = '$num_of_books' 
            WHERE University_id = '$uniID';";
            $result = mysqli_query($conn, $sql);

            //inserting user and book into check_out_book
            $sql = "INSERT INTO check_out_book (University_id, Book_id, Checked_out_date)
            VALUES ('$uniID','$bookID', '$date')";
            $result = mysqli_query($conn, $sql);

            header("location: ../checkouts.php"); //send to their checkouts profile?
            exit();
            
        }
        elseif(isset($_SESSION["Admin_id"]) || isset($_SESSION["Staff_id"])) {
            require_once 'dbh-inc.php';
            require_once 'functions-inc.php';
            
            if(isset($_SESSION["Staff_id"])) {
                $staffID = mysqli_real_escape_string($conn, $_SESSION['Staff_id']);
            }
            else {
                $adminID = mysqli_real_escape_string($conn, $_SESSION['Admin_id']);
            }


            //checking if student or faculty member & get current number of books
            $uniID = mysqli_real_escape_string($conn, $_GET['uni']);

            if (uidExists($conn, $uniID) !== false) {
                header("location: ../index.php?error=wrongID");
                exit();
            }


            $sql = "SELECT *
            FROM users
            WHERE users.University_id = '$uniID'";
            $result = mysqli_query($conn, $sql);
            $q_results_status = mysqli_num_rows($result);
            $data = mysqli_fetch_assoc($result);
            $status = $data['Status'];
            
            if(!isset($data['Num_of_books'])) {
                $num_of_books = 0;
            }
            else {
                $num_of_books = $data['Num_of_books'];
            }

            if($status == "S" && $num_of_books >= 2)
            {
                //echo "You already have 2 books checked out!"
                header("location: ../index.php?error=stud_exceed");
                exit();
            }

            if($status == "F" && $num_of_books >= 3)
            {
                //echo "You already have 3 books checked out!";
                header("location: ../index.php?error=fac_exceed");
                exit();
            }

            $num_of_books += 1;
            
            $date = date('Y-m-d');
            //updating users info
            $bookID = mysqli_real_escape_string($conn, $_GET['bookID']);
            $sql = "UPDATE users
            SET Last_updated = '$date', Num_of_books = '$num_of_books' 
            WHERE University_id = '$uniID';";
            $result = mysqli_query($conn, $sql);

            if(isset($_SESSION['Staff_id'])) {
                //inserting user and book and staff into check_out_book
                $sql = "INSERT INTO check_out_book (Staff_id, University_id, Book_id, Checked_out_date)
                VALUES ('$staffID','$uniID','$bookID', '$date')";
                $result = mysqli_query($conn, $sql);
            }
            else{
                //inserting user and book and staff into check_out_book
                $sql = "INSERT INTO check_out_book (Staff_id, University_id, Book_id, Checked_out_date)
                VALUES ('$adminID','$uniID','$bookID', '$date')";
                $result = mysqli_query($conn, $sql);
            }

            header("location: ../checkouts.php"); //send to their checkouts profile?
            exit();
            
        }
        else {
            header("location: ../login.php?error=notloggedin");
            exit();
        }
?>