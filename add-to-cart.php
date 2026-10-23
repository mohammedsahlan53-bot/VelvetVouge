<?php
include "db.php";
session_start();


if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}


if (!isset($_POST['product_id']) || !is_numeric($_POST['product_id'])) {
    die("Invalid product ID");
}

$user_id    = $_SESSION['user_id'];
$product_id = (int) $_POST['product_id'];


$stmt = $conn->prepare("SELECT id FROM products WHERE id = ?");
$stmt->execute([$product_id]);
if (!$stmt->fetch()) {
    die("Product not found");
}


$stmt = $conn->prepare("SELECT id FROM carts WHERE user_id = ?");
$stmt->execute([$user_id]);
$cart = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$cart) {
    $stmt = $conn->prepare("INSERT INTO carts (user_id) VALUES (?)");
    $stmt->execute([$user_id]);
    $cart_id = $conn->lastInsertId();
} else {
    $cart_id = $cart['id'];
}


$stmt = $conn->prepare("
    SELECT id 
    FROM cart_items 
    WHERE cart_id = ? AND product_id = ?
");
$stmt->execute([$cart_id, $product_id]);
$item = $stmt->fetch(PDO::FETCH_ASSOC);

if ($item) {
    $stmt = $conn->prepare("
        UPDATE cart_items 
        SET quantity = quantity + 1 
        WHERE id = ?
    ");
    $stmt->execute([$item['id']]);
} else {
    $stmt = $conn->prepare("
        INSERT INTO cart_items (cart_id, product_id, quantity)
        VALUES (?, ?, 1)
    ");
    $stmt->execute([$cart_id, $product_id]);
}


header("Location: cart.php");
exit;
