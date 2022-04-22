<?php
    include_once 'header.php';
    include_once 'includes/dbh-inc.php';
    include_once 'includes/functions-inc.php'
?>
 <?php
    
    if (isset($_SESSION['University_id']) && ($_SESSION['logged'] == 0)) {
        $_SESSION['logged'] = 1;
        $UnivID = $_SESSION['University_id'];
        $uidExists = uidExists($conn, $UnivID);
        $All_COD = array();
        $totalFines = 0;
        
        $sql = "SELECT * FROM CHECK_OUT_BOOK AS COB
            WHERE COB.University_id = $UnivID;";
        $result = $conn->query($sql);
        if($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                array_push($All_COD, $row['Checked_out_date']);
            }
        }
        //else {}
        $status = $uidExists["Status"];
        if ($status == "S") {
            for($i=0; $i<sizeof($All_COD); $i++) {
                $COD = $All_COD[$i];
                $today = strtotime("today");
                if ((dateDiffInDays($COD, $today)) > 7) {
                    $totalFines += (dateDiffInDays($COD, $today) - 7);
                }
            }
        }
        else if ($status == "F") {
            for($i=0; $i<sizeof($All_COD); $i++) {
                $COD = $All_COD[$i];
                $today = strtotime('today');
                if ((dateDiffInDays($COD, $today)) > 14) {
                    $totalFines += (dateDiffInDays($COD, $today) - 14);
                }
            }
        }
        $sql = "UPDATE users SET Fines = '$totalFines' WHERE University_id = $UnivID;";
        if (mysqli_query($conn, $sql)) {
            header("location: index.php?error=finesupdated");
        }
        else {
            header("location: index.php?error=sql");
        } 
        //updateFines($conn, $UnivID, $totalFines);
    }

    if(isset($_SESSION["University_id"])) {
        include_once 'email.php';
        $sql = "SELECT * FROM new_messages WHERE University_id = '".$_SESSION["University_id"]."'";
        $result = mysqli_query($conn, $sql);
        $q_results = mysqli_num_rows($result);
        $UnivID = $_SESSION['University_id'];
        $uidExists = uidExists($conn, $UnivID);
        $email = $uidExists["Email"];
        if($q_results > 0) {
            $data = mysqli_fetch_assoc($result);
            $message = $data['Message'];
            $messageid = $data['Message_id'];
            $messagetype = $data['type'];
            sendEmail($email, $message, $messagetype);
            deleteMessageRow($conn, $messageid);
        }
    }   
?>
<div class="search-form">
    <form>
        <input type = 'text' name = 'search' placeholder="Book Search...">
        <button type="submit" name="search-submit">Search</button>
    </form>
</div>
   
<div class="books-container">
    <?php
        if(isset($_GET['search-submit'])) {
            $search = mysqli_real_escape_string($conn, $_GET['search']);
            $sql = "SELECT * 
                    FROM book
                    WHERE book.Title LIKE '%$search%'
                            OR book.Author LIKE '%$search%'
                            OR book.Genre LIKE '%$search%'
                            OR book.Book_id LIKE '%$search%';";
            $result = mysqli_query($conn, $sql);
            $q_results = mysqli_num_rows($result);

            if($q_results > 0) {
                while($data = mysqli_fetch_assoc($result)) {
                    echo "<a class =tobookinfo href='book-info.php?bookid=".$data['Book_id']."'>";
                    echo "<div class='book'>";
                    echo "<img src = '{$data['Cover']}' width = '100%' height = '100%'><br><br>";
                    echo "<h3>$data[Title]</h3>";
                    echo "<p>by: ".$data['Author']."</p>";
                    echo "</div></a>";
                }
            }
            else {
                echo "<p class='noresult'>No results matched your search!</p>";
            }
        }
        else {
            $sql = "SELECT * FROM book";
            $result = mysqli_query($conn, $sql);
            $q_results = mysqli_num_rows($result);
            while($data = mysqli_fetch_assoc($result)) {
                echo "<a class =tobookinfo href='book-info.php?bookid=".$data['Book_id']."'>";
                echo "<div class='book'>";
                echo "<img src = '{$data['Cover']}' width = '100%' height = '100%'><br><br>";
                echo "<h3>$data[Title]</h3>";
                echo "<p>by: ".$data['Author']."</p>";
                echo "</div></a>";
            }
        }
    ?>
</div>

