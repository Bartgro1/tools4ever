<?php

//database connection 
$dbhost = "mariadb";
$dbuser = "root";
$dbpass = "password";
$dbname = "tools4ever";

try {
    $conn = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass);
    // 
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}?>




