<?php
    include_once 'header.php'
?>
    <div class="container">
    <h1>Log In</h1>
    <form action="includes/login.inc.php" method="post">
        <div class="form-group row">
            <label for="Username" class="col-sm-1 col-form-label">Username:</label>
            <div class="col-sm-7">
                <input type="text" class="form-control" id="Username" name="uid" placeholder="Username or Email"><br>
            </div>
        </div>
        <div class="form-group row">
            <label for="pwd" class="col-sm-1 col-form-label">Password:</label>
            <div class="col-sm-7">
                <input type="password" class="form-control" id="pwd" name="password" placeholder="Password"><br>
            </div>
        </div>
        <div class="form-group row">
            <input type="submit" class="btn btn-primary col-sm-1 offset-sm-1" name="submit" value="Log in">
        </div>
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

</div>
</body>
</html>