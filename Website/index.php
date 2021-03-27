<?php
    include_once 'header.php'
?>
<div class="container">
<h1 class="offset-sm-5">The Front Page!</h1>

<?php
    if(isset($_SESSION["usersUid"])){
        echo "<p>Hello there " . $_SESSION["usersName"] . "!</p>";
        echo "Your email address is " . $_SESSION["usersEmail"] . " and you are a " . $_SESSION["userStatus"] . ".<br>";
    } else{
        echo "<a href='register.php' class='offset-sm-5'><button type='button' class='btn btn-primary'>Registration</button></a>";            
        echo "<a href='login.php' class='offset-sm-1'><button type='button' class='btn btn-primary''>Log in</button></a>";
    }
?>
</div>