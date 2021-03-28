<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quizatron</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
</head>

<body>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
    <nav class="navbar navbar-expand-sm bg-dark navbar-dark fixed-top">
        <a class="navbar-brand" href="index.php">Quiz</a>
        <ul class="navbar-nav">
            <?php
            if (isset($_SESSION["usersUid"])) {
                echo "<li class='nav-item'><a href='profile.php' class='nav-link'>Profile</a></li>";
                if ($_SESSION['userStatus'] == "staff") {
                    echo "<li class='nav-item'><a class='nav-link' href='editQuizzes.php'>Edit Quizzes</a></li>";
                }
                echo "<li class='nav-item'><a class='nav-link' href='viewQuizzes.php'>Take Quizzes</a></li>";
                echo "<li class='nav-item'><a class='nav-link' href='quizAttempts.php'>Quiz Attempts</a></li>";
                echo "<li class='nav-item'><a class='nav-link' href='includes/logout.inc.php'>Log Out</a></li>";
            } else {
                echo "<li class='nav-item'><a class='nav-link' href='register.php'>Registration</a></li>";
                echo "<li class='nav-item'><a class='nav-link' href='login.php'>Log in</a></li>";
            }
            ?>
        </ul>
    </nav>
    <div style="margin-top:80px"></div>