<?php

require 'database.php'; // Include the file that contains the database connection

if (!isset($_GET['id'])) {
    echo 'er mist een id parameter';
    exit();
}

if (isset($_GET['id'])) {
    $tool_id = $_GET['id'];

$sql = "SELECT * FROM tools WHERE tool_id = :tool_id"; // Corrected the placeholder name to :tool_id
$stmt = $conn->prepare($sql);
$stmt->bindParam(":tool_id", $tool_id); // Corrected the parameter name here
$stmt->execute();

if ($stmt->rowCount() > 0) {
    $sql = "DELETE FROM tools WHERE tool_id = :tool_id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(":tool_id", $tool_id);
    if ($stmt->execute()) {
        echo "tool is verwijderd";
    }
  }
}
?>