<?php
    include_once 'header.php';
?>

<!--LOGIN FORM-->
<section class="signup-form p-4">
    <div class="container text-center w-50">
    <h2 class="mb-2">Log in</h2>
    <form action="includes/login.inc.php" method="post">
        <input class="form-control m-3" type="text" name="uid" placeholder="Username/Email...">
        <input class="form-control m-3" type="password" name="pwd" placeholder="Password...">
        <button class="btn btn-primary" type="submit" name="submit">Log in</button>
    </form>
    </div>
   
    <?php 
     
     // DISPLAY LOGIN ERROR MESSAGES
     
        if (isset($_GET['error'])) {
            if ($_GET['error'] == "emptyinput") {
                echo '<p>Please fill in all fields.</p>';
            }

            else if ($_GET['error'] == "wronglogin") {
                echo '<p>Incorrect username or password.</p>';
            }
        }
     
        if (isset($_GET['newpwd'])) {
            if($_GET['newpwd'] == 'passwordupdated') {
                echo '<p>Your password has been reset!</p>';
            }
        }
?>

<!--FORGOT PASSWORD-->

<br><br>
<a href="reset-password.php">Forgot your password?</a>
</section>

<?php
    include_once 'footer.php';
?>