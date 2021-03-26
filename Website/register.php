<?php
    include_once 'header.php'
?>
    <h1>Registration</h1>

    <form action="includes/register-inc.php" method="post">
        <label for="Name">Name:</label>
        <input type="text" id="Name" name="sName" placeholder="Duncan Hull"><br>
        <label for="uid">Username:</label>
        <input type="text" id="uid" name="uid" placeholder="KittenDestroyer"><br>
        <label for="pwd">Password:</label>
        <input type="password" id="pwd" name="password"><br>
        <label for="Cpwd">Confirm Password:</label>
        <input type="password" id="Cpwd" name="confirmpassword"><br>
        <label for="email">Email:</label>
        <input type="email" id="email" name="sEmail" placeholder="DuncanHull@manchester.ac.uk"><br>
        
        <input type="radio" id="staff" name="status" value="staff">
        <label for="staff">Staff</label><br>
        <input type="radio" id="student" name="status" value="student">
        <label for="student">Student</label>
        
        <br><br><input type="submit" name="submit" value="Register">
    </form>

    <?php
        if (isset($_GET["error"])) {
            if ($_GET["error"] == "emptyInput") {
                echo "<p>Please fill in all the fields.</p>";
            } else if ($_GET["error"] == "InvalidUserName") {
                echo "<p>Please enter a valid username.</p>";
            } else if ($_GET["error"] == "InvalidEmail") {
                echo "<p>Please enter a valid email address.</p>";
            } else if ($_GET["error"] == "passwordsNoMatch") {
                echo "<p>Please make sure both passwords match.</p>";
            } else if ($_GET["error"] == "usernameTaken") {
                echo "<p>Username is already taken.</p>";
            } else if ($_GET["error"] == "stmtFailed") {
                echo "<p>Something went wrong.</p>";
            } else if ($_GET["error"] == "none") {
                echo "<p>Thank you for registering.</p>";
            }
        }
    ?>

</body>
</html>