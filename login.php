<div class="header">
    <?php
    include_once 'header.php';
    ?>
</div>

<!--LOGIN FORM-->

<section>

    <div class="container text-center p-4 form-width">
        <h2 class="mb-3">Log in</h2>
        <form class="mx-4" action="includes/login.inc.php" method="post">
            <input class="form-control my-4 w-75 mx-auto" type="text" name="uid" placeholder="Username/email">
            <input class="form-control my-4 w-75 mx-auto" type="password" name="pwd" placeholder="Password">
            <button class="btn text-light button" type="submit" name="submit">Log in</button>
        </form>

        <?php

        // DISPLAY LOGIN ERROR MESSAGES

        if (isset($_GET['error'])) {
            if ($_GET['error'] == "emptyinput") {
                echo '<p>Please fill in all fields.</p>';
            } else if ($_GET['error'] == "wronglogin") {
                echo '<p>Incorrect username or password.</p>';
            }
        }

        if (isset($_GET['newpwd'])) {
            if ($_GET['newpwd'] == 'passwordupdated') {
                echo '<p>Your password has been reset!</p>';
            }
        }
        ?>
        
        <!--FORGOT PASSWORD-->

        <br><br>
        <a href="reset-password.php">Forgot your password?</a>

    </div>



</section>

<?php
include_once 'footer.php';
?>