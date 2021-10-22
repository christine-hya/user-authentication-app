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
    <p>Here is a paragraph that explains what we do.</p>
</section>


<?php
include_once 'footer.php';
?>