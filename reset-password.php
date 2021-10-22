<?php
include_once 'header.php';
?>

<section class="signup-form">
    <h2>Reset your password</h2>
    <p>An e-mail will be sent to you to reset your password.</p>

    <form action="includes/reset-request.inc.php" method="post">
        <input type="text" name="email" placeholder="Enter your email address.">
        <button type="submit" name="reset-request-submit">Reset password</button>
    </form>
    <?php
    if (isset($_GET["reset"])) {
        if ($_GET['reset'] == "success") {
            echo '<p>Check your email!</p>';
        }
    }
    ?>
</section>

<?php
include_once 'footer.php';
?>