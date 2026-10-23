<?php
include "../db.php";

if (isset($_POST['submit'])) {

    $category = $_POST['category'];
    $name     = $_POST['name'];
    $price    = $_POST['price'];
    $stock    = $_POST['stock'];

    $colors = json_encode($_POST['colors'] ?? []);
    $sizes  = json_encode($_POST['sizes'] ?? []);

    // Image upload
    $imageNames = [];
    foreach ($_FILES['images']['name'] as $key => $img) {
        $tmp = $_FILES['images']['tmp_name'][$key];
        $newName = time() . "_" . $img;
        move_uploaded_file($tmp, "../uploads/" . $newName);
        $imageNames[] = $newName;
    }

    $images = json_encode($imageNames);

    $stmt = $conn->prepare("
        INSERT INTO products 
        (category, name, price, images, colors, sizes, stock)
        VALUES 
        (:category, :name, :price, :images, :colors, :sizes, :stock)
    ");

    $stmt->execute([
        'category' => $category,
        'name' => $name,
        'price' => $price,
        'images' => $images,
        'colors' => $colors,
        'sizes' => $sizes,
        'stock' => $stock
    ]);

    header("Location: dashboard.php");
}
?>

<h2>Add Product</h2>

<form method="POST" enctype="multipart/form-data">

    Category:
    <select name="category" required>
        <option value="">Select</option>
        <option>Men</option>
        <option>Women</option>
        <option>Kids</option>
    </select><br><br>

    Name: <input type="text" name="name" required><br><br>
    Price: <input type="number" step="0.01" name="price" required><br><br>

    Sizes:
    <input type="checkbox" name="sizes[]" value="S">S
    <input type="checkbox" name="sizes[]" value="M">M
    <input type="checkbox" name="sizes[]" value="L">L
    <input type="checkbox" name="sizes[]" value="XL">XL
    <br><br>

    Colors:
    <input type="checkbox" name="colors[]" value="Red">Red
    <input type="checkbox" name="colors[]" value="Black">Black
    <input type="checkbox" name="colors[]" value="Blue">Blue
    <br><br>

    Images:
    <input type="file" name="images[]" multiple required><br><br>

    Stock:
    <input type="number" name="stock" required><br><br>

    <button type="submit" name="submit">Save Product</button>
</form>
