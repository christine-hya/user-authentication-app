<div class="header">
    <?php
    include_once 'header.php';
    ?>
</div>

<!--DISPLAY SIGN-UP FORM-->

<section>

    <div class="container text-center p-4 my-5 form-width">
        <h2 class="mb-3">Sign Up</h2>
        <form class="mx-4" action="includes/signup.inc.php" method="post">
            <input class="form-control my-4 w-75 mx-auto" type="text" name="name" placeholder="Full name">
            <input class="form-control my-4 w-75 mx-auto" type="text" name="email" placeholder="Email">
            <input class="form-control my-4 w-75 mx-auto" type="text" name="uid" placeholder="Username">
            <input class="form-control my-4 w-75 mx-auto" type="password" name="pwd" placeholder="Password">
            <input class="form-control my-4 w-75 mx-auto" type="password" name="pwdrepeat" placeholder="Repeat password">
            <button class="btn text-light button" type="submit" name="submit">Sign Up</button>
        </form>
        <?php

        //DISPLAY ERROR MESSAGES FOR SIGNUP

        if (isset($_GET['error'])) {
            if ($_GET['error'] == "emptyinput") {
                echo '<p>Please fill in all fields.</p>';
            } else if ($_GET['error'] == "invaliduid") {
                echo '<p>Please choose a valid username.</p>';
            } else if ($_GET['error'] == "invalidemail") {
                echo '<p>Please choose a valid email.</p>';
            } else if ($_GET['error'] == "passwordsdontmatch") {
                echo "<p>Passwords don't match.</p>";
            } else if ($_GET['error'] == "stmtfailed") {
                echo "<p>Something went wrong, please try again.</p>";
            } else if ($_GET['error'] == "usernametaken") {
                echo "<p>Username and/or email already exists. Please choose another one.</p>";
            } else if ($_GET['error'] == "none") {
                echo "<p>Sign up successful!</p>";
            }
        }

        if (isset($_GET['newpwd'])) {
            if ($_GET['newpwd'] == 'passwordupdated') {
                echo '<p>Your password has been reset!</p>';
            }
        }
        ?>

    </div>



</section>

<?php
include_once 'footer.php';
?>