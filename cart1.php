<?php
session_start();
include 'config.php';

// Ініціалізація кошика, якщо він ще не створений
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Додавання товару в кошик
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $productId = intval($_POST['product_id']);
    $quantity = intval($_POST['quantity']);

    // Додати товар у кошик
    $_SESSION['cart'][$productId] = $quantity;
}

// Розрахунок загальної вартості
$total = 0;
foreach ($_SESSION['cart'] as $id => $qty) {
    $stmt = $pdo->prepare("SELECT price FROM products WHERE id = ?");
    $stmt->execute([$id]);
    $product = $stmt->fetch();
    $total += $product['price'] * $qty;
}
?>

<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Кошик</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>Кошик</h1>
        <a href="index.php">Повернутися до каталогу</a>
    </header>
    
    <main>
        <h2>Ваш кошик</h2>
        <ul>
            <?php foreach ($_SESSION['cart'] as $id => $qty): ?>
                <?php
                $stmt = $pdo->prepare("SELECT name, price FROM products WHERE id = ?");
                $stmt->execute([$id]);
                $product = $stmt->fetch();
                ?>
                <li>
                    <?= $product['name'] ?> - <?= $qty ?> x <?= number_format($product['price'], 2) ?> грн
                </li>
            <?php endforeach; ?>
        </ul>
        <h3>Загальна вартість: <?= number_format($total, 2) ?> грн</h3>
        <a href="checkout.php">Оформити замовлення</a>
    </main>

    <footer>
        <p>created by Ekaterina Gorbachenko</p>
    </footer>
</body>
</html>
