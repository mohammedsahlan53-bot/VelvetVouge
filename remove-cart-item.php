<?php
include "db.php";
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("Invalid request");
}

$cart_item_id = (int) $_GET['id'];

/* 🗑 Remove item */
$stmt = $conn->prepare("DELETE FROM cart_items WHERE id = ?");
$stmt->execute([$cart_item_id]);

header("Location: cart.php");
exit;
