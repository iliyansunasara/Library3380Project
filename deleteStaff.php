<?php
    include_once 'header.php';
    if(!isset($_SESSION["Admin_id"])) {
        header("Location: login.php?error=noPermission");
        exit();
    }
?>
    <section class="signup-form">
        <h2>To delete staff member fill out all fields below:</h2>
        <div class="signup-form-form">
            <form action="includes/addStaff-inc.php" method="post">
                <h3>Staff ID:</h3>
                <input oninput="this.value=this.value.slice(0,this.maxLength)" type="number" maxlength="8" name="staffid" placeholder="-"><br><br>
                <button type="deleteStaff" name="deleteStaff" class="addButton" onclick="return confirm('Are you sure you want to Delete?');">Delete Staff Member</button>
            </form>
        </div>
    </section>

    <?php
        if(isset($_GET["error"])) {
            if($_GET["error"] == "emptyinput") {
                echo '<script>alert("Fill in all required fields!")</script>';
            }
            else if($_GET["error"] == "noStaffID") {
                echo '<script>alert("Staff ID does not Exist!")</script>';
            }
            else if($_GET["error"] == "stmtfailed") {
                echo '<script>alert("An Error Occured, Try Again!")</script>';
            }
            else if($_GET["error"] == "none") {
                echo '<script>alert("Staff Member Deleted Successfully!")</script>';
            }
        }
    ?>
    
<?php
    include_once 'footer.php';
?>