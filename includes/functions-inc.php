<?php
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

    function uidExists($con, $UnivID) {
        $sql = "SELECT * FROM USERS WHERE University_id = ?;";
        $stmt = mysqli_stmt_init($con);
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

    function createUser($con, $UnivID, $Pass, $First, $Mid, $Last, $Stat, $Email, $DOB, $Tele, $Addr) {
        $sql = "INSERT INTO USERS (University_id, Password, Fname, Minit, Lname, Status, Email, BDate, Phone_num, Address, Created_at, Last_updated) VALUES (?,?,?,?,?,?,?,?,?,?,now(),now());";
        $stmt = mysqli_stmt_init($con);
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
    function loginUser($con, $UnivID, $Pass) {
        $uidExists =  uidExists($con, $UnivID);
        if ($uidExists === false) {
            header("location: ../login.php?error=wronglogin");
            exit();
        }
        $pwdHashed = $uidExists["Password"];
        $checkPwd = password_verify($Pass, $pwdHashed);
        if($checkPwd === false) {
            header("location: ../login.php?error=wronglogin");
            exit();
        }
        else if ($checkPwd === true){
            session_start();
            $_SESSION["University_id"] = $uidExists["University_id"];
            header("location: ../index.php");
            exit();
        }

    }

?>