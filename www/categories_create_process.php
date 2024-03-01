<?php

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

$stmt = $conn->prepare("INSERT INTO categories (name)
    VALUES (:name)");

$stmt->bindParam(':name', $name);


$stmt->execute();

if ($stmt->rowCount() > 0) {
    header("Location: categories_index.php");
    exit;
} else {
    echo "Something went wrong";
}