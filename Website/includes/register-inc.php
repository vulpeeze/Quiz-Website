<?php

if (isset($_POST["submit"])) {

    $name = $_POST["sName"];
    $uid = $_POST["uid"];
    $email = $_POST["sEmail"];
    $pwd = $_POST["password"];
    $pwdRepeat = $_POST["confirmpassword"];
    $status = $_POST["status"];
    
    require_once 'dbh.inc.php';
    require_once 'functions.inc.php';
    
    if (emptyInputSignup($name, $uid, $email, $pwd, $pwdRepeat, $status) !== false) {
        header("location: ../register.php?error=emptyInput");
        exit();
    }

    if (InvalidUsername($uid) !== false) {
        header("location: ../register.php?error=InvalidUserName");
        exit();
    }
    if (InvalidEmail($email) !== false) {
        header("location: ../register.php?error=InvalidEmail");
        exit();
    }

    if (PasswordMatch($pwd,$pwdRepeat) !== false) {
        header("location: ../register.php?error=passwordsNoMatch");
        exit();
    }

    if (uidExists($conn, $uid, $email) !== false) {
        header("location: ../register.php?error=usernameTaken");
        exit();
    }

    createUser($conn, $name, $uid, $email, $pwd, $status);

} else {
    header("location: ../register.php");
    exit();
}