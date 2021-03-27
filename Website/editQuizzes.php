<?php
include_once 'header.php';
include_once 'includes/dbh.inc.php';
?>
<div class="container">
    <h1>Edit Quizzes</h1>

    <h3>Edit Existing Quizzes</h3>

    <?php
    if (!isset($_SESSION)) {
        session_start();
        unset($_SESSION["quiz"]);
    }
    $sql = "SELECT * FROM quizmetadata WHERE quizAuthor='" . $_SESSION['usersName'] . "';";
    $result = mysqli_query($conn, $sql);
    $resultCheck = mysqli_num_rows($result);

    if ($resultCheck > 0) {
        echo "<table class='table table-striped'>";
        echo "<tr><th>Quiz ID</th><th>Quiz Name</th><th>Quiz Author</th><th>Quiz Duration</th><th>Quiz Available</th><th>Update Quiz</th></tr>";
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<form action='includes/editQuiz.inc.php' method='GET'>
            <tr>
                <th><label>" . $row['quizId'] . "</th>
                <th>" . $row['quizName'] . "</th>
                <th>" . $row['quizAuthor'] . "</th>
                <th>" . $row['quizDuration'] . " minutes</th>
                <th>" . $row['quizAvailable'] . "</th>
                <th><button name='submit' value=" . $row['quizId'] . " type='submit'>Edit</button></th>
            </tr></form>";
        }
        echo "</table>";
    } else {
        echo "<h2>There are no quizzes available.</h2>";
    }
    ?>

    <br>

    <div class="row">
        <div class="col-sm-6">
            <!-- Quiz Creation -->
            <h3>Create a Quiz</h3>
            <form action="includes/createQuiz.inc.php" method="post">
                <div class="form-group row">
                    <label for="name" class="col-sm-3">Quiz Name</label>
                    <div class="col-sm-7">
                        <input type="text" class="form-control" id="name" name="name" placeholder="The Quiz" /><br>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="duration" class="col-sm-3">Quiz Duration</label>
                    <div class="col-sm-7">
                        <input type="number" class="form-control" id="duration" name="duration" placeholder="60" /><br><br>
                    </div>
                </div>
                <div class="form-group row">
                    <input type="submit" class="btn btn-primary col-sm-2 offset-sm-3" name="submit" value="Create Quiz" />
                </div>
            </form>
        </div>

        <div class="col-sm-6">
            <!-- Quiz Updation -->
            <h3>Update a Quiz</h3>
            <form action="includes/updateQuiz.inc.php" method="post">
                <div class="form-group row">
                    <label for="quizId" class="col-sm-3">Quiz ID</label>
                    <div class="col-sm-7">
                        <input type="number" class="form-control" id="quizId" name="quizId" /><br>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="name" class="col-sm-3">Quiz Name</label>
                    <div class="col-sm-7">
                        <input type="text" class="form-control" id="name" name="name" placeholder="The Quiz" /><br>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="duration" class="col-sm-3">Quiz Duration</label>
                    <div class="col-sm-7">
                        <input type="number" class="form-control" id="duration" name="duration" placeholder="60" /><br>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="available" class="col-sm-3">Quiz Available?</label>
                    <div class="col-sm-7">
                        <input type="checkbox" class="form-check-input" id="available" name="available" value=1 /><br><br>
                    </div>
                </div>
                <div class="form-group row">
                    <input type="submit" class="btn btn-primary col-sm-2 offset-sm-3" name="submit" value="Update Quiz" />
                </div>
            </form>
        </div>
        <!-- Error Handling -->
        <?php
        if (isset($_GET["quiz"])) {
            if ($_GET["quiz"] == "made") {
                echo "<p>Your quiz has successfully been created.</p>";
            } elseif ($_GET["quiz"] == "emptyInput") {
                echo "<p>Please fill in all the fields.</p>";
            } elseif ($_GET["quiz"] == "stmtFailed") {
                echo "<p>Something went wrong.</p>";
            }
        }
        ?>

    </div>
</div>