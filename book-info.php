<?php
    include_once 'header.php';
    include_once 'includes/dbh-inc.php';
    include_once 'includes/functions-inc.php'
?>

    <?php
        $bookID = mysqli_real_escape_string($conn, $_GET['bookid']);
        $sql = "SELECT * FROM book WHERE book.Book_id = '$bookID' ";
        $result = mysqli_query($conn, $sql);
        $q_results = mysqli_num_rows($result);
    
        if($q_results == 1) {
            while($data = mysqli_fetch_assoc($result)) {
                echo "<div class='bookinfo'><h3>$data[Title]</h3>
                        <!-- $data[Cover] -->
                        <p>Author: ".$data['Author']."</p>
                        <p>Genre: ".$data['Genre']."</p>
                        <p>Rating: ".checkAgeGroup($data['Age_group'])."</p>
                        <p>".displayFiction($data['Fiction'])."</p>
                        <p>Condition: ".checkCondition($data['Condition'])."</p>
                        </div></a>";
            }
        }
    ?>

<div class="request-form">
    <form action="checkouts.php" method="POST">
        <button type="submit" name="search-submit">Request Book</button>
    </form>
</div>
<?php
    include_once 'footer.php';
?>