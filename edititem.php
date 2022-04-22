<?php
    include_once 'header.php';
    require_once 'includes/dbh-inc.php';
    require_once 'includes/functions-inc.php';
?>
    <?php
        if(isset($_POST['itemID'])) {
            $ItemID = $_POST["itemID"];
            $Type;
            $Condition;
    ?>
        <div class = "signup-form-form">
            <form action="includes/edit-item-inc.php" method="post" enctype="multipart/form-data">
                <?php
                    $sql = "SELECT * FROM ITEM WHERE Item_id = $ItemID;";

                    $result = mysqli_query($conn , $sql);
                    $resultCheck = mysqli_num_rows($result);
                    if ($resultCheck > 0) {
                        while($row = mysqli_fetch_assoc($result)) { 
                            $Type = $row['Item_type'];
                            $Condition = $row['Condition'];
                        }
                    }
                ?>
                <h3>Item Type:</h3>
                <select name="type" id="type">
                    <option value="<?php echo $Genre;?>"><?php echo $Genre;?></option>
                    <option value="C">Calculator</option>
                    <option value="L">Laptop</option>
                    <option value="H">Headphones</option>
                    </select>
                <br><br>
                <h3>Condition:</h3>
                <select name="cond" id="cond">
                    <?php
                        if($Condition == "E") {
                    ?>
                        <option value="E"><?php echo "Excellent";?></option>
                        <option value="G"><?php echo "Good";?></option>
                        <option value="W"><?php echo "Worn";?></option>
                    <?php
                        }
                        else if($Condition == "G") {
                    ?>
                        <option value="G"><?php echo "Good";?></option>
                        <option value="W"><?php echo "Worn";?></option>
                        <option value="E"><?php echo "Excellent";?></option>
                    <?php
                        }
                        else if($Condition == "W") {
                    ?>
                        <option value="W"><?php echo "Worn";?></option>
                        <option value="G"><?php echo "Good";?></option>
                        <option value="E"><?php echo "Excellent";?></option>
                    <?php
                        }
                    ?>
                </select><br><br>
                <input type="hidden" name="itemID" value="<?php echo $ItemID;?>">
                <button type="changeItem" name="changeItem">Submit Changes</button><br><br>
                <button type="deleteItem" name="deleteItem" onclick="return confirm('Are you sure you want to Delete?');">DELETE ITEM</button>
            </form>
        </div>
    <?php
    }
    else {
        header("Location: index.php");
    }
    ?>

    <?php
        if(isset($_GET["error"])) 
        {
            if($_GET["error"] == "none") {
                header("location:index.php?error=itemUpdated");
            }
            else if($_GET["error"] == "noneDeleted") {
                header("location:index.php?error=itemDeleted");
            }
            else if($_GET["error"] == "emptyinput") {
                echo '<script>alert("Empty Input!")</script>';
            }
            else if($_GET["error"] == "sql") {
                echo '<script>alert("Error occurred! Please try again!")</script>';
            }
        }
    ?>

<?php
    include_once 'footer.php';
?>