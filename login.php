<?php
    include_once 'header.php';
?>
    <section class="login-form">
        <h2>Login</h2>
        <form action="includes/login-inc.php" method="post">
            <input oninput="this.value=this.value.slice(0,this.maxLength)" type="number" maxlength="8"  name="id" placeholder="University/Staff ID..."><br><br>
            <input type="password" name="pwd" placeholder="Password..."><br><br>
            <button type="submit" name="submit">Login</button>
        </form>
    </section>
    <?php
        if(isset($_GET["error"])) {
            if($_GET["error"] == "emptyinput") {
                //echo "<p class=\"message\">Fill in all required fields!</p>";
                echo '<script>alert("Fill in all required fields!")</script>';
            }
            else if($_GET["error"] == "wronglogin") {
                //echo "<p class=\"message\">Incorrect UniversityID or Password!</p>";
                echo '<script>alert("Incorrect University ID or Password!")</script>';
            }
            else if($_GET["error"] == "wrongloginstaff") {
                //echo "<p class=\"message\">Incorrect StaffID or Password!</p>";
                echo '<script>alert("Incorrect Staff ID or Password!")</script>';
            }
            else if($_GET["error"] == "notloggedin") {
                //echo "<p class=\"message\">Incorrect StaffID or Password!</p>";
                echo '<script>alert("You must log in to check out a book!")</script>';
            }
            else if($_GET["error"] == "loginpls") {
                //echo "<p class=\"message\">Incorrect StaffID or Password!</p>";
                echo '<script>alert("You must log in to check out a book!")</script>';
            }
            else if($_GET["error"] == "noPermission") {
                echo '<script>alert("You don\'t have permission to visit this page!")</script>';
            }
        }
    ?>
<?php
    include_once 'footer.php';
?>