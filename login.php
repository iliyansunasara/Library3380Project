<?php
    include_once 'header.php';
?>
    <section class="login-form">
        <h2>Login</h2>
        <form action="includes/login-inc.php" method="post">
            <input type="text" name="id" placeholder="Univeristy/Staff ID..."><br><br>
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
        }
    ?>
<?php
    include_once 'footer.php';
?>