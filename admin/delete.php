<?php
include "../db.php";

$id = $_GET['id'];

$conn->prepare("DELETE FROM products WHERE id=?")->execute([$id]);
header("Location: dashboard.php");
exit;

?>