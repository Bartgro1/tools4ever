<?php
session_start();

require 'database.php';

if (isset($_GET['id'])) {
    $brand_id = $_GET['id'];

    
  $stmt = $conn->prepare("SELECT * FROM brands WHERE brand_id = :brand_id");
  $stmt->bindParam(':brand_id', $brand_id);
  $stmt->execute();
  $brand = $stmt->fetch(PDO::FETCH_ASSOC);
    
}
require 'header.php';
?>

<main>
    <div class="container">
        <?php if (isset($brand)) : ?>
            <div class="product-detail">
                <div class="row">
                    <div class="col">
                        <h3><?php echo $brand['brand_name'] ?></h3>
                    </div>
                </div>
            </div>
        <?php else : ?>
            <p>brand not found.</p>
        <?php endif; ?>
    </div>
</main>
<?php require 'footer.php' ?>