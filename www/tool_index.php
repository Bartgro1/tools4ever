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

$stmt = $conn->prepare("SELECT *, tools.tool_name, categories.name AS category_name, tools.tool_price, brands.brand_name as brand_name 
                       FROM tools 
                       JOIN categories ON tools.tool_category = categories.category_id 
                       JOIN brands ON tools.tool_brand = brands.brand_id");

$stmt->execute();
// set the resulting array to associative
$tools = $stmt->fetchall(PDO::FETCH_ASSOC);

require 'header.php';
?>
<main>
    <table>
        <thead>
            <tr>
                <th>Naam</th>
                <th>Categorie</th>
                <th>Prijs</th>
                <th>Merk</th>
                <th>Acties</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($tools as $tool) : ?>
                <tr>
                    <td><?php echo $tool['tool_name'] ?></td>
                    <td><?php echo $tool['category_name'] ?></td>
                    <td><?php echo $tool['tool_price'] ?></td>
                    <td><?php echo $tool['brand_name'] ?></td>
                    <td>
                        <a href="tool_detail.php?id=<?php echo $tool['tool_id'] ?>">Bekijk</a>
                        <a href="tool_edit.php?id=<?php echo $tool['tool_id'] ?>">Wijzig</a>
                        <a href="tool_delete.php?id=<?php echo $tool['tool_id'] ?>">Verwijder</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</main>
<?php require 'footer.php' ?>