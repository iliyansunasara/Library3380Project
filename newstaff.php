<?php
    include_once 'header.php';
?>
<section class="signup-form">
        <h2>To generate report fill out any fields below:</h2>
        <div class="signup-form-form">
            <form action ="includes/newstaff-inc.php" method="POST" target="_blank">
                <h3>Staff ID:</h3>
                    <input oninput="this.value=this.value.slice(0,this.maxLength)" type="number" maxlength="8" name="sid" placeholder="Staff ID..."><br><br>
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
                <h3>Email: </h3>
                    <input type="text" name="email" placeholder="Email..."><br><br>
                <h3>Phone Number:</h3>
                    <input type="tel" name="tele" placeholder="Phone Number..."> <br><br> <br><br>
                <h3>Start Birth:</h3>
                    <input id="dobF" type="date" name="startDob"> <br><br>
                <h3>End Birth:</h3>
                    <input id="dobF" type="date" name="endDob"> <br><br> <br><br>
                <h3>Start Salary:</h3>
                    <input type="text" name="startSal" placeholder="Start salary..."><br><br>
                <h3>End Salary:</h3>
                    <input type="text" name="endSal" placeholder="End salary..."><br><br> <br><br>
                <h3>Start Edit:</h3>
                    <input type="date" name="startEdit"><br><br>
                <h3>End Edit:</h3>
                    <input type="date" name="endEdit"><br><br> <br><br>
                <h3>Start Hire:</h3>
                    <input type="date" name="startHire"><br><br>
                <h3>End Hire:</h3>
                    <input type="date" name="endHire"><br><br>
                <button name="submit" class="submit">Run Report</button>
            </form>
        </div>
</section>
    <?php
        if(isset($_GET["error"])) {
            if($_GET["error"] == "startsalarybig") {
                echo '<script>alert("Start salary is larger than end salary!")</script>';
            }
            else if($_GET["error"] == "startdatebig") {
                echo '<script>alert("A start date is larger than an end date!")</script>';
            }
        }
    ?>
<?php
    include_once 'footer.php';
?>