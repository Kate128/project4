<?php
include 'config.php';

// Отримати список товарів
$stmt = $pdo->query("SELECT * FROM products");
$products = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Інтернет-магазин одягу</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>Інтернет-магазин одягу</h1>
        <a href="cart.php">Кошик</a>
    </header>
    
    <main>
        <h2>Каталог товарів</h2>
        <div class="product-list">
            <?php foreach ($products as $product): ?>
                <div class="product">
                    <img src="images/<?= $product['image'] ?>" alt="<?= $product['name'] ?>">
                    <h3><?= $product['name'] ?></h3>
                    <p><?= $product['description'] ?></p>
                    <p>Ціна: <?= number_format($product['price'], 2) ?> грн</p>
                    <a href="product.php?id=<?= $product['id'] ?>">Детальніше</a>
                </div>
            <?php endforeach; ?>
        </div>
    </main>

    <footer>
        <p>created by Ekaterina Gorbachenko</p>
    </footer>
</body>
</html>
