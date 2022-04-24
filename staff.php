<?php
    include_once 'header.php';
?>
    <?php
        require_once 'includes/functions-inc.php';
        $sql = "SELECT * FROM STAFF;";
        $result = $conn->query($sql);
        ?>
        <div class="tableDiv">
            <h3>STAFF:</h3>
        <table class ='userTable'>
            <thead>
                <tr>
                    <th>First</th>
                    <th>Last</th>
                    <th>Birthday</th>
                    <th>Email</th>
                    <th>Phone #</th>
                    <th>Salary</th>
                    <th colspan="2">Action</th>
                </tr>
            </thead>
        <?php
        if($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) { ?>
                <tr>
                    <td> <?php echo $row['Fname']; ?></td>
                    <td> <?php echo $row['Lname']; ?></td>
                    <td> <?php echo $row['BDate']; ?></td>
                    <td> <?php echo $row['Email']; ?></td>
                    <td> <?php echo $row['Phone_num']; ?></td>
                    <td> <?php echo $row['Salary']; ?></td>
                    <td> <a href="staff.php?edit=<?php echo $row['Staff_id'] ;?>">
                            Edit
                         </a>
                         <a href="includes/staff-inc.php?delete=<?php echo $row['Staff_id'] ;?>">
                            Delete
                         </a>
                    </td> 
                </tr>
            <?php
            }
            ?>
            </table>
        </div>
        <div class="addUser">
            <a href="staff.php?add=" class="button">Add Staff</a>
        </div>
        

        <?php
        }
        
        
    ?>
    <?php
        if(isset($_GET['edit'])) {
            $StaffID = $_GET['edit'];
            $sidExists = sidExists($conn, $StaffID );
    ?>
        <section class="final-signup-form"> <!--signup-form-->
            <h2>To edit staff fill out fields below:</h2>
            <div class="final-signup-form-form"> <!--signup-form-form-->
                <form action="includes/staff-inc.php" method="post">
                    <input type="hidden" name="sid" value="<?php echo $StaffID ;?>">
                    <h3>First Name: </h3>
                    <input type="text" name="fname" value="<?php echo $sidExists['Fname']; ?>"><br><br>
                    <h3>Last Name:</h3>
                    <input type="text" name="lname" value="<?php echo $sidExists['Lname']; ?>"><br><br>
                    <!--<label for="status">Status:</label>-->
                    <h3>Middle Initial:</h3>
                    <!--<label for="mi">Middle Initial (if available):</label>-->
                    <select name="minit">
                        <?php 
                        if($sidExists['Minit'] != "") { ?>
                            <option value="<?php echo $sidExists['Minit']; ?>"><?php echo $sidExists['Minit']; ?></option>
                            <option value="">None</option>
                        <?php
                        }
                        else { ?>
                            <option value="">None</option>
                        <?php
                        }
                        ?>
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
                    <h3>Email: </h3>
                    <input type="text" name="email" value="<?php echo $sidExists['Email']; ?>"><br><br>
                    <h3>Date of Birth:</h3>
                    <!--<label for=dobF">*Date of Birth:</label>-->
                        <input type="date" name="dob" value="<?php echo $sidExists['BDate'];?>"> <br><br>
                    <h3>Phone Number:</h3>
                    <input type="tel" name="tele" value="<?php echo $sidExists['Phone_num'];?>"> <br><br>
                    <h3>Address:</h3>
                    <input type="text" name="addy" value="<?php echo $sidExists['Address'];?>"> <br><br>
                    <h3>Salary:</h3>
                    <input type="text" name="salary" value="<?php echo $sidExists['Salary'];?>"> <br><br><br>
                    <button type="submit" name="submit">Update</button>
                </form> 
            </div>
        </section>

        <?php
        }
        if(isset($_GET['add'])) {
    ?>
        <section class="final-signup-form"> <!--signup-form-->
            <h2>To add staff fill out all required fields(*) below:</h2>
            <div class="final-signup-form-form"> <!--signup-form-form-->
                <form action="includes/staff-inc.php" method="post">
                    <h3>*Staff ID:</h3>
                    <input oninput="this.value=this.value.slice(0,this.maxLength)" type="number" maxlength="8" name="sid" placeholder="Staff ID..."><br><br>
                    <h3>*Password: </h3>
                    <input type="password" name="pwd" placeholder="Password..."><br><br>
                    <h3>*Confirm Password: </h3>
                    <input type="password" name="confirm" placeholder="Confirm Password..."><br><br>
                    <h3>*First Name: </h3>
                    <input type="text" name="fname" placeholder="First Name..."><br><br>
                    <h3>*Last Name:</h3>
                    <input type="text" name="lname" placeholder="Last Name..."><br><br>
                    <h3>Middle Initial:</h3>
                        <select name="minit">
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
                    <h3>*Status: </h3>
                        <select name="status">
                            <option value="">None</option>
                            <option value="0">Standard</option>
                            <option value="1">Admin</option>
                        </select><br><br>
                    <h3>*Email: </h3>
                    <input type="text" name="email" placeholder="Email..."><br><br>
                    <h3>*Date of Birth:</h3>
                        <input id="dobF" type="date" name="dob"> <br><br>
                    <h3>*Phone Number:</h3>
                    <input type="tel" name="tele" placeholder="Phone Number..."> <br><br>
                    <h3>*Address:</h3>
                    <input type="text" name="addy" placeholder="House# Street, City, State"> <br><br>
                    <h3>*Salary:</h3>
                    <input type="text" name="salary" placeholder="Salary..."> <br><br><br>
                    <button type="submit" name="addStaff">Sign Up</button>
                </form> 
            </div>
        </section>
        <?php
        }
        if(isset($_GET["error"])) {
            if($_GET["error"] == "emptyinput") {
                echo "<script>alert('Field left empty!');</script>";
                echo "<script>history.back();</script>";
            }
            else if($_GET["error"] == "matchpwd") {
                echo "<script>alert('Password doesn\'t match!');</script>";
                echo "<script>history.back();</script>";
            }
            else if($_GET["error"] == "invalidsid") {
                echo "<script>alert('Enter a proper Staff ID!');</script>";
                echo "<script>history.back();</script>";
            }
            else if($_GET["error"] == "invalidemail") {
                echo "<script>alert('Enter a proper Email!');</script>";
                echo "<script>history.back();</script>";
            }
            else if($_GET["error"] == "stmtfailed") {
                echo "<script>alert('Something went wrong, please try again!');</script>";
                echo "<script>history.back();</script>";
            }
            else if($_GET["error"] == "sidtaken") {
                echo "<script>alert('Staff ID already Exists!');</script>";
                echo "<script>history.back();</script>";
            }
            else if($_GET["error"] == "staffDeleted") {
                echo "<script>alert('Staff deleted successfully');</script>";
                echo "<script>history.back();</script>";
            }
            else if($_GET["error"] == "staffCO") {
                echo "<script>alert('Staff has a checkout, can\'t delete!');</script>";
                echo "<script>history.back();</script>";
            }
            else if($_GET["error"] == "noneAdd") {
                echo "<script>alert('You have successfully added a staff!');</script>";
                echo "<script>history.back();</script>";
            }
            else if($_GET["error"] == "none") {
                echo "<script>alert('You have successfully updated the staff!');</script>";
                echo "<script>history.back();</script>";
            }
        }
    ?>
<?php
    include_once 'footer.php';
?>