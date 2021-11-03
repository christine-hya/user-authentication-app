<?php

$serverName = "sql4.freesqldatabase.com";
$dBUsername = "sql4448737";
$dBPassword = "CY4ctRvJqH";
$dBName = "sql4448737";

// $serverName = "localhost";
// $dBUsername = "root";
// $dBPassword = "root";
// $dBName = "library";

$conn = mysqli_connect($serverName, $dBUsername, $dBPassword, $dBName);

if(!$conn) {
    die("Connection failed: " . mysqli_connect_error()); 
}





