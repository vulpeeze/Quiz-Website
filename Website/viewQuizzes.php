<?php
    include_once 'header.php';
    include_once 'includes/dbh.inc.php';
?>

<h1>List of Available Quizzes</h1>

<?php
    $sql = "SELECT * FROM quizmetadata WHERE quizAvailable = 1;";
    $result = mysqli_query($conn, $sql);
    $resultCheck = mysqli_num_rows($result);

    if ($resultCheck > 0) {
        echo "<table style='width:100%; border: 1px solid black;'>";
        echo "<tr><th>Quiz ID</th><th>Quiz Name</th><th>Quiz Author</th><th>Quiz Duration</th><th>Take Quiz</th></tr>";
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr><th>" . $row['quizId'] . "</th><th>" . $row['quizName'] . "</th><th>" . $row['quizAuthor'] . "</th><th>" . $row['quizDuration'] . " minutes</th><th>" . "<form action='includes/quizRedirect.inc.php' method='GET'><input type='submit' name='quiz' value=" . $row['quizId'] . "></input></th></tr>";
        }
        echo "</table>";
    } else{
        echo "<h2>There are no quizzes available.</h2>";
    }
?>