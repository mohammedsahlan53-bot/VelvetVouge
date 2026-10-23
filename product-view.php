<?php
include "db.php";
include "header.php";

$id = $_GET['id'];

$stmt = $conn->prepare("SELECT * FROM products WHERE id=:id");
$stmt->execute(['id'=>$id]);
$p = $stmt->fetch(PDO::FETCH_ASSOC);

$images = json_decode($p['images'], true);
$colors = json_decode($p['colors'], true);
$sizes  = json_decode($p['sizes'], true);
?>

<style>
.product-wrapper {
    max-width: 1100px;
    margin: 50px auto;
    display: flex;
    gap: 50px;
    padding: 20px;
    font-family: Arial, sans-serif;
}

.product-images {
    flex: 1;
}

.product-images img {
    width: 100%;
    max-width: 350px;
    border-radius: 12px;
    margin-bottom: 15px;
    border: 1px solid #ddd;
    transition: 0.3s ease;
}

.product-images img:hover {
    transform: scale(1.05);
}

.product-info {
    flex: 1;
}

.product-info h2 {
    font-size: 30px;
    margin-bottom: 15px;
}

.product-info p {
    font-size: 16px;
    margin: 8px 0;
}

.price {
    font-size: 24px;
    font-weight: bold;
    color: #e63946;
    margin: 15px 0;
}

.option-box {
    margin: 10px 0;
}

select, input[type="number"] {
    padding: 8px;
    width: 150px;
    border-radius: 6px;
    border: 1px solid #ccc;
}

.add-btn {
    margin-top: 20px;
    padding: 12px 30px;
    background: #2a9d8f;
    color: white;
    border: none;
    border-radius: 8px;
    font-size: 16px;
    cursor: pointer;
    transition: 0.3s;
}

.add-btn:hover {
    background: #21867a;
}


@media(max-width: 768px) {
    .product-wrapper {
        flex-direction: column;
        text-align: center;
    }

    .product-images img {
        max-width: 100%;
    }
}
</style>

<div class="product-wrapper">

    <div class="product-images">
        <?php foreach ($images as $img): ?>
            <img src="uploads/<?= $img ?>">
        <?php endforeach; ?>
    </div>

    <div class="product-info">
        <h2><?= $p['name'] ?></h2>
        <p>Category: <?= $p['category'] ?></p>
        <p class="price">Rs. <?= $p['price'] ?></p>

        <form method="POST" action="add-to-cart.php">
            <input type="hidden" name="product_id" value="<?= $p['id'] ?>">

            <?php if(!empty($colors)): ?>
            <div class="option-box">
                <label>Select Color:</label><br>
                <select name="color">
                    <?php foreach($colors as $color): ?>
                        <option value="<?= $color ?>"><?= $color ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <?php endif; ?>

            <?php if(!empty($sizes)): ?>
            <div class="option-box">
                <label>Select Size:</label><br>
                <select name="size">
                    <?php foreach($sizes as $size): ?>
                        <option value="<?= $size ?>"><?= $size ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <?php endif; ?>

            <div class="option-box">
                <label>Quantity:</label><br>
                <input type="number" name="qty" value="1" min="1">
            </div>

            <button type="submit" class="add-btn">Add to Cart</button>
        </form>
    </div>

</div>

<?php include "footer.php"; ?>
