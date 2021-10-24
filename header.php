<?php 
   session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library Database App</title>
</head>

<body>

        <nav>
            <div class='wrapper'>
            <a href='index.php'>Logo</a>
            <ul>
                <li><a href='index.php'>Home</a></li>
                <li>About Us</li>
                
                <?php 
                if (isset($_SESSION['usersUid'])) {
                    echo "<li>Profile page</li>";
                    echo "<li><a href='includes/logout.inc.php'>Log out</a></li>";
                    echo "<li><a href='searchbooks.php'>Search for books</a></li>";
                }
                else {
                    echo "<li><a href='signup.php'>Sign up</a></li>";
                    echo "<li><a href='login.php'>Log in</a></li>";
                }
                ?>
               
                
            </ul>
            </div>
        </nav>

        <div class='wrapper'>