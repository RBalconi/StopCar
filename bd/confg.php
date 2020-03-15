<?php
$servername = "localhost";
$database = "stopcar";
$username = "root";
$password = "";

try {
  $conn = new PDO('mysql:host='.$servername.';dbname='.$database, $username, $password);
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  // echo 'Success';
} catch(PDOException $e) {
    echo 'ERROR: ' . $e->getMessage();
}