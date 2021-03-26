<?php
    include_once 'header.php';
    include_once 'includes/dbh.inc.php';

    if ($_SESSION['questionNumber'] < count($_SESSION['questions'])) {
        echo $_SESSION['questions'][$_SESSION['questionNumber']];
    }

    echo "
        <form action='includes/nextQuestion.inc.php' method='get'>
            <input type='radio' id='answer1' name='answers' value='1'/>
            <label for='answer1'>" . $_SESSION['answer1'][$_SESSION['questionNumber']] . "</label><br>
            <input type='radio' id='answer2' name='answers' value='2'/>
            <label for='answer2'>" . $_SESSION['answer2'][$_SESSION['questionNumber']] . "</label><br>
            <input type='radio' id='answer3' name='answers' value='3'/>
            <label for='answer3'>" . $_SESSION['answer3'][$_SESSION['questionNumber']] . "</label><br>
            <input type='radio' id='answer4' name='answers' value='4'/>
            <label for='answer4'>" . $_SESSION['answer4'][$_SESSION['questionNumber']] . "</label><br>
            <input type='submit' name='question' value='Next Question' />
        </form>";