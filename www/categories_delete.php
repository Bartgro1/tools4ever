<?php

require 'database.php'; // Include the file that contains the database connection

if (!isset($_GET['id'])) {
    echo 'er mist een id parameter';
    exit();
}

$id = $_GET['id'];

$sql = "SELECT * FROM categories WHERE category_id = :id";
$stmt = $conn->prepare($sql);
$stmt->bindParam(":id", $id);
$stmt->execute();

if ($stmt->rowCount() > 0) {
    $sql = "DELETE FROM categories WHERE category_id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(":id", $id);

    if ($stmt->execute()) {
        echo "categorie is eindelijk verwijderd!!!";
    } else {
        echo "Er is een fout opgetreden bij het verwijderen van de categorie.";
    }
} else {
    echo "De opgegeven categorie bestaat niet.";
}
?>
