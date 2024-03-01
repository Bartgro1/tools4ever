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

$stmt = $conn->prepare("SELECT * FROM categories");
$stmt->execute();
// set the resulting array to associative
$categories = $stmt->fetchall(PDO::FETCH_ASSOC);

require 'header.php';
?>
<main>
    <table>
        <thead>
            <tr>
                <th>name</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($categories as $category) : ?>
                <tr>
                    <td><?php echo $category['name'] ?></td>

                    <td>
                        <a href="categories_detail.php?id=<?php echo $category['category_id'] ?>">Bekijk</a>
                        <a href="categories_edit.php?id=<?php echo $category['category_id'] ?>">Wijzig</a>
                        <a href="categories_delete.php?id=<?php echo $category['category_id'] ?>">Verwijder</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</main>
<?php require 'footer.php' ?>