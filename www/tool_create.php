<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    echo "You are not logged in, please login. ";
    echo "<a href='login.php'>Login here</a>";
    exit;
}

if ($_SESSION['role'] != 'administrator') {
    echo "You are not allowed to view this page, please login as admin";
    exit;
}

require 'database.php';

$sql = "SELECT * FROM categories";
$stmt = $conn->prepare($sql);
$stmt->execute();
$categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

$sql = "SELECT * FROM brands";
$stmt = $conn->prepare($sql);
$stmt->execute();
$brands = $stmt->fetchAll(PDO::FETCH_ASSOC);

require 'header.php';
?>

<main>
    <h1>Nieuw Gereedschap</h1>
    <div class="container">
        <form action="tool_create_process.php" method="post" enctype="multipart/form-data">
            <div>
                <label for="name">Naam:</label>
                <input type="text" id="name" name="name">
            </div>
            <div>
                <label for="category">Categorie:</label>
                <select name="category" id="category">
                    <?php foreach($categories as $category):?>
                        <option value="<?php echo $category['category_id']; ?>"><?php echo $category['name']; ?></option>
                     <?php endforeach ?>
                </select>
            </div>
            <div>
                <label for="price">Prijs:</label>
                <input type="number" id="price" name="price">
            </div>
            <div>
            <label for="brand">merk:</label>
                <select name="brand" id="brand">
                    <?php foreach($brands as $brand):?>
                        <option value="<?php echo $brand ['brand_id']; ?>"><?php echo $brand['brand_name']; ?></option>
                     <?php endforeach ?>
                </select>

            </div>
            <div>
                <label for="image">Afbeelding:</label>
                <input type="file" name="image" id="image">
            </div>
            <button type="submit" name="submit" class="btn btn-success">Toevoegen</button>
        </form>
    </div>
</main>
<?php require 'footer.php' ?>