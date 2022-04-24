<?php
    include_once 'header.php';
    include_once 'includes/dbh-inc.php';
    include_once 'includes/functions-inc.php';
?>
<?php
    $itemID = $_POST['itemID'];

?>

<div class="signup-form-form">
    <form action="includes/item-checkout-inc.php">
        <h3>University ID:</h3>
        <input type="hidden" name="itemID" value="<?php echo $itemID; ?>">
        <input oninput="this.value=this.value.slice(0,this.maxLength)" type="number" maxlength="7" name="uni" placeholder="University ID"><br><br>
         <button type="submit" name="confirm-checkout">Confirm Checkout</button>
    </form>
</div>

<?php
    include_once 'footer.php';
?>