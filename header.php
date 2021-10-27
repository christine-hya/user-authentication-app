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
    <link rel="icon" href="#" type="image/x-icon">
    <link rel="stylesheet" href="css/stylesheet.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Zen+Antique+Soft&display=swap" rel="stylesheet">
     <!-- Bootstrap CSS -->
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous"> -->
</head>

<body>
<nav>
            <div>
            <a href='index.php'>Logo</a>
            <ul>
                <li><a href='index.php'>Home</a></li>
                <li>About</li>
                
                <?php 
                if (isset($_SESSION['usersUid'])) {
                    echo "<li><a href='includes/logout.inc.php'>Log out</a></li>";
                    echo "<li><a href='searchbooks.php'>Search</a></li>";
                }
                else {
                    echo "<li><a href='signup.php'>Sign up</a></li>";
                    echo "<li><a href='login.php'>Log in</a></li>";
                }
                ?>
               
                
            </ul>
            </div>
        </nav>

       