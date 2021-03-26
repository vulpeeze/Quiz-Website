<?php

if (isset($_GET["submit"])) {

    require_once 'dbh.inc.php';
    require_once 'functions.inc.php';

    $quizId = $_GET['submit'];
    
    $sql = "DELETE FROM quizquestions WHERE quizId='" . $quizId . "';";

    if ($conn->query($sql) === TRUE) {
        echo "Questions deleted successfully<br>";
    } else {
        echo "Error deleting questions: " . $conn->error;
    }

    $sql = "DELETE FROM studentattempts WHERE quizId='" . $quizId . "';";
    if ($conn->query($sql) === TRUE) {
        echo "Questions deleted successfully<br>";
    } else {
        echo "Error deleting questions: " . $conn->error;
    }
    
    $sql = "DELETE FROM quizmetadata WHERE quizId='" . $quizId . "';";
    echo $quizId;
    if ($conn->query($sql) === TRUE) {
        echo "Quiz deleted successfully";
        header("location: ../editQuizzes.php");
        exit();
    } else {
        echo "Error deleting quiz: " . $conn->error;
    }

} else {
    header("location: editQuiz.inc.php?error=deleteInvalid");
    exit();
}