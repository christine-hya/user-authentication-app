<?php
    include_once 'header.php';
?>

<section class="signup-form">
    <h2>Sign Up</h2>
    <form action="includes/signup.inc.php" method="post">
        <input type="text" name="name" placeholder="Full name..."><br><br>
        <input type="text" name="email" placeholder="Email..."><br><br>
        <input type="text" name="uid" placeholder="Username..."><br><br>
        <input type="password" name="pwd" placeholder="Password..."><br><br>
        <input type="password" name="pwdrepeat" placeholder="Repeat password..."><br><br>
        <button type="submit" name="submit">Sign Up</button><br>
    </form>

    <?php 
        if (isset($_GET['error'])) {
            if ($_GET['error'] == "emptyinput") {
                echo '<p>Please fill in all fields.</p>';

            }
            else if ($_GET['error'] == "invaliduid") {
                echo '<p>Please choose a valid username.</p>';

            }
            else if ($_GET['error'] == "invalidemail") {
                echo '<p>Please choose a valid email.</p>';

            }
            else if ($_GET['error'] == "passwordsdontmatch") {
                echo "<p>Passwords don't match.</p>";

            }
            else if ($_GET['error'] == "stmtfailed") {
                echo "<p>Something went wrong, please try again.</p>";

            }
            else if ($_GET['error'] == "usernametaken") {
                echo "<p>Username and/or email already exists. Please choose another one.</p>";

            }
            else if ($_GET['error'] == "none") {
                echo "<p>Sign up successful!</p>";
            }
        }

        if (isset($_GET['newpwd'])) {
            if($_GET['newpwd'] == 'passwordupdated') {
                echo '<p>Your password has been reset!</p>';
            }
        }
?>
 
<a href="reset-password.php">Forgot your password?</a>
</section>


<?php
    include_once 'footer.php';
?>