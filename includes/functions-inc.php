<?php

    function checkCondition($temp) {
        if ($temp == "E") {
            $cond = "Excellent";
        }
        else if ($temp == "G") {
            $cond = "Good";
        }
        else if ($temp == "W") {
            $cond = "Worn";
        }
        else if ($temp == "D") {
            $cond = "Damaged";
        }
        else {
            $cond = "Unknown";
        }
        return $cond;
    }
    function itemType($temp) {
        if ($temp == "C") {
            $itemType = "Calculator";
        }
        else if ($temp == "L") {
            $itemType = "Laptop";
        }
        else if ($temp == "H") {
            $itemType = "Headphones";
        }
        else {
            $itemType = "Unknown";
        }
        return $itemType;
    }

    function checkAgeGroup($temp) {
        if ($temp == "C") {
            $ageGroup = "Children";
        }
        else if ($temp == "T") {
            $ageGroup = "Teen";
        }
        else if ($temp == "A"){
            $ageGroup = "Adult";
        }
        else {
            $ageGroup = "Unknown";
        }
        return $ageGroup;
    }

    function checkFiction($temp) {
        if ($temp == 1) {
            $isFiction = "Yes";
        }
        else if ($temp == 0){
            $isFiction = "No";
        }
        else {
            $isFiction = "Unknown";
        }
        return $isFiction;

    }

    function displayFiction($temp) {
        if ($temp == 1) {
            $isFiction = "Fiction";
        }
        else if ($temp == 0){
            $isFiction = "Non-Fiction";
        }
        else {
            $isFiction = "Unknown";
        }
        return $isFiction;

    }
    
    function emptyInputSignup($UnivID, $Pass, $First, $Last, $Stat, $Email, $DOB, $Tele, $Addr) {
        $result;
        if(empty($UnivID) || empty($Pass) || empty($First) || empty($Last) || empty($Stat) || empty($Email)
        || empty($DOB) || empty($Tele)|| empty($Addr) || $Stat === 'N') {
            $result = true;
        }
        else {
            $result = false;
        }
        return $result;
    }

    function invalidUid($UnivID) {
        $result;
        if(!(preg_match("/^[0-9]*$/", $UnivID) || !(strlen($UnivID)==7))) {
            $result = true;
        }
        else {
            $result = false;
        }
        return $result;
    }

    function invalidEmail($Email) {
        $result;
        if(!filter_var($Email, FILTER_VALIDATE_EMAIL)) {
            $result = true;
        }
        else {
            $result = false;
        }
        return $result;
    }

    function uidExists($conn, $UnivID) {
        $sql = "SELECT * FROM USERS WHERE University_id = ?;";
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            header("location: ../signup.php?error=stmtfailed");
            exit();
        }
        mysqli_stmt_bind_param($stmt, "s", $UnivID);
        mysqli_stmt_execute($stmt);
        
        $resultData = mysqli_stmt_get_result($stmt);

        if($row = mysqli_fetch_assoc($resultData)) {
            return $row;
        }
        else {
            $result = false;
            return $result;
        }
        mysqli_stmt_close($stmt);
    }

    function sidExists($conn, $StaffID) {
        $sql = "SELECT * FROM STAFF WHERE Staff_id = ?;";
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            header("location: ../login.php?error=stmtfailed");
            exit();
        }
        mysqli_stmt_bind_param($stmt, "s", $StaffID);
        mysqli_stmt_execute($stmt);
        
        $resultData = mysqli_stmt_get_result($stmt);

        if($row = mysqli_fetch_assoc($resultData)) {
            return $row;
        }
        else {
            $result = false;
            return $result;
        }
        mysqli_stmt_close($stmt);
    }

    function createUser($conn, $UnivID, $Pass, $First, $Mid, $Last, $Stat, $Email, $DOB, $Tele, $Addr) {
        $sql = "INSERT INTO USERS (University_id, Password, Fname, Minit, Lname, Status, Email, BDate, Phone_num, Address, Created_at, Last_updated, Fines, Num_of_books, Calculator_count, Laptop_count, Headphone_count) VALUES (?,?,?,?,?,?,?,?,?,?,now(),now(),0,0,0,0,0);";
        
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            header("location: ../signup.php?error=stmtfailed");
            exit();
        }
        $hashedPwd = password_hash($Pass, PASSWORD_DEFAULT);

        mysqli_stmt_bind_param($stmt, "ssssssssss", $UnivID, $hashedPwd, $First, $Mid, $Last, $Stat, $Email, $DOB, $Tele, $Addr);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        header("location: ../signup.php?error=none");
        exit();
    }

    function emptyInputLogin($UnivID, $Pass) {
        $result;
        if(empty($UnivID) || empty($Pass)) {
            $result = true;
        }
        else {
            $result = false;
        }
        return $result;
    }

    function emptyInputUpdateProfile($First, $Last, $Email, $Tele, $Addr) {
        $result;
        if(empty($First) || empty($Last) || empty($Email) 
            || empty($Tele)|| empty($Addr)) {
            $result = true;
        }
        else {
            $result = false;
        }
        return $result;
    }


    function loginPerson($conn, $ID, $Pass) {
        $sidExists = false;
        $uidExists = false;
        $role = "";
        $pwdHashed = "";
        $checkPwd = "";
        if (strlen($ID) == 7) {
            $uidExists =  uidExists($conn, $ID);
        }
        else if (strlen($ID) == 8){
            $sidExists = sidExists($conn, $ID);
        }
        if ($uidExists !=  false) { 
            $role = "user";
            $pwdHashed = $uidExists["Password"];
            $checkPwd = password_verify($Pass, $pwdHashed);
        }
        else if ($sidExists != false) {
            if($sidExists['Status'] == "0") {
                $role = "staff";
            }
            else if($sidExists['Status'] == "1")  {
                $role = "admin";
            }
            $pwdHashed = $sidExists["Password"];
            $checkPwd = password_verify($Pass, $pwdHashed);
        }
        else {
            header("location: ../login.php?error=wronglogin");
            exit();
        }

        if($checkPwd === false) {
            header("location: ../login.php?error=wronglogin");
            exit();
        }
        else if ($checkPwd === true && $role === "user"){
            session_start();
            $_SESSION["University_id"] = $uidExists["University_id"];
            header("location: ../index.php");
            exit();
        }
        else if ($checkPwd === true && $role === "staff"){
            session_start();
            $_SESSION["Staff_id"] = $sidExists["Staff_id"];
            header("location: ../index.php");
            exit();
        }
        else if ($checkPwd === true && $role === "admin"){
            session_start();
            $_SESSION["Admin_id"] = $sidExists["Staff_id"];
            header("location: ../index.php");
            exit();
        }
    }

    function updateUser($conn, $UnivID, $First, $Mid, $Last, $Email, $Tele, $Addr) {
        $sql = "UPDATE `users` SET `Fname`='$First',`Minit`='$Mid',`Lname`='$Last',`Email`='$Email',`Phone_num`='$Tele',`Address`='$Addr', `Last_updated` = now() WHERE `University_id`= $UnivID;";
        if (mysqli_query($conn, $sql)) {
            header("location: ../editprofile.php?error=none");
            exit();
        }
        else {
            header("location: ../editprofile.php?error=sql");
            exit();
        }
    }


    function updateStaff($conn, $StaffID, $First, $Mid, $Last, $Email, $Tele, $Addr) {
        $sql = "UPDATE `staff` SET `Fname`='$First',`Minit`='$Mid',`Lname`='$Last',`Email`='$Email',`Phone_num`='$Tele',`Address`='$Addr', `Last_updated` = now() WHERE `Staff_id`= $StaffID;";
        if (mysqli_query($conn, $sql)) {
            header("location: ../editprofile.php?error=none");
            exit();
        }
        else {
            header("location: ../editprofile.php?error=sql");
            exit();
        }
    }

    function createBookTable($conn, $UnivID){
        $sql = "SELECT * FROM CHECK_OUT_BOOK AS COB, BOOK AS B, STAFF AS S
            WHERE COB.University_id = $UnivID
                AND COB.Book_id = B.Book_id AND COB.Staff_id = S.Staff_id;";
        $result = $conn->query($sql);
        if($result->num_rows > 0) {
        ?>
            <div class="COtable">
                <table border="1px" style="width:1000px; line-height:30px;">
                    <tr>
                        <th colspan="8"><h2>Books</h2></th>
                    </tr>
                    <t>
                    <th>Book ID </th>
                    <th>Title </th>
                    <th>Author </th>
                    <th>Genre </th>
                    <th>Age Group</th>
                    <th>Fiction?</th>
                    <th>Condition</th>
                    <th>Checked out</th>
                </t>
            <?php
            while($row = $result->fetch_assoc()) {
            ?> 
                <tr>
                    <td><?php echo $row['Book_id']; ?></td>
                    <td><?php echo $row['Title']; ?></td>
                    <td><?php echo $row['Author']; ?></td>
                    <td><?php echo $row['Genre']; ?></td>
                    <?php
                    $ageGroup = checkAgeGroup($row['Age_group']);
                    ?>
                    <td><?php echo $ageGroup; ?></td>
                    <?php
                    $isFiction = checkFiction($row['Fiction']);
                    ?>
                    <td><?php echo $isFiction; ?></td>
                    <?php
                    $cond = checkCondition($row['Condition']);
                    ?>
                    <td><?php echo $cond; ?></td>
                    <td><?php echo $row['Checked_out_date']; ?></td>
                </tr>
        <?php
            }
        }
        else {
        ?>
            <div class="noCO">
                <p>You have not checked out any books!</p>
            </div>
        <?php
        }
        ?>
                </table>
            </div>
    <?php
    }

    function createItemTable($conn, $UnivID){
        $sql = "SELECT *
                FROM CHECK_OUT_ITEM AS COI, ITEM AS I
                WHERE COI.University_id = $UnivID
                    AND COI.Item_id = I.Item_id;";
        $result = $conn->query($sql);
        if($result->num_rows > 0) {
        ?>
            <div class="COtable">
                <table border="1px" style="width:1000px; line-height:30px;">
                    <tr>
                        <th colspan="4"><h2>Items</h2></th>
                    </tr>
                    <t>
                    <th>Item ID</th>
                    <th>Item Type</th>
                    <th>Condition</th>
                    <th>Checked out</th>
                </t>
            <?php
            while($row = $result->fetch_assoc()) {
            ?> 
                <tr>
                    <td><?php echo $row['Item_id']; ?></td>
                    <?php
                    $itemType = itemType($row['Item_type']);
                    ?>
                    <td><?php echo $itemType; ?></td>
                    <?php
                    $cond = checkCondition($row['Condition']);
                    ?>
                    <td><?php echo $cond; ?></td>
                    <td><?php echo $row['Checked_out_date']; ?></td>
                </tr>
        <?php
            }
        }
        else {
        ?>
            <div class="noCO">
                <p>You have not checked out any items!</p>
            </div>
        <?php
        }
        ?>
                </table>
            </div>
    <?php
    }


    function createFineTable($conn, $UnivID){
        $sql = "SELECT *
                FROM USERS AS U
                WHERE U.University_id = $UnivID;";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();
        if($row['Fines'] > 0) {
        ?>
            <div class="COtable">
                <table border="1px">
                    <tr>
                        <th colspan="1"><h2>Fines</h2></th>
                    </tr>
                    <t>
                    <!--<th>Fines</th>-->
                </t>
            
                <tr>
                    <td><?php echo '$'.$row['Fines']; ?></td>
                </tr>
        <?php
        }
        else {
        ?>
            <div class="noCO">
                <p>You have no fines!</p>
            </div>
        <?php
        }
        ?>
                </table>
            </div>
    <?php
    }

    function createBookReqTable($conn, $UnivID){
        $sql = "SELECT *
                FROM REQUEST_BOOK AS RB, BOOK AS B
                WHERE RB.University_id = $UnivID
                    AND RB.Book_id = B.Book_id;";
        $result = $conn->query($sql);
        if($result->num_rows > 0) {
        ?>
            <div class="COtable">
                <table border="1px">
                    <tr>
                        <th colspan="8"><h2>Requested Books</h2></th>
                    </tr>
                    <t>
                    <th>Book ID </th>
                    <th>Title </th>
                    <th>Author </th>
                    <th>Genre </th>
                    <th>Age Group</th>
                    <th>Fiction?</th>
                    <th>Condition</th>
                    <th>Request Date</th>
                </t>
            <?php
            while($row = $result->fetch_assoc()) {
            ?> 
                <tr>
                    <td><?php echo $row['Book_id']; ?></td>
                    <td><?php echo $row['Title']; ?></td>
                    <td><?php echo $row['Author']; ?></td>
                    <td><?php echo $row['Genre']; ?></td>
                    <?php
                    $ageGroup = checkAgeGroup($row['Age_group']);
                    ?>
                    <td><?php echo $ageGroup; ?></td>
                    <?php
                    $isFiction = checkFiction($row['Fiction']);
                    ?>
                    <td><?php echo $isFiction; ?></td>
                    <?php
                    $cond = checkCondition($row['Condition']);
                    ?>
                    <td><?php echo $cond; ?></td>
                    <td><?php echo $row['Request_date']; ?></td>
                </tr>
        <?php
            }
        }
        else {
        ?>
            <div class="noCO">
                <p>You have not requested any books!</p>
            </div>
        <?php
        }
        ?>
                </table>
            </div>
    <?php
    }

    function createItemReqTable($conn, $UnivID){
        $sql = "SELECT *
                FROM REQUEST_ITEM AS RI, ITEM AS I
                WHERE RI.University_id = $UnivID
                    AND RI.Item_id = I.Item_id;";
        $result = $conn->query($sql);
        if($result->num_rows > 0) {
        ?>
            <div class="COtable">
                <table border="1px">
                    <tr>
                        <th colspan="4"><h2>Requested Items</h2></th>
                    </tr>
                    <t>
                    <th>Item ID</th>
                    <th>Item Type</th>
                    <th>Condition</th>
                    <th>Request Date</th>
                </t>
            <?php
            while($row = $result->fetch_assoc()) {
            ?> 
                <tr>
                    <td><?php echo $row['Item_id']; ?></td>
                    <?php
                    $itemType = itemType($row['Item_type']);
                    ?>
                    <td><?php echo $itemType; ?></td>
                    <?php
                    $cond = checkCondition($row['Condition']);
                    ?>
                    <td><?php echo $cond; ?></td>
                    <td><?php echo $row['Request_date']; ?></td>
                </tr>
        <?php
            }
        }
        else {
        ?>
            <div class="noCO">
                <p>You have not requested any items!</p>
            </div>
        <?php
        }
        ?>
                </table>
            </div>
    <?php
    }
    function createUserBookTable($conn, $StaffID){
        $sql = "SELECT * FROM CHECK_OUT_BOOK AS COB, BOOK AS B, USERS as U
            WHERE COB.Staff_id = $StaffID
                AND COB.Book_id = B.Book_id AND COB.University_id = U.University_id;";
        $result = $conn->query($sql);
        if($result->num_rows > 0) {
        ?>
            <div class="COtable">
                <table border="1px">
                    <tr>
                        <th colspan="9"><h2>Users Books Checked Out</h2></th>
                    </tr>
                    <t>
                        <th>Univeristy ID </th>
                        <th>Status </th>
                        <th>First Name </th>
                        <th>Last name </th>
                        <th>Book ID</th>
                        <th>Title</th>
                        <th>Author</th>
                        <th>Condition</th>
                        <th>Checked out</th>
                    </t>
            <?php
            while($row = $result->fetch_assoc()) {
            ?> 
                <tr>
                    <td><?php echo $row['University_id']; ?></td>
                    <td><?php echo $row['Status']; ?></td>
                    <td><?php echo $row['Fname']; ?></td>
                    <td><?php echo $row['Lname']; ?></td>
                    <td><?php echo $row['Book_id']; ?></td>
                    <td><?php echo $row['Title']; ?></td>
                    <td><?php echo $row['Author']; ?></td>
                    <?php
                    $cond = checkCondition($row['Condition']);
                    ?>
                    <td><?php echo $cond; ?></td>
                    <td><?php echo $row['Checked_out_date']; ?></td>
                </tr>
        <?php
            }
        }
        else {
        ?>
            <div class="noCO">
                <p>You have not checked out any books for users!</p>
            </div>
        <?php
        }
        ?>
                </table>
            </div>
    <?php
    }

    function createUserItemTable($conn, $StaffID){
        $sql = "SELECT * FROM CHECK_OUT_ITEM AS COI, ITEM AS I, USERS as U
            WHERE COI.Staff_id = $StaffID
                AND COI.Item_id = I.Item_id AND COI.University_id = U.University_id;";
        $result = $conn->query($sql);
        if($result->num_rows > 0) {
        ?>
            <div class="COtable">
                <table border="1px">
                    <tr>
                        <th colspan="8"><h2>Users Items Checked Out</h2></th>
                    </tr>
                    <t>
                        <th>Univeristy ID </th>
                        <th>Status </th>
                        <th>First Name </th>
                        <th>Last name </th>
                        <th>Item ID</th>
                        <th>Item Type</th>
                        <th>Condition</th>
                        <th>Checked out</th>
                    </t>
            <?php
            while($row = $result->fetch_assoc()) {
            ?> 
                <tr>
                    <td><?php echo $row['University_id']; ?></td>
                    <td><?php echo $row['Status']; ?></td>
                    <td><?php echo $row['Fname']; ?></td>
                    <td><?php echo $row['Lname']; ?></td>
                    <td><?php echo $row['Item_id']; ?></td>
                    <?php
                    $itemType = itemType($row['Item_type']);
                    ?>
                    <td><?php echo $itemType; ?></td>
                    <?php
                    $cond = checkCondition($row['Condition']);
                    ?>
                    <td><?php echo $cond; ?></td>
                    <td><?php echo $row['Checked_out_date']; ?></td>
                </tr>
        <?php
            }
        }
        else {
        ?>
            <div class="noCO">
                <p>You have not checked out any items for users!</p>
            </div>
        <?php
        }
        ?>
                </table>
            </div>
    <?php
    }
    function createUserBookReqTable($conn, $StaffID){
        $sql = "SELECT *
                FROM REQUEST_BOOK AS RB, BOOK AS B, USERS AS U
                WHERE RB.Staff_id = $StaffID AND RB.Book_id = B.Book_id
                    AND RB.University_id = U.University_id;";
        $result = $conn->query($sql);
        if($result->num_rows > 0) {
            ?>
                <div class="COtable">
                    <table border="1px">
                        <tr>
                            <th colspan="9"><h2>Users Requested Books</h2></th>
                        </tr>
                        <t>
                            <th>Univeristy ID </th>
                            <th>Status </th>
                            <th>First Name </th>
                            <th>Last name </th>
                            <th>Book ID</th>
                            <th>Title</th>
                            <th>Author</th>
                            <th>Condition</th>
                            <th>Request Date</th>
                        </t>
                <?php
                while($row = $result->fetch_assoc()) {
                ?> 
                    <tr>
                        <td><?php echo $row['University_id']; ?></td>
                        <td><?php echo $row['Status']; ?></td>
                        <td><?php echo $row['Fname']; ?></td>
                        <td><?php echo $row['Lname']; ?></td>
                        <td><?php echo $row['Book_id']; ?></td>
                        <td><?php echo $row['Title']; ?></td>
                        <td><?php echo $row['Author']; ?></td>
                        <?php
                        $cond = checkCondition($row['Condition']);
                        ?>
                        <td><?php echo $cond; ?></td>
                        <td><?php echo $row['Request_date']; ?></td>
                    </tr>
            <?php
                }
            }
            else {
            ?>
                <div class="noCO">
                    <p>You have not requested any books for users!</p>
                </div>
            <?php
            }
            ?>
                    </table>
                </div>
        <?php
    }
    function createUserItemReqTable($conn, $StaffID){
        $sql = "SELECT *
        FROM REQUEST_ITEM AS RI, ITEM AS I, USERS AS U
        WHERE RI.Staff_id = $StaffID AND RI.Item_id = I.Item_id
            AND RI.University_id = U.University_id;";
        $result = $conn->query($sql);
        if($result->num_rows > 0) {
        ?>
            <div class="COtable">
                <table border="1px">
                    <tr>
                        <th colspan="9"><h2>Users Requested Items</h2></th>
                    </tr>
                    <t>
                        <th>Univeristy ID </th>
                        <th>Status </th>
                        <th>First Name </th>
                        <th>Last name </th>
                        <th>Item ID</th>
                        <th>Item Type</th>
                        <th>Condition</th>
                        <th>Request Date</th>
                    </t>
                <?php
            while($row = $result->fetch_assoc()) {
            ?> 
                <tr>
                    <td><?php echo $row['University_id']; ?></td>
                    <td><?php echo $row['Status']; ?></td>
                    <td><?php echo $row['Fname']; ?></td>
                    <td><?php echo $row['Lname']; ?></td>
                    <td><?php echo $row['Item_id']; ?></td>
                    <?php
                    $itemType = itemType($row['Item_type']);
                    ?>
                    <td><?php echo $itemType; ?></td>
                    <?php
                    $cond = checkCondition($row['Condition']);
                    ?>
                    <td><?php echo $cond; ?></td>
                    <td><?php echo $row['Request_date']; ?></td>
                </tr>
            <?php
            }
        }
        else {
        ?>
            <div class="noCO">
                <p>You have not requested any books for users!</p>
            </div>
        <?php
        }
        ?>
                </table>
            </div>
    <?php
    }
    function createUsersFineTable($conn){
        $sql = "SELECT *
                FROM USERS AS U
                WHERE U.Fines > 0;";
        $result = $conn->query($sql);
        if($result->num_rows > 0) {
            ?>
                <div class="COtable">
                    <table border="1px">
                        <tr>
                            <th colspan="5"><h2>Users Fines</h2></th>
                        </tr>
                        <t>
                            <th>Univeristy ID</th>
                            <th>Status </th>
                            <th>First Name </th>
                            <th>Last name </th>
                            <th>Fines </th>
                        </t>
                <?php
                while($row = $result->fetch_assoc()) {
                ?> 
                    <tr>
                        <td><?php echo $row['University_id']; ?></td>
                        <td><?php echo $row['Status']; ?></td>
                        <td><?php echo $row['Fname']; ?></td>
                        <td><?php echo $row['Lname']; ?></td>
                        <td><?php echo $row['Fines']; ?></td>
                    </tr>
            <?php
                }
            }
            else {
            ?>
                <div class="noCO">
                    <p>No users have fines!</p>
                </div>
            <?php
            }
            ?>
                    </table>
                </div>
        <?php
    }

    function emptyInputAddbook($BookID, $Title, $Author, $Genre, $AgeGroup, $Fiction, $Condition, $CreatedBy, $LastUpdatedBy) {
        $result;
        if(empty($BookID) || empty($Title) || empty($Author) || empty($Genre) || empty($AgeGroup) || ($Fiction !== "0" && $Fiction !== "1")
        || empty($Condition) || empty($CreatedBy) || empty($LastUpdatedBy)) {
            $result = true;
        }
        else {
            $result = false;
        }
        return $result;
    }

    function invalidBookID($BookID) {
        $result;
        if(!(preg_match("/^[0-9]*$/", $BookID) || !(strlen($BookID) == 12))) {
            $result = true;
        }
        else {
            $result = false;
        }
        return $result;
    }

    function bookIDExists($conn, $BookID) {
        $sql = "SELECT * FROM BOOK WHERE Book_id = ?;";
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            header("location: ../addbook.php?error=stmtfailed");
            exit();
        }
        mysqli_stmt_bind_param($stmt, "s", $BookID);
        mysqli_stmt_execute($stmt);
        
        $resultData = mysqli_stmt_get_result($stmt);

        if($row = mysqli_fetch_assoc($resultData)) {
            return $row;
        }
        else {
            $result = false;
            return $result;
        }
        mysqli_stmt_close($stmt);
    }

    function addBook($conn, $BookID, $Title, $Author, $Cover, $Genre, $AgeGroup, $Fiction, $Condition, $CreatedBy, $LastUpdatedBy) {
        $sql = "INSERT INTO `book`(`Book_id`, `Title`, `Author`, `Cover`, `Genre`, `Age_group`, `Fiction`, `Condition`, `Created_at`, `Last_updated`, `Created_by`, `Last_updated_by`) VALUES ('$BookID','$Title','$Author','$Cover','$Genre','$AgeGroup', '$Fiction' ,'$Condition',now(),now(),'$CreatedBy','$LastUpdatedBy');";
        $conn->query($sql);
        header("location: ../addbook.php?error=none");
        exit();
    }

    function emptyInputAdditem($ItemID, $Type, $Condition, $CreatedBy, $LastUpdatedBy) {
        $result;
        if(empty($ItemID) || empty($Type) || empty($Condition) || empty($CreatedBy) || empty($LastUpdatedBy)) {
            $result = true;
        }
        else {
            $result = false;
        }
        return $result;
    }

    function invalidItemID($ItemID) {
        $result;
        if(!(preg_match("/^[0-9]*$/", $ItemID) || !(strlen($ItemID) == 12))) {
            $result = true;
        }
        else {
            $result = false;
        }
        return $result;
    }

    function itemIDExists($conn, $ItemID) {
        $sql = "SELECT * FROM ITEM WHERE Item_id = ?;";
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            header("location: ../additem.php?error=stmtfailed");
            exit();
        }
        mysqli_stmt_bind_param($stmt, "s", $ItemID);
        mysqli_stmt_execute($stmt);
        
        $resultData = mysqli_stmt_get_result($stmt);

        if($row = mysqli_fetch_assoc($resultData)) {
            return $row;
        }
        else {
            $result = false;
            return $result;
        }
        mysqli_stmt_close($stmt);
    }

    function addItem($conn, $ItemID, $Type, $Condition, $CreatedBy, $LastUpdatedBy) {
        $sql = "INSERT INTO `item`(`Item_id`, `Item_type`, `Condition`, `Created_at`, `Last_updated`, `Created_by`, `Last_updated_by`) VALUES ('$ItemID','$Type','$Condition',now(),now(),'$CreatedBy','$LastUpdatedBy');";
        $conn->query($sql);
        header("location: ../additem.php?error=none");
        exit();
    }

    function invalidSid($StaffID) {
        $result;
        if(!(preg_match("/^[0-9]*$/", $StaffID) || !(strlen($StaffID)==8))) {
            $result = true;
        }
        else {
            $result = false;
        }
        return $result;
    }

    function emptyInputAddStaff($StaffID, $Pass, $First, $Last, $DOB, $Salary, $Email, $Tele, $Addr, $Stat) {
        $result;
        if(empty($StaffID) || empty($Pass) || empty($First) || empty($Last) || empty($DOB) || ($Stat !== "0" && $Stat !== "1")
        || empty($Salary) || empty($Email) || empty($Tele) || empty($Addr)) {
            $result = true;
        }
        else {
            $result = false;
        }
        return $result;
    }

    function addStaff($conn, $StaffID, $Pass, $First, $Mid, $Last, $DOB, $Salary, $Email, $Tele, $Addr, $Stat) {
        $sql = "INSERT INTO STAFF (Staff_id, Password, Fname, Minit, Lname, BDate, Salary, Email, Phone_num, Address, Created_at, Last_updated, Status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, now(), now(), ?);";
        
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            header("location: ../addstaff.php?error=stmtfailed");
            exit();
        }
        $hashedPwd = password_hash($Pass, PASSWORD_DEFAULT);

        mysqli_stmt_bind_param($stmt, "sssssssssss", $StaffID, $hashedPwd, $First, $Mid, $Last, $DOB, $Salary, $Email, $Tele, $Addr, $Stat);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        header("location: ../addstaff.php?error=none");
        exit();
    }

    function emptyInputUpdateBook($Title, $Author, $Genre, $AgeGroup, $Fiction, $Condition, $LastUpdatedBy) {
        $result;
        if(empty($Title) || empty($Author) || empty($Genre) || empty($AgeGroup) || ($Fiction !== "0" && $Fiction !== "1") || empty($Condition) || empty($LastUpdatedBy)) {
            $result = true;
        }
        else {
            $result = false;
        }
        return $result;
    }

    function updateBook($conn, $BookID, $Title, $Author, $Cover, $Genre, $AgeGroup, $Fiction, $Condition, $LastUpdatedBy) {
        $sql = "UPDATE `book` SET `Title`='$Title', `Author`='$Author', `Cover`='$Cover', `Genre`='$Genre', `Age_group`='$AgeGroup', `Fiction`='$Fiction', `Condition`='$Condition', `Last_updated`=now(), `Last_updated_by`='$LastUpdatedBy' WHERE `Book_id`='$BookID';";
        $conn->query($sql);
        header("location: ../editbook.php?error=none");
        exit();
    }

    function deleteBook($conn, $BookID) {
        $sql = "DELETE FROM `book` WHERE `Book_id`='$BookID';";
        $conn->query($sql);
        header("location: ../editbook.php?error=noneDeleted");
        exit();
    }

    function deleteStaff($conn, $StaffID) {
        $sql = "DELETE FROM `staff` WHERE `Staff_id`='$StaffID';";
        $conn->query($sql);
        header("location: ../deletestaff.php?error=none");
        exit();
    }

    function noStaff($conn, $StaffID) {
        $sql = "SELECT * FROM STAFF WHERE Staff_id = ?;";
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            header("location: ../login.php?error=stmtfailed");
            exit();
        }
        mysqli_stmt_bind_param($stmt, "s", $StaffID);
        mysqli_stmt_execute($stmt);
        
        $resultData = mysqli_stmt_get_result($stmt);

        if($row = mysqli_fetch_assoc($resultData)) {
            return $row;
        }
        else {
            $result = false;
            return $result;
        }
        mysqli_stmt_close($stmt);
    }
?>