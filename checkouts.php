<?php
    include_once 'header.php';
?>

    <?php
        if(isset($_SESSION["University_id"])) {
            require_once 'includes/dbh-inc.php';
            require_once 'includes/functions-inc.php';
            ?><br><?php
            createBookTable($conn, $_SESSION["University_id"]);
            createItemTable($conn, $_SESSION["University_id"]);
        }
        else if(isset($_SESSION["Staff_id"])) {
            require_once 'includes/dbh-inc.php';
            require_once 'includes/functions-inc.php';
            ?><br><?php
            createUserBookTable($conn, $_SESSION["Staff_id"]);
            createUserItemTable($conn, $_SESSION["Staff_id"]);
        }
        else if(isset($_SESSION["Admin_id"])) {
            require_once 'includes/dbh-inc.php';
            require_once 'includes/functions-inc.php';
            ?>
            <div class="search-form">
                <form>
                    <input type = 'text' name = 'search' placeholder="Checkout Search...">
                    <button type="submit" name="search-submit">Search</button>
                </form>
            </div>
            <br>
            <?php
            createAllUserBookTable($conn);
            //createAllUserItemTable($conn);
        }
        else {
            header("location: login.php");
        }
    ?>

<?php
    include_once 'footer.php';
?>