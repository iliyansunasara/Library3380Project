<?php
    include_once 'header.php';
?>
<section class="signup-form">
        <h2>To generate table fill out the fields below:</h2>
        <div class="signup-form-form">
            <form> <!--includes/newstaff-inc.php-->
                <h3>Start date:</h3>
                <input type="date" name="start"><br><br>
                <h3>End date:</h3>
                <input type="date" name="end"><br><br>
                <button name="staffReport" class="staffReport">Run Report</button>
            </form>
        </div>
</section>
    <?php
        if(isset($_GET['staffReport']) && isset($_SESSION['Admin_id'])){
            require_once 'includes/dbh-inc.php';
            require_once 'includesfunctions-inc.php';
            $start = $_GET['start'];
            $end = $_GET['end'];
            if (checkDatesGood($start, $end)) {
                createNewStaffTable($conn, $start, $end);
            }
            else {
                header("Location: newstaff.php?error=startdatebig");
                exit();
            } 
        }
        else {
            header("Location: login.php?error=loginpls");
            exit();
        }
    ?>


<?php
    include_once 'footer.php';
?>