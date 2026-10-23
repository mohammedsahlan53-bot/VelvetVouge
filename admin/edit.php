<?php
include "../db.php";

$id = $_GET['id'];

$stmt = $conn->prepare("SELECT * FROM products WHERE id=:id");
$stmt->execute(['id'=>$id]);
$product = $stmt->fetch(PDO::FETCH_ASSOC);

$existingImages = json_decode($product['images'], true);
$existingColors = json_decode($product['colors'], true);
$existingSizes  = json_decode($product['sizes'], true);

if (isset($_POST['update'])) {

    $category = $_POST['category'];
    $name     = $_POST['name'];
    $price    = $_POST['price'];
    $stock    = $_POST['stock'];

    $colors = json_encode($_POST['colors'] ?? []);
    $sizes  = json_encode($_POST['sizes'] ?? []);

    // Image update logic
    if (!empty($_FILES['images']['name'][0])) {

        $newImages = [];
        foreach ($_FILES['images']['name'] as $key => $img) {
            $tmp = $_FILES['images']['tmp_name'][$key];
            $newName = time() . "_" . $img;
            move_uploaded_file($tmp, "../uploads/" . $newName);
            $newImages[] = $newName;
        }

        $images = json_encode($newImages);
    } else {
        $images = json_encode($existingImages);
    }

    $stmt = $conn->prepare("
        UPDATE products SET
        category=:category,
        name=:name,
        price=:price,
        images=:images,
        colors=:colors,
        sizes=:sizes,
        stock=:stock
        WHERE id=:id
    ");

    $stmt->execute([
        'category'=>$category,
        'name'=>$name,
        'price'=>$price,
        'images'=>$images,
        'colors'=>$colors,
        'sizes'=>$sizes,
        'stock'=>$stock,
        'id'=>$id
    ]);

    header("Location: dashboard.php");
}
?>

<h2>Edit Product</h2>

<form method="POST" enctype="multipart/form-data">

    Category:
    <select name="category">
        <option <?= $product['category']=='Men'?'selected':'' ?>>Men</option>
        <option <?= $product['category']=='Women'?'selected':'' ?>>Women</option>
        <option <?= $product['category']=='Kids'?'selected':'' ?>>Kids</option>
}  </select><br><br>
                      
}

    Name:
    <input type="text" name="name" value="<?= $product['name'] ?>"><br><br>

    Price:
    <input type="number" step="0.01" name="price" value="<?= $product['price'] ?>"><br><br>

    Sizes:
    <?php foreach (['S','M','L','XL'] as $s): ?>
        <input type="checkbox" name="sizes[]" value="<?= $s ?>"
        <?= in_array($s,$existingSizes)?'checked':'' ?>><?= $s ?>
    <?php endforeach; ?>
    <br><br>

    Colors:
    <?php foreach (['Red','Black','Blue'] as $c): ?>
        <input type="checkbox" name="colors[]" value="<?= $c ?>"
        <?= in_array($c,$existingColors)?'checked':'' ?>><?= $c ?>
    <?php endforeach; ?>
    <br><br>

    Existing Images:<br>
    <?php foreach ($existingImages as $img): ?>
        <img src="../uploads/<?= $img ?>" width="80">
    <?php endforeach; ?>
    <br><br>

    New Images (optional):
    <input type="file" name="images[]" multiple><br><br>

    Stock:
    <input type="number" name="stock" value="<?= $product['stock'] ?>"><br><br>

    <button type="submit" name="update">Update Product</button>
</form>
