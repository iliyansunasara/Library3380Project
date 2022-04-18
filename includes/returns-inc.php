<?php
    session_start();
    if(isset($_POST['bookID'])) {
        if(isset($_SESSION["Admin_id"]) || isset($_SESSION["Staff_id"])) {
            require_once 'dbh-inc.php';

            //grabs user returning the book
            $bookID = mysqli_real_escape_string($conn, $_POST['bookID']);
            $sql = "SELECT *
            FROM check_out_book
            WHERE check_out_book.Book_id = '$bookID'";
            $result = mysqli_query($conn, $sql);
            $q_results = mysqli_num_rows($result);

            if($q_results > 0) {
                $data = mysqli_fetch_assoc($result);
                $returner = $data['University_id'];
            }
            else {
                header("location: ../index.php?error=returning");
                exit();
            }

            //deletes from row
            $sql = "DELETE FROM check_out_book 
                    WHERE check_out_book.University_id = '$returner' AND check_out_book.Book_id = '$bookID";
            $result = mysqli_query($conn, $sql);

            $date = date('Y-m-d');
            //decrement the user's num of books
            $sql = "UPDATE users SET users.Num_of_books = users.Num_of_books - 1, Last_updated = '$date'
                    WHERE University_id = '$returner';";
            $result = mysqli_query($conn, $sql);

            //moving #1 in queue to check_out_books
            $sql = "SELECT *
            FROM request_book
            WHERE request_book.Book_id = '$bookID'
            ORDER BY Request_date ASC
            LIMIT 1;";
            $result = mysqli_query($conn, $sql);
            $q_results = mysqli_num_rows($result);
            if($q_results > 0) {
                $data = mysqli_fetch_assoc($result);
                $requester = $data['University_id'];

                //inserting new user into check_out_book
                $sql = "INSERT INTO check_out_book (University_id, Book_id, Checked_out_date)
                VALUES ('$requester','$bookID', '$date')";
                $result = mysqli_query($conn, $sql);

                header("location: ../index.php");
                exit();

            }
            else
            {
                header("location: ../index.php");
                exit();
            }

        }
    }
?>