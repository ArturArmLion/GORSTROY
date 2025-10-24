<?php
session_start();
require 'db.php';

if (isset($_GET['token'])) {
    $token = $_GET['token'];

    $stmt = $pdo->prepare('SELECT * FROM users WHERE activation_token = :token');
    $stmt->execute(['token' => $token]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        $stmt = $pdo->prepare('UPDATE users SET is_active = 1, activation_token = NULL WHERE id = :id');
        $stmt->execute(['id' => $user['id']]);

        $_SESSION['success'] = 'Ваш аккаунт успешно активирован. Теперь вы можете войти.';
        header('Location: login.php');
    } else {
        $_SESSION['error'] = 'Неверный токен активации.';
        header('Location: login.php');
    }
} else {
    header('Location: login.php');
}

?>
