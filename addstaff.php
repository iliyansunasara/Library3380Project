<?php
    include_once 'header.php';
?>
    <section class="signup-form">
        <h2>To add staff member fill out all fields below:</h2>
        <div class="signup-form-form">
            <form action="includes/addStaff-inc.php" method="post">
                <h3>Staff ID:</h3>
                <input type="text" name="staffid" placeholder="-"><br><br>
                <h3>Password:</h3>
                <input type="password" name="pwd" placeholder="-"><br><br>
                <h3>First Name:</h3>
                <input type="text" name="fname" placeholder="-"><br><br>
                <h3>Last Name:</h3>
                <input type="text" name="lname" placeholder="-"><br><br>
                <h3>Middle Initial:</h3>
                <select name="minit" id="minit">
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
                </select><br><br><br>
                <h3>Date of Birth:</h3>
                <input id="dob" type="date" name="dob" placeholder="*-"><br><br>
                <h3>Salary:</h3>
                <input type="text" name="salary" placeholder="-"><br><br>
                <h3>Email:</h3>
                <input type="text" name="email" placeholder="-"><br><br>
                <h3>Phone Number:</h3>
                <input type="tel" name="tele" placeholder="-"><br><br>
                <h3>Address:</h3>
                <input type="text" name="addy" placeholder="House# Street, City, State"><br><br>
                <h3>Admin? :</h3>
                <select name="status" id="status">
                    <option value=>-</option>
                    <option value="0">No</option>
                    <option value="1">Yes</option>
                </select><br><br>
                <button type="addStaff" name="addStaff" class="addButton">Add Staff Member</button>
            </form>
        </div>
    </section>

    <?php
        if(isset($_GET["error"])) {
            if($_GET["error"] == "emptyinput") {
                echo '<script>alert("Fill in all required fields!")</script>';
            }
            else if($_GET["error"] == "invalidsid") {
                echo '<script>alert("Enter a proper Staff ID!")</script>';
            }
            else if($_GET["error"] == "invalidemail") {
                echo '<script>alert("Enter a proper Email!")</script>';
            }
            else if($_GET["error"] == "sidtaken") {
                echo '<script>alert("Staff ID already Exists!")</script>';
            }
            else if($_GET["error"] == "stmtfailed") {
                echo '<script>alert("Something went wrong, please try again!")</script>';
            }
            else if($_GET["error"] == "none") {
                echo '<script>alert("You have successfully added a staff member!")</script>';
            }
        }
    ?>
    
<?php
    include_once 'footer.php';
?>