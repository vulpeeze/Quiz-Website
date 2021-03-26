<?php
if (isset($_POST["submit"])) {

    include_once 'dbh.inc.php';
    include_once 'functions.inc.php';

    $quizId = $_POST['quizId'];
    $quizName = $_POST['name'];
    $quizDuration = $_POST['duration'];
    if (isset($_POST['available']) && $_POST['available']==1) {
        $quizAvailable = $_POST['available'];
    } else {
        $quizAvailable = 0;
    }
    
    if (emptyInputUpdateQuiz($quizId) !== false) {
        header("location: ../editQuizzes.php?quiz=emptyInput");
        exit();
    }

    updateQuiz($conn, $quizId, $quizName, $quizDuration, $quizAvailable);
    return;

} else {
    header("location: ../editQuizzes.php");
    exit();
}