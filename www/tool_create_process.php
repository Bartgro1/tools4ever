<?php
ob_start(); 

session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

if ($_SESSION['role'] != 'administrator') {
    echo "You are not allowed to view this page, please login as admin";
    exit;
}

// Check request method
if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    echo "You are not allowed to view this page";
    exit;
}

require 'database.php';

$name = $_POST['name'];
$category_name = $_POST['category']; // Assuming this is the category name you want to insert
$price = $_POST['price'];
$brand = $_POST['brand'];

// Include file upload handling logic
include 'tool_create_file_upload.php';

$stmt = $conn->prepare("INSERT INTO tools (tool_name, tool_category, tool_price, tool_brand, tool_image)
    VALUES (:name, :category_name, :price, :brand, :image)");

$stmt->bindParam(':name', $name);
$stmt->bindParam(':category_name', $category_name); 
$stmt->bindParam(':price', $price);
$stmt->bindParam(':brand', $brand);
$stmt->bindParam(':image', $target_file); 

$stmt->execute();

if ($stmt->rowCount() > 0) {
    header("Location: tool_index.php");
    exit;
} else {
    echo "Something went wrong";
}

ob_end_flush(); 
?>

