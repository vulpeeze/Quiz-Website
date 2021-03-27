<?php
include_once 'header.php';
include_once 'includes/dbh.inc.php';

if ($_SESSION['questionNumber'] < count($_SESSION['questions'])) {
    echo "<div class='container'><h2>" . $_SESSION['questions'][$_SESSION['questionNumber']] . "</h2>";
}

echo "
        <form action='includes/nextQuestion.inc.php' method='get'>
        <div class='form-check'>
            <input type='radio' class='form-check-input' id='answer1' name='answers' value='1'/>
            <label for='answer1'>" . $_SESSION['answer1'][$_SESSION['questionNumber']] . "</label><br>
            <input type='radio' class='form-check-input' id='answer2' name='answers' value='2'/>
            <label for='answer2'>" . $_SESSION['answer2'][$_SESSION['questionNumber']] . "</label><br>
            <input type='radio' class='form-check-input' id='answer3' name='answers' value='3'/>
            <label for='answer3'>" . $_SESSION['answer3'][$_SESSION['questionNumber']] . "</label><br>
            <input type='radio' class='form-check-input' id='answer4' name='answers' value='4'/>
            <label for='answer4'>" . $_SESSION['answer4'][$_SESSION['questionNumber']] . "</label><br><br>
        </div>
        <div class='form-group row'>
            <input type='submit' class='btn btn-primary col-sm-2' name='question' value='Next Question' />
        </div>
        </form></div>";
