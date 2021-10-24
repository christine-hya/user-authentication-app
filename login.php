<?php
    include_once 'header.php';
?>

<section class="signup-form">
    <h2>Log in</h2>
    <form action="includes/login.inc.php" method="post">
        <input type="text" name="uid" placeholder="Username/Email...">
        <input type="password" name="pwd" placeholder="Password...">
        <button type="submit" name="submit">Log in</button>
    </form>

   
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