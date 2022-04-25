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

            //checking if user has checked out this book already
            $bookID = mysqli_real_escape_string($conn, $_POST['bookID']);
            $sql = "SELECT * 
            FROM check_out_book
            WHERE check_out_book.Book_id = '$bookID' AND check_out_book.University_id = '$uniID'";
            $result = mysqli_query($conn, $sql);
            $q_results = mysqli_num_rows($result);
            if($q_results > 0) {
                //echo "You have already have this book!"
                header("location: ../index.php?error=request_error1");
                exit();
            }

            //checking if user has requested this book already
            $sql = "SELECT * 
            FROM request_book
            WHERE request_book.Book_id = '$bookID' AND request_book.University_id = '$uniID'";
            $result = mysqli_query($conn, $sql);
            $q_results = mysqli_num_rows($result);
            if($q_results > 0) {
                //echo "You have already requested this book!"
                header("location: ../index.php?error=request_error2");
                exit();
            }

            //inserting user and book into request_book
            $date = date('Y-m-d');
            $sql = "INSERT INTO request_book (University_id, Book_id, Request_date)
            VALUES ('$uniID','$bookID', '$date')";
            $result = mysqli_query($conn, $sql);

            //incrementing user's num of books
            $num_of_books += 1;
            $sql = "UPDATE users
            SET Last_updated = '$date', Num_of_books = '$num_of_books' 
            WHERE University_id = '$uniID';";
            $result = mysqli_query($conn, $sql);

            //ordering the specific bookID requests by date
            //use to find queue position for that specific book
            $sql = "SELECT *
            FROM request_book
            WHERE request_book.Book_id = '$bookID'
            ORDER BY Request_date ASC;";
            $result = mysqli_query($conn, $sql);
            $q_results_curr_queue_num = mysqli_num_rows($result);
            $data = mysqli_fetch_assoc($result);
            $requests = $data['University_id']; 
            $queue_num = $q_results_curr_queue_num;
            
            //echo "You've been placed in a queue. Position number: '$queue_num'"; //send to their request profile?
            header("location: ../requests.php"); //send to their checkouts profile?
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

            $sql_u = "SELECT *
            FROM USERS
            WHERE USERS.University_id = '$uniID'";
            $result = $conn->query($sql_u);

            if (!($result->num_rows > 0)) {
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

            //checking if user has checked out this book already
            $bookID = mysqli_real_escape_string($conn, $_GET['bookID']);
            $sql = "SELECT * 
            FROM check_out_book
            WHERE check_out_book.Book_id = '$bookID' AND check_out_book.University_id = '$uniID'";
            $result = mysqli_query($conn, $sql);
            $q_results = mysqli_num_rows($result);
            if($q_results > 0) {
                //echo "You have already have this book!"
                header("location: ../index.php?error=request_error1");
                exit();
            }

            //checking if user has requested this book already
            $sql = "SELECT * 
            FROM request_book
            WHERE request_book.Book_id = '$bookID' AND request_book.University_id = '$uniID'";
            $result = mysqli_query($conn, $sql);
            $q_results = mysqli_num_rows($result);
            if($q_results > 0) {
                //echo "You have already requested this book!"
                header("location: ../index.php?error=request_error2");
                exit();
            }

            if(isset($_SESSION["Staff_id"])) {
                //inserting user and book into request_book
                $date = date('Y-m-d');
                $sql = "INSERT INTO request_book (Staff_id, University_id, Book_id, Request_date)
                VALUES ('$staffID','$uniID','$bookID', '$date')";
                $result = mysqli_query($conn, $sql);
            }
            else {
                //inserting user and book into request_book
                $date = date('Y-m-d');
                $sql = "INSERT INTO request_book (Staff_id, University_id, Book_id, Request_date)
                VALUES ('$adminID','$uniID','$bookID', '$date')";
                $result = mysqli_query($conn, $sql);
            }

            //incrementing user's num of books
            $num_of_books += 1;
            $sql = "UPDATE users
            SET Last_updated = '$date', Num_of_books = '$num_of_books' 
            WHERE University_id = '$uniID';";
            $result = mysqli_query($conn, $sql);

            //ordering the specific bookID requests by date
            //use to find queue position for that specific book
            $sql = "SELECT *
            FROM request_book
            WHERE request_book.Book_id = '$bookID'
            ORDER BY Request_date ASC;";
            $result = mysqli_query($conn, $sql);
            $q_results_curr_queue_num = mysqli_num_rows($result);
            $data = mysqli_fetch_assoc($result);
            $requests = $data['University_id']; 
            $queue_num = $q_results_curr_queue_num;
            
            //echo "You've been placed in a queue. Position number: '$queue_num'"; //send to their request profile?
            header("location: ../requests.php"); //send to their checkouts profile?
            exit();
        }
        else {
            header("location: ../login.php?error=notloggedin");
            exit();
        }
?>