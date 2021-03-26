<?php

if (isset($_POST["submit"])) {

    $question = $_POST["question"];
    $ans1 = $_POST["ans1"];
    $ans2 = $_POST["ans2"];
    $ans3 = $_POST["ans3"];
    $ans4 = $_POST["ans4"];
    $ansr = $_POST["ansr"];
    
    require_once 'dbh.inc.php';
    require_once 'functions.inc.php';
    session_start();
    if (emptyInputAddQuestion($question, $ans1, $ans2, $ans3, $ans4, $ansr) !== false) {
        header("location: editQuiz.inc.php?error=emptyInput&submit=" . $_SESSION['quiz']);
        exit();
    }

    if (invalidRightAnswer($ansr) !==false){
        header("location: editQuiz.inc.php?error=invalidRightAnswer&submit=" . $_SESSION['quiz']);
        exit();
    }

    addQuestion($conn, $question, $ans1, $ans2, $ans3, $ans4, $ansr);
    header("location: editQuiz.inc.php?submit=" . $_SESSION['quiz']);
    exit();

} else {
    header("location: editQuizzes.php");
    exit();
}