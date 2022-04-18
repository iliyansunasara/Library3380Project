<?php
    include_once 'header.php';
?>
    <?php
        if(isset($_SESSION["University_id"])) {
            $UnivID = $_SESSION["University_id"];
            require_once 'includes/dbh-inc.php';
            require_once 'includes/functions-inc.php';
            $Fname;
            $Middle;
            $Lname;
            $Email;
            $Telephone;
            $Address;
    ?>
        <div class = "signup-form-form">
            <form action="includes/edit-profile-inc.php" method="post">
                <?php
                    $sql = "SELECT * FROM USERS WHERE University_id = $UnivID;";

                    $result = mysqli_query($conn , $sql);
                    $resultCheck = mysqli_num_rows($result);
                    if ($resultCheck > 0) {
                        while($row = mysqli_fetch_assoc($result)) { 
                            $Fname = $row['Fname'];
                            $Middle = $row['Minit'];
                            $Lname = $row['Lname'];
                            $Email = $row['Email'];
                            $Telephone = $row['Phone_num'];
                            $Address = $row['Address'];
                        }
                    }
                ?>
                <h3>First Name:</h3>
                <input type="text" name="fname" value="<?php echo $Fname;?>"><br><br>
                <h3>Middle Initial:</h3>
                <select name="minit">
                        <?php
                        if ($Middle != "") {
                        ?>
                            <option value="<?php echo $Middle;?>"><?php echo $Middle;?></option>
                        <?php
                        }
                        ?>
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
                    </select>
                <br><br>
                <h3>Last Name:</h3>
                <input type="text" name="lname" value="<?php echo $Lname;?>"> <br><br>
                <h3>Email:</h3>
                <input type="text" name="email" value="<?php echo $Email;?>"> <br><br>
                <h3>Phone Number:</h3>
                <input type="tel" name="tele" value="<?php echo $Telephone;?>"> <br><br>
                <h3>Address:</h3>
                <input type="text" name="addy" value="<?php echo $Address;?>"> <br><br>
                <button type="submit" name="submit">Submit Changes</button>
            </form>
        </div>
        <?php
        }
        else if (isset($_SESSION["Staff_id"])) {
            $StaffID = $_SESSION["Staff_id"];
            require_once 'includes/dbh-inc.php';
            require_once 'includes/functions-inc.php';
            $Fname;
            $Middle;
            $Lname;
            $Email;
            $Telephone;
            $Address;
        ?>
        <div class = "signup-form-form">
            <form action="includes/edit-staff-profile-inc.php" method="post">
                <?php
                    $sql = "SELECT * FROM STAFF WHERE Staff_id = $StaffID;";

                    $result = mysqli_query($conn , $sql);
                    $resultCheck = mysqli_num_rows($result);
                    if ($resultCheck > 0) {
                        while($row = mysqli_fetch_assoc($result)) { 
                            $Fname = $row['Fname'];
                            $Middle = $row['Minit'];
                            $Lname = $row['Lname'];
                            $Email = $row['Email'];
                            $Telephone = $row['Phone_num'];
                            $Address = $row['Address'];
                        }
                    }
                ?>
                <h3>First Name:</h3>
                <input type="text" name="fname" value="<?php echo $Fname;?>"><br><br>
                <h3>Middle Initial:</h3>
                <select name="minit">
                        <?php
                        if ($Middle != "") {
                        ?>
                            <option value="<?php echo $Middle;?>"><?php echo $Middle;?></option>
                        <?php
                        }
                        ?>
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
                    </select>
                <br><br>
                <h3>Last Name:</h3>
                <input type="text" name="lname" value="<?php echo $Lname;?>"> <br><br>
                <h3>Email:</h3>
                <input type="text" name="email" value="<?php echo $Email;?>"> <br><br>
                <h3>Phone Number:</h3>
                <input type="tel" name="tele" value="<?php echo $Telephone;?>"> <br><br>
                <h3>Address:</h3>
                <input type="text" name="addy" value="<?php echo $Address;?>"> <br><br>
                <button type="submit" name="submit">Sumbit Changes</button>
            </form>
        </div>
        <?php
        }
        else if (isset($_SESSION["Admin_id"])) {
            $AdminID = $_SESSION["Admin_id"];
            require_once 'includes/dbh-inc.php';
            require_once 'includes/functions-inc.php';
            $Fname;
            $Middle;
            $Lname;
            $Email;
            $Telephone;
            $Address;
        ?>
        <div class = "signup-form-form">
            <form action="includes/edit-staff-profile-inc.php" method="post">
                <?php
                    $sql = "SELECT * FROM STAFF WHERE Staff_id = $AdminID ;";

                    $result = mysqli_query($conn , $sql);
                    $resultCheck = mysqli_num_rows($result);
                    if ($resultCheck > 0) {
                        while($row = mysqli_fetch_assoc($result)) { 
                            $Fname = $row['Fname'];
                            $Middle = $row['Minit'];
                            $Lname = $row['Lname'];
                            $Email = $row['Email'];
                            $Telephone = $row['Phone_num'];
                            $Address = $row['Address'];
                        }
                    }
                ?>
                <h3>First Name:</h3>
                <input type="text" name="fname" value="<?php echo $Fname;?>"><br><br>
                <h3>Middle Initial:</h3>
                <select name="minit">
                        <?php
                        if ($Middle != "") {
                        ?>
                            <option value="<?php echo $Middle;?>"><?php echo $Middle;?></option>
                        <?php
                        }
                        ?>
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
                    </select>
                <br><br>
                <h3>Last Name:</h3>
                <input type="text" name="lname" value="<?php echo $Lname;?>"> <br><br>
                <h3>Email:</h3>
                <input type="text" name="email" value="<?php echo $Email;?>"> <br><br>
                <h3>Phone Number:</h3>
                <input type="tel" name="tele" value="<?php echo $Telephone;?>"> <br><br>
                <h3>Address:</h3>
                <input type="text" name="addy" value="<?php echo $Address;?>"> <br><br>
                <button type="submit" name="submit">Sumbit Changes</button>
            </form>
        </div>
        <?php
        }
        else {
            header("location: login.php");
        }
        ?>
        <div class="editprofilebox">
        <?php
            if(isset($_GET["error"])) {
            if($_GET["error"] == "none") {
                echo "<p class=\"updategood\">Successfully Updated Profile!</p>";
            }
            else if($_GET["error"] == "emptyinput") {
                echo "<p class=\"updatebad\">Empty Input!</p>";
            }
            else if($_GET["error"] == "invalidemail") {
                echo "<p class=\"updatebad\">Invalid Email!</p>";
            }
            else if($_GET["error"] == "sql") {
                echo "<p class=\"updatebad\">Error occurred! Please try again!</p>";
            }
        }
        ?>
        </div>
<?php
    include_once 'footer.php';
?>