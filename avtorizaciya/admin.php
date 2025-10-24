<?php
session_start();

// Проверка на роль администратора
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}

// Подключение к базе данных
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "GORSTROY";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Ошибка подключения: " . $conn->connect_error);
}

// Получение данных из таблиц базы данных
$sql = "SELECT * FROM users";
$users_result = $conn->query($sql);

$sql = "SELECT * FROM feedback"; // Например, таблица с записями на услуги
$bookings_result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Админ-панель</title>
    <link rel="stylesheet" href="../css/admin.css">
</head>
<body>
    <h1>Админ-панель</h1>

<!-- Вывод списка пользователей -->
<h2>Управление пользователями</h2>
<table border="1">
    <tr>
        <th>ID</th>
        <th>Имя</th>
        <th>Email</th>
        <th>Роль</th>
        <th>Действия</th>
    </tr>
    <?php
    $user_sql = "SELECT * FROM users";
    $user_result = $conn->query($user_sql);
    while ($user = $user_result->fetch_assoc()): ?>
        <tr>
            <td><?php echo $user['id']; ?></td>
            <td><?php echo $user['username']; ?></td>
            <td><?php echo $user['email']; ?></td>
            <td><?php echo $user['role']; ?></td>
            <td>
                <a href="edit_user.php?id=<?php echo $user['id']; ?>">Редактировать</a> |
                <a href="delete_user.php?id=<?php echo $user['id']; ?>" onclick="return confirm('Вы уверены, что хотите удалить этого пользователя?')">Удалить</a>
            </td>
        </tr>
    <?php endwhile; ?>
</table>

<!-- Вывод списка записей -->
<h2>Управление записями клиентов</h2>
<table border="1">
    <tr>
        <th>ID</th>
        <th>Имя</th>
        <th>Телефон</th>
    </tr>
    <?php
    $booking_sql = "SELECT * FROM feedback";
    $booking_result = $conn->query($booking_sql);
    while ($booking = $booking_result->fetch_assoc()): ?>
        <tr>
            <td><?php echo $booking['id']; ?></td>
            <td><?php echo $booking['name']; ?></td>
            <td><?php echo $booking['phone']; ?></td>

            <td>
                <a href="edit_booking.php?id=<?php echo $booking['id']; ?>">Редактировать</a> |
                <a href="delete_booking.php?id=<?php echo $booking['id']; ?>" onclick="return confirm('Вы уверены, что хотите удалить эту запись?')">Удалить</a>
            </td>
        </tr>
    <?php endwhile; ?>
</table>

    <br>
    <a href="add_user.php">Добавить пользователя</a> | 
    <a href="add_booking.php">Добавить запись</a> | 
    <a href="logout.php">Выйти</a>
</body>
</html>

<?php $conn->close(); ?>

