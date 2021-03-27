<?php
include_once 'header.php';
include_once 'includes/dbh.inc.php';
?>
<div class="container">
    <h1>Quiz Attempts</h1>

    <?php
    $sql = "SELECT * FROM studentattempts,quizmetadata WHERE studentattempts.quizId = quizmetadata.quizId and quizmetadata.quizAvailable = 1 and studentId =" . $_SESSION['usersId'] . ";";
    $result = mysqli_query($conn, $sql);
    $resultCheck = mysqli_num_rows($result);

    if ($resultCheck > 0) {
        echo "<table class='table table-striped'>";
        echo "<tr><th>Quiz ID</th><th>Quiz Name</th><th>Quiz Author</th><th>Quiz Duration</th><th>Date Attempted</th><th>Last Score</th></tr>";
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr><th>" . $row['quizId'] . "</th><th>" . $row['quizName'] . "</th><th>" . $row['quizAuthor'] . "</th><th>" . $row['quizDuration'] . " minutes</th><th>" . $row['dateOfAttempt'] . "</th><th>"
                . $row['score'] . "</th></tr>";
        }
        echo "</table>";
    } else {
        echo "<h2>You haven't attempted any quizzes yet.</h2>";
    }
    ?>
</div>