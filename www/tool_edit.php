<?php

session_start();

require 'database.php';

if (!isset($_SESSION['user_id'])) {
    echo "You are not logged in, please login. ";
    echo "<a href='login.php'>Login here</a>";
    exit;
}

if ($_SESSION['role'] != 'administrator') {
    echo "You are not allowed to view this page, please login as admin";
    exit;
}

if (isset($_GET['id'])) {
    $tool_id = $_GET['id'];

// Prepare the SQL statement
$sql = "SELECT * FROM tools WHERE tool_id = :tool_id";
$stmt = $conn->prepare($sql);

// Bind the parameter
$stmt->bindParam(":tool_id", $tool_id);

// Execute the statement
if($stmt->execute()) {
    if($stmt->rowCount() > 0)
       $tool = $stmt->fetch(PDO::FETCH_ASSOC);
        // Process the retrieved data (if needed)
    } else {
        // No tool found with the given ID
        echo "No tool found with this ID <br>";
        echo "<a href='tool_index.php'>Go back</a>";
    }
}
require 'header.php';
?>

<main>
    <h1>Gereedschap Wijzigen</h1>
    <div class="container">
        <form action="tool_update.php?id=<?php echo $tool['tool_id'] ?>" method="POST">
            <div>
                <label for="name">Naam:</label>
                <input type="text" id="name" name="name" value="<?php echo $tool['tool_name'] ?>">
            </div>
            <div>
                <label for="category">Categorie:</label>
                <input type="text" id="category" name="category" value="<?php echo $tool['tool_category'] ?>">
            </div>
            <div>
                <label for="price">Prijs:</label>
                <input type="number" id="price" name="price" value="<?php echo $tool['tool_price'] ?>">
            </div>
            <div>
                <label for="brand">Merk:</label>
                <input type="brand" id="brand" name="brand" value="<?php echo $tool['tool_brand'] ?>">
            </div>
            <div>
                <label for="image">Afbeelding:</label>
                <input type="text" id="image" name="image">
            </div>
            <button type="submit" class="btn btn-success">Toevoegen</button>
        </form>
    </div>
</main>
<?php require 'footer.php' ?>