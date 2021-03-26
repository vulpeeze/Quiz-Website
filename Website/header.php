<?php
    session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quizatron</title>
</head>
<body>
    <ul>
        
        <?php
            if(isset($_SESSION["usersUid"])){
                echo "<li><a href='profile.php'>Profile</a></li>";
                if ($_SESSION['userStatus']=="staff") {
                    echo "<li><a href='editQuizzes.php'>Edit Quizzes</a></li>";
                }
                echo "<li><a href='viewQuizzes.php'>Take Quizzes</a></li>";
                echo "<li><a href='quizAttempts.php'>Quiz Attempts</a></li>";
                echo "<li><a href='includes/logout.inc.php'>Log Out</a></li>";
            } else{
                echo "<li><a href='register.php'>Registration</a></li>";
                echo "<li><a href='login.php'>Log in</a></li>";
            }
        ?>
    </ul>