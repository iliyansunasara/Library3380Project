<?php
    include_once 'header.php';
    require_once 'includes/dbh-inc.php';
    require_once 'includes/functions-inc.php';
    if(!isset($_SESSION["Admin_id"])) {
        header("Location: login.php?error=noPermission");
        exit();
    }
?>
    <?php
        if(isset($_POST['bookID'])) {
            $BookID = $_POST["bookID"];
            $Title;
            $Author;
            $Cover;
            $Genre;
            $AgeGroup;
            $Fiction;
            $Condition;
    ?>
        <div class = "signup-form-form">
            <form action="includes/edit-book-inc.php" method="post" enctype="multipart/form-data">
                <?php
                    $sql = "SELECT * FROM BOOK WHERE Book_id = $BookID;";

                    $result = mysqli_query($conn , $sql);
                    $resultCheck = mysqli_num_rows($result);
                    if ($resultCheck > 0) {
                        while($row = mysqli_fetch_assoc($result)) { 
                            $Title = $row['Title'];
                            $Author = $row['Author'];
                            $Genre = $row['Genre'];
                            $Cover = $row['Cover'];
                            $AgeGroup = $row['Age_group'];
                            $Fiction = $row['Fiction'];
                            $Condition = $row['Condition'];
                        }
                    }
                ?>
                <h3>Title:</h3>
                <input type="text" name="title" value="<?php echo $Title;?>"><br><br>
                <h3>Author:</h3>
                <input type="text" name="author" value="<?php echo $Author;?>"><br><br>
                <h3>Cover:</h3>
                <input type="hidden" name="cover-old" value="<?php echo $Cover;?>">
                <input type="file" name="cover" value="<?php echo $Cover;?>"><br><br> 
                <h3>Genre:</h3>
                <select name="genre">
                    <option value="<?php echo $Genre;?>"><?php echo $Genre;?></option>
                    <option value=>-</option>
                    <option value="Fantasy">Fantasy</option>
                    <option value="Science-Fiction">Science-Fiction</option>
                    <option value="Adventure">Adventure</option>
                    <option value="Romance">Romance</option>
                    <option value="Mystery">Mystery</option>
                    <option value="Horror">Horror</option>
                    <option value="Thriller">Thriller</option>
                    <option value="Comedy">Comedy</option>
                    <option value="Childrens">Childrens</option>
                    <option value="Informative">Informative</option>
                    </select>
                <br><br>
                <h3>Age Group:</h3>
                <select name="ageG" id="ageG">
                    <?php
                    if($AgeGroup == "E") {
                    ?>
                        <option value="E"><?php echo "Everyone";?></option>
                        <option value="T"><?php echo "Teens";?></option>
                        <option value="A"><?php echo "Adults";?></option>
                        <option value="C"><?php echo "Children";?></option>
                    <?php
                    }
                    else if($AgeGroup == "T") {
                    ?>
                        <option value="T"><?php echo "Teens";?></option>
                        <option value="E"><?php echo "Everyone";?></option>
                        <option value="A"><?php echo "Adults";?></option>
                        <option value="C"><?php echo "Children";?></option>
                    <?php
                    }
                    else if($AgeGroup == "A") {
                    ?>
                        <option value="A"><?php echo "Adults";?></option>
                        <option value="E"><?php echo "Everyone";?></option>
                        <option value="T"><?php echo "Teens";?></option>
                        <option value="C"><?php echo "Children";?></option>
                    <?php
                    }
                    else if($AgeGroup == "C") {
                    ?>
                        <option value="C"><?php echo "Children";?></option>
                        <option value="E"><?php echo "Everyone";?></option>
                        <option value="T"><?php echo "Teens";?></option>
                        <option value="A"><?php echo "Adults";?></option>
                    <?php
                    }
                    ?>
                </select><br><br>
                <h3>Fiction? :</h3>
                <select name="isFict" id="isFict">
                <?php
                    if($Fiction == 1) {
                    ?>
                        <option value="1"><?php echo "Yes";?></option>
                        <option value="0">No</option>
                    <?php
                    }
                    else {
                    ?>
                        <option value="0"><?php echo "No";?></option>
                        <option value="1">Yes</option>
                    <?php
                    }
                    ?>
                </select><br><br>
                <h3>Condition:</h3>
                <select name="cond" id="cond">
                    <?php
                        if($Condition == "E") {
                    ?>
                        <option value="E"><?php echo "Excellent";?></option>
                        <option value="G"><?php echo "Good";?></option>
                        <option value="W"><?php echo "Worn";?></option>
                        <option value="D"><?php echo "Damaged";?></option>
                    <?php
                        }
                        else if($Condition == "G") {
                    ?>
                        <option value="G"><?php echo "Good";?></option>
                        <option value="W"><?php echo "Worn";?></option>
                        <option value="E"><?php echo "Excellent";?></option>
                        <option value="D"><?php echo "Damaged";?></option>
                    <?php
                        }
                        else if($Condition == "W") {
                    ?>
                        <option value="W"><?php echo "Worn";?></option>
                        <option value="G"><?php echo "Good";?></option>
                        <option value="E"><?php echo "Excellent";?></option>
                        <option value="D"><?php echo "Damaged";?></option>
                    <?php
                        }
                        elseif($Condition == "D") {
                    ?>
                        <option value="D"><?php echo "Damaged";?></option>
                        <option value="G"><?php echo "Good";?></option>
                        <option value="W"><?php echo "Worn";?></option>
                        <option value="E"><?php echo "Excellent";?></option>
                    <?php
                        }
                    ?>
                </select><br><br>
                <input type="hidden" name="bookIDD" value="<?php echo $BookID;?>">
                <button type="changeBook" name="changeBook">Submit Changes</button><br><br>
                <button type="deleteBook" name="deleteBook" onclick="return confirm('Are you sure you want to Delete?');">DELETE BOOK</button>
            </form>
        </div>
    <?php
    }
    // else {
    //     echo '<script>alert("Book ID not Present!")</script>';
    //     header("location:index.php");
    // }
    ?>

    <?php
        if(isset($_GET["error"])) 
        {
            if($_GET["error"] == "none") {
                echo '<script>alert("Book Updated Successfully!")</script>';
                //header("location:index.php?error=bookUpdated");
            }
            else if($_GET["error"] == "noneDeleted") {
                //header("location:index.php?error=bookDeleted");
                echo '<script>alert("Book Deleted Successfully!")</script>';
            }
            else if($_GET["error"] == "emptyinput") {
                echo '<script>alert("Empty Input!")</script>';
            }
            else if($_GET["error"] == "sql") {
                echo '<script>alert("Error occurred! Please try again!")</script>';
            }
            else if($_GET["error"] == "filesize") {
                echo '<script>alert("File size error!")</script>';
            }
            else if($_GET["error"] == "filetype") {
                echo '<script>alert("File type not supported!")</script>';
            }
            else if($_GET["error"] == "fileupload") {
                echo '<script>alert("File not uploaded!")</script>';
            }
        }
    ?>

<?php
    include_once 'footer.php';
?>