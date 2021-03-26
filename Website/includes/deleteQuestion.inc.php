<?php

if (isset($_POST["submit"])) {

    $delquestion = $_POST["delq"];
    
    require_once 'dbh.inc.php';
    require_once 'functions.inc.php';
    session_start();
    if (empty($delquestion) !== false) {
        header("location: editQuiz.inc.php?Delerror=emptyInput&submit=" . $_SESSION['quiz']);
        exit();
    }

    if (invalidDeleteRightAnswer($conn, $delquestion) !==false){
        header("location: editQuiz.inc.php?Delerror=invalidRightAnswer&submit=" . $_SESSION['quiz']);
        exit();
    }

    deleteQuestion($conn, $delquestion);

    header("location: editQuiz.inc.php?submit=" . $_SESSION['quiz']);
    exit();

} else {
    header("location: editQuizzes.php");
    exit();
}