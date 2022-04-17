<?php
    include_once 'header.php';
?>
    <section class="addPages-form">
        <h2>To add item fill out all fields below:</h2>
        <div class="forms">
            <form action="includes/addItem-inc.php" method="post">
                <label for="itemid">ID:</label>
                <input type="text" name="itemid" placeholder="Item ID..."><br><br>
                <label for="type">Item Type:</label>
                <select name="type" id="type">
                    <option value=>-</option>
                    <option value="C">Calculator</option>
                    <option value="L">Laptop</option>
                    <option value="H">Headphones</option>
                </select><br><br>
                <label for="cond">Condition:</label>
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