<?php

require_once 'includes/dbh.inc.PHP';
include_once 'header.php';
@session_start();
?>

<div class="container">
    <div class="row">
        
        <div class="col-sm-2 mt-5 pt-5">

            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link active text-light" aria-current="page" href="admin/create.php">Add</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-light" href="admin/update.php">Edit</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link text-light" href="admin/delete.php">Delete</a>
                </li>
            </ul>

        </div>

        <div class="col-sm-10">
            <?php require "searchbooks.php"; ?>
        </div>

    </div>
</div>

<?php include "footer.php"; ?>
</body>

</html>