<div class="items-container">
    <?php
        if(isset($_GET['search-submit'])) {
            $search = mysqli_real_escape_string($conn, $_GET['search']);
            echo "<h2><pre>             ITEMS:</pre></h2><br><br>";
            $sql = "SELECT * FROM item WHERE item.Item_type LIKE '%$search%';";
            $result = mysqli_query($conn, $sql);
            $q_results = mysqli_num_rows($result);

            if($q_results > 0) {
                while($data = mysqli_fetch_assoc($result)) {
                    echo "<a class =tobookinfo href='item-info.php?itemid=".$data['Item_id']."'>";
                    echo "<div class='item'>";
                    if($data['Item_type'] == 'C') {
                        echo "<h3>Calculator</h3><br>";
                        if($data['Condition'] == 'E') {
                            echo "<p>Excellent</p>";
                        }
                        else if($data['Condition'] == 'G') {
                            echo "<p>Good</p>";
                        }
                        else if($data['Condition'] == 'W') {
                            echo "<p>Worn</p>";
                        }
                    }
                    elseif($data['Item_type'] == 'L') {
                        echo "<h3>Laptop</h3><br>";
                        if($data['Condition'] == 'E') {
                            echo "<p>Excellent</p>";
                        }
                        else if($data['Condition'] == 'G') {
                            echo "<p>Good</p>";
                        }
                        else if($data['Condition'] == 'W') {
                            echo "<p>Worn</p>";
                        }
                    }
                    elseif($data['Item_type'] == 'H') {
                        echo "<h3>Headphones</h3><br>";
                        if($data['Condition'] == 'E') {
                            echo "<p>Excellent</p>";
                        }
                        else if($data['Condition'] == 'G') {
                            echo "<p>Good</p>";
                        }
                        else if($data['Condition'] == 'W') {
                            echo "<p>Worn</p>";
                        }
                    }
                    echo "</div></a>";
            }
        }
            else {
                //echo "<p class='noresult'>No items matched your search!</p>";
            }
        }
        else {
            echo "<h2><pre>             ITEMS:</pre></h2><br><br>";
            $sql = "SELECT * FROM item";
            $result = mysqli_query($conn, $sql);
            $q_results = mysqli_num_rows($result);
            while($data = mysqli_fetch_assoc($result)) {
                echo "<a class =tobookinfo href='item-info.php?itemid=".$data['Item_id']."'>";
                echo "<div class='item'>";
                if($data['Item_type'] == 'C') {
                    echo "<h3>Calculator</h3><br>";
                    if($data['Condition'] == 'E') {
                        echo "<p>Excellent</p>";
                    }
                    else if($data['Condition'] == 'G') {
                        echo "<p>Good</p>";
                    }
                    else if($data['Condition'] == 'W') {
                        echo "<p>Worn</p>";
                    }
                }
                elseif($data['Item_type'] == 'L') {
                    echo "<h3>Laptop</h3><br>";
                    if($data['Condition'] == 'E') {
                        echo "<p>Excellent</p>";
                    }
                    else if($data['Condition'] == 'G') {
                        echo "<p>Good</p>";
                    }
                    else if($data['Condition'] == 'W') {
                        echo "<p>Worn</p>";
                    }
                }
                elseif($data['Item_type'] == 'H') {
                    echo "<h3>Headphones</h3><br>";
                    if($data['Condition'] == 'E') {
                        echo "<p>Excellent</p>";
                    }
                    else if($data['Condition'] == 'G') {
                        echo "<p>Good</p>";
                    }
                    else if($data['Condition'] == 'W') {
                        echo "<p>Worn</p>";
                    }
                }
                echo "</div></a>";
            }
        }
    ?>
</div>

<?php
    if(isset($_GET["error"])) {
        if($_GET["error"] == "stud_exceed") {
            echo '<script>alert("You already have 2 books checked out!")</script>';
        }
        else if($_GET["error"] == "fac_exceed") {
            echo '<script>alert("You already have 3 books checked out!")</script>';
        }
        else if($_GET["error"] == "request_error1") {
            echo '<script>alert("You already have this book!")</script>';
        }
        else if($_GET["error"] == "request_error2") {
            echo '<script>alert("You have already requested this book!")</script>';
        }
        else if($_GET["error"] == "finesupdates") {
            echo '<script>alert("Fines was updated!")</script>';
        }
        else if($_GET["error"] == "returning") {
            echo '<script>alert("This book has not been checked out!")</script>';
        }
        else if($_GET["error"] == "bookUpdated") {
            echo '<script>alert("Book Successfully Updated!")</script>';
        }
        else if($_GET["error"] == "bookDeleted") {
            echo '<script>alert("Book Deleted Successfully!")</script>';
        }
        else if($_GET["error"] == "itemUpdated") {
            echo '<script>alert("Item Successfully Updated!")</script>';
        }
        else if($_GET["error"] == "itemDeleted") {
            echo '<script>alert("Item Deleted Successfully!")</script>';
        }
        else if($_GET["error"] == "none") {
            //echo '<script>alert("Book Successfully Updated!")</script>';
        }
    }
?>

<?php
    include_once 'footer.php';
?>