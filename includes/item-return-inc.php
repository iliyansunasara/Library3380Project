<?php
    session_start();
    if(isset($_POST["item-return"])) {
        include_once 'dbh-inc.php';
        $itemID = $_POST['itemID'];

        $sql = "SELECT *
        FROM ITEM
        WHERE ITEM.Item_id = '$itemID'";
        $result = $conn->query($sql);
        $data = $result->fetch_assoc();
        $type = $data['Item_type'];
        
        $sql = "SELECT *
        FROM CHECK_OUT_ITEM
        WHERE CHECK_OUT_ITEM.Item_id = '$itemID'";
        $result = $conn->query($sql);
        $data = $result->fetch_assoc();
        $uniID = $data['University_id'];

        $sql = "SELECT *
            FROM USERS
            WHERE USERS.University_id = '$uniID'";
        $result = $conn->query($sql);
        $data = $result->fetch_assoc();

        $date = date('Y-m-d');
        if($type == "C") {
            $sql = "UPDATE USERS 
                    SET Last_updated='$date', Calculator_count=Calculator_count - 1
                    WHERE USERS.University_id = $uniID";
            $result = $conn->query($sql);
        }
        if($type == "H") {
            $sql = "UPDATE USERS 
                    SET Last_updated='$date', Headphone_count=Headphone_count - 1
                    WHERE USERS.University_id = $uniID";
            $result = $conn->query($sql);
        }  
        if($type == "L") {
            $sql = "UPDATE USERS 
                    SET Last_updated='$date', Laptop_count=Laptop_count - 1
                    WHERE USERS.University_id = $uniID";
            $result = $conn->query($sql);
        }

        $sql = "DELETE FROM check_out_item
                WHERE check_out_item.Item_id = $itemID;";
        $result = $conn->query($sql);

        header("location: ../checkouts.php");
        exit();
    }

?>