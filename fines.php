<?php
    include_once 'header.php';
?>
    <?php
        if(isset($_SESSION["University_id"])) {
            require_once 'includes/dbh-inc.php';
            require_once 'includes/functions-inc.php';
            createFineTable($conn, $_SESSION["University_id"]);
        }
        else if(isset($_SESSION["Staff_id"]) || isset($_SESSION["Admin_id"])){
            require_once 'includes/dbh-inc.php';
            require_once 'includes/functions-inc.php';
            createUsersFineTable($conn);
            ?>
            <div class="addUser">
                <a href="fines.php?add=" class="button">Add Fine</a>
            </div>
            <?php
            if(isset($_GET['edit'])) {
                $UnivID = $_GET['edit'];
                $uidExists = uidExists($conn, $UnivID);
                ?>
                <section class="signup-form">
                <h2>To edit fines fill out fields below:</h2>
                <div class="signup-form-form">
                    <form action="includes/fines-inc.php" method="post">
                        <input type="hidden" name="uid" value="<?php echo $UnivID ;?>">
                        <h3>Name: </h3>
                        <input type="text" name="fname" value="<?php echo $uidExists['Fname']." ".$uidExists['Lname']; ?>"readonly><br><br>
                        <h3>Fines: </h3>
                        <input type="text" name="fines" value="<?php echo $uidExists['Fines'];?>"> <br><br><br>
                        <button type="submit" name="updateFine">Update</button>
                    </form> 
                </div>
                </section>
            <?php
            }
            if(isset($_GET['add'])) {
            ?>
            <section class="signup-form"> 
                <h2>To add fine fill out inputs below:</h2>
                <div class="signup-form-form"> 
                    <form action="includes/fines-inc.php" method="post">
                        <h3>University ID:</h3>
                        <input oninput="this.value=this.value.slice(0,this.maxLength)" type="number" maxlength="7" name="uid" placeholder="University ID..."><br><br>
                        <h3>Fines: </h3>
                        <input type="text" name="fines" value="0.00"> <br><br><br>
                        <button type="submit" name="addFine">Update</button>
                    </form> 
                </div>
            </section>
                    <?php
                    }
            if(isset($_GET["error"])) {
                if($_GET["error"] == "emptyinput") {
                    echo "<script>alert('Fine cannot be empty!');</script>";
                    echo "<script>history.back();</script>";
                }
                else if($_GET["error"] == "updatedFines") {
                    echo "<script>alert('You have successfully updated the user\'s fine!');</script>";
                    echo "<script>history.back();</script>";
                }
                else if($_GET["error"] == "uidNotFound") {
                    echo "<script>alert('University ID not found!');</script>";
                    echo "<script>history.back();</script>";
                }
                else if($_GET["error"] == "sql") {
                    echo "<script>alert('Something went wrong, please try again!');</script>";
                    echo "<script>history.back();</script>";
                }
            }
        }
        else {
            header("location: login.php");
        }
    ?>
<?php
    include_once 'footer.php';
?>