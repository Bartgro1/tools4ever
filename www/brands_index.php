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

$stmt = $conn->prepare("SELECT * FROM brands");
$stmt->execute();
// set the resulting array to associative
$brands = $stmt->fetchall(PDO::FETCH_ASSOC);

require 'header.php';
?>
<main>
    <table>
        <thead>
            <tr>
                <th>Naam</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($brands as $brand) : ?>
                <tr>

                    <td><?php echo $brand['brand_name'] ?></td>
                    <td>
                        <a href="brands_detail.php?id=<?php echo $brand['brand_id'] ?>">Bekijk</a>
                        <a href="brands_edit.php?id=<?php echo $brand['brand_id'] ?>">Wijzig</a>
                        <a href="brands_delete.php?id=<?php echo $brand['brand_id'] ?>">Verwijder</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</main>
<?php require 'footer.php' ?>