<?php
    include_once 'header.php';
    require_once 'includes/dbh-inc.php';
    require_once 'includes/functions-inc.php';
    if(!isset($_SESSION["Admin_id"])) {
        header("Location: login.php?error=noPermission");
        exit();
    }
?>
    <?php
        if(isset($_POST['itemID'])) {
            $ItemID = $_POST["itemID"];
            $Type;
            $Condition;
    ?>
        <div class = "signup-form-form">
            <form action="includes/edit-item-inc.php" method="post">
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
                    <?php
                    if($Type == "C") {
                    ?>
                        <option value="C"><?php echo "Calculator";?></option>;
                        <option value="L"><?php echo "Laptop";?></option>;
                        <option value="H"><?php echo "Headphones";?></option>;
                    <?php
                    }
                    elseif($Type == "L") {
                    ?>
                        <option value="L"><?php echo "Laptop";?></option>;
                        <option value="C"><?php echo "Calculator";?></option>;
                        <option value="H"><?php echo "Headphones";?></option>;
                    <?php
                    }
                    elseif($Type == "H") {
                    ?>
                        <option value="H"><?php echo "Headphones";?></option>;
                        <option value="C"><?php echo "Calculator";?></option>;
                        <option value="L"><?php echo "Laptop";?></option>;
                    <?php
                    }
                    ?>
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
                        <option value="D"><?php echo "Damaged";?></option>
                    <?php
                        }
                        else if($Condition == "G") {
                    ?>
                        <option value="G"><?php echo "Good";?></option>
                        <option value="W"><?php echo "Worn";?></option>
                        <option value="E"><?php echo "Excellent";?></option>
                        <option value="D"><?php echo "Damaged";?></option>
                    <?php
                        }
                        else if($Condition == "W") {
                    ?>
                        <option value="W"><?php echo "Worn";?></option>
                        <option value="G"><?php echo "Good";?></option>
                        <option value="E"><?php echo "Excellent";?></option>
                        <option value="D"><?php echo "Damaged";?></option>
                    <?php
                        }
                        else if($Condition == "D") {
                    ?>
                        <option value="D"><?php echo "Damaged";?></option>
                        <option value="G"><?php echo "Good";?></option>
                        <option value="W"><?php echo "Worn";?></option>
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