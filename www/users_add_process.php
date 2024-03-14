<?php

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

session_start();
require 'database.php';

$errors = [];

// Check if user is logged in as administrator
if (!isset($_SESSION['user_id'])) {
    $errors[] = "You are not logged in, please login.";
}

if ($_SESSION['role'] != 'administrator') {
    $errors[] = "You are not allowed to view this page, please login as admin";
}

// Check if the form was submitted with the POST method
if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    $errors[] = "You are not allowed to view this page";
}

// Check if all required fields are filled in
$required_fields = ['firstname', 'lastname', 'email', 'role', 'address', 'city', 'backgroundColor', 'font'];
foreach ($required_fields as $field) {
    if (empty($_POST[$field])) {
        $errors[] = "Please fill in all fields";
        break; // Stop checking further fields if one is found empty
    }
}

// Validate email
$email = test_input($_POST["email"]);
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = "Invalid email format";
}

// Validate firstname and lastname
foreach (['firstname', 'lastname'] as $nameField) {
    if (!preg_match("/^[a-zA-Z-' ]*$/", $_POST[$nameField])) {
        $errors[] = "Only letters and white space allowed for " . ($nameField == 'firstname' ? 'voornaam' : 'achternaam');
    }
}

if (empty($errors)) {
    // Check if user already exists
    $stmt = $conn->prepare("SELECT COUNT(*) FROM users WHERE email = :email OR (firstname = :firstname AND lastname = :lastname)");
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':firstname', $_POST['firstname']);
    $stmt->bindParam(':lastname', $_POST['lastname']);
    $stmt->execute();
    $count = $stmt->fetchColumn();

    if ($count > 0) {
        $errors[] = "User with the same email or firstname and lastname combination already exists";
    } else {
        // Continue with inserting data to database
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $role = $_POST['role'];
        $address = $_POST['address'];
        $city = $_POST['city'];
        $is_active = 1;

        $stmt = $conn->prepare("INSERT INTO users (email, password, firstname, lastname, role, address, city, is_active)
                                VALUES (:email, :password, :firstname, :lastname, :role, :address, :city, :is_active)");

        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $password);
        $stmt->bindParam(':firstname', $_POST['firstname']);
        $stmt->bindParam(':lastname', $_POST['lastname']);
        $stmt->bindParam(':role', $role);
        $stmt->bindParam(':address', $address);
        $stmt->bindParam(':city', $city);
        $stmt->bindParam(':is_active', $is_active);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $user_id = $conn->lastInsertId();
            $backgroundColor = $_POST['backgroundColor'];
            $font = $_POST['font'];
            
            $stmt2 = $conn->prepare("INSERT INTO user_settings (user_id, backgroundColor, font)
                                    VALUES (:user_id, :backgroundColor, :font)");
            $stmt2->bindParam(':user_id', $user_id);
            $stmt2->bindParam(':backgroundColor', $backgroundColor);
            $stmt2->bindParam(':font', $font);
            $stmt2->execute();

            if ($stmt2->rowCount() > 0) {
                header("Location: users_index.php");
                exit; // Always exit after a header redirect
            } else {
                echo "Something went wrong";
            }
        } else {
            echo "Something went wrong";
        }
    }
}

// If there are any errors, display them
if (!empty($errors)) {
    foreach ($errors as $error) {
        echo $error . "<br>";
    }
    exit; // Exit script if there are errors
}
?>

