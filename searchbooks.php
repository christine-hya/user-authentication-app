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

<section>
    <h2>Some Basic Categories</h2>
    <div>
        <h3>Fun Stuff</h3>
    </div>
    <div>
        <h3>Serious Stuff</h3>
    </div>
    <div>
        <h3>Exciting Stuff</h3>
    </div>
    <div>
        <h3>Boring Stuff</h3>
    </div>
</section>

<?php
include_once 'footer.php';
?>