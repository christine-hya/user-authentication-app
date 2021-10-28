<?php
    include_once 'header.php';
?>

<!--DISPLAY SIGN-UP FORM-->

<section>
    <div class="container text-center w-50 p-4">
    <h2 class="mb-3">Sign Up</h2>
    <form action="includes/signup.inc.php" method="post">
        <input class="form-control m-1" type="text" name="name" placeholder="Full name..."><br><br>
        <input class="form-control m-1" type="text" name="email" placeholder="Email..."><br><br>
        <input class="form-control m-1" type="text" name="uid" placeholder="Username..."><br><br>
        <input class="form-control m-1" type="password" name="pwd" placeholder="Password..."><br><br>
        <input class="form-control m-1" type="password" name="pwdrepeat" placeholder="Repeat password..."><br><br>
        <button class="btn btn-primary" type="submit" name="submit">Sign Up</button><br>
    </form>
    </div>

    <?php 

    //DISPLAY ERROR MESSAGES FOR SIGNUP
    
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
 


<?php
    include_once 'footer.php';
?>