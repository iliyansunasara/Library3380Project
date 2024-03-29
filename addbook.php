<?php
    include_once 'header.php';
    if(!isset($_SESSION["Admin_id"])) {
        header("Location: login.php?error=noPermission");
        exit();
    }
?>  
    <section class="signup-form">
        <h2>To add book fill out all fields below:</h2>
        <div class="signup-form-form">
            <form action="includes/addBook-inc.php" method="post" enctype="multipart/form-data">
                <h3>Book ID:</h3>
                <input oninput="this.value=this.value.slice(0,this.maxLength)" type="number" maxlength="12" name="bookid" placeholder="Book ID..."><br><br>
                <h3>Title:</h3>
                <input type="text" name="title" placeholder="Title..."><br><br>
                <h3>Author:</h3>
                <input type="text" name="author" placeholder="Author..."><br><br>
                <h3>Cover:</h3>
                <input type="file" name="cover"><br><br> 
                <h3>Genre:</h3>
                <select name="genre" id="genre">
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
                </select><br><br>
                <h3>Fiction? :</h3>
                <select name="isFict" id="isFict">
                    <option value=>-</option>
                    <option value="0">No</option>
                    <option value="1">Yes</option>
                </select><br><br>
                <h3>Age Group:</h3>
                <select name="ageG" id="ageG">
                    <option value=>-</option>
                    <option value="E">Everyone</option>
                    <option value="T">Teen</option>
                    <option value="A">Adult</option>
                    <option value="C">Children</option>
                </select><br><br>
                <h3>Condition:</h3>
                <select name="cond" id="cond">
                    <option value=>-</option>
                    <option value="E">Excellent</option>
                    <option value="G">Good</option>
                    <option value="W">Worn</option>
                </select><br><br>
                <button type="addBook" name="addBook" class="addButton">Add Book</button>
            </form>
        </div>
    </section>

    <?php
        if(isset($_GET["error"])) {
            $var = $_GET["error"];
            echo "<script>alert(".$var.")</script>";
            if($_GET["error"] == "emptyinput") {
                echo '<script>alert("Fill in all required fields!")</script>';
            }
            else if($_GET["error"] == "invalidBookID") {
                echo '<script>alert("Enter a proper Book ID!")</script>';
            }
            else if($_GET["error"] == "bookIDtaken") {
                echo '<script>alert("Book ID already Exists!")</script>';
            }
            else if($_GET["error"] == "stmtfailed") {
                echo '<script>alert("Something went wrong, please try again!")</script>';
            }
            else if($_GET["error"] == "none") {
                echo '<script>alert("You have successfully added a book!")</script>';
            }
        }
    ?>
    
<?php
    include_once 'footer.php';
?>