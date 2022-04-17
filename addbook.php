<?php
    include_once 'header.php';
?>
    <section class="addPages-form">
        <h2>To add book fill out all fields below:</h2>
        <div class="forms">
            <form action="includes/addBook-inc.php" method="post">
                <input type="text" name="bookid" placeholder="Book ID..."><br><br>
                <input type="text" name="title" placeholder="Title..."><br><br>
                <input type="text" name="author" placeholder="Author..."><br><br>
                <!-- <input type="text" name="lname" placeholder="*Cover..."> -->
                <label for="genre">Genre:</label>
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
                <label for="isFict">Fiction?</label>
                <select name="isFict" id="isFict">
                    <option value=>-</option>
                    <option value="0">No</option>
                    <option value="1">Yes</option>
                </select><br><br>
                <label for="ageG">Age Group:</label>
                <select name="ageG" id="ageG">
                    <option value=>-</option>
                    <option value="E">Everyone</option>
                    <option value="T">Teen</option>
                    <option value="A">Adult</option>
                    <option value="C">Children</option>
                </select><br><br>
                <label for="cond">Condition:</label>
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