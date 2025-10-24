<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'user') {
    header("Location: login.php");
    exit();
}

echo "Добро пожаловать, " . $_SESSION['username'] . "! Здесь вы можете записаться на услуги.";
?>

<a href="logout.php">Выйти</a>
