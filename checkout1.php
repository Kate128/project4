<?php
session_start();
include 'config.php';

// Розрахунок загальної вартості
$total = 0;
foreach ($_SESSION['cart'] as $id => $qty) {
    $stmt = $pdo->prepare("SELECT price FROM products WHERE id = ?");
    $stmt->execute([$id]);
    $product = $stmt->fetch();
    $total += $product['price'] * $qty;
}

// Обробка замовлення
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stmt = $pdo->prepare("INSERT INTO orders (total) VALUES (?)");
    $stmt->execute([$total]);
    $orderId = $pdo->lastInsertId();

    foreach ($_SESSION['cart'] as $id => $qty) {
        $stmt = $pdo->prepare("INSERT INTO order_items (order_id, product_id, quantity) VALUES (?, ?, ?)");
        $stmt->execute([$orderId, $id, $qty]);
    }

    // Очищення кошика
    unset($_SESSION['cart']);
    echo "Дякуємо за замовлення! Ваше замовлення №$orderId оформлено.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Оформлення замовлення</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>Оформлення замовлення</h1>
        <a href="cart.php">Кошик</a>
    </header>
    
    <main>
        <h2>Ваша замовлення</h2>
        <p>Загальна вартість: <?= number_format($total, 2) ?> грн</p>
        <form action="checkout.php" method="POST">
            <button type="submit">Підтвердити замовлення</button>
        </form>
    </main>

    <footer>
        <p>created by Ekaterina Gorbachenko</p>
    </footer>
</body>
</html>
