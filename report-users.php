<?php
    include_once 'header.php';
    if(!isset($_SESSION["Admin_id"])) {
        header("Location: login.php?error=noPermission");
        exit();
    }
?>
<section class="repusers-form">
        <h2>To generate report fill out any fields below:</h2>
        <div class="repusers-form-form"> <!--"signup-form-form"-->
            <form action ="includes/report-users-inc.php" method="POST" target="_blank">
                <div class="signup-form-form">
                <h3>University ID:</h3>
                    <input oninput="this.value=this.value.slice(0,this.maxLength)" type="number" maxlength="7" name="uid" placeholder="University ID..."><br><br>
                <h3>First Name: </h3>
                    <input type="text" name="fname" placeholder="First Name..."><br><br>
                <h3>Middle Initial:</h3>
                    <select name="minit" id="mi">
                        <option value="">None</option>
                        <option value="A">A</option>
                        <option value="B">B</option>
                        <option value="C">C</option>
                        <option value="D">D</option>
                        <option value="E">E</option>
                        <option value="F">F</option>
                        <option value="G">G</option>
                        <option value="H">H</option>
                        <option value="I">I</option>
                        <option value="J">J</option>
                        <option value="K">K</option>
                        <option value="L">L</option>
                        <option value="M">M</option>
                        <option value="N">N</option>
                        <option value="O">O</option>
                        <option value="P">P</option>
                        <option value="Q">Q</option>
                        <option value="R">R</option>
                        <option value="S">S</option>
                        <option value="T">T</option>
                        <option value="U">U</option>
                        <option value="V">V</option>
                        <option value="W">W</option>
                        <option value="X">Y</option>
                        <option value="Y">X</option>
                        <option value="Z">Z</option>
                    </select> <br><br>
                <h3>Last Name:</h3>
                    <input type="text" name="lname" placeholder="Last Name..."><br><br>
                <h3>Status: </h3>
                    <select name="status" id="status"> <br><br>
                        <option value="">None</option> <!--maybe fix????-->
                        <option value="S">Student</option>
                        <option value="F">Faculty</option>
                    </select> <br><br>
                <h3>Email: </h3>
                    <input type="text" name="email" placeholder="Email..."><br><br>
                <h3>Phone Number:</h3>
                    <input type="tel" name="tele" placeholder="Phone Number..."> <br><br>
                <h3>Address:</h3>
                    <input type="text" name="addy" placeholder="Address..."><br><br> <br>
                </div>
                <h3>Birth Range:</h3>
                    <input type="date" name="endDob"> 
                    <input type="date" name="startDob"> <br><br>
                <h3>Fine Range:</h3>
                    <input type="text" name="endFines" placeholder="End fines...">
                    <input type="text" name="startFines" placeholder="Start fines..."><br><br> 
                <h3>Book Range:</h3>
                    <input type="text" name="endBooks" placeholder="End books...">
                    <input type="text" name="startBooks" placeholder="Start books..."> <br><br>
                <h3>Calculator Range:</h3>
                    <input type="text" name="endCalc" placeholder="End calculator...">
                    <input type="text" name="startCalc" placeholder="Start calculator..."> <br><br>
                <h3>Laptop Range:</h3>
                    <input type="text" name="endLap" placeholder="End laptop...">
                    <input type="text" name="startLap" placeholder="Start laptop..."> <br><br>
                <h3>Headphone Range:</h3>
                    <input type="text" name="endHead" placeholder="End headphones...">
                    <input type="text" name="startHead" placeholder="Start headphones..."> <br><br>
                <h3>Edit Range:</h3>
                    <input type="date" name="endEdit">
                    <input type="date" name="startEdit"><br><br>
                <h3>Joined Range:</h3>
                    <input type="date" name="endJoin">
                    <input type="date" name="startJoin"><br><br>
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