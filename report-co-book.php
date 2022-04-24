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
            <form action ="includes/report-co-book-inc.php" method="POST" target="_blank">
                <div class="signup-form-form">
                <h3>Staff ID:</h3>
                    <input oninput="this.value=this.value.slice(0,this.maxLength)" type="number" maxlength="8" name="sid" placeholder="Staff ID..."><br><br>
                <h3>University ID:</h3>
                    <input oninput="this.value=this.value.slice(0,this.maxLength)" type="number" maxlength="7" name="uid" placeholder="University ID..."><br><br>
                <h3>Book ID:</h3>
                    <input oninput="this.value=this.value.slice(0,this.maxLength)" type="number" maxlength="12" name="bid" placeholder="Book ID..."><br><br>
                <h3>Title:</h3>
                    <input type="text" name="title" placeholder="Title..."><br><br>
                <h3>Author:</h3>
                    <input type="text" name="author" placeholder="Author..."><br><br>
                <h3>Genre:</h3>
                <select name="genre" id="genre">
                    <option value="">-</option>
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
                <h3>Age Group:</h3>
                <select name="ageG" id="ageG">
                    <option value="">-</option>
                    <option value="E">Everyone</option>
                    <option value="T">Teen</option>
                    <option value="A">Adult</option>
                    <option value="C">Children</option>
                </select><br><br>
                <h3>Fiction? :</h3>
                <select name="isFict" id="isFict">
                    <option value="">-</option>
                    <option value="0">No</option>
                    <option value="1">Yes</option>
                </select><br><br>
                <h3>Condition:</h3>
                <select name="cond" id="cond">
                    <option value=>-</option>
                    <option value="E">Excellent</option>
                    <option value="G">Good</option>
                    <option value="W">Worn</option>
                    <option value="D">Damaged</option>
                </select><br><br>
                </div>
                <h3>Checkout Range:</h3>
                    <input type="date" name="endCOB">
                    <input type="date" name="startCOB"><br><br>
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