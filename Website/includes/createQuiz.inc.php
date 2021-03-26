<?php
if (isset($_POST["submit"])) {

    include_once 'dbh.inc.php';
    include_once 'functions.inc.php';

    $quizName = $_POST['name'];
    $quizDuration = $_POST['duration'];

    if (emptyInputCreateQuiz($quizName, $quizDuration) !== false) {
        header("location: ../editQuizzes.php?quiz=emptyInput");
        exit();
    }

    createQuiz($conn, $quizName,$quizDuration);


} else {
    header("location: ../editQuizzes.php");
    exit();
}