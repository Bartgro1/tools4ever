<?php

//database connection 
$dbhost = "mariadb";
$dbuser = "root";
$dbpass = "password";
$dbname = "tools4ever";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // 
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}?>




