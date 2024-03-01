<?php
session_start();

// Check if user is logged in and is an administrator
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'administrator') {
    echo "You are not allowed to view this page. Please login as an admin.";
    exit;
}

require 'database.php';

// Check if all required fields are filled
if (!isset($_POST['name'], $_POST['category'], $_POST['price'], $_POST['brand'])) {
    echo "Please fill in all fields";
    exit;
}

$tool_name = $_POST['name'];
$tool_category = $_POST['category'];
$tool_price = $_POST['price'];
$tool_brand = $_POST['brand'];
$tool_id = $_GET['id']; // Update variable name to $tool_id

$sql = "UPDATE tools
        SET tool_name = :tool_name,
        tool_category = :tool_category,
        tool_price = :tool_price,
        tool_brand = :tool_brand      
        WHERE tool_id = :tool_id";

$stmt = $conn->prepare($sql);
$stmt->bindParam(':tool_name', $tool_name);
$stmt->bindParam(':tool_category', $tool_category);
$stmt->bindParam(':tool_price', $tool_price);
$stmt->bindParam(':tool_brand', $tool_brand);
$stmt->bindParam(':tool_id', $tool_id);

if ($stmt->execute()) {
    echo "Tool has been updated";
} else {
    echo "No changes were made";
}
?>

