<?php
include_once 'header.php';
?>

<section class="signup-form">

    <?php
    $selector = $_GET["selector"];
    $validator = $_GET["validator"];

    if (empty($selector) || empty($validator)) {
        echo "Could not validate your request!";
    } else {
        if (ctype_xdigit($selector) !== false && ctype_xdigit($validator) !== false) {
    ?>
            <form action="includes/reset-password.inc" method="post">
                <input type="hidden" name="selector" value="<?php echo $selector; ?> ">
                <input type="hidden" name="validator" value="<?php echo $validator; ?> ">
                <input type="password" name="pwd" value="Enter a new password">
                <input type="password" name="pwd-repeat" value="Repeat a new password">
                <button type="submit" name="reset-password-submit">Reset password</button>

            </form>
    <?php
        }
    }
    ?>

</section>

<?php
include_once 'footer.php';
?>