<?php
include 'config.php';

if (!isset($_GET['id'])) {
    die('Товар не знайдено');
}

$productId = intval($_GET['id']);
$stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
$stmt->execute([$productId]);
$product = $stmt->fetch();

if (!$product) {
    die('Товар не знайдено');
}
?>

<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $product['name'] ?></title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>Інтернет-магазин одягу</h1>
        <a href="cart.php">Кошик</a>
    </header>
    
    <main>
        <h2><?= $product['name'] ?></h2>
        <img src="images/<?= $product['image'] ?>" alt="<?= $product['name'] ?>">
        <p><?= $product['description'] ?></p>
        <p>Ціна: <?= number_format($product['price'], 2) ?> грн</p>
        <form action="cart.php" method="POST">
            <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
            <input type="number" name="quantity" value="1" min="1">
            <button type="submit">Додати в кошик</button>
        </form>
    </main>

    <footer>
        <p>created by Ekaterina Gorbachenko</p>
    </footer>
</body>
</html>
