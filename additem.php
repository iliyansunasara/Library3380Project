<?php
    include_once 'header.php';
    if(!isset($_SESSION["Admin_id"])) {
        header("Location: login.php?error=noPermission");
        exit();
    }
?>
    <section class="signup-form">
        <h2>To add item fill out all fields below:</h2>
        <div class="signup-form-form">
            <form action="includes/addItem-inc.php" method="post">
                <h3>Item ID:</h3>
                <input oninput="this.value=this.value.slice(0,this.maxLength)" type="number" maxlength="12" name="itemid" placeholder="Item ID..."><br><br>
                <h3>Item Type:</h3>
                <select name="type" id="type">
                    <option value=>-</option>
                    <option value="C">Calculator</option>
                    <option value="L">Laptop</option>
                    <option value="H">Headphones</option>
                </select><br><br>
                <h3>Condition:</h3>
                <select name="cond" id="cond">
                    <option value=>-</option>
                    <option value="E">Excellent</option>
                    <option value="G">Good</option>
                    <option value="W">Worn</option>
                </select><br><br>
                <button type="addItem" name="addItem" class="addButton">Add Item</button>
            </form>
        </div>
    </section>

    <?php
        if(isset($_GET["error"])) {
            if($_GET["error"] == "emptyinput") {
                echo '<script>alert("Fill in all required fields!")</script>';
            }
            else if($_GET["error"] == "invalidItemID") {
                echo '<script>alert("Enter a proper Item ID!")</script>';
            }
            else if($_GET["error"] == "itemIDtaken") {
                echo '<script>alert("Item ID already Exists!")</script>';
            }
            else if($_GET["error"] == "stmtfailed") {
                echo '<script>alert("Something went wrong, please try again!")</script>';
            }
            else if($_GET["error"] == "none") {
                echo '<script>alert("You have successfully added an item!")</script>';
            }
        }
    ?>
    
<?php
    include_once 'footer.php';
?>