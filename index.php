<?php
    include_once 'header.php';
    include_once 'includes/dbh-inc.php';
    include_once 'includes/functions-inc.php'
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
            $sql = "SELECT * FROM item WHERE item.Item_type LIKE '%$search%';";
            $result = mysqli_query($conn, $sql);
            $q_results = mysqli_num_rows($result);

            if($q_results > 0) {
                while($data = mysqli_fetch_assoc($result)) {
                    echo "<a class =tobookinfo href='book-info.php?bookid=".$data['Book_id']."'>";
                    echo "<div class='item'>";
                    // echo "<img src = '{$data['Cover']}' width = '100%' height = '100%'><br><br>";
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
            echo "<h2>-------------------------------------------------------</h2><br><br>";
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
    }
?>

    <?php
        /*
        require_once 'includes/dbh-inc.php';

        $sql = "SELECT * FROM BOOK WHERE available = '1';";
        $result = $conn->query($sql) or die($conn->error);

        while ($data = $result->fetch_assoc()) {
            echo "<img src='$data['cover']' width='40%' height='40%'>";
            echo "<h2>$data['Title']</h2>";
            echo "<h2>$data['Author']</h2>";
        }


        $sql = "SELECT * FROM ITEM WHERE available = '1';";
        $result = $conn->query($sql) or die($conn->error);

        while ($data = $result->fetch_assoc()) {
            echo "<h2>$data['name']</h2>";
        }

        */
    ?>
<?php
    include_once 'footer.php';
?>