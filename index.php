<?php include "db.php"; include "header.php"; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Velvet Vogue</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>


<section class="hero">
    <div class="hero-content">
        <h1>Discover Your Style</h1>
        <p>Premium fashion for Men, Women & Kids</p>

        <div class="hero-buttons">
            <a href="products.php" class="hero-btn primary">Shop Now</a>
            <a href="men.php" class="hero-btn secondary">Men’s Collection</a>
        </div>
    </div>
</section>

<div class="home-container">
    <h2>Velvet Vogue</h2>



    <div class="featured-grid">
        <?php
        $stmt = $conn->query("SELECT * FROM products LIMIT 6");

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $images = json_decode($row['images'], true);
        ?>
            <div class="product-card">

                <?php if (!empty($images[0])): ?>
                    <img src="uploads/<?= htmlspecialchars($images[0]) ?>" width="100">
                <?php endif; ?>

                <h4 class="product-name"><?= htmlspecialchars($row['name']) ?></h4>

                <p><?= htmlspecialchars($row['category']) ?></p>

                <p class="product-price">Rs. <?= htmlspecialchars($row['price']) ?></p>

                <a class="view-btn" href="product-view.php?id=<?= $row['id'] ?>">
                    View
                </a>
            </div>
        <?php } ?>
    </div>
</div>

<?php include "footer.php"; ?>

</body>
</html>
