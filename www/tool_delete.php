<?php

require 'database.php'; // Include the file that contains the database connection

if (!isset($_GET['id'])) {
    echo 'er mist een id parameter';
    exit();
}

$tool_id = $_GET['id']; // Moved outside of the if statement for better scope

$sql = "SELECT * FROM tools WHERE tool_id = :tool_id"; // Corrected the placeholder name to :tool_id
$stmt = $conn->prepare($sql);
$stmt->bindParam(":tool_id", $tool_id); 
$stmt->execute();

if ($stmt->rowCount() > 0) {
    $deleteSql = "DELETE FROM tools WHERE tool_id = :tool_id"; // Changed variable name to avoid confusion
    $deleteStmt = $conn->prepare($deleteSql);
    $deleteStmt->bindParam(":tool_id", $tool_id);
    
    if ($deleteStmt->execute()) {
        echo "tool is verwijderd";
    } else {
        echo "Er is een fout opgetreden bij het verwijderen van de tool."; // Error message if deletion fails
    }
} else {
    echo "De opgegeven tool bestaat niet."; // Error message if tool is not found
}

?>
