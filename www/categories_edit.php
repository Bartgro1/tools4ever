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
    $category_id = $_GET['id'];

    // Prepare the SQL statement
    $sql = "SELECT * FROM categories WHERE category_id = :category_id";
    $stmt = $conn->prepare($sql);
    

    // Bind the parameter
    $stmt->bindParam(":category_id", $category_id);

    // Execute the statement
    if ($stmt->execute()) {
        if ($stmt->rowCount() > 0) {
            $category = $stmt->fetch(PDO::FETCH_ASSOC);
            // Process the retrieved data (if needed)
        } else {
            // No category found with the given ID
            echo "No category found with this ID <br>";
            echo "<a href='tool_index.php'>Go back</a>";
            exit; // You may want to exit here to prevent further execution
        }
    } else {
        // Error in executing SQL statement
        echo "Error executing SQL statement";
        exit; // You may want to exit here to prevent further execution
    }
}

require 'header.php';
?>

<main>
    <h1>Gereedschap Wijzigen</h1>
    <div class="container">
        <form action="categories_update.php?id=<?php echo $category_id ?>" method="POST">
            <div>
                <label for="category">Categorie:</label>
                <input type="text" id="category" name="category" value="<?php echo $category['name'] ?>">
            </div>
          
            <button type="submit" class="btn btn-success">Bewerken</button>
        </form>
    </div>
</main>

<?php require 'footer.php' ?>
