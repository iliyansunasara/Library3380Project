<?php
    include_once 'header.php';
    include_once 'includes/dbh-inc.php';
    include_once 'includes/functions-inc.php'
?>

<?php
    $itemID = mysqli_real_escape_string($conn, $_GET['itemid']);
    $sql = "SELECT * FROM item WHERE item.Item_id = '$itemID' ";
    $result = mysqli_query($conn, $sql);
    $q_results = mysqli_num_rows($result);

    if($q_results == 1) {
        echo "<div class='bookinfo'>";
        while($data = mysqli_fetch_assoc($result)) {
            if($data['Item_type'] == 'C') {
                echo "<h3>Calculator</h3>";
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
                echo "<h3>Laptop</h3>";
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
                echo "<h3>Headphones</h3>";
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

<?php
    if(isset($_SESSION["Admin_id"])) {
?>
    <div class="checkout-request-form">
        <form action="edititem.php" method="POST">
            <input type="hidden" name="itemID" value="<?php echo $itemID;?>">
            <button type="submit" name="editItem">Edit Item</button>
        </form>
    </div>
<?php
    }
?>

<?php
    if((isset($_SESSION["Admin_id"]) || isset($_SESSION["Staff_id"])) && getResult($conn, $itemID)->num_rows > 0) {
?>
    <div class="checkout-request-form">
        <form action="includes/returns-inc.php" method="POST">
            <input type="hidden" name="itemID" value="<?php echo $itemID;?>">
            <button type="submit" name="return">Return</button>
        </form>
    </div>
<?php
    }
?>



<?php
    $sql = "SELECT * FROM check_out_item WHERE check_out_item.Item_id = '$itemID' ";
    $result = mysqli_query($conn, $sql);
    $q_results = mysqli_num_rows($result);
    if($q_results > 0 && isset($_SESSION["University_id"])) {
?>
    <div class="checkout-request-form">
        <form action="includes/user-req-inc.php" method="POST">
            <input type="hidden" name="itemID" value="<?php echo $itemID; ?>">
            <button type="submit" name="req-form-">Request Item</button>
        </form>
    </div>
<?php
    }
    else if (isset($_SESSION["University_id"]) || isset($_SESSION["Staff_id"]) || isset($_SESSION["Admin_id"])) {
?>
    <div class="checkout-request-form">
        <form action="includes/user-check-inc.php" method="POST">
            <input type="hidden" name="itemID" value="<?php echo $itemID; ?>">
            <button type="submit" name="check-form-">Checkout Item</button>
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