<?php
    include_once 'header.php';
?>
<section class="repusers-form">
        <h2>To generate report fill out any fields below:</h2>
        <div class="repusers-form-form"> <!--"signup-form-form"-->
            <form action ="includes/report-item-inc.php" method="POST" target="_blank">
                <div class="signup-form-form">
                <h3>Item ID:</h3>
                    <input oninput="this.value=this.value.slice(0,this.maxLength)" type="number" maxlength="12" name="iid" placeholder="Item ID..."><br><br>
                <h3>Item Type:</h3>
                <select name="itemType">
                    <option value=>-</option>
                    <option value="H">Headphones</option>
                    <option value="C">Calculator</option>
                    <option value="L">Laptop</option>
                </select><br><br>
                <h3>Condition:</h3>
                <select name="cond" id="cond">
                    <option value=>-</option>
                    <option value="E">Excellent</option>
                    <option value="G">Good</option>
                    <option value="W">Worn</option>
                    <option value="D">Damaged</option>
                </select><br><br>
                <h3>Created by:</h3>
                    <input oninput="this.value=this.value.slice(0,this.maxLength)" type="number" maxlength="8" name="creator" placeholder="Staff ID..."><br><br>
                <h3>Last update by:</h3>
                    <input oninput="this.value=this.value.slice(0,this.maxLength)" type="number" maxlength="8" name="updator" placeholder="Staff ID..."><br><br>
                </div>
                <h3>Added Range:</h3>
                    <input type="date" name="endAdd">
                    <input type="date" name="startAdd"><br><br>
                <h3>Updated Range:</h3>
                    <input type="date" name="endUP">
                    <input type="date" name="startUP"><br><br>
                <button name="submit" class="submit">Run Report</button>
            </form>
        </div>
</section>
    <?php
        if(isset($_GET["error"])) {
            if($_GET["error"] == "startdatebig") {
                echo '<script>alert("A start date is larger than an end date!")</script>';
                echo "<script>window.close();</script>";
            }
        }
    ?>
<?php
    include_once 'footer.php';
?>