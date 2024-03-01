<?php
session_start();

// Check if user is logged in and is an administrator
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'administrator') {
    echo "You are not allowed to view this page. Please login as an admin.";
    exit;
}

require 'database.php';

// Check if all required fields are filled
if (!isset($_POST['category'])) {
    echo "Please fill in all fields";
    exit;
}

$category_name = $_POST['category'];
$category_id = $_GET['id']; 

$sql = "UPDATE categories
        SET name = :category_name    
        WHERE category_id = :category_id";

$stmt = $conn->prepare($sql);
$stmt->bindParam(':category_name', $category_name);
$stmt->bindParam(':category_id', $category_id); // Binding category_id

if ($stmt->execute()) {
    echo "Category has been updated";
} else {
    echo "No changes were made";
}
?>

