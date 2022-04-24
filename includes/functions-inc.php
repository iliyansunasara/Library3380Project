<?php
    function pre_r($array) {
        echo '<pre>';
        print_r($array);
        echo '</pre>';
    }
    function checkDatesGood($date1, $date2) {
        if ($date1 > $date2) {
            return false;
        }
        else {
            return true;
        }
    }
    function emptyInputUpdatePass($Old, $New, $Confirm) {
        $result= "";
        if(empty($Old) || empty($New) || empty($Confirm)) {
            $result = true;
        }
        else {
            $result = false;
        }
        return $result;
    }
    function updatePass($conn, $table, $ID, $Old, $New) {
        if ($table == "USERS") {
            $uidExists = uidExists($conn, $ID);
            $pwdHashed = $uidExists["Password"];
            $checkPwd = password_verify($Old, $pwdHashed);
            if($checkPwd === false) {
                header("location: ../edit-password.php?error=oldbad");
                exit(); 
            }
            else if ($checkPwd === true){
                $hashedPwd = password_hash($New, PASSWORD_DEFAULT);
                $sql = "UPDATE `users` SET `Password`='$hashedPwd' WHERE `University_id`= '$ID';";
                if (mysqli_query($conn, $sql)) {
                    header("location: ../edit-password.php?error=none");
                    exit();
                }  
                else {
                    header("location: ../edit-password.php?error=sql");
                    exit();
                }
            }
        }
        else if ($table == "STAFF"){
            $sidExists = sidExists($conn, $ID);
            $pwdHashed = $sidExists["Password"];
            $checkPwd = password_verify($Old, $pwdHashed);
            if($checkPwd === false) {
                header("location: ../edit-password.php?error=oldbad");
                exit(); 
            }
            else if ($checkPwd === true){
                $hashedPwd = password_hash($New, PASSWORD_DEFAULT);
                $sql = "UPDATE `staff` SET `Password`='$hashedPwd' WHERE `Staff_id`= '$ID';";
                if (mysqli_query($conn, $sql)) {
                    header("location: ../edit-password.php?error=none");
                    exit();
                }  
                else {
                    header("location: ../edit-password.php?error=sql");
                    exit();
                }
            }
        }
    }
    function emptyInputStaffUpdate($StaffID, $First, $Last, $Email, $DOB, $Tele, $Addr, $Salary) {
        $result= "";
        if(empty($StaffID) || empty($First) || empty($Last) || empty($Email) || empty($DOB)
        || empty($Tele)|| empty($Addr) || empty($Salary)) {
            $result = true;
        }
        else {
            $result = false;
        }
        return $result;
    }
    function updateStaffAdmin($conn, $StaffID, $First, $Mid, $Last, $Email, $DOB, $Tele, $Addr, $Salary) {
        $sql = "UPDATE `staff` SET `Fname`='$First',`Minit`='$Mid',`Lname`='$Last',`Email`='$Email', `BDate`='$DOB', `Phone_num`='$Tele',`Address`='$Addr',`Salary`='$Salary', `Last_updated` = now() WHERE `Staff_id`= $StaffID;";
        if (mysqli_query($conn, $sql)) {
            header("location: ../staff.php?error=none");
            exit();
        }
        else {
            header("location: ../staff.php?error=sql");
            exit();
        }
    }
    function createReportItemTable($conn, $BookID, $ItemType, $Condition, $Creator, $Updator, $startAdd, $endAdd, $startUp, $endUp) {
        if (empty($startAdd)) {
            $startAdd = "19000101";
        }
        if (empty($endAdd)) {
            $endAdd = "99991231";
        }
        if (empty($startUp)) {
            $startUp = "19000101";
        }
        if (empty($endUp)) {
            $endUp = "99991231";
        }
        $sql = "SELECT * 
                FROM ITEM AS I
                WHERE I.Item_id LIKE '%$BookID%'
                    AND I.Item_type LIKE '%$ItemType%'
                    AND I.Condition LIKE '%$Condition%'
                    AND I.Created_by LIKE '%$Creator%'
                    AND I.Last_updated_by LIKE '%$Updator%'
                    AND I.Created_at >= '$startAdd'
                    AND I.Created_at <= '$endAdd'
                    AND I.Last_updated >= '$startUp'
                    AND I.Last_updated <= '$endUp';";
        $result = $conn->query($sql);
        if($result->num_rows > 0) {
        ?>
            <div class="COtable">
                <table border="1px" style="width:100%; line-height:25px;">
                    <tr>
                        <th colspan="11"><h2>Item Report</h2></th>
                    </tr>
                <t>
                    <th>Item ID</th>
                    <th>Item Type</th>
                    <th>Condition</th>
                    <th>Added by</th>
                    <th>Last Update by</th>
                    <th>Added</th>
                    <th>Last Update</th>
                </t>
            <?php
            while($row = $result->fetch_assoc()) {
            ?> 
                <tr>
                    <td><?php echo $row['Item_id']; ?></td>
                    <?php
                        $type = itemType($row['Item_type']);
                    ?>
                    <td><?php echo $type; ?></td>
                    <?php
                        $cond = checkCondition($row['Condition']);
                    ?>
                    <td><?php echo $cond; ?></td>
                    <td><?php echo $row['Created_by']; ?></td>
                    <td><?php echo $row['Last_updated_by']; ?></td>
                    <td><?php echo $row['Created_at']; ?></td>
                    <td><?php echo $row['Last_updated']; ?></td>
                </tr>
        <?php
            }
        }
        else {
        ?>
            <div class="noCO">
                <p>No item meets the criteria!</p>
            </div>
        <?php
        }
        ?>
                </table>
            </div>
    <?php
    }
    function createReportBookTable($conn, $BookID, $Title, $Author, $Genre, $AgeGroup, $Fiction, $Condition, $Creator,
    $Updator, $startAdd, $endAdd, $startUp, $endUp) {
        if (empty($startAdd)) {
            $startAdd = "19000101";
        }
        if (empty($endAdd)) {
            $endAdd = "99991231";
        }
        if (empty($startUp)) {
            $startUp = "19000101";
        }
        if (empty($endUp)) {
            $endUp = "99991231";
        }
        $sql = "SELECT * 
                FROM BOOK AS B
                WHERE B.Book_id LIKE '%$BookID%'
                    AND B.Title LIKE '%$Title%'
                    AND B.Author LIKE '%$Author%'
                    AND B.Genre LIKE '%$Genre%'
                    AND B.Fiction LIKE '%$Fiction%'
                    AND B.Age_group LIKE '%$AgeGroup%'
                    AND B.Condition LIKE '%$Condition%'
                    AND B.Created_by LIKE '%$Creator%'
                    AND B.Last_updated_by LIKE '%$Updator%'
                    AND B.Created_at >= '$startAdd'
                    AND B.Created_at <= '$endAdd'
                    AND B.Last_updated >= '$startUp'
                    AND B.Last_updated <= '$endUp';";
        $result = $conn->query($sql);
        if($result->num_rows > 0) {
        ?>
            <div class="COtable">
                <table border="1px" style="width:100%; line-height:25px;">
                    <tr>
                        <th colspan="11"><h2>Book Report</h2></th>
                    </tr>
                <t>
                    <th>Book ID</th>
                    <th>Title</th>
                    <th>Author</th>
                    <th>Genre</th>
                    <th>Age Group</th>
                    <th>Fiction?</th>
                    <th>Condition</th>
                    <th>Added by</th>
                    <th>Last Update by</th>
                    <th>Added</th>
                    <th>Last Update</th>
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
                        $age = checkAgeGroup($row['Age_group']);
                    ?>
                    <td><?php echo $age; ?></td>
                    <?php
                        $fict = checkFiction($row['Fiction']);
                    ?>
                    <td><?php echo $fict; ?></td>
                    <?php
                        $cond = checkCondition($row['Condition']);
                    ?>
                    <td><?php echo $cond; ?></td>
                    <td><?php echo $row['Created_by']; ?></td>
                    <td><?php echo $row['Last_updated_by']; ?></td>
                    <td><?php echo $row['Created_at']; ?></td>
                    <td><?php echo $row['Last_updated']; ?></td>
                </tr>
        <?php
            }
        }
        else {
        ?>
            <div class="noCO">
                <p>No book meets the criteria!</p>
            </div>
        <?php
        }
        ?>
                </table>
            </div>
    <?php
    }
    function createNewStaffTable($conn, $startHire, $endHire, $StaffID, $Fname, $Mid, $Lname, $startDOB, $endDOB, $Email, $PhoneNum, $startSal, $endSal, $startEdit, $endEdit) {
        if (empty($startHire)) {
            $startHire = "19000101";
        }
        if (empty($endHire)) {
            $endHire = "99991231";
        }
        if (empty($startDOB)) {
            $startDOB = "19000101";
        }
        if (empty($endDOB)) {
            $endDOB = "99991231";
        }
        if (empty($startSal)) {
            $startSal = "-100000000";
        }
        if (empty($endSal)) {
            $endSal = "100000000";
        }
        if (empty($startEdit)) {
            $startEdit = "19000101";
        }
        if (empty($endEdit)) {
            $endEdit = "99991231";
        }
        $sql = "SELECT * 
                FROM STAFF
                WHERE Created_at >= '$startHire'
                    AND Created_at <= '$endHire'
                    AND Staff_id LIKE '%$StaffID%'
                    AND Fname LIKE '%$Fname%'
                    AND Minit LIKE '%$Mid%'
                    AND Lname LIKE '%$Lname%'
                    AND BDate >= '$startDOB'
                    AND BDate <=  '$endDOB'
                    AND Email LIKE '%$Email%'
                    AND Phone_num LIKE '%$PhoneNum%'
                    AND Salary >= '$startSal'
                    AND Salary <=  '$endSal'
                    AND Last_updated >= '$startEdit'
                    AND Last_updated <= '$endEdit';";
        $result = $conn->query($sql);
        if($result->num_rows > 0) {
        ?>
            <div class="COtable">
                <table border="1px" style="width:100%; line-height:25px;">
                    <tr>
                        <th colspan="11"><h2>Staff Report</h2></th>
                    </tr>
                    <t>
                    <th>Staff ID</th>
                    <th>First Name</th>
                    <th>Middle</th>
                    <th>Last Name</th>
                    <th>Birth Date</th>
                    <th>Email</th>
                    <th>Phone #</th>
                    <th>Address #</th>
                    <th>Salary</th>
                    <th>Profile Updated</th>
                    <th>Hired</th>
                </t>
            <?php
            while($row = $result->fetch_assoc()) {
            ?> 
                <tr>
                    <td><?php echo $row['Staff_id']; ?></td>
                    <td><?php echo $row['Fname']; ?></td>
                    <td><?php echo $row['Minit']; ?></td>
                    <td><?php echo $row['Lname']; ?></td>
                    <td><?php echo $row['BDate']; ?></td>
                    <td><?php echo $row['Email']; ?></td>
                    <td><?php echo $row['Phone_num']; ?></td>
                    <td><?php echo $row['Address']; ?></td>
                    <td><?php echo $row['Salary']; ?></td>
                    <td><?php echo $row['Last_updated']; ?></td>
                    <td><?php echo $row['Created_at']; ?></td>
                </tr>
        <?php
            }
        }
        else {
        ?>
            <div class="noCO">
                <p>No staff member meets the criteria!</p>
            </div>
        <?php
        }
        ?>
                </table>
            </div>
    <?php
    }
    function createReportUsersTable($conn, $UnivID, $Fname, $Mid, $Lname, $Stat, $Email, $PhoneNum, $Address, $startDOB, $endDOB,
    $startFines, $endFines, $startBooks, $endBooks, $startCalc, $endCalc, $startLap, $endLap, $startHead, $endHead, 
    $startEdit, $endEdit, $startJoin, $endJoin) {
        if (empty($startDOB)) {
            $startDOB = "19000101";
        }
        if (empty($endDOB)) {
            $endDOB = "99991231";
        }
        if (empty($startFines)) {
            $startFines = "-100000000";
        }
        if (empty($endFines)) {
            $endFines = "100000000";
        }
        if (empty($startBooks)) {
            $startBooks = "-100000000";
        }
        if (empty($endBooks)) {
            $endBooks = "100000000";
        }
        if (empty($startCalc)) {
            $startCalc = "-100000000";
        }
        if (empty($endCalc)) {
            $endCalc = "100000000";
        }
        if (empty($startLap)) {
            $startLap = "-100000000";
        }
        if (empty($endLap)) {
            $endLap = "100000000";
        }
        if (empty($startHead)) {
            $startHead = "-100000000";
        }
        if (empty($endHead)) {
            $endHead = "100000000";
        }
        if (empty($startEdit)) {
            $startEdit = "19000101";
        }
        if (empty($endEdit)) {
            $endEdit = "99991231";
        }
        if (empty($startJoin)) {
            $startJoin = "19000101";
        }
        if (empty($endJoin)) {
            $endJoin = "99991231";
        }
        $sql = "SELECT * 
                FROM USERS
                WHERE University_id LIKE '%$UnivID%'
                    AND Fname LIKE '%$Fname%'
                    AND Minit LIKE '%$Mid%'
                    AND Lname LIKE '%$Lname%'
                    AND Status LIKE '%$Stat%'
                    AND Email LIKE '%$Email%'
                    AND Phone_num LIKE '%$PhoneNum%'
                    AND Address LIKE '%$Address%'
                    AND BDate >= '$startDOB'
                    AND BDate <=  '$endDOB'
                    AND Fines >= '$startFines'
                    AND Fines <= '$endFines'
                    AND Num_of_books >= '$startBooks'
                    AND Num_of_books  <= '$endBooks'
                    AND Calculator_count >= '$startCalc'
                    AND Calculator_count <= '$endCalc'
                    AND Laptop_count >= '$startLap'
                    AND Laptop_count <= '$endLap'
                    AND Headphone_count >= '$startHead'
                    AND Headphone_count <= '$endHead'
                    AND Last_updated >= '$startEdit'
                    AND Last_updated <= '$endEdit'
                    AND Created_at >= '$startJoin'
                    AND Created_at <= '$endJoin';";
        $result = $conn->query($sql);
        if($result->num_rows > 0) {
        ?>
            <div class="COtable">
                <table border="1px" style="width:100%; line-height:30px;">
                    <tr>
                        <th colspan="16"><h2>USERS Report</h2></th>
                    </tr>
                    <t>
                    <th>Uni ID</th>
                    <th>Status</th>
                    <th>First</th>
                    <th>Mid</th>
                    <th>Last</th>
                    <th>Born</th>
                    <th>Email</th>
                    <th>Phone #</th>
                    <th>Address</th>
                    <th>Fines</th>
                    <th>Book</th>
                    <th>Calculator</th>
                    <th>Laptop</th>
                    <th>Headphone</th>
                    <th>Updated</th>
                    <th>Joined</th>
                </t>
            <?php
            while($row = $result->fetch_assoc()) {
            ?> 
                <tr>
                    <td><?php echo $row['University_id']; ?></td>
                    <?php
                    $newStat = checkStatus($row['Status']);
                    ?>
                    <td><?php echo $newStat; ?></td>
                    <td><?php echo $row['Fname']; ?></td>
                    <td><?php echo $row['Minit']; ?></td>
                    <td><?php echo $row['Lname']; ?></td>
                    <td><?php echo $row['BDate']; ?></td>
                    <td><?php echo $row['Email']; ?></td>
                    <td><?php echo $row['Phone_num']; ?></td>
                    <td><?php echo $row['Address']; ?></td>
                    <td><?php echo $row['Fines']; ?></td>
                    <td><?php echo $row['Num_of_books']; ?></td>
                    <td><?php echo $row['Calculator_count']; ?></td>
                    <td><?php echo $row['Laptop_count']; ?></td>
                    <td><?php echo $row['Headphone_count']; ?></td>
                    <td><?php echo $row['Last_updated']; ?></td>
                    <td><?php echo $row['Created_at']; ?></td>
                </tr>
        <?php
            }
        }
        else {
        ?>
            <div class="noCO">
                <p>No user meets the criteria!</p>
            </div>
        <?php
        }
        ?>
                </table>
            </div>
    <?php
    }
    function createReportCOBTable($conn, $StaffID, $UnivID, $BookID, $Title, $Author, $Genre, $AgeGroup, $Fiction, $Condition, $startCOB, $endCOB) {
        if (empty($startCOB)) {
            $startCOB = "19000101";
        }
        if (empty($endCOB)) {
            $endCOB = "99991231";
        }
        $sql = "SELECT * 
                FROM CHECK_OUT_BOOK AS COB JOIN BOOK AS B ON COB.Book_id = B.Book_id
                WHERE COB.Staff_id LIKE '%$StaffID%'
                    AND COB.University_id LIKE '%$UnivID%'
                    AND COB.Book_id LIKE '%$BookID%'
                    AND B.Title LIKE '%$Title%'
                    AND B.Author LIKE '%$Author%'
                    AND B.Genre LIKE '%$Genre%'
                    AND B.Fiction LIKE '%$Fiction%'
                    AND B.Age_group LIKE '%$AgeGroup%'
                    AND B.Condition LIKE '%$Condition%'
                    AND COB.Checked_out_date >= '$startCOB'
                    AND COB.Checked_out_date <= '$endCOB';";
        $result = $conn->query($sql);
        if($result->num_rows > 0) {
        ?>
            <div class="COtable">
                <table border="1px" style="width:100%; line-height:25px;">
                    <tr>
                        <th colspan="10"><h2>Checked Out Book Report</h2></th>
                    </tr>
                    <t>
                    <th>Staff ID</th>
                    <th>University ID</th>
                    <th>Book ID</th>
                    <th>Title</th>
                    <th>Author</th>
                    <th>Genre</th>
                    <th>Age Group</th>
                    <th>Fiction?</th>
                    <th>Condition</th>
                    <th>Checked Out</th>
                </t>
            <?php
            while($row = $result->fetch_assoc()) {
            ?> 
                <tr>
                    <td><?php echo $row['Staff_id']; ?></td>
                    <td><?php echo $row['University_id']; ?></td>
                    <td><?php echo $row['Book_id']; ?></td>
                    <td><?php echo $row['Title']; ?></td>
                    <td><?php echo $row['Author']; ?></td>
                    <td><?php echo $row['Genre']; ?></td>
                    <?php
                        $age = checkAgeGroup($row['Age_group']);
                    ?>
                    <td><?php echo $age; ?></td>
                    <?php
                        $fict = checkFiction($row['Fiction']);
                    ?>
                    <td><?php echo $fict; ?></td>
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
                <p>No checkout meets the criteria!</p>
            </div>
        <?php
        }
        ?>
                </table>
            </div>
    <?php
    }
    function dateDiffInDays($date1, $date2) {
        $diff = $date2 - strtotime($date1);
        return abs(round($diff / 86400));
    }
    function checkStatus($temp) {
        if ($temp == "S") {
            $stat = "Student";
        }
        else if ($temp == "F") {
            $stat = "Faculty";
        }
        else if ($temp == "") {
            $stat = "None";
        }
        else {
            $stat = "Unknown";
        }
        return $stat;
    }
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
        $result= "";
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
        $result= "";
        if(!(preg_match("/^[0-9]*$/", $UnivID)) || !(strlen($UnivID)==7)) {
            $result = true;
        }
        else {
            $result = false;
        }
        return $result;
    }

    function invalidEmail($Email) {
        $result= "";
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

    function iidCO($conn, $ItemID) {
        $sql = "SELECT * FROM CHECK_OUT_ITEM WHERE Item_id = ?;";
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            header("location: ../edititem.php?error=stmtfailed");
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
    function bidCO($conn, $BookID) {
        $sql = "SELECT * FROM CHECK_OUT_BOOK WHERE Book_id = ?;";
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            header("location: ../edititem.php?error=stmtfailed");
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


    function createUserAdmin($conn, $UnivID, $Pass, $First, $Mid, $Last, $Stat, $Email, $DOB, $Tele, $Addr) {
        $sql = "INSERT INTO USERS (University_id, Password, Fname, Minit, Lname, Status, Email, BDate, Phone_num, Address, Created_at, Last_updated, Fines, Num_of_books, Calculator_count, Laptop_count, Headphone_count) VALUES (?,?,?,?,?,?,?,?,?,?,now(),now(),0,0,0,0,0);";
        
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            header("location: ../users.php?error=stmtfailed");
            exit();
        }
        $hashedPwd = password_hash($Pass, PASSWORD_DEFAULT);

        mysqli_stmt_bind_param($stmt, "ssssssssss", $UnivID, $hashedPwd, $First, $Mid, $Last, $Stat, $Email, $DOB, $Tele, $Addr);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        header("location: ../users.php?error=noneAdd");
        exit();
    }

    function emptyInputLogin($UnivID, $Pass) {
        $result= "";
        if(empty($UnivID) || empty($Pass)) {
            $result = true;
        }
        else {
            $result = false;
        }
        return $result;
    }

    function emptyInputUpdateProfile($First, $Last, $Email, $Tele, $Addr) {
        $result= "";
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
            $_SESSION['logged'] = 0;
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
    function uidCOI($conn, $UnivID) {
        $sql = "SELECT * FROM CHECK_OUT_BOOK WHERE University_id = ?;";
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            header("location: ../edititem.php?error=stmtfailed");
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
    function uidCOB($conn, $UnivID) {
        $sql = "SELECT * FROM CHECK_OUT_ITEM WHERE University_id = ?;";
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            header("location: ../edititem.php?error=stmtfailed");
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
    function deleteUser($conn, $UnivID) {
        $sql = "DELETE FROM `USERS` WHERE `University_id`='$UnivID';";
        $conn->query($sql);
    }
    function emptyInputUserUpdate($UnivID, $First, $Last, $Stat, $Email, $DOB, $Tele, $Addr, $Fine) {
        $result= "";
        if(empty($UnivID) || empty($First) || empty($Last) || empty($Stat) || empty($Email)
        || empty($DOB) || empty($Tele)|| empty($Addr) || empty($Fine)) {
            $result = true;
        }
        else {
            $result = false;
        }
        return $result;
    }
    function updateUserAdmin($conn, $UnivID, $First, $Mid, $Last, $Stat, $Email, $DOB, $Tele, $Addr, $Fine) {
        $sql = "UPDATE `users` SET `Fname`='$First',`Minit`='$Mid',`Lname`='$Last',`Email`='$Email',`Phone_num`='$Tele',`Address`='$Addr',`Fines`='$Fine', `Last_updated` = now() WHERE `University_id`= $UnivID;";
        if (mysqli_query($conn, $sql)) {
            header("location: ../users.php?error=none");
            exit();
        }
        else {
            header("location: ../users.php?error=sql");
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

    function getQueuePos($conn, $bookID, $UnivID) {
        $sql = "SELECT *
        FROM request_book
        WHERE request_book.Book_id = '$bookID'
        ORDER BY Request_date ASC;";
        $result = $conn->query($sql);
        $tot_rows = $result->num_rows;
        $queue_num = 0;
        if($tot_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $queue_num +=1;
            }
        }
        else{
            return;
        }

        return $queue_num;
    }

    function createBookReqTable($conn, $UnivID){ 
        $books = array();
        $positions = array();
        $sql_b = "SELECT DISTINCT Book_id
                  FROM REQUEST_BOOK;";
        $result_b = $conn->query($sql_b);
        if($result_b->num_rows > 0) {
            while($row = $result_b->fetch_assoc()) {
                array_push($books, $row['Book_id']);
            }
            foreach($books as $bookID) {
                array_push($positions, getQueuePos($conn, $bookID, $UnivID));
            }
        }
        
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
                        <th colspan="9"><h2>Requested Books</h2></th>
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
                    <th>Waitlist</th>
                </t>
            <?php
            $i = 0;
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
                    <td><?php echo $positions[$i++]; ?></td>
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
                        <th>University ID </th>
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
                        <th>University ID </th>
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
                            <th>University ID </th>
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
                        <th>University ID </th>
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
                            <th colspan="7"><h2>Users Fines</h2></th>
                        </tr>
                        <t>
                            <th>University ID</th>
                            <th>Status </th>
                            <th>First Name </th>
                            <th>Last name </th>
                            <th>Fines </th>
                            <th>Action</th>
                        </t>
                    
                <?php
                while($row = $result->fetch_assoc()) {
                ?> 
                    <tr>
                        <td><?php echo $row['University_id']; ?></td>
                        <?php
                            $stat = checkStatus($row['Status']);
                        ?>
                        <td><?php echo $stat; ?></td>
                        <td><?php echo $row['Fname']; ?></td>
                        <td><?php echo $row['Lname']; ?></td>
                        <td><?php echo $row['Fines']; ?></td>
                        <td> <a href="fines.php?edit=<?php echo $row['University_id'] ;?>">
                            Edit
                         </a>
                        </td> 
                    </tr>
            <?php
                }
                ?>
                </table>
            </div>
            <?php
            }
            else {
            ?>
                <div class="noCO">
                    <p>No users have fines!</p>
                </div>
            <?php
            }
            ?>
                
        <?php
    }
    function updateUserFine($conn, $UnivID, $Fine) {
        $sql = "UPDATE `users` SET `Fines`='$Fine', `Last_updated` = now() WHERE `University_id`= $UnivID;";
        if (mysqli_query($conn, $sql)) {
            header("location: ../fines.php?error=updatedFines");
            exit();
        }
        else {
            header("location: ../fines.php?error=sql");
            exit();
        }
    }
    function emptyInputAddbook($BookID, $Title, $Author, $Genre, $AgeGroup, $Fiction, $Condition, $CreatedBy, $LastUpdatedBy) {
        $result= "";
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
        $result= "";
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
        $result= "";
        if(empty($ItemID) || empty($Type) || empty($Condition) || empty($CreatedBy) || empty($LastUpdatedBy)) {
            $result = true;
        }
        else {
            $result = false;
        }
        return $result;
    }

    function invalidItemID($ItemID) {
        $result= "";
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
        $result= "";
        if(!(preg_match("/^[0-9]*$/", $StaffID)) || !(strlen($StaffID)==8)) {
            $result = true;
        }
        else {
            $result = false;
        }
        return $result;
    }

    function emptyInputAddStaff($StaffID, $Pass, $Confirm, $First, $Last, $DOB, $Salary, $Email, $Tele, $Addr, $Stat) {
        $result= "";
        if(empty($StaffID) || empty($Pass) || empty($Confirm) || empty($First) || empty($Last) || empty($DOB) || ($Stat !== "0" && $Stat !== "1")
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
        header("location: ../staff.php?error=noneAdd");
        exit();
    }

    function emptyInputUpdateBook($Title, $Author, $Genre, $AgeGroup, $Fiction, $Condition, $LastUpdatedBy) {
        $result= "";
        if(empty($Title) || empty($Author) || empty($Genre) || empty($AgeGroup) || ($Fiction !== "0" && $Fiction !== "1") || empty($Condition) || empty($LastUpdatedBy)) {
            $result = true;
        }
        else {
            $result = false;
        }
        return $result;
    }

    function emptyInputUpdateItem($Type, $Condition, $LastUpdatedBy) {
        $result= "";
        if(empty($Type) || empty($Condition) || empty($LastUpdatedBy)) {
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

    function updateItem($conn, $ItemID, $Type, $Condition, $LastUpdatedBy) {
        $sql = "UPDATE `item` SET `Item_type`='$Type', `Condition`='$Condition', `Last_updated`=now(), `Last_updated_by`='$LastUpdatedBy' WHERE `Item_id`='$ItemID';";
        $conn->query($sql);
        header("location: ../edititem.php?error=none");
        exit();
    }

    function deleteBook($conn, $BookID) {
        $sql = "DELETE FROM `book` WHERE `Book_id`='$BookID';";
        $conn->query($sql);
        header("location: ../editbook.php?error=noneDeleted");
        exit();
    }

    function deleteItem($conn, $ItemID) {
        $sql = "DELETE FROM `item` WHERE `Item_id`='$ItemID';";
        $conn->query($sql);
        header("location: ../edititem.php?error=noneDeleted");
        exit();
    }

    function deleteStaff($conn, $StaffID) {
        $sql = "DELETE FROM `staff` WHERE `Staff_id`='$StaffID';";
        $conn->query($sql);
    }
    function sidCOB($conn, $StaffID) {
        $sql = "SELECT * FROM CHECK_OUT_BOOK WHERE Staff_id = ?;";
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            header("location: ../index.php?error=stmtfailed");
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

    function sidCOI($conn, $StaffID) {
        $sql = "SELECT * FROM CHECK_OUT_ITEM WHERE Staff_id = ?;";
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            header("location: ../index.php?error=stmtfailed");
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
    function createAllUserBookTable($conn) {
        if(isset($_GET['search-submit'])) {
            $search = mysqli_real_escape_string($conn, $_GET['search']);
            $sql1 = "SELECT * 
                    FROM check_out_book AS COB, users AS U, book AS B
                    WHERE (COB.University_id = U.University_id
                            AND COB.Book_id = B.Book_id)
                            AND
                            (U.University_id LIKE '%$search%'
                            OR COB.Staff_id LIKE '%$search%'
                            OR B.Book_id LIKE '%$search%'
                            OR U.Fname LIKE '%$search%'
                            OR U.Lname LIKE '%$search%'
                            OR B.Title LIKE '%$search%'
                            OR COB.Checked_out_date LIKE '%$search%');";
            $sql2 = "SELECT * 
                    FROM check_out_item AS COI, users AS U, item AS I
                    WHERE (COI.University_id = U.University_id
                            AND COI.Item_id = I.Item_id)
                            AND
                            (U.University_id LIKE '%$search%'
                            OR COI.Staff_id LIKE '%$search%'
                            OR I.Item_id LIKE '%$search%'
                            OR U.Fname LIKE '%$search%'
                            OR U.Lname LIKE '%$search%'
                            OR I.Item_type LIKE '%$search%'
                            OR COI.Checked_out_date LIKE '%$search%');";
            $result1 = mysqli_query($conn, $sql1);
            $qb_results = mysqli_num_rows($result1);
            $result2 = mysqli_query($conn, $sql2);
            $qi_results = mysqli_num_rows($result2);
            if($qb_results > 0) {
                ?>
                <div class="COtable">
                    <table>
                        <tr>
                            <th colspan="5"><h2>Books Checked Out</h2></th>
                        </tr>
                        <t>
                            <th>Staff ID</th>
                            <th>User</th>
                            <th>Title</th>
                            <th>Checked out</th>
                            <th>Due Date</th>
                        </t>
                <?php
                while($row = mysqli_fetch_assoc($result1)) {
                    ?> 
                    <tr>
                        <td><?php echo $row['Staff_id']; ?></td>
                        <td><?php echo $row['Fname'] ." ".$row['Lname']; ?></td>
                        <td><?php echo $row['Title']; ?></td>
                        <td><?php echo $row['Checked_out_date']; ?></td>
                        <?php
                        if($row['Status'] == 'F') {
                            $DD = date("Y-m-d",strtotime($row['Checked_out_date'].' + 14 days'));
                        }
                        else if ($row['Status'] == 'S') {
                            $DD = date("Y-m-d",strtotime($row['Checked_out_date'].' + 7 days'));
                        }
                        ?>
                        <td><?php echo $DD; ?></td>
                    </tr>
                <?php
                }
                ?>
                    </table>
                </div>
                <?php
            }
            if ($qi_results > 0) {
                ?>
                <div class="COtable">
                    <table>
                        <tr>
                            <th colspan="8"><h2>Items Checked Out</h2></th>
                        </tr>
                        <t>
                            <th>Staff ID </th>
                            <th>User </th>
                            <th>Item Type</th>
                            <th>Checked out</th>
                            <th>Due Date</th>
                        </t>
                <?php
                while($row = mysqli_fetch_assoc($result2)) {
                    ?> 
                    <tr>
                        <td><?php echo $row['Staff_id']; ?></td>
                        <td><?php echo $row['Fname'] ." ".$row['Lname']; ?></td>
                        <?php
                            $type = itemType($row['Item_type']);
                        ?>
                        <td><?php echo $type; ?></td>
                        <td><?php echo $row['Checked_out_date']; ?></td>
                        <?php
                        if($row['Status'] == 'F') {
                            $DD = date("Y-m-d",strtotime($row['Checked_out_date'].' + 14 days'));
                        }
                        else if ($row['Status'] == 'S') {
                            $DD = date("Y-m-d",strtotime($row['Checked_out_date'].' + 7 days'));
                        }
                        ?>
                        <td><?php echo $DD; ?></td>
                    </tr>
                <?php
                }
                ?>
                    </table>
                </div>
            <?php
            }
            else if ($qb_results === 0 && $qi_results === 0){
                echo "<p class='noresult'>No results matched your search!</p>";
            }
        }
        else {
            $sql1 = "SELECT *
                FROM check_out_book AS COB, users AS U, book AS B
                WHERE COB.University_id = U.University_id
                            AND COB.Book_id = B.Book_id";
            $result1 = mysqli_query($conn, $sql1);
            $qb_results = mysqli_num_rows($result1);
            if($qb_results > 0) {
            ?>
                <div class="COtable">
                    <table>
                        <tr>
                            <th colspan="5"><h2>Books Checked Out</h2></th>
                        </tr>
                        <t>
                            <th>Staff ID </th>
                            <th>User </th>
                            <th>Title</th>
                            <th>Checked out</th>
                            <th>Due Date</th>
                        </t>
                <?php
                while($row = $result1->fetch_assoc()) {
                ?> 
                    <tr>
                        <td><?php echo $row['Staff_id']; ?></td>
                            <td><?php echo $row['Fname'] ." ".$row['Lname']; ?></td>
                            <td><?php echo $row['Title']; ?></td>
                            <td><?php echo $row['Checked_out_date']; ?></td>
                            <?php
                            if($row['Status'] == 'F') {
                                $DD = date("Y-m-d",strtotime($row['Checked_out_date'].' + 14 days'));
                            }
                            else if ($row['Status'] == 'S') {
                                $DD = date("Y-m-d",strtotime($row['Checked_out_date'].' + 7 days'));
                            }
                            ?>
                        <td><?php echo $DD; ?></td>
                    </tr>
            <?php
                }
            ?>
                    </table>
                </div>
            <?php
            }
            else {
            ?>
                <div class="noCO">
                    <p>No one has checked out books!</p>
                </div>
            <?php
            }
            ?>
        <?php
            $sql2 = "SELECT *
                    FROM check_out_item AS COI, users AS U, item AS I
                    WHERE COI.University_id = U.University_id
                            AND COI.Item_id = I.Item_id;";
            $result2 = mysqli_query($conn, $sql2);
            $qi_results = mysqli_num_rows($result2);
            if($qi_results > 0) {
            ?>
            <div class="COtable">
                <table>
                    <tr>
                        <th colspan="5"><h2>Items Checked Out</h2></th>
                    </tr>
                        <t>
                            <th>Staff ID </th>
                            <th>User </th>
                            <th>Item Type</th>
                            <th>Checked out</th>
                            <th>Due Date</th>
                        </t>
            <?php
                while($row = $result2->fetch_assoc()) {
            ?> 
                <tr>
                    <td><?php echo $row['Staff_id']; ?></td>
                        <td><?php echo $row['Fname'] ." ".$row['Lname']; ?></td>
                        <?php
                            $type = itemType($row['Item_type']);
                        ?>
                        <td><?php echo $type; ?></td>
                        <td><?php echo $row['Checked_out_date']; ?></td>
                        <?php
                        if($row['Status'] == 'F') {
                            $DD = date("Y-m-d",strtotime($row['Checked_out_date'].' + 14 days'));
                        }
                        else if ($row['Status'] == 'S') {
                            $DD = date("Y-m-d",strtotime($row['Checked_out_date'].' + 7 days'));
                        }
                        ?>
                        <td><?php echo $DD; ?></td>
                </tr>
            <?php
                }

            }
        }
    }
    function createAllUserReqTable($conn) {
        if(isset($_GET['search-submit'])) {
            $search = mysqli_real_escape_string($conn, $_GET['search']);
            $sql1 = "SELECT * 
                    FROM request_book AS RB, users AS U, book AS B
                    WHERE (RB.University_id = U.University_id
                            AND RB.Book_id = B.Book_id)
                            AND
                            (U.University_id LIKE '%$search%'
                            OR RB.Staff_id LIKE '%$search%'
                            OR B.Book_id LIKE '%$search%'
                            OR U.Fname LIKE '%$search%'
                            OR U.Lname LIKE '%$search%'
                            OR B.Title LIKE '%$search%'
                            OR RB.Request_date LIKE '%$search%');";
            $sql2 = "SELECT * 
                    FROM request_item AS RI, users AS U, item AS I
                    WHERE (RI.University_id = U.University_id
                            AND RI.Item_id = I.Item_id)
                            AND
                            (U.University_id LIKE '%$search%'
                            OR RI.Staff_id LIKE '%$search%'
                            OR I.Item_id LIKE '%$search%'
                            OR U.Fname LIKE '%$search%'
                            OR U.Lname LIKE '%$search%'
                            OR I.Item_type LIKE '%$search%'
                            OR RI.Request_date LIKE '%$search%');";
            $result1 = mysqli_query($conn, $sql1);
            $qb_results = mysqli_num_rows($result1);
            $result2 = mysqli_query($conn, $sql2);
            $qi_results = mysqli_num_rows($result2);
            if($qb_results > 0) {
                ?>
                <div class="COtable">
                    <table>
                        <tr>
                            <th colspan="4"><h2>Books Requested</h2></th>
                        </tr>
                        <t>
                            <th>Staff ID</th>
                            <th>User</th>
                            <th>Title</th>
                            <th>Requested</th>
                        </t>
                <?php
                while($row = mysqli_fetch_assoc($result1)) {
                    ?> 
                    <tr>
                        <td><?php echo $row['Staff_id']; ?></td>
                        <td><?php echo $row['Fname'] ." ".$row['Lname']; ?></td>
                        <td><?php echo $row['Title']; ?></td>
                        <td><?php echo $row['Request_date']; ?></td>
                    </tr>
                <?php
                }
                ?>
                    </table>
                </div>
                <?php
            }
            if ($qi_results > 0) {
                ?>
                <div class="COtable">
                    <table>
                        <tr>
                            <th colspan="4"><h2>Items Requested</h2></th>
                        </tr>
                        <t>
                            <th>Staff ID </th>
                            <th>User </th>
                            <th>Item Type</th>
                            <th>Checked out</th>
                        </t>
                <?php
                while($row = mysqli_fetch_assoc($result2)) {
                    ?> 
                    <tr>
                        <td><?php echo $row['Staff_id']; ?></td>
                        <td><?php echo $row['Fname'] ." ".$row['Lname']; ?></td>
                        <?php
                            $type = itemType($row['Item_type']);
                        ?>
                        <td><?php echo $type; ?></td>
                        <td><?php echo $row['Request_date']; ?></td>
                    </tr>
                <?php
                }
                ?>
                    </table>
                </div>
            <?php
            }
            else if ($qb_results === 0 && $qi_results === 0){
                echo "<p class='noresult'>No results matched your search!</p>";
            }
        }
        else {
            $sql1 = "SELECT *
                FROM request_book AS RB, users AS U, book AS B
                WHERE RB.University_id = U.University_id
                            AND RB.Book_id = B.Book_id";
            $result1 = mysqli_query($conn, $sql1);
            $qb_results = mysqli_num_rows($result1);
            if($qb_results > 0) {
            ?>
                <div class="COtable">
                    <table>
                        <tr>
                            <th colspan="4"><h2>Books Requested</h2></th>
                        </tr>
                        <t>
                            <th>Staff ID </th>
                            <th>User </th>
                            <th>Title</th>
                            <th>Requested</th>
                        </t>
                <?php
                while($row = $result1->fetch_assoc()) {
                ?> 
                    <tr>
                        <td><?php echo $row['Staff_id']; ?></td>
                            <td><?php echo $row['Fname'] ." ".$row['Lname']; ?></td>
                            <td><?php echo $row['Title']; ?></td>
                            <td><?php echo $row['Request_date']; ?></td>
                    </tr>
            <?php
                }
            ?>
                    </table>
                </div>
            <?php
            }
            else {
            ?>
                <div class="noCO">
                    <p>No one has checked out books!</p>
                </div>
            <?php
            }
            ?>
        <?php
            $sql2 = "SELECT *
                    FROM request_item AS RI, users AS U, item AS I
                    WHERE RI.University_id = U.University_id
                            AND RI.Item_id = I.Item_id;";
            $result2 = mysqli_query($conn, $sql2);
            $qi_results = mysqli_num_rows($result2);
            if($qi_results > 0) {
            ?>
            <div class="COtable">
                <table>
                    <tr>
                        <th colspan="4"><h2>Items Requested</h2></th>
                    </tr>
                        <t>
                            <th>Staff ID </th>
                            <th>User </th>
                            <th>Item Type</th>
                            <th>Requested</th>
                        </t>
            <?php
                while($row = $result2->fetch_assoc()) {
            ?> 
                <tr>
                    <td><?php echo $row['Staff_id']; ?></td>
                        <td><?php echo $row['Fname'] ." ".$row['Lname']; ?></td>
                        <?php
                            $type = itemType($row['Item_type']);
                        ?>
                        <td><?php echo $type; ?></td>
                        <td><?php echo $row['Request_date']; ?></td>
                </tr>
            <?php
                }

            }
        }
    }
    function updateFines($conn, $UnivID, $Fines) {
        $sql = "UPDATE users SET Fines = '$Fines' WHERE University_id = $UnivID;";
        if (mysqli_query($conn, $sql)) {
            header("location: index.php?error=finesupdated");
        }
        else {
            header("location: index.php?error=sql");
        } 
    } 
    function deleteMessageRow($conn, $id) {
        $sql = "DELETE FROM `new_messages` WHERE `Message_id` = $id;";
        $conn->query($sql);
        header("location: ../index.php?error=none");
    }
    function returnBook($conn, $bookID) {
        // $sql = "SELECT * FROM check_out_book WHERE check_out_book.Book_id = '$bookID';";
        $sql = "DELETE FROM `check_out_book` WHERE (`Book_id` = $bookID);";
        // $sql = "DELETE FROM `library`.`check_out_book` WHERE (`University_id` = '5431189') and (`Book_id` = '000000000001');";
        $conn->query($sql);
        header("location: ../index.php?error=none");
    }
    function getResult($conn, $bookID) {
        //$sql = "SELECT * FROM check_out_book WHERE check_out_book.Book_id = '$bookID'";
        $sql = "SELECT * FROM check_out_book WHERE check_out_book.Book_id = $bookID";
        $result = $conn->query($sql);
        return $result;
    }
    function deleteQueue($conn, $bookID) {
        $sql = "DELETE FROM `request_book` WHERE `Book_id` = $bookID;";
        $conn->query($sql);
        header("location: ../index.php?error=none");
    }
?>