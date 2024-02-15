<?php

session_start();

// Check if user is logged in and is an administrator
$tool_name = $_POST['tool_name'];
$tool_category = $_POST['tool_category'];
$tool_price = $_POST['tool_price'];
$tool_brand = $_POST['tool_brand'];
$tool_id = $_GET['id']; // Update variable name to $tool_id

// Check if all required fields are filled

require 'database.php';

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
$stmt->execute();

if (execute()) {
    echo "Tool has been updated";
} else {
    echo "No changes were made";
}
