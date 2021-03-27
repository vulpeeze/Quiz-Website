<?php
    include_once 'header.php'
?>
    <div class="container">
    <h1>Registration</h1>

    <form action="includes/register-inc.php" method="post">
    <div class="form-group row">
        <label for="Name" class="col-sm-1 col-form-label">Name:</label>
        <div class="col-sm-7">
        <input type="text" class="form-control" id="Name" name="sName" placeholder="Duncan Hull"><br>
        </div>
    </div>
    <div class="form-group row">
        <label for="uid" class="col-sm-1">Username:</label>
        <div class="col-sm-7">
        <input type="text" class="form-control" id="uid" name="uid" placeholder="KittenDestroyer"><br>
        </div>
    </div>
    <div class="form-group row">
        <label for="pwd" class="col-sm-1">Password:</label>
        <div class="col-sm-7">
        <input type="password" class="form-control" id="pwd" name="password"><br>
        </div>
    </div>
    <div class="form-group row">
        <label for="Cpwd" class="col-sm-1">Confirm Password:</label>
        <div class="col-sm-7">
        <input type="password" class="form-control" id="Cpwd" name="confirmpassword"><br>
        </div>
    </div>
    <div class="form-group row">
        <label for="email" class="col-sm-1">Email:</label>
        <div class="col-sm-7">
        <input type="email" class="form-control" id="email" name="sEmail" placeholder="DuncanHull@manchester.ac.uk"><br>
        </div>
    </div>
    <div class="offset-sm-1 form-check">
        <input type="radio" class="form-check-input" id="staff" name="status" value="staff">
        <label for="staff" class="form-check-label">Staff</label><br>
        <input type="radio" class="form-check-input" id="student" name="status" value="student">
        <label for="student" class="form-check-label">Student</label>
    </div>
    <br>
    <div class="form-group row">
        <br><br><input type="submit" class="btn btn-primary col-sm-1 offset-sm-1" name="submit" value="Register">
    </div>
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
    </div>

</body>
</html>