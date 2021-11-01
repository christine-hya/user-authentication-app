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
  <link rel="icon" href="assets/book-favicon.png" type="image/x-icon">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Zen+Antique+Soft&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.13.0/css/all.css">
  <link rel="stylesheet" href="css/stylesheet.css">
</head>

<body>
  <nav class="navbar navbar-expand-lg navbar-dark header m-3 mt-0">
    <div class="container-fluid">

      <?php
      if (!isset($_SESSION['usersUid'])) {
        echo "<a class='nav-item' href='index.php'>Home</a>";
      }

      ?>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
          <?php
          if ($_GET['userType'] == 'member' && isset($_SESSION['usersUid'])) {
            echo "<li class='nav-item'>
          <a class='nav-link active' aria-current='page' href='searchbooks.php?userType=member'>Home</a>
        </li>";
          }
          if ($_GET['userType'] == 'admin' && isset($_SESSION['usersUid'])) {
            echo "<li class='nav-item'>
          <a class='nav-link active' aria-current='page' href='searchbooks.php?userType=admin'>Home</a>
        </li>";
          }
          ?>
          <?php
          if (isset($_SESSION['usersUid'])) {
            echo "<li class='nav-item'><a class='nav-link text-light' href='includes/logout.inc.php'>Log out</a></li>";
          } else {
            echo "<li class='nav-item'><a class='nav-link text-light' href='signup.php'>Sign up</a></li>";
            echo "<li class='nav-item'><a class='nav-link text-light' href='login.php'>Log in</a></li>";
          }
          ?>
          <li class='nav-item'><a class='nav-link text-light' href='#search'>Search</a></li>

        </ul>
      </div>
    </div>


  </nav>