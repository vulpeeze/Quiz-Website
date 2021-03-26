<?php
    include_once 'header.php'
?>

<h1>The Front Page!</h1>

<?php
    if(isset($_SESSION["usersUid"])){
        echo "<p>Hello there " . $_SESSION["usersName"] . "!</p>";
        echo "Your email address is " . $_SESSION["usersEmail"] . " and you are a " . $_SESSION["userStatus"] . ".<br>";
    } else{
        echo "<li><a href='register.php'>Registration</a></li>";            
        echo "<li><a href='login.php'>Log in</a></li>";
    }
?>