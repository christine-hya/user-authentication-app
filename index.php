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

require_once "login.php";
require_once "signup.php";
}

//SIGN-UP FORM

?>

<?php
include_once 'footer.php';
?>