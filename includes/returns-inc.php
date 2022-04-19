<?php
    session_start();
    require_once 'dbh-inc.php';
    require_once 'functions-inc.php';
    if(isset($_SESSION["Admin_id"]) || isset($_SESSION["Staff_id"])) {
        //grabs user returning the book
        //$bookID = mysqli_real_escape_string($conn, $_POST['bookID']);
        $bookID = $_POST['bookID'];
        $result = getResult($conn, $bookID);
        $data = $result->fetch_assoc();
        $returner = $data['University_id'];
        returnBook($conn, $bookID);

            $date = date('Y-m-d');
            //decrement the user's num of books
            $sql = "UPDATE users SET users.Num_of_books = users.Num_of_books - 1, Last_updated = '$date' WHERE University_id = '$returner';";
            $result = $conn->query($sql);

            //moving #1 in queue to check_out_books
            $sql = "SELECT *
            FROM request_book
            WHERE request_book.Book_id = '$bookID'
            ORDER BY Request_date ASC
            LIMIT 1;";
            $result = $conn->query($sql);
            // $data = $result->fetch_assoc();
            // $reqq = $data['University_id'];
            // $sql = "UPDATE users SET users.Num_of_books = users.Num_of_books + 1, Last_updated = '$date' WHERE University_id = '$reqq';";
            // $conn->query($sql);

            deleteQueue($conn, $bookID);

            if($result->num_rows > 0) {
                $data = $result->fetch_assoc();
                $requester = $data['University_id'];

                //inserting new user into check_out_book
                $sql = "INSERT INTO check_out_book (University_id, Book_id, Checked_out_date)
                VALUES ('$requester','$bookID', '$date')";
                $result = $conn->query($sql);

                header("location: ../index.php");
                exit();

            }
            else
            {
                header("location: ../index.php");
                exit();
            }

        }
?>
