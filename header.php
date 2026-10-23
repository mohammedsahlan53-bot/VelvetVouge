<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Clothing Store</title>

    <style>
        body {
            margin: 0;
            font-family: Arial, Helvetica, sans-serif;
            background-color: #f5f5f5;
        }

        nav {
            background-color: #000;
            padding: 15px 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 20px;
        }

        nav a {
            color: #fff;
            text-decoration: none;
            font-size: 15px;
            font-weight: 500;
            padding: 6px 12px;
            border-radius: 4px;
            transition: background 0.3s ease;
        }

        nav a:hover {
            background-color: #444;
        }

        .nav-right {
            margin-left: auto;
            display: flex;
            gap: 15px;
        }

        hr {
            margin: 0;
            border: none;
            height: 1px;
            background-color: #ddd;
        }
    </style>
</head>

<body>

<nav>
    <a href="index.php">Home</a>
    <a href="products.php">Products</a>
    <a href="men.php">Men</a>
    <a href="women.php">Women</a>
    <a href="kids.php">Kids</a>

    <div class="nav-right">
        <?php if (isset($_SESSION['user_id'])): ?>
            
                
            <a href="cart.php">Cart</a>
            <a href="logout.php">Logout</a>
        <?php else: ?>
            <a href="login.php">Login</a>
            <a href="register.php">Register</a>
        <?php endif; ?>
    </div>
</nav>

<hr>



