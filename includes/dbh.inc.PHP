<?php

// $serverName = "sql106.epizy.com";
// $dBUsername = "epiz_30249027";
// $dBPassword = "xVyQLL7J";
// $dBName = "epiz_30249027_library";

$serverName = "localhost";
$dBUsername = "root";
$dBPassword = "root";
$dBName = "library";

$conn = mysqli_connect($serverName, $dBUsername, $dBPassword, $dBName);

if(!$conn) {
    die("Connection failed: " . mysqli_connect_error()); 
}





