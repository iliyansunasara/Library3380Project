<?php
    include_once 'header.php';
?>
    <section class="login-form">
        <h2>Student/Faculty Login</h2>
        <form action="includes/login-inc.php" method="post">
            <input type="text" name="uni" placeholder="University ID...">
            <input type="password" name="pwd" placeholder="Password...">
            <button type="submit" name="submit">Login</button>
        </form>
    </section>
    <section class="login-form">
        <h2>Staff Login</h2>
        <form action="includes/staff-login-inc.php" method="post">
            <input type="text" name="sid" placeholder="Staff ID...">
            <input type="password" name="spwd" placeholder="Password...">
            <button type="submit" name="submit">Login</button>
        </form>
    </section>

    <section class="login-form">
        <h2>Librarian Login</h2>
        <form action="includes/admin-login-inc.php" method="post">
            <input type="text" name="adminid" placeholder="Librarian ID...">
            <input type="password" name="adminpwd" placeholder="Password...">
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
            else if($_GET["error"] == "wrongloginadmin") {
                //echo "<p class=\"message\">Incorrect AdminID or Password!</p>";
                echo '<script>alert("Incorrect Librarian ID or Password!")</script>';
            }
        }
    ?>
<?php
    include_once 'footer.php';
?>