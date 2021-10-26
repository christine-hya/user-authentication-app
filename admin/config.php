<?php

/**
  * Configuration for database connection
  *
  */

$host       = "localhost";
$username   = "root";
$password   = "root";
$dbname     = "library";
$dsn        = "mysql:host=$host;dbname=$dbname";
$options    = array(
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
              );

              try{
                $conn = new PDO("mysql:host=$host;dbname=$dbname",$dsn,$options);
              
              }catch(PDOException $err){
                echo "Database connection problem. ". $err->getMessage();
                exit();
              }