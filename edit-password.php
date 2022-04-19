<?php
    include_once 'header.php';
?>
    <section class="editpass-form">
        <h2>To change password please fill out fields below:</h2>
        <div class="editpass-form-form">
            <form action="includes/edit-password-inc.php" method="post">
                <h3>Old Password:</h3>
                <input type="password" name="old" placeholder="Old Password..."><br><br>
                <h3>New Password: </h3>
                <input type="password" name="new" placeholder="New Password..."><br><br>
                <h3>Confirm Password:</h3>
                <input type="password" name="confirm" placeholder="Confirm Password..."><br><br>
                <button type="submit" name="submit">Change Password</button>
            </form>
            
        </div>
    </section>
    <?php
        if(isset($_GET["error"])) {
            if($_GET["error"] == "emptyinput") {
                echo "<script>alert('Fill in all required fields!');</script>";
            }
            else if($_GET["error"] == "oldbad") {
                echo "<script>alert('Old password incorrect, please try again!');</script>";
            }
            else if($_GET["error"] == "match") {
                echo "<script>alert('New Password doesn't match confirmed password, please try again!');</script>";
            }
            else if($_GET["error"] == "stmtfailed" || $_GET["error"] == "sql") {
                echo "<script>alert('Something went wrong, please try again!');</script>";
            }
            else if($_GET["error"] == "none") {
                echo "<script>alert('You have successfully changed your password!');</script>";
            }
        }
    ?>
    
<?php
    include_once 'footer.php';
?>