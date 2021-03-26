<?php

if (isset($_POST["submit"])) {

    $upQuestion = $_POST["upq"];
    $question = $_POST["question"];
    $ans1 = $_POST["ans1"];
    $ans2 = $_POST["ans2"];
    $ans3 = $_POST["ans3"];
    $ans4 = $_POST["ans4"];
    $ansr = $_POST["ansr"];
    
    require_once 'dbh.inc.php';
    require_once 'functions.inc.php';
    session_start();

    if (empty($upQuestion) !== false) {
        header("location: editQuiz.inc.php?uperror=emptyInput&submit=" . $_SESSION['quiz']);
        exit();
    }

    if (invalidDeleteRightAnswer($conn, $upQuestion) !==false){
        header("location: editQuiz.inc.php?uperror=invalidQuestionNumber&submit=" . $_SESSION['quiz']);
        exit();
    }

    if (invalidRightAnswerUpdate($ansr) !==false){
        header("location: editQuiz.inc.php?uperror=invalidRightAnswer&submit=" . $_SESSION['quiz']);
        exit();
    }

    updateQuestion($conn, $upQuestion, $question, $ans1, $ans2, $ans3, $ans4, $ansr);

    header("location: editQuiz.inc.php?submit=" . $_SESSION['quiz']);
    exit();

} else {
    header("location: editQuizzes.php");
    exit();
}