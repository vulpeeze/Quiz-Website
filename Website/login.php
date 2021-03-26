<?php
    include_once 'header.php'
?>
    <h1>Log In</h1>

    <form action="includes/login.inc.php" method="post">
        <label for="Username">Username:</label>
        <input type="text" id="Username" name="uid" placeholder="Username or Email"><br>
        <label for="pwd">Password:</label>
        <input type="password" id="pwd" name="password"><br>
        
        <br><br><input type="submit" name="submit" value="Log in">
    </form>

    <?php
        if (isset($_GET["error"])) {
            if ($_GET["error"] == "emptyInput") {
                echo "<p>Please fill in all the fields.</p>";
            } else if ($_GET["error"] == "noUserName") {
                echo "<p>This username doesn't exist. Make sure you're registered.</p>";
            } else if ($_GET["error"] == "wrongPassword") {
                echo "<p>That password is incorrect. Please try again.</p>";
            }
        }
    ?>

</body>
</html>