<?php
    include_once 'header.php';
?>
    <section class="login-form">
        <h2>Login</h2>
        <form action="includes/login-inc.php" method="post">
            <input type="text" name="uni" placeholder="University ID...">
            <input type="password" name="pwd" placeholder="Password...">
            <button type="submit" name="submit">Login</button>
        </form>
    </section>
    <?php
        if(isset($_GET["error"])) {
            if($_GET["error"] == "emptyinput") {
                echo "<p class=\"message\">Fill in all required fields!</p>";
            }
            else if($_GET["error"] == "wronglogin") {
                echo "<p class=\"message\">Incorrect UniversityID or Password!</p>";
            }
        }
    ?>
<?php
    include_once 'footer.php';
?>