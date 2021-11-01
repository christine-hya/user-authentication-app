<div class="header">
    <?php
    include_once 'header.php';
    ?>
</div>

<?php
if (isset($_SESSION['usersUid'])) {
    echo "<div class='m-5 p-5'><p>Hello " . $_SESSION['usersUid'] . "</p></div>";
}
?>

<h2 class="m-5">Library Search System</h2>

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