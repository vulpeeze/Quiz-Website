<?php
    include_once 'header.php';
    include_once 'includes/dbh.inc.php';
?>
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
        echo "<table style='width:100%; border: 1px solid black;'>";
        echo "<tr><th>Quiz ID</th><th>Quiz Name</th><th>Quiz Author</th><th>Quiz Duration</th><th>Quiz Available</th><th>Update Quiz</th></tr>";
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<form action='includes/editQuiz.inc.php' method='GET'>
            <tr>
                <th><label>" . $row['quizId'] . "</th>
                <th>" . $row['quizName'] . "</th>
                <th>" . $row['quizAuthor'] . "</th>
                <th>" . $row['quizDuration'] . " minutes</th>
                <th>". $row['quizAvailable'] . "</th>
                <th><button name='submit' value=" . $row['quizId'] . " type='submit'>Edit</button></th>
            </tr></form>";
        }
        echo "</table>";
    } else{
        echo "<h2>There are no quizzes available.</h2>";    
    }
?>

<!-- Quiz Creation -->
<h3>Create a Quiz</h3>
<form action="includes/createQuiz.inc.php" method="post">
    <label for="name">Quiz Name</label>
    <input type="text" id="name" name="name" placeholder="The Quiz" /><br>
    <label for="duration">Quiz Duration</label>
    <input type="number" id="duration" name="duration" placeholder="60" /><br><br>
    <input type="submit" name="submit" value="Create Quiz" />
</form>

<h3>Update a Quiz</h3>
<form action="includes/updateQuiz.inc.php" method="post">
    <label for="quizId">Quiz ID</label>
    <input type="number" id="quizId" name="quizId" /><br>
    <label for="name">Quiz Name</label>
    <input type="text" id="name" name="name" placeholder="The Quiz" /><br>
    <label for="duration">Quiz Duration</label>
    <input type="number" id="duration" name="duration" placeholder="60" /><br>
    <label for="available">Quiz Available?</label>
    <input type="checkbox" id="available" name="available" value=1 /><br><br>
    <input type="submit" name="submit" value="Update Quiz" />
</form>

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