<?php
include "db.php";
include "header.php";


if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];


$stmt = $conn->prepare("SELECT id FROM carts WHERE user_id = ?");
$stmt->execute([$user_id]);
$cart = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$cart) {
    echo "<div style='padding:30px'><h2>Your cart is empty</h2></div>";
    include "footer.php";
    exit;
}

$cart_id = $cart['id'];


$stmt = $conn->prepare("
    SELECT 
        ci.id AS cart_item_id,
        p.name,
        p.price,
        ci.quantity
    FROM cart_items ci
    JOIN products p ON ci.product_id = p.id
    WHERE ci.cart_id = ?
");
$stmt->execute([$cart_id]);
$items = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div style="padding:30px;">
<h2>Your Cart</h2>

<?php if (empty($items)): ?>
    <p>Your cart is empty</p>
<?php else: ?>

<table border="1" cellpadding="10" cellspacing="0" width="100%">
<tr>
    <th>Product</th>
    <th>Price</th>
    <th>Qty</th>
    <th>Subtotal</th>
    <th>Action</th>
</tr>

<?php
$grandTotal = 0;
foreach ($items as $item):
    $subtotal = $item['price'] * $item['quantity'];
    $grandTotal += $subtotal;
?>
<tr>
    <td><?= htmlspecialchars($item['name']) ?></td>
    <td>Rs. <?= number_format($item['price'], 2) ?></td>
    <td><?= $item['quantity'] ?></td>
    <td>Rs. <?= number_format($subtotal, 2) ?></td>
    <td>
        <a href="remove-cart-item.php?id=<?= $item['cart_item_id'] ?>"
           onclick="return confirm('Remove item?')">
           Remove
        </a>
    </td>
</tr>
<?php endforeach; ?>

<tr>
    <td colspan="3"><strong>Grand Total</strong></td>
    <td colspan="2"><strong>Rs. <?= number_format($grandTotal, 2) ?></strong></td>
</tr>
</table>

<br>
<button>Proceed to Checkout</button>

<?php endif; ?>
</div>

<?php include "footer.php"; ?>
