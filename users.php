<?php
    include_once 'header.php';
?>
    <?php
        require_once 'includes/functions-inc.php';
        $sql = "SELECT * FROM USERS;";
        $result = $conn->query($sql);
        ?>
        <div class="tableDiv">
            <h3>USERS:</h3>
        <table class ='userTable'>
            <thead>
                <tr>
                    <th>Status</th>
                    <th>First</th>
                    <th>Last</th>
                    <th>Birthday</th>
                    <th>Email</th>
                    <th>Phone #</th>
                    <th>Fines</th>
                    <th colspan="2">Action</th>
                </tr>
            </thead>
        <?php
        if($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) { ?>
                <tr>
                    <?php
                        $stat = checkStatus($row['Status']);
                    ?>
                    <td> <?php echo $stat; ?></td>
                    <td> <?php echo $row['Fname']; ?></td>
                    <td> <?php echo $row['Lname']; ?></td>
                    <td> <?php echo $row['BDate']; ?></td>
                    <td> <?php echo $row['Email']; ?></td>
                    <td> <?php echo $row['Phone_num']; ?></td>
                    <td> <?php echo $row['Fines']; ?></td>
                    <td> <a href="users.php?edit=<?php echo $row['University_id'] ;?>">
                            Edit
                         </a>
                         <a href="includes/users-inc.php?delete=<?php echo $row['University_id'] ;?>">
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
            <a href="users.php?add=" class="button">Add User</a>
        </div>
        

        <?php
        }
        
        
    ?>
    <?php
        if(isset($_GET['edit'])) {
            $UnivID = $_GET['edit'];
            $uidExists = uidExists($conn, $UnivID);
    ?>
        <section class="final-signup-form"> <!--signup-form-->
            <h2>To edit user fill out fields below:</h2>
            <div class="final-signup-form-form"> <!--signup-form-form-->
                <form action="includes/users-inc.php" method="post">
                    <input type="hidden" name="uni" value="<?php echo $UnivID;?>">
                    <h3>First Name: </h3>
                    <input type="text" name="fname" value="<?php echo $uidExists['Fname']; ?>"><br><br>
                    <h3>Middle Initial:</h3>
                    <!--<label for="mi">Middle Initial (if available):</label>-->
                    <select name="minit">
                        <?php 
                        if($uidExists['Minit'] != "") { ?>
                            <option value="<?php echo $uidExists['Minit']; ?>"><?php echo $uidExists['Minit']; ?></option>
                            <option value="">None</option>
                        <?php
                        }
                        else { ?>
                            <option value="">None</option>"
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
                    <h3>Last Name:</h3>
                    <input type="text" name="lname" value="<?php echo $uidExists['Lname']; ?>"><br><br>
                    <h3>Status: </h3>
                    <!--<label for="status">Status:</label>-->
                    <select name="status"> <br><br>
                        <>
                        <option value="<?php echo $uidExists['Status']; ?>"><?php echo checkStatus($uidExists['Status']); ?></option>
                        <option value="S">Student</option>
                        <option value="F">Faculty</option>
                    </select> <br><br>
                    <h3>Email: </h3>
                    <input type="text" name="email" value="<?php echo $uidExists['Email']; ?>"><br><br>
                    <h3>Date of Birth:</h3>
                    <!--<label for=dobF">*Date of Birth:</label>-->
                        <input type="date" name="dob" value="<?php echo $uidExists['BDate'];?>"> <br><br>
                    <h3>Phone Number:</h3>
                    <input type="tel" name="tele" value="<?php echo $uidExists['Phone_num'];?>"> <br><br>
                    <h3>Address:</h3>
                    <input type="text" name="addy" value="<?php echo $uidExists['Address'];?>"> <br><br>
                    <h3>Fines:</h3>
                    <input type="text" name="fine" value="<?php echo $uidExists['Fines'];?>"> <br><br><br>
                    <button type="submit" name="submit">Update</button>
                </form> 
            </div>
        </section>

        <?php
        }
        if(isset($_GET['add'])) {
    ?>
        <section class="final-signup-form"> <!--signup-form-->
            <h2>To add user fill out all required fields(*) below:</h2>
            <div class="final-signup-form-form"> <!--signup-form-form-->
                <form action="includes/signup-inc.php" method="post">
                    <h3>*University ID:</h3>
                    <input oninput="this.value=this.value.slice(0,this.maxLength)" type="number" maxlength="7" name="uni" placeholder="University ID..."><br><br>
                    <h3>*Password: </h3>
                    <input type="password" name="pwd" placeholder="Password..."><br><br>
                    <h3>*Confirm Password: </h3>
                    <input type="password" name="confirm" placeholder="Confirm Password..."><br><br>
                    <h3>*First Name: </h3>
                    <input type="text" name="fname" placeholder="First Name..."><br><br>
                    <h3>Middle Initial:</h3>
                    <!--<label for="mi">Middle Initial (if available):</label>-->
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
                    <h3>*Last Name:</h3>
                    <input type="text" name="lname" placeholder="Last Name..."><br><br>
                    <h3>*Status: </h3>
                    <!--<label for="status">Status:</label>-->
                    <select name="status" id="status"> <br><br>
                        <option value="N">None</option>
                        <option value="S">Student</option>
                        <option value="F">Faculty</option>
                    </select> <br><br>
                    <h3>*Email: </h3>
                    <input type="text" name="email" placeholder="Email..."><br><br>
                    <h3>*Date of Birth:</h3>
                    <!--<label for=dobF">*Date of Birth:</label>-->
                        <input id="dobF" type="date" name="dob" placeholder="Date of Birth..."> <br><br>
                    <h3>*Phone Number:</h3>
                    <input type="tel" name="tele" placeholder="Phone Number..."> <br><br>
                    <h3>*Address:</h3>
                    <input type="text" name="addy" placeholder="House# Street, City, State"> <br><br> <br>
                    <button type="submit" name="signup">Sign Up</button>
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
            else if($_GET["error"] == "invaliduid") {
                echo "<script>alert('Enter a proper University ID!');</script>";
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
            else if($_GET["error"] == "uidtaken") {
                echo "<script>alert('University ID already Exists!');</script>";
                echo "<script>history.back();</script>";
            }
            else if($_GET["error"] == "userDeleted") {
                echo "<script>alert('User deleted successfully');</script>";
                echo "<script>history.back();</script>";
            }
            else if($_GET["error"] == "hasCO") {
                echo "<script>alert('User has a checkout, can\'t delete!');</script>";
                echo "<script>history.back();</script>";
            }
            else if($_GET["error"] == "noneAdd") {
                echo "<script>alert('You have successfully added a user!');</script>";
                echo "<script>history.back();</script>";
            }
            else if($_GET["error"] == "none") {
                echo "<script>alert('You have successfully updated the user!');</script>";
                echo "<script>history.back();</script>";
            }
        }
    ?>
<?php
    include_once 'footer.php';
?>