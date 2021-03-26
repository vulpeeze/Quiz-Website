<?php
if (isset($_GET["submit"])) {

    include_once 'dbh.inc.php';
    include_once 'functions.inc.php';

    session_start();
    $quizId = $_GET['submit'];
    $_SESSION['quiz'] = $quizId;

    $sql = "SELECT * FROM quizmetadata WHERE quizId='" . $quizId . "';";
    $result = mysqli_query($conn, $sql);

    while ($row = mysqli_fetch_assoc($result)) {
        echo "<h1>" .$row['quizName'] . "</h1>";
    }

    echo '
        <form action="../editQuizzes.php">
            <input type="submit" value="Go back" />
        </form>';
    
    echo '
        <form action="deleteQuizzes.inc.php">
            <button name="submit" value=' . $quizId . ' type="submit">Delete this Quiz</button>
        </form>';

    $sql = "SELECT * FROM quizquestions WHERE quizId='" . $quizId . "';";
    $result = mysqli_query($conn, $sql);

    echo "<table style='width:100%; border: 1px solid black;'>";
    echo "<tr>
        <th>Quiz Number</th>
        <th>Question</th>
        <th>Answer 1</th>
        <th>Answer 2</th>
        <th>Answer 3</th>
        <th>Answer 4</th>
        <th>Right Answer</th>
        </tr>";
    $quizNumbering = 1;
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>
        <th>" . $quizNumbering . "</th>
        <th>" .$row['questions'] . "</th>
        <th>" .$row['answer1'] . "</th>
        <th>" .$row['answer2'] . "</th>
        <th>" .$row['answer3'] . "</th>
        <th>" .$row['answer4'] . "</th>
        <th>" .$row['rightAnswer'] . "</th>
        </tr>";
        $quizNumbering++;
    }
    echo "</table>";

    echo '<h2>Add Question</h2>
    <form action="addQuestion.inc.php" method="post">
        <label for="question">Question:</label>
        <input type="text" id="question" name="question"><br>
        <label for="ans1">Answer 1:</label>
        <input type="text" id="ans1" name="ans1"><br>
        <label for="ans2">Answer 2:</label>
        <input type="text" id="ans2" name="ans2"><br>
        <label for="ans3">Answer 3:</label>
        <input type="text" id="ans3" name="ans3"><br>
        <label for="ans4">Answer 4:</label>
        <input type="text" id="ans4" name="ans4"><br>
        <label for="ansr">Which is the right answer:</label>
        <input type="number" id="ansr" name="ansr"><br>
        <br><br><input type="submit" name="submit" value="Add Question">
    </form>';
    if (isset($_GET["error"])) {
        if ($_GET["error"] == "emptyInput") {
            echo "<p>Please fill in all the fields.</p>";
        } else if ($_GET["error"] == "invalidRightAnswer") {
            echo "<p>Please enter a valid right answer.</p>";
        } else if ($_GET["error"] == "stmtFailed") {
            echo "<p>Something went wrong.</p>";
        }
    }

    echo '<h2>Delete Question</h2>
    <form action="deleteQuestion.inc.php" method="post">
        <label for="delq">Which question to delete:</label>
        <input type="number" id="delq" name="delq"><br>
        <br><br><input type="submit" name="submit" value="Delete Question">
    </form>';
    if (isset($_GET["Delerror"])) {
        if ($_GET["Delerror"] == "emptyInput") {
            echo "<p>Please fill in all the fields.</p>";
        } else if ($_GET["Delerror"] == "invalidRightAnswer") {
            echo "<p>Please choose a valid question to delete.</p>";
        } else if ($_GET["Delerror"] == "stmtFailed") {
            echo "<p>Something went wrong.</p>";
        }
    }

    echo '<h2>Update Question</h2>
    <form action="updateQuestion.inc.php" method="post">
        <label for="upq">Which question to update:</label>
        <input type="number" id="upq" name="upq"><br>
        <label for="question">Question:</label>
        <input type="text" id="question" name="question"><br>
        <label for="ans1">Answer 1:</label>
        <input type="text" id="ans1" name="ans1"><br>
        <label for="ans2">Answer 2:</label>
        <input type="text" id="ans2" name="ans2"><br>
        <label for="ans3">Answer 3:</label>
        <input type="text" id="ans3" name="ans3"><br>
        <label for="ans4">Answer 4:</label>
        <input type="text" id="ans4" name="ans4"><br>
        <label for="ansr">Which is the right answer:</label>
        <input type="number" id="ansr" name="ansr"><br>
        <br><br><input type="submit" name="submit" value="Update Question">
    </form>';
    if (isset($_GET["uperror"])) {
        if ($_GET["uperror"] == "emptyInput") {
            echo "<p>Please choose a question to update.</p>";
        } else if ($_GET["uperror"] == "invalidQuestionNumber") {
            echo "<p>Please choose a valid question to update.</p>";
        } else if ($_GET["uperror"] == "invalidRightAnswer") {
            echo "<p>Please choose a valid number to be your right answer.</p>";
        } else if ($_GET["uperror"] == "stmtFailed") {
            echo "<p>Something went wrong.</p>";
        }
    }

} else {
    //header("location: ../editQuizzes.php?error=failedToEdit");
    exit();
}