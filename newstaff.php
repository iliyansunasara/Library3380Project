<?php
    include_once 'header.php';
?>


<section class="signup-form">
        <h2>To generate table fill out the fields below:</h2>
        <div class="signup-form-form">
            <form action="includes/newstaff-inc.php" method="post">
                <h3>Salary:</h3>
                <input type="text" name="start" placeholder="$(Salary)"><br><br>
                <h3>Start date:</h3>
                <input type="date" name="start"><br><br>
                <h3>End date:</h3>
                <input type="date" name="end"><br><br>
                <button name="staffReport" class="addButton">Run Report</button>
            </form>
        </div>
    </section>

<?php
    include_once 'footer.php';
?>