<?php
    session_start();
    include_once 'functions.inc.php';
    include_once 'dbh.inc.php';
    $answer = $_GET['answers'];
    nextQuestion($conn,$answer);
    header("location: ../takeQuiz.php");
?>