<?php

session_start();

// Check if user is logged in and is an administrator
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'administrator') {
    echo "You are not allowed to view this page. Please login as an admin.";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo "Invalid request method.";
    exit;
}

// Check if all required fields are filled


$firstname = $_POST['firstname'];
$lastname = $_POST['lastname'];
$email = $_POST['email'];
$password= $_POST['password'];
$address = $_POST['address'];
$city = $_POST['city'];
$role = $_POST['role'];
$id = $_GET['id'];

require 'database.php';

$sql = "UPDATE users
        SET firstname = :firstname,
        lastname = :lastname,
        email = :email,
        password = :password,
        address = :address,
        city = :city,
        role = :role
        WHERE id = :id";


$stmt = $conn->prepare($sql);
$stmt->bindParam(':firstname', $firstname);
$stmt->bindParam(':lastname', $lastname);
$stmt->bindParam(':email', $email);
$stmt->bindParam(':password', $password);
$stmt->bindParam(':address', $address);
$stmt->bindParam(':city', $city);
$stmt->bindParam(':role', $role);
$stmt->bindParam(':id', $id);
$stmt->execute();

if($stmt->execute()) {
  echo "User has been updated";
}