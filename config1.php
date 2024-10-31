<?php
// config.php
$host = 'localhost'; // Хост бази даних
$db   = 'online_store'; // Назва бази даних
$user = 'root'; // Ім'я користувача
$pass = ''; // Пароль

try {
    // Підключення до бази даних
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // Обробка помилки з'єднання
    echo "Помилка з'єднання: " . $e->getMessage();
}
?>
