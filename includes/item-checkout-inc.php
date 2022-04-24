<?php 
session_start();
if(isset($_GET["confirm-checkout"])) {
    include_once 'dbh-inc.php';
    $itemID = $_GET['itemID'];
    $uniID = $_GET['uni'];

    $sql = "SELECT *
    FROM ITEM
    WHERE ITEM.Item_id = '$itemID'";
    $result = $conn->query($sql);
    $data = $result->fetch_assoc();
    $type = $data['Item_type'];

    $sql = "SELECT *
            FROM USERS
            WHERE USERS.University_id = '$uniID'";
    $result = $conn->query($sql);
    if($result->num_rows > 0) {
        $data = $result->fetch_assoc();

        if($type == "C" && $data['Calculator_count'] > 0) {
            //echo "<p class='noresult'>This user already has a calculator!</p>";
            header("location: ../item-search.php?error=calclimit");
            exit();
        }
        if($type == "H" && $data['Headphone_count'] > 0) {
            //echo "<p class='noresult'>This user already has headphones!</p>";
            header("location: ../item-search.php?error=headlimit");
            exit();
        }
        if($type == "L" && $data['Laptop_count'] > 0) {
            //echo "<p class='noresult'>This user already has a laptop!</p>";
            header("location: ../item-search.php?error=laptoplimit");
            exit();
        }
        $date = date('Y-m-d');
        if($type == "C") {
            $sql = "UPDATE USERS 
                    SET Last_updated='$date', Calculator_count=Calculator_count + 1
                    WHERE USERS.University_id = $uniID";
            $result = $conn->query($sql);
        }
        if($type == "H") {
            $sql = "UPDATE USERS 
                    SET Last_updated='$date', Headphone_count=Headphone_count + 1
                    WHERE USERS.University_id = $uniID";
            $result = $conn->query($sql);
        }  
        if($type == "L") {
            $sql = "UPDATE USERS 
                    SET Last_updated='$date', Laptop_count=Laptop_count + 1
                    WHERE USERS.University_id = $uniID";
            $result = $conn->query($sql);
        }

        $sql = "SELECT *
        FROM ITEM
        WHERE ITEM.Item_id = '$itemID'";
        $result = $conn->query($sql);
        $data = $result->fetch_assoc();
        $type = $data['Item_type'];

        $sql = "INSERT INTO CHECK_OUT_ITEM (University_id, Item_id, Checked_out_date)
                VALUES ('$uniID','$itemID','$date')";
        $result = $conn->query($sql);

        header("location: ../checkouts.php");
        exit();
    }
    else {
            //echo "<p class='noresult'>Input a valid user!</p>";
            header("location: ../item-search.php?error=invaliduser");
            exit();
    }
}

/*
    if(isset($_SESSION['Admin_id']) || isset($_SESSION['Staff_id'])) {
        if(isset($_POST['itemID'])) {
            require_once 'dbh-inc.php';
            $itemID = mysqli_real_escape_string($conn, $_POST['itemID']);

            //getting item type
            $sql = "SELECT *
            FROM item
            WHERE item.Item_id = '$itemId'";
            $result = mysqli_query($conn, $sql);
            $q_results_status = mysqli_num_rows($result);
            $data = mysqli_fetch_assoc($result);
            $item_type = $data['Item_type'];
    
            if(!isset($data['Calculator_count'])) {
                $c_count = 0;
            }
            else {
                $c_count = $data['Calculator_count'];
            }
            if(!isset($data['Laptop_count'])) {
                $l_count = 0;
            }
            else {
                $l_count = $data['Laptop_count'];
            }
            if(!isset($data['Headphone_count'])) {
                $h_count = 0;
            }
            else {
                $h_count = $data['Headphone_count'];
            }


            if($item_type == "C" && $c_count > 0)
            {
                //echo "They already this item checked out!"
                header("location: ../index.php?error=item_exceed");
                exit();
            }
            elseif($item_type == "L" && $l_count > 0) {
                
            }
            elseif($item_type == "L" && $l_count > 0) {

            }
            //checking if user has checked out this book already
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
                
            header("location: ../index.php"); //send to their checkouts profile?
            //exit();
        }
    }
    */

?>