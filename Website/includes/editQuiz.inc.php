<?php
if (isset($_GET["submit"])) {

    include_once 'dbh.inc.php';
    include_once 'functions.inc.php';

    session_start();
    $quizId = $_GET['submit'];
    $_SESSION['quiz'] = $quizId;

    $sql = "SELECT * FROM quizmetadata WHERE quizId='" . $quizId . "';";
    $result = mysqli_query($conn, $sql);

    include_once '../header.php';

    while ($row = mysqli_fetch_assoc($result)) {
        echo "<div class='container'><h1>" . $row['quizName'] . "</h1>";
    }

    echo '
        <div class="row">
        <div class="col-sm-6 text-start">
        <form action="../editQuizzes.php">
            <input type="submit" class="btn btn-primary" value="Go back" />
        </form></div>';

    echo '<div class="col-sm-6 text-end">
        <form action="deleteQuizzes.inc.php">
            <button name="submit" class="btn btn-primary" value=' . $quizId . ' type="submit">Delete this Quiz</button>
        </form></div></div>';

    $sql = "SELECT * FROM quizquestions WHERE quizId='" . $quizId . "';";
    $result = mysqli_query($conn, $sql);

    echo "<br><table class='table table-striped'>";
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
        <th>" . $row['questions'] . "</th>
        <th>" . $row['answer1'] . "</th>
        <th>" . $row['answer2'] . "</th>
        <th>" . $row['answer3'] . "</th>
        <th>" . $row['answer4'] . "</th>
        <th>" . $row['rightAnswer'] . "</th>
        </tr>";
        $quizNumbering++;
    }
    echo "</table>";

    echo '
    <h2>Add Question</h2>
    <form action="addQuestion.inc.php" method="post">
    <div class="form-group row">
        <label for="question" class="col-sm-3 col-form-label">Question:</label>
        <div class="col-sm-9">
        <input type="text" class="form-control" id="question" name="question"><br>
        </div>
    </div>
    <div class="form-group row">
        <label for="ans1" class="col-sm-3 col-form-label">Answer 1:</label>
        <div class="col-sm-9">
        <input type="text" class="form-control" id="ans1" name="ans1"><br>
        </div>
    </div>
    <div class="form-group row">
        <label for="ans2" class="col-sm-3 col-form-label">Answer 2:</label>
        <div class="col-sm-9">
        <input type="text" class="form-control" id="ans2" name="ans2"><br>
        </div>
    </div>
    <div class="form-group row">
        <label for="ans3" class="col-sm-3 col-form-label">Answer 3:</label>
        <div class="col-sm-9">
        <input type="text" class="form-control" id="ans3" name="ans3"><br>
        </div>
    </div>
    <div class="form-group row">
        <label for="ans4" class="col-sm-3 col-form-label">Answer 4:</label>
        <div class="col-sm-9">
        <input type="text" class="form-control" id="ans4" name="ans4"><br>
        </div>
    </div>
    <div class="form-group row">
        <label for="ansr" class="col-sm-3 col-form-label">Which is the right answer:</label>
        <div class="col-sm-6">
        <input type="number" class="form-control" id="ansr" name="ansr">
        </div>
        <input type="submit" class="btn btn-primary col-sm-3" name="submit" value="Add Question">
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
    echo "</div><hr>";


    echo '<h2>Delete Question</h2>
    <form action="deleteQuestion.inc.php" method="post">
    <div class="form-group row">
        <label for="delq" class="col-sm-3 col-form-label">Which question to delete:</label>
        <div class="col-sm-6">
        <input type="number" class="form-control" id="delq" name="delq">
        </div>
        <input type="submit" class="btn btn-primary col-sm-3" name="submit" value="Delete Question">
    </div>
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
    echo "<hr>";

    echo '<h2>Update Question</h2>
    <h5>Choose a question to update and anything left blank will be kept the same.</h5><br>
    <form action="updateQuestion.inc.php" method="post">
    <div class="form-group row">
        <label for="upq" class="col-sm-3 col-form-label">Which question to update:</label>
        <div class="col-sm-9">
        <input type="number" class="form-control" id="upq" name="upq"><br>
        </div>
    </div>
    <div class="form-group row">
        <label for="question" class="col-sm-3 col-form-label">Question:</label>
        <div class="col-sm-9">
        <input type="text" class="form-control" id="question" name="question"><br>
        </div>
    </div>
    <div class="form-group row">
        <label for="ans1" class="col-sm-3 col-form-label">Answer 1:</label>
        <div class="col-sm-9">
        <input type="text" class="form-control" id="ans1" name="ans1"><br>
        </div>
    </div>
    <div class="form-group row">
        <label for="ans2" class="col-sm-3 col-form-label">Answer 2:</label>
        <div class="col-sm-9">
        <input type="text" class="form-control" id="ans2" name="ans2"><br>
        </div>
    </div>
    <div class="form-group row">
        <label for="ans3" class="col-sm-3 col-form-label">Answer 3:</label>
        <div class="col-sm-9">
        <input type="text" class="form-control" id="ans3" name="ans3"><br>
        </div>
    </div>
    <div class="form-group row">
        <label for="ans4" class="col-sm-3 col-form-label">Answer 4:</label>
        <div class="col-sm-9">
        <input type="text" class="form-control" id="ans4" name="ans4"><br>
        </div>
    </div>
    <div class="form-group row">
        <label for="ansr" class="col-sm-3 col-form-label">Which is the right answer:</label>
        <div class="col-sm-6">
        <input type="number" class="form-control" id="ansr" name="ansr">
        </div>
        <input type="submit" class="btn btn-primary col-sm-3" name="submit" value="Update Question">
    </div>
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
    echo "</div>";
} else {
    //header("location: ../editQuizzes.php?error=failedToEdit");
    exit();
}
