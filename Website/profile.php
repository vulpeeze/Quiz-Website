<?php
    include_once 'header.php';
    if (!isset($_SESSION['usersId'])){  
    header('location: /login.php');
    exit;
}
?>

<?php
    echo "<div class='container'>";
    echo "<h1>" . $_SESSION['usersName'] . "</h1>";
    echo "<p>Your user ID is: " . $_SESSION['usersId'] . ".</p>";
    echo "<p>Your username is " . $_SESSION['usersUid'] . ".</p>";
    echo "<p>Your email address is " . $_SESSION['usersEmail'] . "</p>";
    echo "<p>You are a " . $_SESSION['userStatus'] . ".</p></div>";
?>