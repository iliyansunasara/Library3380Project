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

<?php
    if(isset($_SESSION["Admin_id"])) {
?>
    <div>
        <form action="editbook.php" method="POST">
            <input type="hidden" name="bookID" value="<?php echo $bookID;?>">
            <button type="submit" name="editBook">Edit Book</button>
        </form>
    </div>
<?php
    }
?>

<?php
    if((isset($_SESSION["Admin_id"]) || isset($_SESSION["Staff_id"])) && getResult($conn, $bookID)->num_rows > 0) {
?>
    <div class="checkout-request-form">
        <form action="includes/returns-inc.php" method="POST">
            <input type="hidden" name="bookID" value="<?php echo $bookID;?>">
            <button type="submit" name="return">Return</button>
        </form>
    </div>
<?php
    }
?>



<?php
    $sql = "SELECT * FROM check_out_book WHERE check_out_book.Book_id = '$bookID' ";
    $result = mysqli_query($conn, $sql);
    $q_results = mysqli_num_rows($result);
    if($q_results > 0 && isset($_SESSION["University_id"])) {
?>
    <div class="checkout-request-form">
        <form action="includes/user-req-inc.php" method="POST">
            <input type="hidden" name="bookID" value="<?php echo $bookID; ?>">
            <button type="submit" name="req-form-">Request Book</button>
        </form>
    </div>
<?php
    }
    else if (isset($_SESSION["University_id"]) || isset($_SESSION["Staff_id"]) || isset($_SESSION["Admin_id"])) {
?>
    <div class="checkout-request-form">
        <form action="includes/user-check-inc.php" method="POST">
            <input type="hidden" name="bookID" value="<?php echo $bookID; ?>">
            <button type="submit" name="check-form-">Checkout Book</button>
        </form>
    </div>


<?php
    }
    else {
        header("Location: login.php?error=mustlogin");
        exit();
    }
?>




<?php
    include_once 'footer.php';
?>