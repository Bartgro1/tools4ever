<?php

if(!isset($_GET['id'])){
    echo 'er mist een id parameter';
    exit();
}

$id = $_GET['id'];

$sql = "DELETE FROM tools WHERE tool_id = :tool_id";
$stmt = $conn->prepare($sql);
$stmt ->bindParam(":tool_id", $id);
$stmt ->execute();

header("location: tools_index.php");