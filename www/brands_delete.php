<?php

require 'database.php'; // Include the file that contains the database connection

if (!isset($_GET['id'])) {
    echo 'er mist een id parameter';
    exit();
}

$brand_id = $_GET['id']; // Moved outside of the if statement for better scope

$sql = "SELECT * FROM brands WHERE brand_id = :brand_id"; // Corrected the placeholder name to :category_id
$stmt = $conn->prepare($sql);
$stmt->bindParam(":brand_id", $brand_id); 
$stmt->execute();

if ($stmt->rowCount() > 0) {
    $deleteSql = "DELETE FROM brands WHERE brand_id = :brand_id"; // Changed variable name to avoid confusion
    $deleteStmt = $conn->prepare($deleteSql);
    $deleteStmt->bindParam(":brand_id", $brand_id);
    
    if ($deleteStmt->execute()) {
        echo "categorie is verwijderd"; // Adjusted the success message to plural form
    } else {
        echo "Er is een fout opgetreden bij het verwijderen van de categorie."; // Error message if deletion fails
    }
} else {
    echo "De opgegeven categorie bestaat niet."; // Error message if category is not found
}

?>
