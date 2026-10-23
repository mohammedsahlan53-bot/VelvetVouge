<?php include "../db.php"; ?>

<h2>Manage Products</h2>
<a href="create.php">Add Product</a><br><br>

<?php
$stmt = $conn->query("SELECT * FROM products");

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    echo "{$row['name']} ({$row['category']})";
    echo " | <a href='edit.php?id={$row['id']}'>Edit</a>";
    echo " | <a href='delete.php?id={$row['id']}'
           onclick='return confirm(\"Delete?\")'>Delete</a><hr>";
}
?>
