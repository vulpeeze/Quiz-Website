<?php
    session_start();

    $_SESSION["quiz"] = $_GET["quiz"];
    $_SESSION['questionNumber'] = 0;
    $_SESSION['quizScore'] = 0;
    echo $_SESSION["quiz"] . " + " . $_SESSION['questionNumber'] . "<br>";

    require_once 'dbh.inc.php';
    require_once 'functions.inc.php';

    $sql = "SELECT questions FROM quizquestions WHERE quizId = " . $_SESSION['quiz'] . ";";
    $result = mysqli_query($conn, $sql);
    $resultCheck = mysqli_num_rows($result);
    $_SESSION['totalQuestions'] = $resultCheck;
    
    if ($resultCheck > 0) {
        $questions = new SplQueue;
        while ($row = mysqli_fetch_assoc($result)) {
            $questions->enqueue($row['questions']);
        }
        $_SESSION['questions'] = $questions;
    } else {
        unset($_SESSION["questions"]);
        unset($_SESSION["answer1"]);
        unset($_SESSION["answer2"]);
        unset($_SESSION["answer3"]);
        unset($_SESSION["answer4"]);
        header("location: ../quizEmpty.php");
        exit();
    }

    enqueueQuiz($conn, 'answer1');
    enqueueQuiz($conn, 'answer2');
    enqueueQuiz($conn, 'answer3');
    enqueueQuiz($conn, 'answer4');
    enqueueQuiz($conn, 'rightAnswer');

    function enqueueQuiz($conn, $item){
        $sql = "SELECT " . $item . " FROM quizquestions WHERE quizId = " . $_SESSION['quiz'] . ";";
        $result = mysqli_query($conn, $sql);
        
        $questions = new SplQueue;
        while ($row = mysqli_fetch_assoc($result)) {
            $questions->enqueue($row[$item]);
        }
        $_SESSION[$item] = $questions;
    }

    header("location: ../takeQuiz.php");
    exit();