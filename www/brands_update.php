<?php
session_start();

require 'database.php';

// Check if user is logged in and is an administrator
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'administrator') {
    echo "You are not allowed to view this page. Please login as an admin.";
    exit;
}

// Check if all required fields are filled
if (!isset($_POST['brand']) || !isset($_GET['id'])) {
    echo "Please fill in all fields";
    exit;
}

$brand_name = $_POST['brand'];
$brand_id = $_GET['id']; 

$sql = "UPDATE brands
        SET brand_name = :brand_name    
        WHERE brand_id = :brand_id";

$stmt = $conn->prepare($sql);
$stmt->bindParam(':brand_name', $brand_name);
$stmt->bindParam(':brand_id', $brand_id);

if ($stmt->execute()) {
    echo "Brand has been updated";
} else {
    echo "No changes were made";
}
?>

