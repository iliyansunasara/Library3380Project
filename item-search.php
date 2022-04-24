<?php
    include_once 'header.php';
    include_once 'includes/dbh-inc.php';
    include_once 'includes/functions-inc.php';
?>

<form>
    <button formaction="index.php">Book Search</button>
</form>

<div class="signup-form-form">
    <form>
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
                <button type="submit" name="search-submit">Search</button>
    </form>
</div>

<div class="items-container">
    <?php
        if(isset($_GET['itemid']) || isset($_GET['type']) || isset($_GET['cond'])) {
            $itemid = mysqli_real_escape_string($conn, $_GET['itemid']);
            $type = mysqli_real_escape_string($conn, $_GET['type']);
            $cond = mysqli_real_escape_string($conn, $_GET['cond']);
            echo "<h2><pre>             ITEMS:</pre></h2><br><br>";
            $sql = "SELECT * 
                    FROM item 
                    WHERE item.Item_id LIKE '%$itemid%'
                        AND item.Item_type LIKE '%$type%'
                        AND item.Condition LIKE '%$cond%';";

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
                echo "<p class='noresult'>No items matched your search!</p>";
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
            if($_GET["error"] == "calclimit") {
                //echo "<p class=\"message\">Fill in all required fields!</p>";
                echo '<script>alert("This user already has a calculator!")</script>';
            }
            else if($_GET["error"] == "headlimit") {
                //echo "<p class=\"message\">Incorrect UniversityID or Password!</p>";
                echo '<script>alert("This user already has headphones!")</script>';
            }
            else if($_GET["error"] == "laptoplimit") {
                //echo "<p class=\"message\">Incorrect StaffID or Password!</p>";
                echo '<script>alert("This user already has a laptop!")</script>';
            }
            else if($_GET["error"] == "invaliduser") {
                //echo "<p class=\"message\">Incorrect StaffID or Password!</p>";
                echo '<script>alert("You must input a valid user!")</script>';
            }
        }
    ?>

<?php
    include_once 'footer.php';
?>
