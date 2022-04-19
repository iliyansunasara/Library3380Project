<?php
    include_once 'header.php';
?>
    <section class="signup-form">
        <h2>To signup fill out fields below: * indicates required fields</h2>
        <div class="signup-form-form">
            <form action="includes/signup-inc.php" method="post">
                <h3>*University ID:</h3>
                <input oninput="this.value=this.value.slice(0,this.maxLength)" type="number" maxlength="7" name="uni" placeholder="University ID..."><br><br>
                <h3>*Password: </h3>
                <input type="password" name="pwd" placeholder="Password..."><br><br>
                <h3>*First Name: </h3>
                <input type="text" name="fname" placeholder="First Name..."><br><br>
                <h3>*Last Name:</h3>
                <input type="text" name="lname" placeholder="Last Name..."><br><br>
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
                <button type="submit" name="submit">Sign Up</button>
            </form>
            
        </div>
    </section>
    <?php
        if(isset($_GET["error"])) {
            if($_GET["error"] == "emptyinput") {
                echo "<script>alert('Fill in all required fields!');</script>";
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
            else if($_GET["error"] == "uidtaken") {
                echo "<script>alert('University ID already Exists!');</script>";
                echo "<script>history.back();</script>";
            }
            else if($_GET["error"] == "stmtfailed") {
                echo "<script>alert('Something went wrong, please try again!');</script>";
                echo "<script>history.back();</script>";
            }
            else if($_GET["error"] == "none") {
                echo "<script>alert('You have successfully signed up!');</script>";
            }
        }
    ?>
    
<?php
    include_once 'footer.php';
?>