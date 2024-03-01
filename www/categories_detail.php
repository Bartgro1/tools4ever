<?php
session_start();

require 'database.php';

if (isset($_GET['id'])) {
    $category_id = $_GET['id'];

    
  $stmt = $conn->prepare("SELECT * FROM categories WHERE category_id = :category_id");
  $stmt->bindParam(':category_id', $category_id);
  $stmt->execute();
  $category = $stmt->fetch(PDO::FETCH_ASSOC);
    
}
require 'header.php';
?>

<main>
    <div class="container">
        <?php if (isset($category)) : ?>
            <div class="product-detail">
                <div class="row">
                    <div class="col">
                        <h3><?php echo $category['name'] ?></h3>
                    </div>
                </div>

            </div>
        <?php else : ?>
            <p>Tool not found.</p>
        <?php endif; ?>
    </div>
</main>
<?php require 'footer.php' ?>