<?php
include_once 'header.php';
?>

<section>
    <?php
    if (isset($_SESSION['usersUid'])) {
        echo "<p>Hello " . $_SESSION['usersUid'] . "</p>";
    }
    ?>

    <h1>Library Search System</h1>

</section>

<?php

//LOGIN FORM

if (!isset($_SESSION['usersUid'])) {
    echo "<p>Log in to search for books.</p>
    <section>
        <h2>Log in</h2>
        <form action='includes/login.inc.php' method='post'>
            <input type='text' name='uid' placeholder='Username/Email...'>
            <input type='password' name='pwd' placeholder='Password...'>
            <button type='submit' name='submit'>Log in</button>
        </form>
    </section>";
    echo "<br><br>
    <a href='reset-password.php'>Forgot your password?</a>
    </section>";
}

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

//SIGN-UP FORM

if (!isset($_SESSION['usersUid'])) {
    echo 
    "<section>
        <h2>Sign Up</h2>
        <form action='includes/signup.inc.php' method='post'>
            <input type='text' name='name' placeholder='Full name...'><br><br>
            <input type='text' name='email' placeholder='Email...'><br><br>
            <input type='text' name='uid' placeholder='Username...'><br><br>
            <input type='password' name='pwd' placeholder='Password...'><br><br>
            <input type='password' name='pwdrepeat' placeholder='Repeat password...'><br><br>
            <button type='submit' name='submit'>Sign Up</button><br>
        </form>
    </section>";
}

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

<?php
include_once 'footer.php';
?>